@extends('marco.sistema2')

@section('titulo')
    Modificar Usuario
@endsection
@section('titulo_contenido')
    <div class="row">
        <div class="col-sm-9">
            <h3 class="card-title">Modificar Usuario</h3>
        </div>
        <div class="col-sm-3">
            <a href="{{route('usuario.list')}}" class="btn btn-info">Volver a Listado</a>
        </div>
    </div>
@endsection
@section('contenido')
    <div class="text-center">
        <form class="form" method="post" action="{{route('usuario.update',$user->id)}}">
            {!! csrf_field() !!}
            {{method_field('put')}}
            @include('marco.form.textbox',fData('rut',$user->rut,[],true))
            @include('marco.form.textbox',fData('first_name',$user->first_name))
            @include('marco.form.textbox',fData('last_name',$user->last_name))
            @include('marco.form.textbox',fData('email',$user->email))
            @include('marco.form.select',fData('perfil',$user->roles[0]->id,$roles))
            @include('marco.form.select',fData('carrera',$user->carrera->id,$carreras))
            @include('marco.form.submit',fData('save','fa-save'))
        </form>
    </div>
@endsection

@section('otros_js')
    <script language="javascript">
        $(document).ready(function(){
            $("#first_name").change(sugiere_mail);
            $("#last_name").change(sugiere_mail);
        });
        function sugiere_mail(){
            var este = $(this);
            var actual = este.val();
            este.val(actual.charAt(0).toUpperCase()+actual.slice(1).toLowerCase());
            var fName = $("#first_name");
            var lName = $("#last_name");
            if(fName.val()!="" && lName.val()!=""){
                var mail = $("#email");
                mail.val(fName.val()+"."+lName.val()+"@inacapmail.cl");
            }
        }
    </script>
@endsection