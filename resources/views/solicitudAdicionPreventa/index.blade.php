@extends('base')

@section('body')
<div class="row">
    <div class="col-auto">
        <h2>Peticiones de creación</h2>
        <ul>
            @foreach($createPetitions as $item)
                <li><a href="{{route('peticion.show', ['peticion' => $item])}}">{{ $item->presale_id ? $item->presale->name : $item->presale_name }}</a></li>
            @endforeach
        </ul>
    </div>

    <div class="col-auto">
        <h2>Peticiones de actualización</h2>
        <ul>
            @foreach($updatePetitions as $item)
                <li><a href="{{route('peticion.show', ['peticion' => $item])}}">{{ $item->presale_id ? $item->presale->name : $item->presale_name }}</a></li>
            @endforeach
        </ul>
    </div>
@endsection