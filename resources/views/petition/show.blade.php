@extends('base')

@section('body')

@if($error)
<div class="alert alert-warning" role="alert">
    Ha habido un error. No debe repetirse la actualización hasta que se resuelva
</div>
@endif
@if($presaleUrlError)
<div class="alert alert-warning" role="alert" dusk="presaleUrlError">
    Se intenta crear una preventa con una URL ya usada.
</div>
@endif
@if($editorialUrlError)
<div class="alert alert-warning" role="alert" dusk="editorialUrlError">
Se intenta crear una editorial con una URL ya usada.
</div>
@endif
<div class="row">
    <div class="col-auto">
        <h2 dusk="header">{{ $petition->presale_id ? 'Actualización' : 'Creación' }}</h2>
    </div>
</div>

<div class="row">
    <div class="col">
        <label for="presale_name" class="form-label">Preventa</label>
        <input name="presale_name" type="text" value="{{$petition->presale_id ? $petition->presale->name : $petition->presale_name}}" class="form-control" disabled>
    </div>
    <div class="col">
        <label for="presale_url" class="form-label">URL</label>
        <input name="presale_url" type="text" value="{{$petition->presale_id ? $petition->presale->url : $petition->presale_url}}" class="form-control" disabled>
    </div>
</div>

<div class="row">
    <div class="col">
        <label for="editorial_name" class="form-label">Editorial</label>
        <input name="editorial_name" type="text" value="{{$petition->editorial_id ? $petition->editorial->name : $petition->editorial_name}}" class="form-control" disabled>
    </div>
    <div class="col">
        <label for="editorial_url" class="form-label">URL</label>
        <input name="editorial_url" type="text" value="{{$petition->editorial_id ? $petition->editorial->url : $petition->editorial_url}}" class="form-control" disabled>
    </div>
</div>

<div class="row">
    @if($petition->presale_id)
    <div class="col">
        <label for="presale_state" class="form-label">Estado</label>
        <select name="presale_state" class="form-select" disabled>
            <option @if($petition->presale->state == "Recaudando") selected @endif>Recaudando</option>
            <option @if($petition->presale->state == "Pendiente de entrega") selected @endif>Pendiente de entrega</option>
            <option @if($petition->presale->state == "Parcialmente entregado") selected @endif>Parcialmente entregado</option>
            <option @if($petition->presale->state == "Entregado") selected @endif>Entregado</option>
        </select>
    </div>
    @endif
    <div class="col">
        <label for="petition_state" class="form-label">Estado propuesto</label>
        <select name="petition_state" class="form-select" disabled>
            <option @if($petition->state == "Recaudando") selected @endif>Recaudando</option>
            <option @if($petition->state == "Pendiente de entrega") selected @endif>Pendiente de entrega</option>
            <option @if($petition->state == "Parcialmente entregado") selected @endif>Parcialmente entregado</option>
            <option @if($petition->state == "Entregado") selected @endif>Entregado</option>
        </select>
    </div>
</div>

@if($petition->presale_id)
<div class="row">
    <div class="col">
        <label for="info" class="form-label">Información</label>
        <textarea name="info" class="form-control" id="exampleFormControlTextarea1" rows="3" disabled>{{ $petition->info }}</textarea>
    </div>
</div>
@endif    
    
<div class="row">
    @if($petition->presale_id)
    <div class="col">
        <label for="start" class="form-label">Inicio de la preventa</label>
        <input type="date" name="start" class="form-control" value="{{$petition->presale->start ? $petition->presale->start->format('Y-m-d') : ''}}" disabled>
    </div>
    @endif
    <div class="col">
        <label for="start_p" class="form-label">Inicio de la preventa propuesto</label>
        <input type="date" name="start_p" class="form-control" value="{{$petition->start ? $petition->start->format('Y-m-d') : ''}}" disabled>
    </div>
</div>

<div class="row">
    @if($petition->presale_id)
    <div class="col">
        <label for="announced_end" class="form-label">Fecha de entrega anunciada</label>
        <input type="date" name="announced_end" class="form-control" value="{{$petition->presale->announced_end ? $petition->presale->announced_end->format('Y-m-d') : ''}}" disabled>
    </div>
    @endif
    <div class="col">
        <label for="announced_end_p" class="form-label">Fecha de entrega anunciada propuesta</label>
        <input type="date" name="announced_end_p" class="form-control" value="{{$petition->announced_end ? $petition->announced_end->format('Y-m-d') : ''}}" disabled>
    </div>
</div>

<div class="row">
    @if($petition->presale_id)
    <div class="col">
        <label for="end_p" class="form-label">Fecha de entrega</label>
        <input type="date" name="end_p" class="form-control" value="{{$petition->presale->end ? $petition->presale->end->format('Y-m-d') : ''}}" disabled>
    </div>
    @endif
    <div class="col">
        <label for="end_p" class="form-label">Fecha de entrega propuesta</label>
        <input type="date" name="end_p" class="form-control" value="{{$petition->end ? $petition->end->format('Y-m-d') : ''}}" disabled>
    </div>
</div>

<div class="row">
    <div class="col-auto">
        <form action="{{route('petition.accept', ['petition' => $petition])}}" method="post">
            @csrf
            <button type="submit" class="btn btn-primary">Accept</button>
        </form>
    </div>
    <div class="col-auto">
        <a href="{{route('petition.edit', ['petition' => $petition])}}"><button type="submit" class="btn btn-primary">Editar</button></a>
    </div>
    <div class="col-auto">
        <form action="{{route('petition.destroy', ['petition' => $petition])}}" method="post">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger">Delete</button>
    </div>
</div>
@endsection