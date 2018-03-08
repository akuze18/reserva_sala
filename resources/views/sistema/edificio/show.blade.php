@extends('marco.sistema2')

@section('titulo')
    Detalle de Edificio
@endsection

@section('titulo_contenido')
    <div class="row">
        <div class="col-sm-9">
            <h3 class="card-title">Detalle de Edificio</h3>
        </div>
        <div class="col-sm-3">
            <a href="{{route('edificio.list')}}" class="btn btn-info">Volver a Listado</a>
        </div>
    </div>
@endsection

@section('contenido')
    <ul class="list-group">
        <li class="list-group-item row">
            <span class="badge badge-danger col-sm-2">Nombre</span>
            <span class="col-sm-10">{{$edificio->name}}</span>
        </li>
        <li class="list-group-item row">
            <span class="badge badge-danger col-sm-2">Pisos</span>
            <span class="col-sm-10">(Asignados {{$edificio->pisos->count()}})</span>
        </li>
        @foreach($edificio->pisos as $piso)
            <li class="list-group-item row">
                <span class="col-sm-1">&nbsp;</span>
                <span class="col-sm-8">
                    {{'Piso '.$piso->name}}
                </span>
            </li>
        @endforeach
    </ul>
@endsection