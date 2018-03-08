@extends('marco.sistema2')

@section('titulo')
    Detalle de Carrera
@endsection

@section('titulo_contenido')
    <div class="row">
        <div class="col-sm-9">
            <h3 class="card-title">Detalle de Carrera</h3>
        </div>
        <div class="col-sm-3">
            <a href="{{route('carrera.list')}}" class="btn btn-info">Volver a Listado</a>
        </div>
    </div>
@endsection

@section('contenido')
    <ul class="list-group">
        <li class="list-group-item row">
            <span class="badge badge-danger col-sm-2">Codigo</span>
            <span class="col-sm-10">{{$carrera->slug}}</span>
        </li>
        <li class="list-group-item row">
            <span class="badge badge-danger col-sm-2">Nombre</span>
            <span class="col-sm-10">{{$carrera->name}}</span>
        </li>
        <li class="list-group-item row">
            <span class="badge badge-danger col-sm-2">Total Semestres</span>
            <span class="col-sm-10">{{$carrera->semestres}}</span>
        </li>
        @permission('list.asignatura')
        <li class="list-group-item row">
            <span class="badge badge-danger col-sm-2">Detalle de Ramos</span>
            <span class="col-sm-2">
                <a href="{{route('asignatura.list',$carrera->id)}}" class="btn btn-primary btn-sm">Ver detalle</a>
            </span>
        </li>
        @endpermission
    </ul>
@endsection