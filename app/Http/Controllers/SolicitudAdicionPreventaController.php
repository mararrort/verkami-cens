<?php

namespace App\Http\Controllers;

use App\Models\SolicitudAdicionPreventa;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class SolicitudAdicionPreventaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sap = SolicitudAdicionPreventa::where('solved', false)->get();
        
        return view('solicitudAdicionPreventa.index', ['sap' => $sap]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('solicitudAdicionPreventa.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (strlen($request->text) <= 500) {
            $sap = new SolicitudAdicionPreventa();

            $sap->text = $request->text;
            $sap->id = Uuid::uuid4();

            $sap->save();
        }

        return redirect()->route('preventas.index');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SolicitudAdicionPreventa  $solicitudAdicionPreventa
     * @return \Illuminate\Http\Response
     */
    public function show(string $solicitudAdicionPreventa)
    {
        // For some reason it is not working with the auto load.
        $solicitudAdicionPreventa = SolicitudAdicionPreventa::find($solicitudAdicionPreventa);
        return view('solicitudAdicionPreventa.show', ['sap' => $solicitudAdicionPreventa]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SolicitudAdicionPreventa  $solicitudAdicionPreventa
     * @return \Illuminate\Http\Response
     */
    public function edit(string $solicitudAdicionPreventa)
    {
        // For some reason it is not working with the auto load.
        $solicitudAdicionPreventa = SolicitudAdicionPreventa::find($solicitudAdicionPreventa);
        return view('solicitudAdicionPreventa.edit', ['sap' => $solicitudAdicionPreventa]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SolicitudAdicionPreventa  $solicitudAdicionPreventa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $solicitudAdicionPreventa)
    {
        // For some reason it is not working with the auto load.
        $solicitudAdicionPreventa = SolicitudAdicionPreventa::find($solicitudAdicionPreventa);

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
    public function destroy(SolicitudAdicionPreventa $solicitudAdicionPreventa)
    {
        //
    }
}
