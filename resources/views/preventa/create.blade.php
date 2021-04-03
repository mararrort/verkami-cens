@extends('base')
@section('title', 'Crear preventa')
@section('body')
<div class="row">
    <div class="col">
        <form method="POST" action="/preventas">
        @csrf
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input name="name" class="form-control" type="text">
            </div>
            <div class="mb-3">
                <label for="url" class="form-label">URL</label>
                <input name="url" class="form-control" type="text">
            </div>

            <div class="mb-3">
                <label for="editorial" class="form-label">Editorial</label>
                <select name="editorial" class="form-select">
                    @foreach ($editoriales as $editorial)
                        <option value="{{$editorial->id}}">{{$editorial->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="state" class="form-label">Estado</label>
                <select name="state" class="form-select">
                    <option>Recaudando</option>
                    <option>Pendiente de entrega</option>
                    <option>Parcialmente entregado</option>
                    <option>Entregado</option>
                    <option>Sin definir</option>
                </select>

            <button type="submit" class="btn btn-primary">Crear</button>
        </form>
    </div>
</div>
@endsection