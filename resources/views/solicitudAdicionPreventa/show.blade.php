@extends('base')

@section('body')
<h2 dusk="header">{{ $sap->presale_id ? 'Actualización' : 'Creación' }}</h2>
    <div class="row">
        Preventa: <a href="{{$sap->presale_id ? $sap->preventa->url : $sap->presale_url}}">{{$sap->presale_id ? $sap->preventa->name : $sap->presale_name}}</a>
    </div>
    <div class="row">
        @if ($sap->editorial_id)
            Editorial: <a href="{{$sap->empresa->url}}">{{$sap->empresa->name}}</a>
        @else 
            Editorial: <a href="{{$sap->editorial_url}}">{{$sap->editorial_name}}</a>
        @endif
    </div>
    <div class="row">
        @if ($sap->presale_id)
            Estado actual: {{$sap->preventa->state}} | Estado propuesto: {{ $sap->state }}
        @else
            Estado: {{ $sap->state }}
        @endif
    </div>
    <div class="row">
        @if ($sap->presale_id)
            Retraso: {{ $sap->preventa->late ? "Si" : "No" }} | Retraso propuesto: {{ $sap->late ? "Si" : "No" }}
        @else
            Retraso: {{ $sap->late ? "Si" : "No" }}
        @endif
    </div>
    @if($sap->presale_id)
    <div class="row">
        Información: <p>{{ $sap->info }}</p>
    </div>
    @endif
    <div class="row">
        <div class="form-check">
        <input class="form-check-input" type="checkbox" name="sendTelegramNotification" @if($sap->sendTelegramNotification) checked @endif disabled>
        <label class="form-check-label" for="sendTelegramNotification">
            Enviar notificación por Telegram
        </label>
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
        <a href="{{route('peticion.edit', ['peticion' => $sap])}}"><button type="submit" class="btn btn-primary">Editar</button></a>
    </div>
    <div class="col-auto">
        <form action="{{route('peticion.destroy', ['peticion' => $sap])}}" method="post">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger">Delete</button>
    </div>
</div>
@endsection