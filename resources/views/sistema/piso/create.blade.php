@extends('marco.sistema2')

@section('titulo')
    Crear Piso
@endsection

@section('titulo_contenido')
    <div class="row">
        <div class="col-sm-9">
            <h3 class="card-title">Crear Piso</h3>
        </div>
        <div class="col-sm-3">
            <a href="{{route('piso.list')}}" class="btn btn-info">Volver a Listado</a>
        </div>
    </div>
@endsection

@section('contenido')
    <div class="text-center">
        <form class="form" method="post" action="{{route('piso.store')}}">
            {{ csrf_field() }}
            @include('marco.form.select',fData('edificio_id',null,$edificios))
            @include('marco.form.textbox',fData('name'))
            @include('marco.form.submit',fData('save','fa-save'))
        </form>
    </div>
@endsection
