@extends('base')

@section('body')
<div class="row">
    <div class="col-md-auto">
        <form method="POST" autocomplete="off" action="{{route('petition.update', ['petition' => $petition])}}">
            @csrf
            @method('PATCH')
            <div class="row">
                <div class="col-md-12">
                    Introduce el nombre y URL del mecenazgo
                </div>
                <div class="col-md-4">
                    <label for="presale_name" class="form-label">Nombre</label>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="presale_name" value="{{ $petition->presale_name}}">
                </div>
                @error('presale_name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="col-md-4">
                    <label for="presale_url" class="form-label">URL</label>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="presale_url" value="{{ $petition->presale_url }}">
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
                            <option value="{{$item->id}}" @if($petition->editorial_id == $item->id) selected @endif>{{$item->name}}</option>
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
                            <input type="text" class="form-control" name="editorial_name" value="{{ $petition->editorial_name }}">
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
                            <input type="text" class="form-control" name="editorial_url" value="{{ $petition->editorial_url }}">
                        </div>
                        @error('editorial_url')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <label for="state" class="form-label">Estado</label>
                    <select name="state" class="form-select">
                        <option @if($petition->state == "Recaudando") selected @endif>Recaudando</option>
                        <option @if($petition->state == "Pendiente de entrega") selected @endif>Pendiente de entrega</option>
                        <option @if($petition->state == "Parcialmente entregado") selected @endif>Parcialmente entregado</option>
                        <option @if($petition->state == "Entregado") selected @endif>Entregado</option>
                        <option @if($petition->state == "Entregado, faltan recompensas") selected @endif>Entregado, faltan recompensas</option>
                        <option @if($petition->state == "Abandonado") selected @endif>Abandonado</option>
                    </select>
                    @error('state')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            @if($petition->presale_id)
            <div class="row">
                <div class="mb-3">
                    <label for="info" class="form-label">Aporta fuentes sobre la información</label>
                    <textarea class="form-control" name="info" rows="3">{{$petition->info}}</textarea>
                </div>
            </div>
            @endif
            
        <div class="row">
            <div class="mb-3">
                <label for="start" class="form-label">Inicio de la preventa</label>
                <input dusk="start" type="date" name="start" class="form-control" value="{{$petition->start ? $petition->start->format('Y-m-d') : ''}}">
                @error('start')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="mb-3">
                <label for="announced_end" class="form-label">Fecha de entrega anunciada</label>
                <input dusk="announced_end" type="date" name="announced_end" class="form-control" value="{{$petition->announced_end ? $petition->announced_end->format('Y-m-d') : ''}}">
                @error('announced_end')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="mb-3">
                <label for="end" class="form-label">Fecha de entrega</label>
                <input dusk="end" type="date" name="end" class="form-control" value="{{$petition->end ? $petition->end->format('Y-m-d') : ''}}">
                @error('end')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
            <div class="row">
                <button type="submit" class="btn btn-primary">Aceptar</button>
            </div>
        </form>
    </div>
</div>
@endsection