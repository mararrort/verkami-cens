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
                @foreach ($editorials as $editorial)
                <tr>
                    <td><a href="{{$editorial->url}}" rel="external" target="_blank">{{$editorial->name}}</a></td>
                    <td>{{count($editorial->presales)}}</td>
                    <td>{{count($editorial->getPresales('Recaudando'))}}</td>
                    <td>{{count($editorial->getPresales('Pendiente de entrega'))}}</td>
                    <td>{{count($editorial->getPresales('Parcialmente entregado'))}}</td>
                    <td>{{count($editorial->getPresales('Entregado'))}}</td>
                    <td>{{count($editorial->getPresales('Sin definir'))}}</td>
                    <td>{{$editorial->getLates()}} de {{count($editorial->presales)}}</td>
                <tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection