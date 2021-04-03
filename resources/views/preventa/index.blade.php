<table>
    <caption>
        Listado de preventas recaudando.
    </caption>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Editorial</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($recaudando as $item)
        <tr>
            <td><a href="{{$item->url}}">{{$item->name}}</a></td>
            <td>{{$item->empresa->name}}</td>
        <tr>
        @endforeach
    </tbody>
</table>

<table>
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
            <td><a href="{{$item->url}}">{{$item->name}}</a></td>
            <td>{{$item->empresa->name}}</td>
        <tr>
        @endforeach
    </tbody>
</table>

<table>
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
            <td><a href="{{$item->url}}">{{$item->name}}</a></td>
            <td>{{$item->empresa->name}}</td>
        <tr>
        @endforeach
    </tbody>
</table>

<table>
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
            <td><a href="{{$item->url}}">{{$item->name}}</a></td>
            <td>{{$item->empresa->name}}</td>
        <tr>
        @endforeach
    </tbody>
</table>

<table>
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
            <td><a href="{{$item->url}}">{{$item->name}}</a></td>
            <td>{{$item->empresa->name}}</td>
        <tr>
        @endforeach
    </tbody>
</table>
