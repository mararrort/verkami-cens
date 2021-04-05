@extends('base')

@section('body')
<div class="row">
    <div class="col-md-auto">
        Preventa: <a href="{{$sap->presale_url}}">{{$sap->presale_name}}</a>
    </div>
    <div class="col-md-auto">
        @if ($sap->editorial_id)
            Editorial: <a href="{{$sap->empresa->url}}">{{$sap->empresa->name}}</a>
        @else 
            Editorial: <a href="{{$sap->editorial_url}}">{{$sap->editorial_name}}</a>
        @endif
    </div>
    <div class="col-md-auto">
        Estado: {{$sap->state}}
    </div>
    <div class="col-md-auto">
        Retraso: {{$sap->late ? "Si" : "No"}}
    </div>
</div>
<div class="row">
    <div class="col-auto">
        <form action="{{route('peticion.accept', ['peticion' => $sap])}}" method="post">
            @csrf
            <button type="submit" class="btn btn-primary">Accept</button>
        </form>
    </div>
    <div class="col-auto">
        <form action="{{route('peticion.destroy', ['peticion' => $sap])}}" method="post">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger">Delete</button>
    </div>
</div>
@endsection