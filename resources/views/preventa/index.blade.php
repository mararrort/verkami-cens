<table>
    <caption>
        Listado de preventas y su estado.
    </caption>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($preventas as $preventa)
        <tr>
            <td><a href="{{$preventa->url}}">{{$preventa->name}}</a></td>
            <td>{{$preventa->state}}</td>
        <tr>
        @endforeach
    </tbody>
</table>