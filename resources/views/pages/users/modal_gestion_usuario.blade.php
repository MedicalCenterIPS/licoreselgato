<div class="modal fade" id="modalPermisosUsuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="modalPermisosUsuarioLabel">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content p-0">
            <div class="panel panel-inverse p-0 mb-0">
                <div class="panel-heading text-center bg-blue p-1">
                    <h4 class="panel-title fs-4">Usuario</h4>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="panel-body p-2 mb-0">

                    <div class="row mb-2">
                        <div class="col-md-2">
                            <div class="input-group">
                                <span class="input-group-text">ID</span>
                                <input type="text" class="form-control bg-white text-center" id="idUser" disabled>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="input-group">
                                <span class="input-group-text">Nombre Completo</span>
                                <input type="text" class="form-control bg-white text-center" id="nameUser" disabled>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="input-group">
                                <span class="input-group-text">Correo</span>
                                <input type="text" class="form-control bg-white text-center" id="emailUser" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text">Rol</span>
                                <select class="form-select text-center" id="selectRolUser" name="selectRolUser">
                                    @foreach ($roles as $rol)
                                        <option value="{{ $rol->name }}">{{ $rol->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text">Proceso</span>
                                <select class="form-select text-center" id="selectProcessUser" name="selectProcessUser">
                                    @foreach ($procesos as $proceso)
                                        <option value="{{ $proceso->id }}">{{ $proceso->process }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text">Estado</span>
                                <input type="radio" class="btn-check flex-grow-1" name="stateUser" value="1" id="activeUser"
                                    autocomplete="off">
                                <label class="btn btn-outline-green flex-grow-1" for="activeUser">Activo</label>

                                <input type="radio" class="btn-check flex-grow-1" name="stateUser" value="0" id="retiredUser"
                                    autocomplete="off">
                                <label class="btn btn-outline-danger flex-grow-1" for="retiredUser">Retirado</label>
                            </div>
                        </div>
                        <div class="col-md-6">

                        </div>
                    </div>

                </div>
            </div>

            <div class="modal-footer p-1">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnUpdate" disabled>Guardar</button>
            </div>
        </div>
    </div>
</div>
