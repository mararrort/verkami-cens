<?php

namespace App\Http\Controllers;

use App\Models\Preventa;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class PreventaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recaudando = Preventa::select('preventas.*')
            ->where('state', 'Recaudando')
            ->join('empresas', 'empresa_id', '=', 'empresas.id')
            ->orderBy('empresas.name', 'ASC')
            ->get();
        $pendienteDeEntrega = Preventa::select('preventas.*')
            ->where('state', 'Pendiente de entrega')
            ->join('empresas', 'empresa_id', '=', 'empresas.id')
            ->orderBy('empresas.name', 'ASC')
            ->get();
        $parcialmenteEntregado = Preventa::select('preventas.*')
            ->where('state', 'Parcialmente entregado')
            ->join('empresas', 'empresa_id', '=', 'empresas.id')
            ->orderBy('empresas.name', 'ASC')
            ->get();
        $entregado = Preventa::select('preventas.*')
            ->where('state', 'Entregado')
            ->join('empresas', 'empresa_id', '=', 'empresas.id')
            ->orderBy('empresas.name', 'ASC')
            ->get();
        $sinDefinir = Preventa::select('preventas.*')
            ->where('state', 'Sin definir')
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
        $empresas = Empresa::orderBy('name', 'asc')->get();

        return view('preventa.create', ['editoriales' => $empresas]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $preventa = new Preventa();

        $preventa->name = $request->name;
        $preventa->state = $request->state;
        $preventa->empresa_id = $request->editorial;
        $preventa->url = $request->url;
        $preventa->id = Uuid::uuid4();

        $preventa->save();

        return redirect('/preventas');
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
        $empresas = Empresa::orderBy('name', 'asc')->get();

        return view('preventa.edit', ['preventa' => $preventa, 'editoriales' => $empresas]);
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
        $preventa->name = $request->name;
        $preventa->state = $request->state;
        $preventa->empresa_id = $request->editorial;
        $preventa->url = $request->url;

        $preventa->save();

        return redirect('/preventas');
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
