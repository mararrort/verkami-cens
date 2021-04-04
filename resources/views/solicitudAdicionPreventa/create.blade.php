@extends('base')

@section('body')
<div class="row">
    <div class="col-md-auto">
        <h1>Solicitar añadir una preventa</h1>
        <p>Rellena el campo de texto con información sobre la preventa a añadir.
        La información debe incluir el nombre, editorial, URLs y su estado actual.
        La falta de información llevará a que la solicitud se ignore.
        Si el campo texto tiene más de 500 carácteres, también se ignorará.
        Tras enviar la solicitud, se te redirigirá al índice de preventas.
        </p>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <form method="POST" action="{{route('peticion.store')}}">
        @csrf
            <div class="mb-3">
                <textarea class="form-control" name="text" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Crear</button>
        </form>

        
@endsection