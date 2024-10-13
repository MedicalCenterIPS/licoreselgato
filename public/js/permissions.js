$(document).ready(function () {

    /**
     * Funcion para cargar los datos de los permisos en un data
     */
    let tablePermission = $("#permissions-datatable").DataTable({

        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.0.5/i18n/es-ES.json',
        },

        destroy: true,
        autoWidth: false,
        responsive: true,
        ordering: false,
        lengthMenu: [
            [8],
            ["8"]
        ],

        dom: "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",

        processing: true,
        serverSide: true,

        ajax: {
            url: "permisos-data",
            type: "GET",
        },

        columns: [
            {
                data: "id",
                class: "dt-center fw-bolder p-1",
                width: "13%",
            },
            {
                data: "name",
                class: "fw-bolder p-1",
            },
            {
                class: "dt-center p-1",
                data: null,
                width: "18%",
                render: function (data, type, row, meta) {
                    return `<div class="row">
                        <div class="d-flex justify-content-center">
                            <div class="action-buttons text-center">
                                <button type="button" id="btnEditPermission" class="btn btn-white border border-0 text-blue btn-sm m-0 me-2 p-1 pe-2 ps-2">
                                <i class="fa fa-marker fa-lg"></i>
                                </button>
                            </div>
                            <div class="action-buttons text-center">
                                <button type="button" id="btnDeletePermission" class="btn btn-btn-white border border-0 text-red btn-sm m-0 p-1 pe-2 ps-2">
                                <i class="fa fa-trash fa-lg"></i>
                                </button>
                                </div>
                            </div>
                    </div>`;
                },
            },
        ],

        drawCallback: function (row, data, start, end, display) {

            var permissions = this.api();

            $(permissions.column(0).header()).addClass('bg-gradient-orange text-black');
            $(permissions.column(1).header()).addClass('bg-gradient-orange text-black');
            $(permissions.column(2).header()).addClass('bg-gradient-orange text-black');

        },

        footerCallback: function (row, data, start, end, display) {

        },
    });


    /**
     * Evento para detectar el boton de crear permiso
     */
    $("#btnCreatePermission").on("click", function (e) {
        //Valirdacion del formulario para verificar las reglas antes de permitir la ejecucion del create en la BD
        if (!$('#form_permission').valid()) {
            e.preventDefault();
        } else {
            Swal.fire({
                title: "Creando el Permiso, por favor espere...",
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            let permiso = $("#permission").val();
            $.ajax({
                type: "POST",
                url: "permisos",
                data: {
                    name: permiso,
                },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                dataType: "json",
                success: function (message) {
                    if (message.success === true) {
                        Swal.close();
                        Swal.fire({
                            icon: "success",
                            title: message.message,
                        });

                        tablePermission.draw();
                        $("#btnClearPermission").click();
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: message.message,
                            showConfirmButton: true,
                        });
                    }
                },

                error: function (response) {
                    Swal.fire({
                        icon: "info",
                        title: "Sesion expirada",
                        showConfirmButton: true,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "GET",
                                url: "session_usuario",
                                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                success: function (message) {
                                    window.location = '/login'
                                },
                                error: function (message) {
                                    window.location = '/login'
                                }
                            });
                        }
                    });
                },
            });
        }
    });


    /**
    * Metodo que realiza la validacion de cada uno de los campos del formulario, en caso de que no se cumpla alguna regla se resaltara en rojo con un aviso de
    * la informacion solicitada, si todos los campos estan dilifenciados de manera correcta se permitira avanzar con la creacion o actualizacion de la informacion
    */
    $('#form_permission').validate({
        errorElement: 'div',
        errorClass: 'help-block',
        focusInvalid: false,
        ignore: "",

        rules: {
            permission: {
                required: true
            },
        },

        messages: {
            permission: {
                required: "Ingresar el permiso"
            },
        },

        highlight: function (e) {
            $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
            $(e).closest('.form-control').removeClass('border border-dark').addClass('border border-red');
        },

        success: function (e) {
            $(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
            $(e).remove();
        },

        errorPlacement: function (error, element) {
            if (element.is('input[type=checkbox]') || element.is('input[type=radio]')) {
                var controls = element.closest('div[class*="col-"]');
                if (controls.find(':checkbox,:radio').length > 1) controls.append(error);
                else error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
            }
            else if (element.is('.select2')) {
                error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
            }
            else if (element.is('.chosen-select')) {
                error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
            }
            else error.insertAfter(element.parent());
        }
    });


    /**
     * Evento para detectar el boton de editar permiso
     */
    tablePermission.on("click", "#btnEditPermission", function () {
        let tr = $(this).closest("tr");

        let Fila = tablePermission.row(tr);

        let datosFila = Fila.data();

        $("#idPermission").val(datosFila.id);
        $("#permission").val(datosFila.name);
        $("#btnCreatePermission").addClass("d-none");
        $("#btnUpdatePermission").removeClass("d-none");
    });


    /**
    * Evento para detectar el boton de guardar permiso
    */
    $("#btnUpdatePermission").on("click", function () {
        //Valirdacion del formulario para verificar las reglas antes de permitir la ejecucion del create en la BD
        if (!$('#form_permission').valid()) {
            e.preventDefault();
        } else {
            let id_permiso = $("#idPermission").val();
            let permiso = $("#permission").val();
            Swal.fire({
                title: "Actualizando el Permiso, por favor espere...",
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            $.ajax({
                type: "PUT",
                url: "permisos/" + id_permiso,
                data: {
                    name: permiso,
                },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                dataType: "json",
                success: function (data) {
                    Swal.close();
                    Swal.fire({
                        icon: "success",
                        title: "Permiso actualizado con éxito",
                    });

                    tablePermission.draw();
                    $("#btnClearPermission").click();
                },
                error: function (response) {
                    Swal.fire({
                        icon: "info",
                        title: "Sesion expirada",
                        showConfirmButton: true,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "GET",
                                url: "session_usuario",
                                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                success: function (message) {
                                    window.location = '/login'
                                },
                                error: function (message) {
                                    window.location = '/login'
                                }
                            });
                        }
                    });
                },
            });
        }
    });


    /**
     * Evento para detectar el boton de eliminar permiso
     */
    tablePermission.on("click", "#btnDeletePermission", function () {

        let tr = $(this).closest("tr");

        let Fila = tablePermission.row(tr);

        let datosFila = Fila.data();
        swal.fire({
            html: "Confirma que desea <b>eliminar</b> el permiso <b>" + datosFila.name + "</b>?",
            icon: 'question',
            showDenyButton: true,
            denyButtonText: `No`,
            confirmButtonText: 'Si, eliminar',
            allowOutsideClick: false,
            allowEscapeKey: false
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Eliminando el Permiso, por favor espere...",
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    type: "DELETE",
                    url: "permisos/" + datosFila.id,
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function (message) {

                        if (message.success === true) {
                            Swal.close();
                            Swal.fire({
                                icon: "success",
                                title: message.message,
                            });

                            tablePermission.draw();
                            $("#btnClearPermission").click();
                        } else {
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                html: message.message,
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            })
                        }

                    },
                    error: function (response) {
                        Swal.fire({
                            icon: "info",
                            title: "Sesion expirada",
                            showConfirmButton: true,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    type: "GET",
                                    url: "session_usuario",
                                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                    success: function (message) {
                                        window.location = '/login'
                                    },
                                    error: function (message) {
                                        window.location = '/login'
                                    }
                                });
                            }
                        });
                    },
                });
            }
        });

    });


    /**
     * Evento para detectar el boton de limpiar permiso
     */
    $("#btnClearPermission").on("click", function () {
        $("#permission").val("");
        $("#btnCreatePermission").removeClass("d-none");
        $("#btnUpdatePermission").addClass("d-none");

        $('#form_permission').validate().resetForm();
        $('.form-group').removeClass('has-error');
        $('.form-control').removeClass('border border-red').addClass('border border-dark');
    });


    /**
     * Evento para detectar el boton de buscar
     */
    $("#btnClearSearch").on("click", function () {
        $("#barSearch").val("");
        tablePermission.search("").draw();
    });


    /**
     * Función para buscar después de 3 segundos de escribir en el input barraBuscar.
     */
    let timeoutId;

    $("#barSearch").on("keyup", function () {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(function () {
            // Call your desired function here
            drawTable($("#barSearch").val())
        }, 1500);
    });

    function drawTable($value) {
        tablePermission.search($value).draw();
    }


    /**
     * Filtro personalizado para las columnas de Permiso y Estado de usuario.
     */
    /* $(".select-filtrar").change(function () {
        tablePermission
            .column($(this).data("column"))
            .search($(this).val())
            .draw();
    }); */
});
