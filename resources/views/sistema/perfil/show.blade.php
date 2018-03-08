@extends('marco.sistema2')

@section('titulo')
    Detalle de Perfil
@endsection

@section('titulo_contenido')
    <div class="row">
        <div class="col-sm-9">
            <h3 class="card-title">Detalle de Perfil</h3>
        </div>
        <div class="col-sm-3">
            <a href="{{route('perfiles.list')}}" class="btn btn-info">Volver a Listado</a>
        </div>
    </div>
@endsection

@section('contenido')
    <ul class="list-group">
        <li class="list-group-item row">
            <span class="badge badge-danger col-sm-2">Codigo</span>
            <span class="col-sm-10">{{$perfil->slug}}</span>
        </li>
        <li class="list-group-item row">
            <span class="badge badge-danger col-sm-2">Nombre</span>
            <span class="col-sm-10">{{$perfil->name}}</span>
        </li>
        <li class="list-group-item row">
            <span class="badge badge-danger col-sm-2">Usuarios</span>
            <span class="col-sm-10">{{$perfil->users->count()}}</span>
        </li>
        <li class="list-group-item row">
            <span class="badge badge-danger col-sm-2">Permisos</span>
            <span class="col-sm-10">Total de permitidas : {{$perfil->permissions->count()}}</span>
        </li>
        <li class="list-group-item row">
            <span class="col-sm-12">
                @include('marco.form.checklist',fData('permissions',$permisos,$permisos,false,null,true))
            </span>
        </li>
    </ul>
@endsection
