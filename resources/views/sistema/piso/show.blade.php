@extends('marco.sistema2')

@section('titulo')
    Detalle de Piso
@endsection

@section('titulo_contenido')
    <div class="row">
        <div class="col-sm-9">
            <h3 class="card-title">Detalle de Piso</h3>
        </div>
        <div class="col-sm-3">
            <a href="{{route('piso.list')}}" class="btn btn-info">Volver a Listado</a>
        </div>
    </div>
@endsection

@section('contenido')
    <ul class="list-group">
        <li class="list-group-item row">
            <span class="badge badge-danger col-sm-2">Nombre</span>
            <span class="col-sm-10">{{$piso->name}}</span>
        </li>
        <li class="list-group-item row">
            <span class="badge badge-danger col-sm-2">Edificio</span>
            <span class="col-sm-10">{{$piso->edificio->name}}</span>
        </li>
        <li class="list-group-item row">
            <span class="badge badge-danger col-sm-2">Salas</span>
            <span class="col-sm-10">(Asignadas {{$piso->salas->count()}})</span>
        </li>
        @foreach($piso->salas as $sala)
            <li class="list-group-item row">
                <span class="col-sm-1">&nbsp;</span>
                <span class="col-sm-8">
                    {{'Sala '.$sala->name}}
                </span>
            </li>
        @endforeach
    </ul>
@endsection
