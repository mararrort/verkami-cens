<?php

namespace App\Http\Controllers;

use App\Models\Editorial;
use App\Models\Presale;

class PresaleController extends Controller
{
    /**
     * Display a listing of presales.
     *
     * All the parameters are optional.
     * If $editorial is defined, it must be the identificator to one editorial,
     * and all the listed presales will be owned by it.
     *
     * @param Editorial $editorial
     *
     * @return \Illuminate\Http\Response
     */
    public function index(
        Editorial $editorial = null
    ) {
        $presales = Presale::select('presales.*')->join(
            'editorials',
            'editorial_id',
            '=',
            'editorials.id'
        );

        if (isset($editorial)) {
            $presales->where('editorials.id', $editorial->id);
        }

        // Default sorting
        // The orderByRaw solution has been got here: https://stackoverflow.com/a/25954745
        $presales
            ->orderByRaw(
                'FIELD(state, "Sin Definir", "Recaudando", "Pendiente de entrega", "Parcialmente entregado", "Entregado")'
            )
            ->orderBy('editorials.name', 'ASC')
            ->orderBy('presales.name', 'ASC');

        $presales = $presales->get();

        return view('presale.index', [
            'presales' => $presales,
            'editorial' => $editorial,
        ]);
    }
}
