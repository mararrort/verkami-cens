@extends('base')

@section('body')
<div class="row">
    <div class="col-md-auto">
        <h1>Listado de preventas</h1>
        <p>A continuación se muestra un listado de las preventas registradas, 
        separadas en cinco tablas en función de su estado (Recaudando, Pendiente de entrega,
        Parcialmente entregado, Entregado).</p>
        <p>Los nombres de las preventas son enlaces al sitio web donde se gestionaron
        (Comunmente Verkami).</p>
        <p>La clasificación de su estado se basa en la última información accedida.</p>
        <p>Se considera que una preventa es puntual si ninguno de sus productos
        ha quedado pendiente de entregar después de la fecha de entrega anunciada durante la campaña de recolecta</p>
        <p><a href="{{route('petition.create')}}">Puedes solicitar añadir una preventa a través de este enlace</a></p>
    </div>
</div>

<div class="row">
    <div class="col-auto">
        <table class="table">
            <caption>
                Listado de preventas registradas.
            </caption>
            <thead>
                <tr>
                    <th>Nombre <a href="
                        @if($editorial) 
                            {{route('presales.filteredOrderedIndex', ['editorial' => $editorial, 'column' => 'Nombre', 'order' => 'ASC'])}}
                        @else 
                            {{route('presales.orderedIndex', ['column' => 'Nombre', 'order' => 'ASC'])}}
                        @endif">
                        <i class="bi bi-arrow-up-short"></i></a> 
                        <a href=
                       " @if($editorial) 
                            {{route('presales.filteredOrderedIndex', ['editorial' => $editorial, 'column' => 'Nombre', 'order' => 'DESC']) }}
                        @else 
                            {{route('presales.orderedIndex', ['column' => 'Nombre', 'order' => 'DESC'])}}
                        @endif">
                        <i class="bi bi-arrow-down-short"></i></a>
                    </th>
                    <th>Editorial <a href="
                        @if($editorial) 
                            {{route('presales.filteredOrderedIndex', ['editorial' => $editorial, 'column' => 'Editorial', 'order' => 'ASC'])}}
                        @else 
                            {{route('presales.orderedIndex', ['column' => 'Editorial', 'order' => 'ASC'])}}
                        @endif">
                        <i class="bi bi-arrow-up-short"></i></a> 
                        <a href=
                       " @if($editorial) 
                            {{route('presales.filteredOrderedIndex', ['editorial' => $editorial, 'column' => 'Editorial', 'order' => 'DESC']) }}
                        @else 
                            {{route('presales.orderedIndex', ['column' => 'Editorial', 'order' => 'DESC'])}}
                        @endif">
                        <i class="bi bi-arrow-down-short"></i></a>
                    </th>
                    <th>Estado <a href="
                        @if($editorial) 
                            {{route('presales.filteredOrderedIndex', ['editorial' => $editorial, 'column' => 'Estado', 'order' => 'ASC'])}}
                        @else 
                            {{route('presales.orderedIndex', ['column' => 'Estado', 'order' => 'ASC'])}}
                        @endif">
                        <i class="bi bi-arrow-up-short"></i></a> 
                        <a href=
                       " @if($editorial) 
                            {{route('presales.filteredOrderedIndex', ['editorial' => $editorial, 'column' => 'Estado', 'order' => 'DESC']) }}
                        @else 
                            {{route('presales.orderedIndex', ['column' => 'Estado', 'order' => 'DESC'])}}
                        @endif">
                        <i class="bi bi-arrow-down-short"></i></a>
                    </th>
                    <th>F. de financiación <a href="
                        @if($editorial) 
                            {{route('presales.filteredOrderedIndex', ['editorial' => $editorial, 'column' => 'Financiacion', 'order' => 'ASC'])}}
                        @else 
                            {{route('presales.orderedIndex', ['column' => 'Financiacion', 'order' => 'ASC'])}}
                        @endif">
                        <i class="bi bi-arrow-up-short"></i></a> 
                        <a href=
                       " @if($editorial) 
                            {{route('presales.filteredOrderedIndex', ['editorial' => $editorial, 'column' => 'Financiacion', 'order' => 'DESC']) }}
                        @else 
                            {{route('presales.orderedIndex', ['column' => 'Financiacion', 'order' => 'DESC'])}}
                        @endif">
                        <i class="bi bi-arrow-down-short"></i></a>
                    </th>
                    <th>F. de entrega anunciada <a href="
                        @if($editorial) 
                            {{route('presales.filteredOrderedIndex', ['editorial' => $editorial, 'column' => 'EntregaA', 'order' => 'ASC'])}}
                        @else 
                            {{route('presales.orderedIndex', ['column' => 'EntregaA', 'order' => 'ASC'])}}
                        @endif">
                        <i class="bi bi-arrow-up-short"></i></a> 
                        <a href=
                       " @if($editorial) 
                            {{route('presales.filteredOrderedIndex', ['editorial' => $editorial, 'column' => 'EntregaA', 'order' => 'DESC']) }}
                        @else 
                            {{route('presales.orderedIndex', ['column' => 'EntregaA', 'order' => 'DESC'])}}
                        @endif">
                        <i class="bi bi-arrow-down-short"></i></a>
                    </th>
                    <th>F. de entrega <a href="
                        @if($editorial) 
                            {{route('presales.filteredOrderedIndex', ['editorial' => $editorial, 'column' => 'EntregaR', 'order' => 'ASC'])}}
                        @else 
                            {{route('presales.orderedIndex', ['column' => 'EntregaR', 'order' => 'ASC'])}}
                        @endif">
                        <i class="bi bi-arrow-up-short"></i></a> 
                        <a href=
                       " @if($editorial) 
                            {{route('presales.filteredOrderedIndex', ['editorial' => $editorial, 'column' => 'EntregaR', 'order' => 'DESC']) }}
                        @else 
                            {{route('presales.orderedIndex', ['column' => 'EntregaR', 'order' => 'DESC'])}}
                        @endif">
                        <i class="bi bi-arrow-down-short"></i></a>
                    </th>
                    <th>Puntualidad <a href="
                        @if($editorial) 
                            {{route('presales.filteredOrderedIndex', ['editorial' => $editorial, 'column' => 'Puntualidad', 'order' => 'ASC'])}}
                        @else 
                            {{route('presales.orderedIndex', ['column' => 'Puntualidad', 'order' => 'ASC'])}}
                        @endif">
                        <i class="bi bi-arrow-up-short"></i></a> 
                        <a href=
                       " @if($editorial) 
                            {{route('presales.filteredOrderedIndex', ['editorial' => $editorial, 'column' => 'Puntualidad', 'order' => 'DESC']) }}
                        @else 
                            {{route('presales.orderedIndex', ['column' => 'Puntualidad', 'order' => 'DESC'])}}
                        @endif">
                        <i class="bi bi-arrow-down-short"></i></a>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($presales as $item)
                @if ($item->isLate())
                <tr class="table-danger" dusk="danger">
                @elseif (!$item->isLate() && $item->state == "Entregado")
                <tr class="table-success" dusk="success">
                @else
                <tr>
                @endif
                    <td><a dusk="editPresale" href="{{route('petition.create', ['presale' => $item->id])}}"><i class="bi bi-pencil"></a></i><a href="{{$item->url}}" rel="external" target="_blank">{{$item->name}}</a></td>
                    <td>{{$item->editorial->name}}</td>
                    <td>{{$item->state}}</td>
                    <td>{{$item->start ? $item->start->format('Y-m') : '-'}}</td>
                    <td>{{$item->announced_end ? $item->announced_end->format('Y-m') : '-'}}</td>
                    <td>{{$item->end ? $item->end->format('Y-m') : '-'}}</td>
                    <td>{{ $item->state == "Recaudando" ?
                        "-" : ($item->isLate() ? "No" : "Si") }}</td>
                <tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection