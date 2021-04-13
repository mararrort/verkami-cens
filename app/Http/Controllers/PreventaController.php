<?php

namespace App\Http\Controllers;

use App\Models\Editorial;
use App\Models\Preventa;
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
        // The orderByRaw solution has been got here: https://stackoverflow.com/a/25954745
        $presales = Preventa::select('preventas.*')
            ->join('editorials', 'editorial_id', '=', 'editorials.id')
            ->orderByRaw('FIELD(state, "Sin Definir", "Recaudando", "Pendiente de entrega", "Parcialmente entregado", "Entregado")')
            ->orderBy('editorials.name', 'ASC')
            ->orderBy('preventas.name', 'ASC')
            ->get();

        return view('preventa.index', ['presales' => $presales]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $editorials = Editorial::orderBy('name', 'asc')->get();

        return view('preventa.create', ['editorials' => $editorials]);
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
        $preventa->editorial_id = $request->editorial;
        $preventa->url = $request->url;
        $preventa->tarde = $request->has('tarde');
        $preventa->id = Uuid::uuid4();

        $preventa->save();

        return redirect('/preventas');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Preventa  $preventa
     * @return \Illuminate\Http\Response
     */
    public function edit(Preventa $preventa)
    {
        $editorials = Editorial::orderBy('name', 'asc')->get();

        return view('preventa.edit', ['preventa' => $preventa, 'editorials' => $editorials]);
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
        $preventa->editorial_id = $request->editorial;
        $preventa->url = $request->url;
        $preventa->tarde = $request->has('tarde');

        $preventa->save();

        return redirect('/preventas');
    }
}
