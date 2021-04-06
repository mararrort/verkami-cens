@extends('base')
@section('title', 'Editar empresa')
@section('body')
<div class="row">
    <div class="col">
        <form method="POST" action="{{route('editoriales.update', ['editoriale' => $editorial])}}">
        @method('PUT')
        @csrf
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input id="name" name="name" class="form-control" type="text"
                    value="{{$editorial->name}}">
            </div>
            <div class="mb-3">
                <label for="url" class="form-label">URL</label>
                <input id="url" name="url" class="form-control" type="text"
                    value="{{$editorial->url}}">
            </div>

            <button type="submit" class="btn btn-primary">Crear</button>
        </form>
    </div>
</div>
@endsection