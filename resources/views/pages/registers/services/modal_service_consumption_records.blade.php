<div class="modal fade" id="modalServiceConsumptionRecords" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="modalPermisosUsuarioLabel">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content p-0">
            <div class="panel panel-inverse p-0 mb-0">
                <div class="panel-heading text-center bg-gradient-blue p-1">
                    <h4 class="panel-title fs-18px" id="title_proform">Registrar consumo de servicios</h4>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal"
                        id="btnCloseModalConsumption"></button>
                </div>

                <div class="panel-body p-2">
                    <form id="form_service_co">
                        @csrf
                        <input type="text" hidden value="" id="id_register_consumption">
                        <div class="row mb-2">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="id_site_service" class="form-label"><b>Sede</b></label>
                                    <select class="form-select form-select-sm border border-dark SelectOut"
                                        id="" name="id_site_service">
                                        <option value="">---</option>
                                        @foreach ($sites as $site)
                                            <option value="{{ $site->id }}">{{ $site->site }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="account" class="form-label"><b>Cuenta</b></label>
                                    <input type="text" id="" name="account"
                                            class="form-control form-control-sm border border-dark text-center">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="company_service_consumption" class="form-label"><b>Empresa</b></label>
                                    <select class="form-select form-select-sm border border-dark SelectOut"
                                        id="" name="company_service_consumption">
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
                                        id="" name="month">
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
                                        id="" name="year">
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
                                        <input type="text" id="" name="amount"
                                            class="form-control form-control-sm border border-dark text-center">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="type_service" class="form-label"><b>Tipo servicio</b></label>
                                    <select class="form-select form-select-sm border border-dark SelectOut"
                                        id="" name="type_service">
                                        <option value="">---</option>
                                        <option value="whater">Agua</option>
                                        <option value="energy">Energia</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <hr class="border border-2 border-black m-0 mt-3 mb-2">

                        <div class="row mb-0">
                            <div class="col-sm-12 d-flex align-items-end justify-content-between">

                                <button type="button" class="btn bg-gradient-orange text-black fw-bolder"
                                    id="clear_form_service_co"onclick="clearForm('#form_service_co');">
                                    Limpiar
                                </button>

                                <button type="button" class="btn bg-gradient-blue text-white fw-bolder"
                                    id="update_form_service_co" hidden> Actualizar
                                </button>

                                <button type="button" class="btn bg-gradient-green text-white fw-bolder"
                                    id="register_form_service_co">
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
