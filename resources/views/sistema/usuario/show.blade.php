@extends('marco.sistema2')

@section('titulo')
    Detalle de Usuario
@endsection

@section('titulo_contenido')
    <div class="row">
        <div class="col-sm-9">
            <h3 class="card-title">Detalle de Usuario</h3>
        </div>
        <div class="col-sm-3">
            <a href="{{route('usuario.list')}}" class="btn btn-info">Volver a Listado</a>
        </div>
    </div>
@endsection
@section('contenido')
    <ul class="list-group">
        <li class="list-group-item row">
            <span class="badge badge-danger col-sm-2">Rut</span>
            <span class="col-sm-10">{{$usuario->rut}}</span>
        </li>
        <li class="list-group-item row">
            <span class="badge badge-danger col-sm-2">Nombre</span>
            <span class="col-sm-10">{{$usuario->first_name}}</span>
        </li>
        <li class="list-group-item row">
            <span class="badge badge-danger col-sm-2">Apellido</span>
            <span class="col-sm-10">{{$usuario->last_name}}</span>
        </li>
        <li class="list-group-item row">
            <span class="badge badge-danger col-sm-2">Correo</span>
            <span class="col-sm-10">{{$usuario->email}}</span>
        </li>
        <li class="list-group-item row">
            <span class="badge badge-danger col-sm-2">Perfil</span>
            <span class="col-sm-10">{{$usuario->roles[0]->name}}</span>
        </li>
        <li class="list-group-item row">
            <span class="badge badge-danger col-sm-2">Carrera</span>
            <span class="col-sm-10">{{$usuario->carrera->name}}</span>
        </li>
        @if($usuario->roles[0]->slug=='docente')
            <li class="list-group-item row">
            <span class="badge badge-warning col-sm-2">Carga Académica</span>
            <span class="col-sm-10">{{$usuario->cargas_academicas->count()}} bloques</span>
        </li>
        @endif
        <li class="list-group-item row">
            <span class="badge badge-warning col-sm-2">Total Solicitudes</span>
            <span class="col-sm-10">{{$usuario->solicitudes->count()}}</span>
        </li>
    </ul>
@endsection
