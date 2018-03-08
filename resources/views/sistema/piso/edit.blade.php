@extends('marco.sistema2')

@section('titulo')
    Modificar Piso
@endsection

@section('titulo_contenido')
    <div class="row">
        <div class="col-sm-9">
            <h3 class="card-title">Modificar Piso</h3>
        </div>
        <div class="col-sm-3">
            <a href="{{route('piso.list')}}" class="btn btn-info">Volver a Listado</a>
        </div>
    </div>
@endsection

@section('contenido')
    <div class="text-center">
        <form class="form" method="post" action="{{route('piso.update',$piso->id)}}">
            {{ csrf_field() }}
            {{method_field('put')}}
            @include('marco.form.select',fData('edificio_id',$piso->edificio_id,$edificios))
            @include('marco.form.textbox',fData('name',$piso->name))
            @include('marco.form.submit',fData('save','fa-save'))
        </form>
    </div>
@endsection
