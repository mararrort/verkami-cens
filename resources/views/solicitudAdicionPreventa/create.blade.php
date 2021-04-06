@extends('base')
@if($presale)
@section('title', 'Solicitar modificación')
@else
@section('title', 'Solicitar adición')
@endif
@section('body')
<div class="row">
    <div class="col-md-auto">
        <h1>{{$presale ? "Solicitar modificación" : "Solicitar adición"}}</h1>
        @if($presale)
        <p>Introduce la modificación sobre el estado o la puntualidad. Si deseas modificar otra cosa,
        deberás pedírmelo a <a href="https://twitter.com/mararrort">mi cuenta de Twitter</a></p>
        @else
        <p>Rellena los campos con información sobre la preventa a añadir.
        Tras enviar la solicitud, se te redirigirá al índice de preventas.
        </p>
        @endif
    </div>
</div>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="row">
    <div class="col-md-12">
        <form method="POST" action="{{route('peticion.store')}}">
        @csrf
        @if (!$presale)
        <div class="row">
            <div class="col-md-12">
                Introduce el nombre y URL del mecenazgo
            </div>
            <div class="col-md-4">
                <label for="presale_name" class="form-label">Nombre</label>
            </div>
            <div class="col-md-8">
                <input type="text" class="form-control" name="presale_name" value="{{old('presale_name')}}">
            </div>
            @error('presale_name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="col-md-4">
                <label for="presale_url" class="form-label">URL</label>
            </div>
            <div class="col-md-8">
                <input type="text" class="form-control" name="presale_url" value="{{old('presale_url')}}">
            </div>
            @error('presale_url')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="row">
            <div class="col-md-12">
                Selecciona la editorial a la que pertenece o introduce los datos si no está registrada.
            </div>
            <div class="col-md-6">
                <select class="form-select" name="editorial_id">
                    <option selected></option>
                    @foreach($editorials as $item)
                        <option value="{{$item->id}}" @if(old('editorial_id') == $item->id) selected @endif>{{$item->name}}</option>
                    @endforeach
                </select>
                @error('editorial_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-4">
                        <label for="editorial_name" class="form-label">Nombre</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="editorial_name" value="{{old('editorial_name')}}">
                    </div>
                    @error('editorial_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="editorial_url" class="form-label">URL</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="editorial_url" value="{{old('editorial_url')}}">
                    </div>
                    @error('editorial_url')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        @else
        <input name="presale_id" type="hidden" value="{{$presale->id}}">
        <input name="editorial_id" type="hidden" value="{{$presale->empresa->id}}">
        @endif

        <div class="row">
            <div class="col-md-12">
                <label for="state" class="form-label">Estado</label>
                <select name="state" class="form-select">
                    <option>Recaudando</option>
                    <option>Pendiente de entrega</option>
                    <option>Parcialmente entregado</option>
                    <option>Entregado</option>
                    <option>Sin definir</option>
                </select>
                @error('state')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="form-check">
                <label for="late" class="form-check-label">La entrega de la preventa está fuera de plazo</label>
                <input class="form-check-input" type="checkbox" name="late" value="{{old('late')}}">
            </div>
        </div>
        <button type="submit" class="btn btn-primary" dusk="submit">{{$presale ? "Solicitar modificación" : "Solicitar adición"}}</button>
    </form>
@endsection