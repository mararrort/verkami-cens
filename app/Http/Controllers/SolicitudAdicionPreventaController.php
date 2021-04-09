<?php

namespace App\Http\Controllers;

use App\Models\SolicitudAdicionPreventa;
use App\Models\Preventa;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;


class SolicitudAdicionPreventaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $createPetitions = SolicitudAdicionPreventa::whereNull('presale_id')->get();

        $updatePetitions = SolicitudAdicionPreventa::whereNotNull('presale_id')->get();
        
        return view('solicitudAdicionPreventa.index', 
            ['createPetitions' => $createPetitions, 'updatePetitions' => $updatePetitions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Preventa $presale = null)
    {
        $editorials = Empresa::orderBy('name', 'ASC')->get();
        return view('solicitudAdicionPreventa.create', ['editorials' => $editorials, 'presale' => $presale]);
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
            'presale_id' => 'required_without:presale_name,presale_url|nullable|exists:preventas,id',
            'presale_name' => 'required_without:presale_id|nullable|string|max:64',
            'presale_url' => 'required_without:presale_id|nullable|string|max:128',
            'editorial_id' => 'required_without:editorial_name,editorial_url|nullable|exists:empresas,id',
            'editorial_name' => 'required_without:editorial_id|nullable|string|max:64',
            'editorial_url' => 'required_without:editorial_id|nullable|string|max:128',
            'state' => ['required', Rule::in(['Recaudando', 'Pendiente de entrega', 'Parcialmente entregado', 'Entregado', 'Sin definir']),],
            'info' => 'nullable|string'
        ]);

        $sap = new SolicitudAdicionPreventa();
        
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
        $sap->save();

        return redirect()->route('preventas.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SolicitudAdicionPreventa  $solicitudAdicionPreventa
     * @return \Illuminate\Http\Response
     */
    public function show(SolicitudAdicionPreventa $peticion)
    {      
        return view('solicitudAdicionPreventa.show', ['sap' => $peticion]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SolicitudAdicionPreventa  $solicitudAdicionPreventa
     * @return \Illuminate\Http\Response
     */
    public function edit(SolicitudAdicionPreventa $peticion)
    {
        $editorials = Empresa::all();
        return view('solicitudAdicionPreventa.edit', ['peticion' => $peticion, 'editorials' => $editorials]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SolicitudAdicionPreventa  $solicitudAdicionPreventa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SolicitudAdicionPreventa $peticion)
    {
        $peticion->presale_name = $request->presale_name;
        $peticion->presale_url = $request->presale_url;
        $peticion->editorial_id = $request->editorial_id;
        $peticion->editorial_name = $request->editorial_name;
        $peticion->editorial_url = $request->editorial_url;
        $peticion->state = $request->state;
        $peticion->late = $request->has('late');
        $peticion->info = $request->info;

        $peticion->save();

        return redirect()->route('peticion.show', ['peticion' => $peticion]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SolicitudAdicionPreventa  $solicitudAdicionPreventa
     * @return \Illuminate\Http\Response
     */
    public function destroy(SolicitudAdicionPreventa $peticion)
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
    public function accept(SolicitudAdicionPreventa $peticion)
    {
        // Get the editorial
        if ($peticion->editorial_id) {
            $editorial = Empresa::find($peticion->editorial_id);
        } else {
            $editorial = new Empresa();
            $editorial->name = $peticion->editorial_name;
            $editorial->url = $peticion->editorial_url;
            $editorial->id = UUID::uuid4();
            $editorial->save();
        }

        // Get the presale
        if($peticion->presale_id) {
            $presale = Preventa::find($peticion->presale_id);
        } else {
            $presale = new Preventa();
            $presale->id = UUID::uuid4();
            $presale->name = $peticion->presale_name;
            $presale->url = $peticion->presale_url;
            $presale->empresa_id = $editorial->id;
        }

        $presale->state = $peticion->state;
        $presale->tarde = $peticion->late;
        
        // Save the status
        $presale->save(); 

        $text = 'La preventa '.$presale->name.' de  ' . $editorial->name 
            . ' ha sido '  . ($peticion->presale_id ? 'actualizada' : 'creada')
            . '. Se encuentra en estado ' . $presale->state . ' y ' . ($presale->tarde ? 'no ' : '')
            . 'es puntual.';

        // Notify by Telegram
        HTTP::get('https://api.telegram.org/bot'.env('TELEGRAM_TOKEN').'/sendMessage', [
            'chat_id' => env('TELEGRAM_CHAT'),
            'text' => $text
        ]);

        $peticion->delete();

        return redirect()->route('peticion.index');
    }
}
