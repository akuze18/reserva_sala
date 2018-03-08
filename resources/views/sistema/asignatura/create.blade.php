@extends('marco.sistema2')

@section('titulo')
    Crear Ramo
@endsection

@section('titulo_contenido')
    <div class="row">
        <div class="col-sm-9">
            <h3 class="card-title">Crear Ramo</h3>
        </div>
        <div class="col-sm-3">
            <a href="{{route('asignatura.list',$carrera->id)}}" class="btn btn-info">Volver a Listado</a>
        </div>
    </div>
@endsection

@section('contenido')
    <div class="text-center">

        <form class="form" method="post" action="{{route('asignatura.store',$carrera->id)}}">
            {{ csrf_field() }}
            @include('marco.form.select',fData('carrera',$carrera->id,$carreras,false))
            @include('marco.form.textbox',fData('slug'))
            @include('marco.form.textbox',fData('name'))
            @include('marco.form.select',fData('nivel',null,$niveles))
            @include('marco.form.submit',fData('save','fa-save'))
        </form>
    </div>
@endsection