@extends('marco.sistema2')

@section('titulo')
    Listado de Ramos de la carrera {{$carrera->name}}
@endsection

@section('titulo_contenido')
    <div class="row">
        <div class="col-sm-10">
            <h3 class="card-title">Ramos de carrera {{$carrera->name}}</h3>
        </div>
        @permission('create.asignatura')
        <div class="col-sm-2">
            <a href="{{route('asignatura.create',$carrera->id)}}" class="btn btn-success col-sm-12">Nuevo Ramo</a>
            <p></p>
            <a href="{{route('carrera.show',$carrera->id)}}" class="btn btn-info  col-sm-12">Volver al detalle</a>
        </div>
        @endpermission
    </div>
@endsection

@section('contenido')
    <ul class="list-group">
        @foreach($asignaturas as $asignatura)
            <li class="list-group-item">
                <div class="row">
                <div class="col-sm-1">
                    {{$asignatura->nivel->name}}
                </div>
                <div class="col-sm-7">
                    {{$asignatura->name}}
                </div>
                <div class="col-sm-4">
                    <!-- Botonera de opciones por elemento -->
                    @permission('delete.asignatura')
                    <button type="button" data-toggle="modal" data-target="#modalborrar"
                            class="btn btn-sm btn-danger derecha" id="{{$asignatura->id}}">
                        Eliminar
                    </button>
                    @endpermission
                    @permission('edit.asignatura')
                    <a href="{{route('asignatura.edit',$asignatura->id)}}" class="btn btn-sm btn-warning derecha">Modificar</a>
                    @endpermission
                    @permission('see.asignatura')
                    <a href="{{route('asignatura.show',$asignatura->id)}}" class="btn btn-sm btn-primary derecha">Detalle</a>
                    @endpermission
                </div>
                </div>
            </li>
        @endforeach
    </ul>

    <div class="div-center">
        {{$asignaturas->links(paginacion_BS4())}}
    </div>
    @include('modals.confirma-eliminar',['ruta_destroy'=>'asignatura.destroy','mensaje_destroy'=>'Esta segudo que desea eliminar el ramo'])
@endsection

@section('otros_js')
    <script language="javascript">
        $('#modalborrar').on('show.bs.modal', function(e) {
            var $modal = $(this),
                    esseyId = e.relatedTarget.id;
            var $formulario = $modal.find('.form-elimina');
            var $baseAction = $formulario[0].getAttribute('action');
            var $newAction = $baseAction.replace('_ID_',esseyId);
            $formulario[0].setAttribute('action',$newAction);
        });
    </script>
@endsection