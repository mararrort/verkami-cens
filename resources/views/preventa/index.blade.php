@extends('base')

@section('body')
<div class="row">
    <div class="col-md-auto">
        <h1>Listado de preventas</h1>
        <p>A continuación se muestra un listado de las preventas registradas, 
        separadas en cinco tablas en función de su estado (Recaudando, Pendiente de entrega,
        Parcialmente entregado, Entregado, Sin definir).</p>
        <p>Los nombres de las preventas son enlaces al sitio web donde se gestionaron
        (Comunmente Verkami).</p>
        <p>La clasificación de su estado se basa en la última información accedida.</p>
        <p>Se considera que una preventa es puntual si ninguno de sus productos
        ha quedado pendiente de entregar después de la fecha de entrega anunciada durante la campaña de recolecta</p>
        <p><a href="{{route('peticion.create')}}">Puedes solicitar añadir una preventa a través de este enlace</a></p>
        @auth<a href="{{route('preventas.create')}}">Añadir preventa</a>@endauth
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
                    <th>Puntualidad</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($presales as $item)
                @if ($item->tarde)
                <tr class="table-danger" dusk="danger">
                @elseif (!$item->tarde && $item->state == "Entregado")
                <tr class="table-success" dusk="success">
                @else
                <tr>
                @endif
                    <td><a dusk="editPresale" href="{{route('peticion.create', ['presale' => $item->id])}}"><i class="bi bi-pencil"></a></i><a href="{{$item->url}}">{{$item->name}}</a> @auth <a href="/preventas/{{$item->id}}/edit">Editar</a>@endauth</td>
                    <td>{{$item->empresa->name}}</td>
                    <td>{{$item->state}}</td>
                    <td>{{ ($item->state == "Sin definir" || $item->state == "Recaudando") ?
                        "-" : ($item->tarde ? "No" : "Si") }}</td>
                <tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection