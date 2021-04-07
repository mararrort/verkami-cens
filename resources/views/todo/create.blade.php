@extends('base')
@section('title', "Crear TODO")

@section('body')
<form method="POST" action="{{route('TODO.store')}}">
    @csrf
    <div>
        <label for="text" class="form-label">
        <input type="text" name="text" class="form-control" dusk="text">
        @error('text')
                <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div>
        <label for="type" class="form-label">
        <select name="type" class="form-select">
            <option value="private">Privado</option>
            <option value="public">Publico</option>
            <option value="undecided">Indefinido</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Crear</button>
</form>
@endsection