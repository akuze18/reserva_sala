@extends('marco.sistema2')

@section('titulo')
    Modificar Motivo
@endsection

@section('titulo_contenido')
    <div class="row">
        <div class="col-sm-9">
            <h3 class="card-title">Modificar Motivo</h3>
        </div>
        <div class="col-sm-3">
            <a href="{{route('motivo.list')}}" class="btn btn-info">Volver a Listado</a>
        </div>
    </div>
@endsection

@section('contenido')
    <div class="text-center">
        <form class="form" method="post" action="{{route('motivo.update',$motivo->id)}}">
            {{ csrf_field() }}
            {{method_field('put')}}
            @include('marco.form.select',fData('accion',$motivo->action,$acciones))
            @include('marco.form.textbox',fData('descripcion',$motivo->descripcion))
            @include('marco.form.submit',fData('save','fa-save'))
        </form>
    </div>
@endsection