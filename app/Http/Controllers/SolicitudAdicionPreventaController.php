<?php

namespace App\Http\Controllers;

use App\Models\SolicitudAdicionPreventa;
use App\Models\Preventa;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;


class SolicitudAdicionPreventaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sap = SolicitudAdicionPreventa::all();
        
        return view('solicitudAdicionPreventa.index', ['sap' => $sap]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $editorials = Empresa::orderBy('name', 'ASC')->get();
        return view('solicitudAdicionPreventa.create', ['editorials' => $editorials]);
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
            'presale_name' => 'required|string|max:50',
            'presale_url' => 'required|string|max:100',
            'editorial_id' => 'required_without:editorial_name,editorial_url|nullable|exists:empresas,id',
            'editorial_name' => 'required_without:editorial_id|nullable|string|max:50',
            'editorial_url' => 'required_without:editorial_id|nullable|string|max:100',
            'state' => ['required', Rule::in(['Recaudando', 'Pendiente de entrega', 'Parcialmente entregado', 'Entregado', 'Sin definir']),],
        ]);

        $sap = new SolicitudAdicionPreventa();
        
        $sap->presale_name = $request->presale_name;
        $sap->presale_url = $request->presale_url;
        $sap->editorial_id = $request->editorial_id;
        $sap->editorial_name = $request->editorial_name;
        $sap->editorial_url = $request->editorial_url;
        $sap->state = $request->state;
        $sap->late = $request->has('late');
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
        return view('solicitudAdicionPreventa.show', ['sap' => $solicitudAdicionPreventa]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SolicitudAdicionPreventa  $solicitudAdicionPreventa
     * @return \Illuminate\Http\Response
     */
    public function edit(SolicitudAdicionPreventa $peticion)
    {
        return view('solicitudAdicionPreventa.edit', ['sap' => $solicitudAdicionPreventa]);
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
        $solicitudAdicionPreventa->solved = $request->has('solved');

        $solicitudAdicionPreventa->save();

        return redirect()->route('peticion.index');
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

        $presale = new Preventa();
        $presale->id = UUID::uuid4();
        $presale->name = $peticion->presale_name;
        $presale->url = $peticion->presale_url;
        $presale->state = $peticion->state;
        $presale->tarde = $peticion->late;
        $presale->empresa_id = $editorial->id;
        $presale->save(); 

        $peticion->delete();

        return redirect()->route('peticion.index');
    }
}
