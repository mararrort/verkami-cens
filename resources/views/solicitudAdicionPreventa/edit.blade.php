@extends('base')

@section('body')
<div class="row">
    <div class="col-md-auto">
        <form method="POST" action="{{route('peticion.update', ['peticion' => $sap ])}}">
        @csrf
        @method('PUT')
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="{{$sap->solved}}" name="solved">
                <label for="solved" class="form-check-label">Solucionada</label>
            </div>

            <button type="submit" class="btn btn-primary">Editar</button>
        </form>
    </div>
</div>
@endsection