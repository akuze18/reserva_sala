@extends('marco.sistema2')

@section('titulo')
    Detalle de Sala
@endsection

@section('titulo_contenido')
    <div class="row">
        <div class="col-sm-9">
            <h3 class="card-title">Detalle de Sala</h3>
        </div>
        <div class="col-sm-3">
            <a href="{{route('sala.list')}}" class="btn btn-info">Volver a Listado</a>
        </div>
    </div>
@endsection

@section('contenido')
    <ul class="list-group">
        <li class="list-group-item row">
            <span class="badge badge-danger col-sm-2">Nombre</span>
            <span class="col-sm-10">{{$sala->name}}</span>
        </li>
        <li class="list-group-item row">
            <span class="badge badge-danger col-sm-2">Capacidad</span>
            <span class="col-sm-10">{{$sala->capacidad}}</span>
        </li>
        <li class="list-group-item row">
            <span class="badge badge-danger col-sm-2">Piso</span>
            <span class="col-sm-10">{{$sala->piso->name}}</span>
        </li>
        <li class="list-group-item row">
            <span class="badge badge-danger col-sm-2">Edificio</span>
            <span class="col-sm-10">{{$sala->piso->edificio->name}}</span>
        </li>
    </ul>
@endsection
