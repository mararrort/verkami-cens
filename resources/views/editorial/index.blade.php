@extends('base')

@section('title', 'Listado de Editoriales')

@section('body')
<div class="row">
    <div class="col-md-auto">
        <h1>Listado de editoriales</h1>
        <p>A continuación se muestra un listado de las editoriales registradas, 
        con información numérica respecto a la situación de sus preventas.</p>
        <p>Los nombres de las preventas son enlaces a su sitio web.</p>
        <p>Al pulsar en la cifra de preventas de una editorial, te dirigirás
        al índice de preventas viendo tan solo las correspondientes a esa editorial</p>
        <p>Tan solo se registran editoriales de las que haya preventas a registrar.</p>
    </div>
</div>
<div class="row">
    <div class="col">
        <table id="editorialsTableId" class="table">
            <caption>
                Listado de editoriales y resumen del estado de sus preventas.
            </caption>
            <thead>
                <tr>
                    <th>Editorial</th>
                    <th colspan="4">Preventas</th>
                </tr>
                <tr>
                    <td></td>
                    <td>Total</td>
                    <td>Entregados con retraso</td>
                    <td>Pendiente de entregar</td>
                    <td>Pendiente de entregar y con retraso</td>
            </thead>
            <tbody>
                @foreach ($editorials as $editorial)
                <tr>
                    <td><a href="{{$editorial->url}}" rel="external" target="_blank">{{$editorial->name}}</a></td>
                    <td><a href="{{route('presales.filteredIndex', [$editorial])}}">{{count($editorial->presales)}}</a></td>
                    <td>{{count($editorial->getFinishedLatePresales())}}</td>
                    <td>{{count($editorial->getNotFinishedPresales())}}</td>
                    <td>{{count($editorial->getNotFinishedLatePresales())}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('js')
    <script src="/js/editorials.js"></script>
@endsection