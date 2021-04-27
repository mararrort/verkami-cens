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
        <p><a href="{{route('peticion.create')}}">Puedes solicitar añadir una preventa a través de este enlace</a></p>
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
                    <th>Nombre</th>
                    <th>Editorial</th>
                    <th>Estado</th>
                    <th>F. de financiación</th>
                    <th>F. de entrega anunciada</th>
                    <th>F. de entrega</th>
                    <th>Puntualidad</th>
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
                    <td><a dusk="editPresale" href="{{route('peticion.create', ['presale' => $item->id])}}"><i class="bi bi-pencil"></a></i><a href="{{$item->url}}" rel="external" target="_blank">{{$item->name}}</a></td>
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