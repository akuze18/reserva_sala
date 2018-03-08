@extends('marco.sistema2')

@section('titulo')
    Detalle de Ramo
@endsection

@section('titulo_contenido')
    <div class="row">
        <div class="col-sm-9">
            <h3 class="card-title">Detalle de Ramo</h3>
        </div>
        <div class="col-sm-3">
            <a href="{{route('asignatura.list',$asignatura->carrera->id)}}" class="btn btn-info">Volver a Listado</a>
        </div>
    </div>
@endsection

@section('contenido')
    <ul class="list-group">
        <li class="list-group-item row">
            <span class="badge badge-danger col-sm-2">Codigo</span>
            <span class="col-sm-10">{{$asignatura->slug}}</span>
        </li>
        <li class="list-group-item row">
            <span class="badge badge-danger col-sm-2">Nombre</span>
            <span class="col-sm-10">{{$asignatura->name}}</span>
        </li>
        <li class="list-group-item row">
            <span class="badge badge-danger col-sm-2">Carrera</span>
            <span class="col-sm-10">{{$asignatura->carrera->name}}</span>
        </li>
        <li class="list-group-item row">
            <span class="badge badge-danger col-sm-2">Semestres</span>
            <span class="col-sm-10">{{$asignatura->nivel->name}}</span>
        </li>
        <li class="list-group-item row">
            <span class="badge badge-danger col-sm-2">Cargas Academicas</span>
            <span class="col-sm-10">{{$asignatura->cargas_academicas->count()}}</span>
        </li>
        @foreach($asignatura->cargas_academicas as $carga)
            <li class="list-group-item row">
                <span class="col-sm-1">&nbsp;</span>
                <span class="badge badge-warning col-sm-2">Info</span>
                <span class="col-sm-9">{{$carga->docente->name.': Sala '.$carga->sala->name.', '.$carga->horario->display}}</span>
            </li>
        @endforeach
    </ul>
@endsection