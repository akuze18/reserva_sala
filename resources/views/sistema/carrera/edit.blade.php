@extends('marco.sistema2')

@section('titulo')
    Modificar Carrera
@endsection

@section('titulo_contenido')
    <div class="row">
        <div class="col-sm-9">
            <h3 class="card-title">Modificar Carrera</h3>
        </div>
        <div class="col-sm-3">
            <a href="{{route('carrera.list')}}" class="btn btn-info">Volver a Listado</a>
        </div>
    </div>
@endsection

@section('contenido')
    <div class="text-center">
        <form class="form" method="post" action="{{route('carrera.update',$carrera->id)}}">
            {{ csrf_field() }}
            {{method_field('put')}}
            @include('marco.form.textbox',fData('slug',$carrera->slug))
            @include('marco.form.textbox',fData('name',$carrera->name))
            @include('marco.form.select',fData('semestres',$carrera->semestres,$semestres))
            @include('marco.form.submit',fData('save','fa-save'))
        </form>
    </div>
@endsection
