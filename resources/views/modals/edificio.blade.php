<!-- Modal Edificio-->
<div class="modal fade" id="modaledificio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Mantenedor Edificio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- formulario -->
                <form id="formedificio">
                    <div class="form-group">
                        <label for="name-edificio" class="form-control-label">Nombre Edificio:</label>
                        <input type="text" class="form-control" id="name-edificio" placeholder="Introduzca nombre del Edificio" required>
                    </div>

                </form>
                <!-- fin formulario -->
            </div>
            <div class="modal-footer">
                <button type="button" id="btnLimpiar" class="btn btn-warning">Limpiar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- fin modal Edificio -->