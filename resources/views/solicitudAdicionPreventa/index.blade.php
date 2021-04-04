@extends('base')

@section('body')
<div class="row">
    <div class="col-md-auto">
        <ul>
            @foreach($sap as $item)
                <li>{{ substr($item->text, 0, 40).'...' }} <a href="{{route('peticion.show', ['peticion' => $item->id])}}">Show</a></li>
            @endforeach
        </ul>
    </div>
@endsection