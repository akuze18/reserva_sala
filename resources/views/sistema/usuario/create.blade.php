@extends('marco.sistema2')
@section('titulo')
    Crear Usuario
@endsection
@section('titulo_contenido')
    <div class="row">
        <div class="col-sm-9">
            <h3 class="card-title">Crear Usuario</h3>
        </div>
        <div class="col-sm-3">
            <a href="{{route('usuario.list')}}" class="btn btn-info">Volver a Listado</a>
        </div>
    </div>
@endsection
@section('contenido')
    <div class="text-center">
        <form class="form" method="post" action="{{route('usuario.store')}}">
            {!! csrf_field() !!}
            @include('marco.form.textbox',fData('rut'))
            @include('marco.form.textbox',fData('first_name'))
            @include('marco.form.textbox',fData('last_name'))
            @include('marco.form.textbox',fData('email'))
            @include('marco.form.select',fData('perfil',null,$roles))
            @include('marco.form.select',fData('carrera',null,$carreras))
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