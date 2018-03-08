@extends('marco.sistema2')

@section('titulo')
    Modificar Sala
@endsection

@section('titulo_contenido')
    <div class="row">
        <div class="col-sm-9">
            <h3 class="card-title">Modificar Sala</h3>
        </div>
        <div class="col-sm-3">
            <a href="{{route('sala.list')}}" class="btn btn-info">Volver a Listado</a>
        </div>
    </div>
@endsection

@section('contenido')
    <div class="text-center">
        <form class="form" method="post" action="{{route('sala.update',$sala->id)}}">
            {{ csrf_field() }}
            {{ method_field('put') }}
            @include('marco.form.select',fData('edificio_id',$sala->piso->edificio->id,$edificios))
            @include('marco.form.select',fData('piso_id',$sala->piso->id,$pisos))
            @include('marco.form.textbox',fData('name',$sala->name))
            @include('marco.form.numberbox',fData('capacidad',$sala->capacidad,[],true,45))
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