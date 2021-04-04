@extends('base')
@section('title', 'Crear preventa')
@section('body')
<div class="row">
    <div class="col">
        <form method="POST" action="/preventas/{{$preventa->id}}">
        @csrf
        @method('PUT')
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input name="name" class="form-control" type="text" value="{{$preventa->name}}">
            </div>
            <div class="mb-3">
                <label for="url" class="form-label">URL</label>
                <input name="url" class="form-control" type="text" value="{{$preventa->url}}">
            </div>

            <div class="mb-3">
                <label for="editorial" class="form-label">Editorial</label>
                <select name="editorial" class="form-select">
                    @foreach ($editoriales as $editorial)
                        <option value="{{$editorial->id}}" @if($preventa->empresa->id == $editorial->id) selected @endif>{{$editorial->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="state" class="form-label">Estado</label>
                <select name="state" class="form-select">
                    <option @if($preventa->state == 'Recaudando') selected @endif>Recaudando</option>
                    <option @if($preventa->state == 'Pendiente de entrega') selected @endif>Pendiente de entrega</option>
                    <option @if($preventa->state == 'Parcialmente entregado') selected @endif>Parcialmente entregado</option>
                    <option @if($preventa->state == 'Entregado') selected @endif>Entregado</option>
                    <option @if($preventa->state == 'Sin definir') selected @endif>Sin definir</option>
                </select>
            
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="{{$preventa->tarde}}" name="tarde">
                <label for="tarde" class="form-check-label">Tarde</label>
            </div>

            <button type="submit" class="btn btn-primary">Editar</button>
        </form>
    </div>
</div>
@endsection