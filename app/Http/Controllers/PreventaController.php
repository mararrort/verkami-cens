<?php

namespace App\Http\Controllers;

use App\Models\Preventa;
use Illuminate\Http\Request;

class PreventaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recaudando = Preventa::where('state', 'Recaudando')
            ->join('empresas', 'empresa_id', '=', 'empresas.id')
            ->orderBy('empresas.name', 'ASC')
            ->get();
        $pendienteDeEntrega = Preventa::where('state', 'Pendiente de entrega')
            ->join('empresas', 'empresa_id', '=', 'empresas.id')
            ->orderBy('empresas.name', 'ASC')
            ->get();
        $parcialmenteEntregado = Preventa::where('state', 'Parcialmente entregado')
            ->join('empresas', 'empresa_id', '=', 'empresas.id')
            ->orderBy('empresas.name', 'ASC')
            ->get();
        $entregado = Preventa::where('state', 'Entregado')
            ->join('empresas', 'empresa_id', '=', 'empresas.id')
            ->orderBy('empresas.name', 'ASC')
            ->get();
        $sinDefinir = Preventa::where('state', 'Sin definir')
            ->join('empresas', 'empresa_id', '=', 'empresas.id')
            ->orderBy('empresas.name', 'ASC')
            ->get();

        return view('preventa.index', 
            ['recaudando' => $recaudando, 
            'pendienteDeEntrega' => $pendienteDeEntrega, 
            'parcialmenteEntregado' => $parcialmenteEntregado,
            'entregado' => $entregado,
            'sinDefinir' => $sinDefinir]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Preventa  $preventa
     * @return \Illuminate\Http\Response
     */
    public function show(Preventa $preventa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Preventa  $preventa
     * @return \Illuminate\Http\Response
     */
    public function edit(Preventa $preventa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Preventa  $preventa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Preventa $preventa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Preventa  $preventa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Preventa $preventa)
    {
        //
    }
}
