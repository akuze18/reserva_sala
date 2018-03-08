<div class="modal fade" id="modalinfo" tabindex="-1" role="dialog" aria-labelledby="ModalInfoTittle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalInfoTittle">Descripción de Disponibilidad</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card text-center">
                <div class="card-block">
                    <blockquote class="card-blockquote table-success" style="height: 3em">Disponible</blockquote>
                </div>
                @role('docente|admin|operador')
                <div class="card-block">
                    <blockquote class="card-blockquote table-alumno" style="height: 3em">Ocupada por un alumno</blockquote>
                </div>
                @endrole
                @role('admin|operador')
                <div class="card-block">
                    <blockquote class="card-blockquote table-CA" style="height: 3em">Ocupada por docente (Carga Academica)</blockquote>
                </div>
                <div class="card-block">
                    <blockquote class="card-blockquote table-danger" style="height: 3em">Ocupada por docente (Solicitud)</blockquote>
                </div>
                <div class="card-block">
                    <blockquote class="card-blockquote table-warning" style="height: 3em">Pendiente de Solicitud</blockquote>
                </div>
                <div class="card-block">
                    <blockquote class="card-blockquote table-none" style="height: 3em">No Disponible</blockquote>
                </div>
                @endrole
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>