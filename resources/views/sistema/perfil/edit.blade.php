@extends('marco.sistema2')

@section('titulo')
    Modificar Perfil
@endsection

@section('titulo_contenido')
    <div class="row">
        <div class="col-sm-9">
            <h3 class="card-title">Modificar Perfil</h3>
        </div>
        <div class="col-sm-3">
            <a href="{{route('perfiles.list')}}" class="btn btn-info">Volver a Listado</a>
        </div>
    </div>
@endsection

@section('contenido')
    <div class="text-center">
        <form class="form" method="post" action="{{route('perfiles.update',$perfil->slug)}}">
            {{ csrf_field() }}
            {{method_field('put')}}
            @include('marco.form.textbox',fData('slug',$perfil->slug,[],false))
            @include('marco.form.textbox',fData('name',$perfil->name))
            @include('marco.form.textbox',fData('description',$perfil->description))
            @include('marco.form.checklist',fData('permissions',$perfil->permissions,$permisos,true,null,true))
            @include('marco.form.submit',fData('save','fa-save'))
        </form>
    </div>
@endsection

@section('otros_js')
    <script language="javascript">
        $(document).ready(function(){
            $(".action1").click(function(){
                var padre = $(this).parent();
                var group = '.group-'+padre.attr('id');
                $(group).each(function(){
                    $(this).find('.select-'+padre.attr('id')).each(function(){
                        var actual_val = Boolean($(this).prop('checked'));
                        //$(this).attr("checked", !actual_val);
                        $(this).prop("checked", !actual_val);
                        //alert($(this).attr('name'));
                    });
                });
            });
            $(".action2").click(function(){
                var padre = $(this).parent();
                var group = '.group-'+padre.attr('id');
                $(group).each(function(){
                    $(this).find('.select-'+padre.attr('id')).each(function(){
                        //alert($(this).attr('checked'));
                        //$(this).attr("checked", true);
                        $(this).prop("checked", true);
                        //alert($(this).attr('name'));
                    });
                });
            });
            $(".action3").click(function(){
                var padre = $(this).parent();
                var group = '.group-'+padre.attr('id');
                $(group).each(function(){
                    $(this).find('.select-'+padre.attr('id')).each(function(){
                        //alert($(this).attr('checked'));
                        //$(this).attr("checked", false);
                        $(this).prop("checked", false);
                        //alert($(this).attr('name'));
                    });
                });
            });
            /*$('input:checkbox').click(function(event){
                var valor = Boolean($(this).attr('checked'));
                $(this).attr("checked", !(valor));
            });*/
        });
    </script>
@endsection