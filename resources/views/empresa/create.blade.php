@extends('base')
@section('title', 'Crear empresa')
@section('body')
<div class="row">
    <div class="col">
        <form method="POST" action="/editoriales">
        @csrf
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input id="name" name="name" class="form-control" type="text">
            </div>
            <div class="mb-3">
                <label for="url" class="form-label">URL</label>
                <input id="url" name="url" class="form-control" type="text">
            </div>

            <button type="submit" class="btn btn-primary">Crear</button>
        </form>
    </div>
</div>
@endsection