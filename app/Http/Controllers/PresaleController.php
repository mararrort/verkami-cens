<?php

namespace App\Http\Controllers;

use App\Models\Editorial;
use App\Models\Presale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

define('ColumnNames', [
    'Nombre' => 'presales.name',
    'Editorial' => 'editorials.name',
    'Estado' => 'presales.state',
    'Financiacion' => 'presales.start',
    'EntregaA' => 'presales.announced_end',
    'EntregaR' => 'presales.end',
]);

class PresaleController extends Controller
{
    /**
     * Display a listing of presales.
     *
     * All the parameters are optional.
     * If $editorial is defined, it must be the identificator to one editorial,
     * and all the listed presales will be owned by it.
     * Both $column or $order must be either defined or undefined.
     * If $column is defined, it must be Nombre.
     * If $order is defined, it must be either ASC or DESC.
     * If $column and $order are defined, the returned list will be ordered
     * by the given column in the given order.
     *
     * @param Editorial $editorial
     * @param string $column
     * @param string $order
     *
     * @return \Illuminate\Http\Response
     */
    public function index(
        Editorial $editorial = null,
        string $column = null,
        string $order = null
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

        // Puntuality is excluded because is not an stored but a calculated value
        // If $column == "Puntualidad", it must be sorted later (Once it is get)
        if ($column != 'Puntualidad') {
            if (isset($column, $order)) {
                $presales->orderBy(ColumnNames[$column], $order);
                if ($column != 'Editorial') {
                    $presales->orderBy('editorials.name', 'ASC');
                }
                if ($column != 'Nombre') {
                    $presales->orderBy('presales.name', 'ASC');
                }
            } else {
                // Default sorting
                // The orderByRaw solution has been got here: https://stackoverflow.com/a/25954745
                $presales
                    ->orderByRaw(
                        'FIELD(state, "Sin Definir", "Recaudando", "Pendiente de entrega", "Parcialmente entregado", "Entregado")'
                    )
                    ->orderBy('editorials.name', 'ASC')
                    ->orderBy('presales.name', 'ASC');
            }
        }

        $presales = $presales->get();

        // Puntuality sorting
        // The DESC order is Recaudando ("Collecting"), Not Late and Late
        if ($column == 'Puntualidad') {
            $presales = $presales->sort(function (Presale $a, Presale $b) {
                $return = 0;
                // Collecting always precedes a non collecting
                if ($a->state == 'Recaudando' && $b->state != 'Recaudando') {
                    $return = -1;
                // Non collecting always follows collecting
                } elseif ($a->state != 'Recaudando' && $b->state == 'Recaudando') {
                    $return = 1;
                // Between not collecting, the lateness is the first check
                } elseif ($a->state != 'Recaudando' && $b->state != 'Recaudando') {
                    // Lates always follows not lates
                    if ($a->isLate() && ! $b->isLate()) {
                        $return = 1;
                    // Not lates always precedes lates
                    } elseif (! $a->isLate() && $b->isLate()) {
                        $return = -1;
                    // If theye are both lates or not late, check editorial name
                    } elseif ($a->editorial != $b->editorial) {
                        $return = strcmp($b->editorial->name, $a->editorial->name);
                    // If they also share editorial, checks name
                    } else {
                        $return = strcmp($b->name, $a->name);
                    }
                }
                // If theye are both collecting, check editorial and later name
                else {
                    if ($a->editorial != $b->editorial) {
                        $return = strcmp($b->editorial->name, $a->editorial->name);
                    } else {
                        $return = strcmp($b->name, $a->name);
                    }
                }

                return $return;
            });

            if ($order == 'ASC') {
                $presales = $presales->reverse();
            }
        }

        return view('presale.index', [
            'presales' => $presales,
            'editorial' => $editorial,
        ]);
    }
}
