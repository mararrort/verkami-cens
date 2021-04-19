@extends('base')
@section('title', "Crear TODO")

@section('body')
<form autocomplete="off" method="POST" action="{{route('todo.update', ['todo' => $todo ])}}">
    @csrf
    @method('PUT')
    <div>
        <label for="text" class="form-label">
        <input type="text" name="text" class="form-control" value="{{$todo->text}}" dusk="text">
    </div>
    <div>
        <label for="type" class="form-label">
        <select name="type" class="form-select" dask="type">
            <option value="private" @if($todo->type == "private") selected @endif>Privado</option>
            <option value="public" @if($todo->type == "public") selected @endif>Publico</option>
            <option value="undecided" @if($todo->type == "undecided") selected @endif>Indefinido</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary" dusk="edit">Actualizar</button>
</form>
@endsection