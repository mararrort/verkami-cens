@extends('base')

@section('title', 'Listado de Editoriales')

@section('body')
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
                <tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection