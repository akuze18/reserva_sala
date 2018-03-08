@extends('marco.sistema2')

@section('titulo')
    Modificar Ramo
@endsection

@section('titulo_contenido')
    <div class="row">
        <div class="col-sm-9">
            <h3 class="card-title">Modificar Ramo</h3>
        </div>
        <div class="col-sm-3">
            <a href="{{route('asignatura.list',$asignatura->carrera->id)}}" class="btn btn-info">Volver a Listado</a>
        </div>
    </div>
@endsection

@section('contenido')
    <div class="text-center">
        <form class="form" method="post" action="{{route('asignatura.update',$asignatura->id)}}">
            {{ csrf_field() }}
            {{method_field('put')}}
            @include('marco.form.select',fData('carrera',$asignatura->carrera->id,$carreras,false))
            @include('marco.form.textbox',fData('slug',$asignatura->slug))
            @include('marco.form.textbox',fData('name',$asignatura->name))
            @include('marco.form.select',fData('nivel',$asignatura->nivel->id,$niveles))
            @include('marco.form.submit',fData('save','fa-save'))
        </form>
    </div>
@endsection