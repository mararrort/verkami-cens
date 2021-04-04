@extends('base')

@section('title', 'Listado de Editoriales')

@section('body')
<div class="row">
    <div class="col-md-auto">
        <h1>Listado de editoriales</h1>
        <p>A continuación se muestra un listado de las editoriales registradas, 
        con información numérica respecto a la situación de sus preventas.</p>
        <p>Los nombres de las preventas son enlaces a su sitio web.</p>
        <p>Tan solo se registran editoriales de las que haya preventas a registrar.</p>
        @auth<a href="{{route('editoriales.create')}}">Añadir empresa</a>@endauth
    </div>
</div>
<div class="row">
    <div class="col">
        <table class="table">
            <caption>
                Listado de editoriales y resumen del estado de sus preventas.
            </caption>
            <thead>
                <tr>
                    <th>Editorial</th>
                    <th colspan="5">Preventas</th>
                </tr>
                <tr>
                    <td></td>
                    <td>Total</td>
                    <td>Recaudando</td>
                    <td>Pendiente de entregar</td>
                    <td>Parcialmente entregado</td>
                    <td>Entregado</td>
                    <td>Sin definir</td>
                    <td>Con retraso</td>
            </thead>
            <tbody>
                @foreach ($empresas as $empresa)
                <tr>
                    <td><a href="{{$empresa->url}}">{{$empresa->name}}</a></td>
                    <td>{{count($empresa->preventas)}}</td>
                    <td>{{count($empresa->getPreventas('Recaudando'))}}</td>
                    <td>{{count($empresa->getPreventas('Pendiente de entrega'))}}</td>
                    <td>{{count($empresa->getPreventas('Parcialmente entregado'))}}</td>
                    <td>{{count($empresa->getPreventas('Entregado'))}}</td>
                    <td>{{count($empresa->getPreventas('Sin definir'))}}</td>
                    <td>{{$empresa->getTardias()}} de {{count($empresa->preventas)}}</td>
                <tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection