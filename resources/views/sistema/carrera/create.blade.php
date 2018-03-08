@extends('marco.sistema2')

@section('titulo')
    Crear Carrera
@endsection

@section('titulo_contenido')
    <div class="row">
        <div class="col-sm-9">
            <h3 class="card-title">Crear Carrera</h3>
        </div>
        <div class="col-sm-3">
            <a href="{{route('carrera.list')}}" class="btn btn-info">Volver a Listado</a>
        </div>
    </div>
@endsection

@section('contenido')
    <div class="text-center">
        <form class="form" method="post" action="{{route('carrera.store')}}">
            {{ csrf_field() }}
            @include('marco.form.textbox',fData('slug'))
            @include('marco.form.textbox',fData('name'))
            @include('marco.form.select',fData('semestres',null,$semestres))
            @include('marco.form.submit',fData('save','fa-save'))
        </form>
    </div>
@endsection