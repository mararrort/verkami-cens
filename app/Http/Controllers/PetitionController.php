<?php

namespace App\Http\Controllers;

use App\Models\Editorial;
use App\Models\Petition;
use App\Models\Presale;
use App\Models\TelegramUser;
use App\Notifications\PetitionAccepted;
use App\Notifications\PetitionCreated;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;
use NotificationChannels\Telegram\Exceptions\CouldNotSendNotification as TelegramException;
use NotificationChannels\Twitter\Exceptions\CouldNotSendNotification as TwitterException;
use Ramsey\Uuid\Uuid;

class PetitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $createPetitions = Petition::whereNull('presale_id')->get();

        $updatePetitions = Petition::whereNotNull('presale_id')->get();

        return view('petition.index', [
            'createPetitions' => $createPetitions,
            'updatePetitions' => $updatePetitions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Presale $presale = null)
    {
        $editorials = Editorial::orderBy('name', 'ASC')->get();

        return view('petition.create', [
            'editorials' => $editorials,
            'presale' => $presale,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Log::info('A petition request has been get', [
            'request' => $request->all(),
        ]);
        $validated = $request->validate([
            'presale_id' => 'required_without:presale_name,presale_url|nullable|exists:presales,id',
            'presale_name' => 'required_without:presale_id|nullable|string|max:64',
            'presale_url' => 'required_without:presale_id|nullable|string|max:128',
            'editorial_id' => 'required_without:editorial_name,editorial_url|nullable|exists:editorials,id',
            'editorial_name' => 'required_without:editorial_id|nullable|string|max:64',
            'editorial_url' => 'required_without:editorial_id|nullable|string|max:128',
            'state' => [
                'required',
                Rule::in([
                    'Recaudando',
                    'Pendiente de entrega',
                    'Parcialmente entregado',
                    'Entregado',
                    'Entregado, faltan recompensas',
                    'Abandonado',
                ]),
            ],
            'info' => 'nullable|string',
            'start' => 'nullable|date',
            'announced_end' => 'nullable|date',
            'end' => 'nullable|date',
        ]);

        $petition = new Petition();

        $petition->presale_id = $request->presale_id;
        $petition->presale_name = $request->presale_name;
        $petition->presale_url = $request->presale_url;
        $petition->editorial_id = $request->editorial_id;
        $petition->editorial_name = $request->editorial_name;
        $petition->editorial_url = $request->editorial_url;
        $petition->state = $request->state;
        $petition->info = $request->info;
        $petition->id = Uuid::uuid4();
        $petition->start = $request->start;
        $petition->announced_end = $request->announced_end;
        $petition->end = $request->end;

        $petition->save();
        Log::info('A petition has been created', ['petition' => $petition]);

        // Notify
        $telegramUsers = TelegramUser::where(
            'createdPetitions',
            true
        )->get();
        try {
            Notification::send(
                $telegramUsers,
                new PetitionCreated($petition)
            );
            Log::info('Notifications have been sent');
        } catch (TelegramException $exception) {
            Log::error('The telegram message has not been send', [
                'exception' => $exception,
            ]);
        }

        return redirect()->route('presales.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Petition  $petition
     * @param  bool  $error
     * @return \Illuminate\Http\Response
     */
    public function show(Petition $petition, $error = false)
    {
        $presaleUrlError = false;
        $editorialUrlError = false;
        if (! $petition->isUpdate()) {
            $presaleUrlError = Presale::where(
                'url',
                $petition->presale_url
            )->exists();
        }
        if ($petition->isNewEditorial()) {
            $editorialUrlError = Editorial::where(
                'url',
                $petition->editorial_url
            )->exists();
        }
        //dd([$presaleUrlError, $editorialUrlError]);

        return view('petition.show', [
            'petition' => $petition,
            'error' => $error,
            'presaleUrlError' => $presaleUrlError,
            'editorialUrlError' => $editorialUrlError,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Petition  $petition
     * @return \Illuminate\Http\Response
     */
    public function edit(Petition $petition)
    {
        $editorials = Editorial::all();

        return view('petition.edit', [
            'petition' => $petition,
            'editorials' => $editorials,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Petition  $petition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Petition $petition)
    {
        $petition->presale_name = $request->presale_name;
        $petition->presale_url = $request->presale_url;
        $petition->editorial_id = $request->editorial_id;
        $petition->editorial_name = $request->editorial_name;
        $petition->editorial_url = $request->editorial_url;
        $petition->state = $request->state;
        $petition->info = $request->info;
        $petition->start = $request->start;
        $petition->announced_end = $request->announced_end;
        $petition->end = $request->end;

        $petition->save();

        return redirect()->route('petition.show', ['petition' => $petition]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Petition  $petition
     * @return \Illuminate\Http\Response
     */
    public function destroy(Petition $petition)
    {
        $petition->delete();

        return redirect()->route('petition.index');
    }

    /**
     * Accept the request and then destroy it.
     *
     * The request is for adding a new presale, which can have a new editorial.
     * The editorial will be new if the field editorial_id is null.
     * If the editorial is new, it will be created and persisted.
     */
    public function accept(Petition $petition)
    {
        // Get the editorial
        if ($petition->editorial_id) {
            $editorial = Editorial::find($petition->editorial_id);
        } else {
            $editorial = new Editorial();
            $editorial->name = $petition->editorial_name;
            $editorial->url = $petition->editorial_url;
            $editorial->id = UUID::uuid4();
            $editorial->save();
        }

        // Get the presale
        if ($petition->presale_id) {
            $presale = Presale::find($petition->presale_id);
        } else {
            $presale = new Presale();
            $presale->id = UUID::uuid4();
            $presale->name = $petition->presale_name;
            $presale->url = $petition->presale_url;
            $presale->editorial_id = $editorial->id;
        }

        $presale->state = $petition->state;

        $presale->start = $petition->start;
        $presale->announced_end = $petition->announced_end;
        $presale->end = $petition->end;

        // Save the status
        try {
            $presale->save();
        } catch (QueryException $exception) {
            return redirect()->route('petition.show', [
                'petition' => $petition,
                'error' => true,
            ]);
        }

        // Notify

        $telegramUsers = TelegramUser::where(
            'createdPetitions',
            true
        )->get();
        foreach ($telegramUsers as $telegramUser) {
            Log::info('A Telegram message will be send to the client '.$telegramUser->id);
            try {
                Notification::send(
                    $telegramUser,
                    new PetitionAccepted($petition, $editorial, $presale)
                );
            } catch (TwitterException $exception) {
                Log::error('The tweet has not been send', [
                    'exception' => $exception,
                ]);
            } catch (TelegramException $exception) {
                Log::error('The telegram message has not been send', [
                    'exception' => $exception,
                ]);
            } catch (ClientException $exception) {
                Log::warning('Cannot send a Telegram message to the client '.$telegramUser->id.'. It will be removed from the DDBB');
                $telegramUser->delete();
            }
        }

        $petition->delete();

        return redirect()->route('petition.index');
    }
}
