<?php

namespace App\Http\Controllers;

use App\Models\Editorial;
use App\Models\Presale;
use App\Models\Petition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
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

        return view('petition.index',
            ['createPetitions' => $createPetitions, 'updatePetitions' => $updatePetitions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Presale $presale = null)
    {
        $editorials = Editorial::orderBy('name', 'ASC')->get();

        return view('petition.create', ['editorials' => $editorials, 'presale' => $presale]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'presale_id' => 'required_without:presale_name,presale_url|nullable|exists:presales,id',
            'presale_name' => 'required_without:presale_id|nullable|string|max:64',
            'presale_url' => 'required_without:presale_id|nullable|string|max:128',
            'editorial_id' => 'required_without:editorial_name,editorial_url|nullable|exists:editorials,id',
            'editorial_name' => 'required_without:editorial_id|nullable|string|max:64',
            'editorial_url' => 'required_without:editorial_id|nullable|string|max:128',
            'state' => ['required', Rule::in(['Recaudando', 'Pendiente de entrega', 'Parcialmente entregado', 'Entregado', 'Sin definir'])],
            'info' => 'nullable|string',
            'start' => 'nullable|date',
            'announced_end' => 'nullable|date',
            'end' => 'nullable|date',
        ]);

        $sap = new Petition();

        $sap->presale_id = $request->presale_id;
        $sap->presale_name = $request->presale_name;
        $sap->presale_url = $request->presale_url;
        $sap->editorial_id = $request->editorial_id;
        $sap->editorial_name = $request->editorial_name;
        $sap->editorial_url = $request->editorial_url;
        $sap->state = $request->state;
        $sap->late = $request->has('late');
        $sap->info = $request->info;
        $sap->id = Uuid::uuid4();
        $sap->sendTelegramNotification = true;
        $sap->start = $request->start;
        $sap->announced_end = $request->announced_end;
        $sap->end = $request->end;

        $sap->save();

        return redirect()->route('preventas.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Petition  $petition
     * @return \Illuminate\Http\Response
     */
    public function show(Petition $peticion)
    {
        return view('petition.show', ['sap' => $peticion]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Petition  $petition
     * @return \Illuminate\Http\Response
     */
    public function edit(Petition $peticion)
    {
        $editorials = Editorial::all();

        return view('petition.edit', ['peticion' => $peticion, 'editorials' => $editorials]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Petition  $petition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Petition $peticion)
    {
        $peticion->presale_name = $request->presale_name;
        $peticion->presale_url = $request->presale_url;
        $peticion->editorial_id = $request->editorial_id;
        $peticion->editorial_name = $request->editorial_name;
        $peticion->editorial_url = $request->editorial_url;
        $peticion->state = $request->state;
        $peticion->late = $request->has('late');
        $peticion->info = $request->info;
        $peticion->sendTelegramNotification = $request->has('sendTelegramNotification');
        $peticion->start = $request->start;
        $peticion->announced_end = $request->announced_end;
        $peticion->end = $request->end;

        $peticion->save();

        return redirect()->route('peticion.show', ['peticion' => $peticion]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Petition  $petition
     * @return \Illuminate\Http\Response
     */
    public function destroy(Petition $peticion)
    {
        $peticion->delete();

        return redirect()->route('peticion.index');
    }

    /**
     * Accept the request and then destroy it.
     *
     * The request is for adding a new presale, which can have a new editorial.
     * The editorial will be new if the field editorial_id is null.
     * If the editorial is new, it will be created and persisted.
     */
    public function accept(Petition $peticion)
    {
        // Get the editorial
        if ($peticion->editorial_id) {
            $editorial = Editorial::find($peticion->editorial_id);
        } else {
            $editorial = new Editorial();
            $editorial->name = $peticion->editorial_name;
            $editorial->url = $peticion->editorial_url;
            $editorial->id = UUID::uuid4();
            $editorial->save();
        }

        // Get the presale
        if ($peticion->presale_id) {
            $presale = Presale::find($peticion->presale_id);
        } else {
            $presale = new Presale();
            $presale->id = UUID::uuid4();
            $presale->name = $peticion->presale_name;
            $presale->url = $peticion->presale_url;
            $presale->editorial_id = $editorial->id;
        }

        $presale->state = $peticion->state;
        $presale->late = $peticion->late;

        $presale->start = $peticion->start;
        $presale->announced_end = $peticion->announced_end;
        $presale->end = $peticion->end;

        // Save the status
        $presale->save();

        // Notify by Telegram
        if ($peticion->sendTelegramNotification) {
            $text = 'La preventa ['.str_replace('.', '\\.', $presale->name).']('.$presale->url.') de  ['.str_replace('.', '\\.', $editorial->name).']('.$editorial->url.')'
                .' ha sido '.($peticion->presale_id ? 'actualizada' : 'creada').'\\. ';
            $text = $text.'Se encuentra en estado '.$presale->state.'\\. ';
            if ($presale->late) {
                $text = $text.'Es impuntual\\.';
            }

            foreach (DB::table('telegram_chat')->get() as $chatId) {
                HTTP::get('https://api.telegram.org/bot'.env('TELEGRAM_TOKEN').'/sendMessage', [
                    'chat_id' => $chatId->id,
                    'text' => $text,
                    'parse_mode' => 'MarkdownV2',
                    'disable_web_page_preview' => true,
                ]);
                Log::info('A Telegram notification has been sent', ['chatId' => $chatId->id, 'text' => $text]);
            }
        }

        $peticion->delete();

        return redirect()->route('peticion.index');
    }
}
