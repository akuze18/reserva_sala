@extends('marco.sistema2')

@section('titulo')
    Buscar Docente
@endsection
@section('panelIzq')
<div class="nav-item">
    <div class="nav-link">
        <h1><i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;FILTROS</h1>
        <div class="col-md-12">
            <form method="GET" action="{{route('CA.search')}}">
                @include('marco.form.select',fData('docente',$docente,$docentes,true,null,true,false))
                @include('marco.form.select',fData('carrera',$carrera,$carreras,true,null,true,false))
                @include('marco.form.select',fData('nivel',$nivel,$niveles,true,null,true,false))
                @include('marco.form.select',fData('asignatura',$asignatura,$asignaturas,true,null,true,false))
                @include('marco.form.select',fData('modulo',$modulo,$modulos,true,null,true,false))
                @include('marco.form.select',fData('dia',$dia,$dias,true,null,true,false))
                @include('marco.form.submit',fData('filter','fa-filter'))
            </form>
        </div>
        <span>No es necesario ocupar todos los filtros</span>
    </div>
</div>
@endsection

@section('titulo_contenido')
    <div class="row">
        <div class="col-sm-11">
            <h1 class="text-center"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;BUSQUEDA DOCENTE</h1>
        </div>
        <div class="col-sm-1">
            <a href="{{route('inicio')}}" class="btn btn-success">Inicio</a>
        </div>
    </div>
@endsection

@section('contenido')
    <table class="table table-condensed table-responsive">
        <thead>
            <tr>
                <th>Docente</th>
                <th>Carrera</th>
                <th>Semestre</th>
                <th>Asignatura</th>
                <th>Sala</th>
                <th>Dia</th>
                <th>Modulo</th>
            </tr>
        </thead>
        <tbody class="">
        @if($cargas_academicas->count()==0)
            <div class="jumbotron alert alert-danger text-center"><p>NO SE HAN ENCONTRADO RESULTADOS</p></div>
        @else
            <div><p>RESULTADOS: {{$cargas_academicas->firstItem()}}-{{$cargas_academicas->lastItem()}} de {{$cargas_academicas->total()}}</p></div>
        @endif
        @foreach($cargas_academicas as $carga_academica)
            <tr >
                <td>{{$carga_academica->docente->name}}</td>
                <td>{{$carga_academica->asignatura->carrera->name}}</td>
                <td>{{$carga_academica->asignatura->nivel->name}}</td>
                <td>{{$carga_academica->asignatura->name}}</td>
                <td>{{$carga_academica->sala->long_name}}</td>
                <td>{{$carga_academica->horario->dia->name}}</td>
                <td>{{$carga_academica->horario->modulo->full_name}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="div-center">{{$cargas_academicas->appends(Request::except('page'))->links(paginacion_BS4())}}</div>
@endsection

@section('otros_js')
    <script language="javascript">
        $(document).ready(function(){
            $("#carrera").change(function(){
                var $selector = $(this);
                $selector.find('option:selected').each(function(){
                    var id_select = $(this).val();
                    $.post("{{route('getAsignaturas')}}",{parentId: id_select},function(data){
                        $("#asignatura").html(data);
                    });
                });
            });
        });
    </script>
@endsection