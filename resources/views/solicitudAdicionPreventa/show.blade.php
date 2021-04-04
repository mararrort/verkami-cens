@extends('base')

@section('body')
<div class="row">
    <div class="col-md-auto">
        {{ $sap->text}}
    </div>
</div>
<div class="row">
    <div class="col-md-auto">
        <a href="{{ route('peticion.edit', ['peticion' => $sap]) }}">
        Editar</a>
    </div>
</div>
@endsection