@extends('marco.sistema2')

@section('titulo_contenido')
    <div class="row">
        <div class="col-sm-9">
            <h3 class="card-title">Crear Sala</h3>
        </div>
        <div class="col-sm-3">
            <a href="{{route('sala.list')}}" class="btn btn-info">Volver a Listado</a>
        </div>
    </div>
@endsection

@section('contenido')
    <div class="text-center">
        <form class="form" method="post" action="{{route('sala.store')}}">
            {!! csrf_field() !!}
            @include('marco.form.select',fData('edificio_id',null,$edificios))
            @include('marco.form.select',fData('piso_id',null,$pisos))
            @include('marco.form.textbox',fData('name'))
            @include('marco.form.numberbox',fData('capacidad',null,[],true,45))
            @include('marco.form.submit',fData('save','fa-save'))
        </form>
    </div>
@endsection

@section('otros_js')
    <script language="javascript">
        $(document).ready(function(){
            $("#edificio_id").change(function(){
                $("#edificio_id option:selected").each(function(){
                    var id_edificio = $(this).val();
                    $.post("{{route('getPisos')}}",{edificioId: id_edificio},function(data){
                        $("#piso_id").html(data);
                    });
                });
            });
        });
    </script>
@endsection