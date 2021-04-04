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
    </div>
</div>
<div class="row">
    <div class="col-md-auto">
        <table class="table caption-top">
            <caption>
                Listado de preventas recaudando.
            </caption>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Editorial</th>
                    <th>Puntualidad</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($recaudando as $item)
                <tr>
                    <td><a href="{{$item->url}}">{{$item->name}}</a> @auth <a href="/preventas/{{$item->id}}/edit">Editar</a>@endauth</td>
                    <td>{{$item->empresa->name}}</td>
                    <td>{{$item->tarde ? "No" : "Si" }}</td>
                <tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-md-auto">
        <table class="table caption-top">
            <caption>
                Listado de preventas pendientes de entrega.
            </caption>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Editorial</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pendienteDeEntrega as $item)
                <tr>
                    <td><a href="{{$item->url}}">{{$item->name}}</a> @auth <a href="/preventas/{{$item->id}}/edit">Editar</a>@endauth</td>
                    <td>{{$item->empresa->name}}</td>
                <tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-md-auto">
        <table class="table caption-top">
            <caption>
                Listado de preventas parcialmente entregadas.
            </caption>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Editorial</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($parcialmenteEntregado as $item)
                <tr>
                    <td><a href="{{$item->url}}">{{$item->name}}</a> @auth <a href="/preventas/{{$item->id}}/edit">Editar</a>@endauth</td>
                    <td>{{$item->empresa->name}}</td>
                <tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-md-auto">
        <table class="table caption-top">
            <caption>
                Listado de preventas entregadas.
            </caption>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Editorial</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($entregado as $item)
                <tr>
                    <td><a href="{{$item->url}}">{{$item->name}}</a> @auth <a href="/preventas/{{$item->id}}/edit">Editar</a>@endauth</td>
                    <td>{{$item->empresa->name}}</td>
                <tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-md-auto">
        <table class="table caption-top">
            <caption>
                Listado de preventas cuyo estado se desconoce.
            </caption>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Editorial</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sinDefinir as $item)
                <tr>
                    <td><a href="{{$item->url}}">{{$item->name}}</a> @auth <a href="/preventas/{{$item->id}}/edit">Editar</a>@endauth</td>
                    <td>{{$item->empresa->name}}</td>
                <tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection