@extends('marco.sistema2')

@section('titulo')
    Modificar Carga Academica
@endsection

@section('titulo_contenido')
    <div class="row">
        <div class="col-sm-9">
            <h3 class="card-title">Modificar Carga Academica</h3>
        </div>
        <div class="col-sm-3">
            <a class="btn btn-info" href="{{route('CA.detail',$docente->id)}}">Volver al detalle</a>
        </div>
    </div>
@endsection

@section('contenido')
    <div class="text-center">
        <form class="form" method="post" action="{{route('CA.update',$cargaAcademica->id)}}">
            {{ csrf_field() }}
            {{method_field('put')}}
            @include('marco.form.select',fData('docente_id',$docente->id,$docentes,false))
            @include('marco.form.hidden',fData('docente_id',$docente->id))
            @include('marco.form.select',fData('dia_id',$dia->id,$dias,false))
            @include('marco.form.select',fData('modulo_id',$modulo->id,$modulos,false))
            @include('marco.form.hidden',fData('horario_id',$horario->id))
            @include('marco.form.select',fData('carrera_id',$carreraUsar,$carreras))
            @include('marco.form.select',fData('asignatura_id',$asignatura,$asignaturas))
            @include('marco.form.select',fData('edificio_id',$edificio,$edificios))
            @include('marco.form.select',fData('piso_id',$piso,$pisos))
            @include('marco.form.select',fData('sala_id',$sala,$salas))
            @include('marco.form.submit',fData('save','fa-save'))
        </form>
    </div>

@endsection

@section('otros_js')
    <script language="javascript">
        $(document).ready(function(){
            $("#carrera_id").change(function(){
                var $selector = $(this);
                $selector.find('option:selected').each(function(){
                    var id_select = $(this).val();
                    $.post("{{route('getAsignaturas')}}",{parentId: id_select},function(data){
                        $("#asignatura_id").html(data);
                    });
                });
            });
            $("#edificio_id").change(function(){
                var $selector = $(this);
                $selector.find('option:selected').each(function(){
                    var id_select = $(this).val();
                    $.post("{{route('getPisos')}}",{parentId: id_select},function(data){
                        $("#piso_id").html(data);
                    });
                });
            });
            $("#piso_id").change(function(){
                var $selector = $(this);
                $selector.find('option:selected').each(function(){
                    var id_select = $(this).val();
                    $.post("{{route('getSalas')}}",{parentId: id_select},function(data){
                        $("#sala_id").html(data);
                    });
                });
            });
        });
    </script>
@endsection