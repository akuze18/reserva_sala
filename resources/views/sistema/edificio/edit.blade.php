@extends('marco.sistema2')

@section('titulo')
    Modificar Edificio
@endsection

@section('titulo_contenido')
    <div class="row">
        <div class="col-sm-9">
            <h3 class="card-title">Modificar Edificio</h3>
        </div>
        <div class="col-sm-3">
            <a href="{{route('edificio.list')}}" class="btn btn-info">Volver a Listado</a>
        </div>
    </div>
@endsection

@section('contenido')
    <div class="text-center">
        <form class="form" method="post" action="{{route('edificio.update',$edificio->id)}}">
            {{ csrf_field() }}
            {{method_field('put')}}
            @include('marco.form.textbox',fData('name',$edificio->name))
            @include('marco.form.submit',fData('save','fa-save'))
        </form>
    </div>
@endsection
