@extends('marco.sistema2')

@section('titulo')
    Listado de Carreras
@endsection

@section('titulo_contenido')
    <div class="row">
        <div class="col-sm-10">
            <h3 class="card-title">Listado de Carreras</h3>
        </div>
        @permission('create.carrera')
        <div class="col-sm-2">
            <a href="{{route('carrera.create')}}" class="btn btn-success">Nueva Carrera</a>
        </div>
        @endpermission
    </div>
@endsection

@section('contenido')
    <ul class="list-group">
        @foreach($carreras as $carrera)
            <li class="list-group-item">
                <div class="row">
                <div class="col-sm-8">
                    {{$carrera->name}}
                </div>
                <div class="col-sm-4">
                    <!-- Botonera de opciones por elemento -->
                    @permission('delete.carrera')
                    <button type="button" data-toggle="modal" data-target="#modalborrar"
                            class="btn btn-sm btn-danger derecha" id="{{$carrera->id}}">
                        Eliminar
                    </button>
                    @endpermission
                    @permission('edit.carrera')
                    <a href="{{route('carrera.edit',$carrera->id)}}" class="btn btn-sm btn-warning derecha">Modificar</a>
                    @endpermission
                    @permission('see.carrera')
                    <a href="{{route('carrera.show',$carrera->id)}}" class="btn btn-sm btn-primary derecha">Detalle</a>
                    @endpermission
                </div>
                </div>
            </li>
        @endforeach
    </ul>
    <div class="div-center">
        {{$carreras->links(paginacion_BS4())}}
    </div>
    @include('modals.confirma-eliminar',['ruta_destroy'=>'carrera.destroy','mensaje_destroy'=>'Esta segudo que desea eliminar la carrera'])
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