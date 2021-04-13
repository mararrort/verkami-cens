<?php

namespace App\Http\Controllers;

use App\Models\Editorial;
use App\Models\Presale;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class PresaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // The orderByRaw solution has been got here: https://stackoverflow.com/a/25954745
        $presales = Presale::select('presales.*')
            ->join('editorials', 'editorial_id', '=', 'editorials.id')
            ->orderByRaw('FIELD(state, "Sin Definir", "Recaudando", "Pendiente de entrega", "Parcialmente entregado", "Entregado")')
            ->orderBy('editorials.name', 'ASC')
            ->orderBy('presales.name', 'ASC')
            ->get();

        return view('presale.index', ['presales' => $presales]);
    }
}
