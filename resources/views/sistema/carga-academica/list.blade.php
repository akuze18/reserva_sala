@extends('marco.sistema2')

@section('titulo')
    Listado de Cargas Academicas por Docente
@endsection

@section('titulo_contenido')
    <div class="row">
        <div class="col-sm-9">
            <h3 class="card-title">Listado de Cargas Academicas por Docente</h3>
        </div>
    </div>
@endsection

@section('contenido')
    <ul class="list-group">
        @foreach($docentes as $docente)
            <li class="list-group-item">
                <div class="row">
                    <div class="col-sm-8">
                        {{''.$docente->name.' > '.$docente->carrera->name}}
                    </div>
                    <div class="col-sm-4">
                        <!-- Botonera de opciones por elemento -->
                        @permission('see.cargaacademica')
                        <a href="{{route('CA.detail',$docente->id)}}" class="btn btn-sm btn-primary derecha">Detalle</a>
                        @endpermission
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
    <div class="div-center">
        {{$docentes->links(paginacion_BS4())}}
    </div>
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