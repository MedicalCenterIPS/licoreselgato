<div class="modal fade" id="modalUnitProduction" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="modalPermisosUsuarioLabel">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content p-0">
            <div class="panel panel-inverse p-0 mb-0">
                <div class="panel-heading text-center bg-gradient-blue p-1">
                    <h4 class="panel-title fs-18px" id="title_proform">Registrar unidad de producción</h4>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal"
                        id="btnCloseModalRoute"></button>
                </div>

                <div class="panel-body p-2">
                    <form id="form_up">
                        @csrf
                        <input type="text" hidden value="" id="id_register_pu">
                        <div class="row mb-2">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="site" class="form-label"><b>Sede</b></label>
                                    <select class="form-select form-select-sm border border-dark SelectOut"
                                        id="site" name="site">
                                        <option value="">---</option>
                                        @foreach ($sites as $site)
                                            <option value="{{ $site->id }}">{{ $site->site }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="type_collaborator" class="form-label"><b>Tipo de Colaborador</b></label>
                                    <select class="form-select form-select-sm border border-dark SelectOut"
                                        id="type_collaborator" name="type_collaborator">
                                        <option value="">---</option>
                                        @foreach ($type_collaborators as $type_collaborator)
                                            <option value="{{ $type_collaborator->id }}">{{ $type_collaborator->type }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="company" class="form-label"><b>Empresa</b></label>
                                    <select class="form-select form-select-sm border border-dark SelectOut"
                                        id="company" name="company">
                                        <option value="">---</option>
                                        <option value="Aviomar">Aviomar</option>
                                        <option value="Snider">Snider</option>
                                        <option value="Colvan">Colvan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="month" class="form-label"><b>Mes</b></label>
                                    <select class="form-select form-select-sm border border-dark SelectOut"
                                        id="month" name="month">
                                        <option value="">---</option>
                                        @foreach ($months as $key => $value)
                                            <option value="{{ $value }}">{{ $key }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="year" class="form-label"><b>Año</b></label>
                                    <select class="form-select form-select-sm border border-dark SelectOut"
                                        id="year" name="year">
                                        <option value="">---</option>
                                        @php
                                            $currentYear = date('Y');
                                            $startYear = 2021;
                                        @endphp
                                        @for ($year = $startYear; $year <= $currentYear; $year++)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label class="form-label" for="amount"><b>Cantidad</b></label>
                                        <input type="text" id="amount" name="amount"
                                            class="form-control form-control-sm border border-dark text-center">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="tipor" class="form-label"><b>Tipo registro</b></label>
                                    <select class="form-select form-select-sm border border-dark SelectOut"
                                        id="tipor" name="tipor">
                                        <option value="">---</option>
                                        <option value="pu">Unidades de producción</option>
                                        <option value="cp">Capacitación</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <hr class="border border-2 border-black m-0 mt-3 mb-2">

                        <div class="row mb-0">
                            <div class="col-sm-12 d-flex align-items-end justify-content-between">

                                <button type="button" class="btn bg-gradient-orange text-black fw-bolder"
                                    id="clear_form_pu"onclick="clearForm('#form_up');">
                                    Limpiar
                                </button>

                                <button type="button" class="btn bg-gradient-blue text-white fw-bolder"
                                    id="update_form_pu" hidden> Actualizar
                                </button>

                                <button type="button" class="btn bg-gradient-green text-white fw-bolder"
                                    id="register_form_pu">
                                    Registrar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
