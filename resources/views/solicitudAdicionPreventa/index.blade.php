@extends('base')

@section('body')
<div class="row">
    <div class="col-md-auto">
        <ul>
            @foreach($sap as $item)
                <li><a href="{{route('peticion.show', ['peticion' => $item])}}">{{ $item->presale_name }}</a></li>
            @endforeach
        </ul>
    </div>
@endsection