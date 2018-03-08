<!-- Modal recuperar-->
<div class="modal fade" id="modalrecuperar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Recuperacion de Clave</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- formulario -->
            <form id="formrecuperar" method="POST" action="{{ route('password.email') }}">
            <div class="modal-body">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="email" class="form-control-label">Correo:</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Introduzca correo Institucional" value="{{ old('email') }}" required>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-success">Guardar</button>
            </div>
            </form>
            <!-- fin formulario -->
        </div>
    </div>
</div>

<!-- fin modal REcuperar -->