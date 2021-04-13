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
        <p>Si deseas modificar otra cosa, deberás pedírmelo a <a href="https://twitter.com/roltrasos">mi cuenta de Twitter</a> o <a href="https://t.me/SafeForCrowdfunding">grupo de Telegram</a>.</p>
        @else
        <p>Rellena los campos con información sobre la preventa a añadir.
        Tras enviar la solicitud, se te redirigirá al índice de preventas.
        </p>
        @endif
    </div>
</div>
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
        <input name="editorial_id" type="hidden" value="{{$presale->editorial->id}}">
        @endif

        <div class="row">
            <div class="col-md-12">
                <label for="state" class="form-label">Estado</label>
                <select name="state" class="form-select">
                    <option @if(isset($presale) && $presale->status == "Recaudando") checked @endif>Recaudando</option>
                    <option @if(isset($presale) && $presale->status == "Pendiente de entrega") checked @endif>Pendiente de entrega</option>
                    <option @if(isset($presale) && $presale->status == "Parcialmente entregado") checked @endif>Parcialmente entregado</option>
                    <option @if(isset($presale) && $presale->status == "Entregado") checked @endif>Entregado</option>
                    <option @if(isset($presale) && $presale->status == "Sin definir") checked @endif>Sin definir</option>
                </select>
                @error('state')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-auto">
                <label for="start" class="form-label">Finalización de la preventa</label>
                <input dusk="start" type="date" name="start" class="form-control" @if(isset($presale) && isset($presale->start)) value="{{$presale->start->format('Y-m-d')}}" @endif>
                @error('start')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-auto">
                <label for="announced_end" class="form-label">Fecha de entrega anunciada</label>
                <input dusk="announced_end" type="date" name="announced_end" class="form-control" @if(isset($presale) && isset($presale->announced_end)) value="{{$presale->announced_end->format('Y-m-d')}}" @endif>
                @error('announced_end')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-auto">
                <label for="end" class="form-label">Fecha de entrega</label>
                <input dusk="end" type="date" name="end" class="form-control" @if(isset($presale) && isset($presale->end)) value="{{$presale->end->format('Y-m-d')}}" @endif>
                @error('end')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-auto">
                <div class="form-check">
                    <label for="late" class="form-check-label">La entrega de la preventa está fuera de plazo</label>    
                    <input class="form-check-input" type="checkbox" name="late" @if(isset($presale) && $presale->tarde) checked @endif>
                </div>
            </div>
        </div>

        @if($presale)
        <div class="row">
            <div class="mb-3">
                <label for="info" class="form-label">Aporta fuentes sobre la información</label>
                <textarea class="form-control" name="info" rows="3"></textarea>
            </div>
        </div>
        @endif
        <button type="submit" class="btn btn-primary" dusk="submit">{{$presale ? "Solicitar modificación" : "Solicitar adición"}}</button>
    </form>
@endsection