$(document).ready(function () {

    /**
     * Funcion para cargar los datos de los roles en un data
     */
    let tablaProcesos = $("#processes-datatable").DataTable({

        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.0.5/i18n/es-ES.json',
        },

        destroy: true,
        processing: true,
        serverSide: true,
        autoWidth: false,
        responsive: true,
        ordering: false,

        dom:
            "<'row'<'col-sm-8'><'col-sm-4'>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",

        ajax: {
            url: "procesos-data",
            type: "GET",
        },

        columns: [
            {
                data: "id",
                class: "dt-center fw-bolder p-1",
                width: "13%",
            },
            {
                data: "process",
                class: "fw-bolder p-1",
            },
            {
                data: "abbreviation",
                class: "dt-center fw-bolder p-1",
            },
            {
                class: "dt-center p-1",
                data: null,
                width: "18%",
                render: function (data, type, row, meta) {

                    //console.log(data)

                    return `<div class="row">
                        <div class="d-flex justify-content-center">
                            <div class="action-buttons text-center">
                                <button type="button" id="btnEditProcess" class="btn btn-white border border-0 text-blue btn-sm m-0 me-2 p-1 pe-2 ps-2">
                                <i class="fa fa-marker fa-lg"></i>
                                </button>
                            </div>
                            <div class="action-buttons text-center">
                                <button type="button" id="btnDeleteProcess" class="btn btn-btn-white border border-0 text-red btn-sm m-0 p-1 pe-2 ps-2">
                                <i class="fa fa-trash fa-lg"></i>
                                </button>
                                </div>
                            </div>
                    </div>`;
                },
            },
        ],

        drawCallback: function (row, data, start, end, display) {

            var roles = this.api();

            $(roles.column(0).header()).addClass('bg-gradient-orange text-black');
            $(roles.column(1).header()).addClass('bg-gradient-orange text-black');
            $(roles.column(2).header()).addClass('bg-gradient-orange text-black');
            $(roles.column(3).header()).addClass('bg-gradient-orange text-black');

        },

        footerCallback: function (row, data, start, end, display) {

        },
    });


    /**
     * Evento para detectar el boton de crear rol
     */
    $("#btnCreateProcess").on("click", function () {
        //Valirdacion del formulario para verificar las reglas antes de permitir la ejecucion del create en la BD
        if (!$('#form_process').valid()) {
            e.preventDefault();
        } else {
            let process = $("#process").val();
            let ab = $("#abbreviation").val();
            Swal.fire({
                title: "Creando el Proceso, por favor espere...",
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            $.ajax({
                type: "POST",
                url: "procesos",
                data: {
                    process: process,
                    abbreviation: ab,
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

                        $("#process").val("");
                        $("#abbreviation").val("");
                        tablaProcesos.draw();
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: message.message,
                            showConfirmButton: true,
                        });
                    }
                },
                error: function (response) {
                    //console.log(response);
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
    $('#form_process').validate({
        errorElement: 'div',
        errorClass: 'help-block',
        focusInvalid: false,
        ignore: "",

        rules: {
            process: {
                required: true
            },
            abbreviation: {
                required: true
            },
        },

        messages: {
            process: {
                required: "Ingresar el proceso"
            },
            abbreviation: {
                required: "Ingresar la abreviación del proceso"
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
     * Evento para detectar el boton de editar rol
     */
    tablaProcesos.on("click", "#btnEditProcess", function () {
        let tr = $(this).closest("tr");
        let Fila = tablaProcesos.row(tr);
        let datosFila = Fila.data();

        $("#idProcess").val(datosFila.id);
        $("#process").val(datosFila.process);
        $("#abbreviation").val(datosFila.abbreviation);

        $("#btnCreateProcess").addClass("d-none");
        $("#btnUpdateProcess").removeClass("d-none");

    });


    /**
     * Evento para detectar el boton de guardar proceso
     */
    $("#btnUpdateProcess").on("click", function () {
        //Valirdacion del formulario para verificar las reglas antes de permitir la ejecucion de la actualizacion en la BD
        if (!$('#form_process').valid()) {
            e.preventDefault();
        } else {
            let id_proceso = $("#idProcess").val();
            let proceso = $("#process").val();
            let abbreviation = $("#abbreviation").val();
            Swal.fire({
                title: "Actualizando el Proceso, por favor espere...",
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            $.ajax({
                type: "PUT",
                url: "procesos/" + id_proceso,
                data: {
                    process: proceso,
                    abbreviation: abbreviation,
                },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                dataType: "json",
                success: function (data) {
                    Swal.close();
                    Swal.fire({
                        icon: "success",
                        title: "Proceso actualizado con éxito",
                    });

                    $("#process").val("");
                    $("#abbreviation").val("");
                    $("#btnCreateProcess").removeClass("d-none");
                    $("#btnUpdateProcess").addClass("d-none");
                    tablaProcesos.draw();
                },
                error: function (response) {
                    //console.log(response);
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
     * Evento para detectar el boton de eliminar proceso
     */
    tablaProcesos.on("click", "#btnDeleteProcess", function () {

        let tr = $(this).closest("tr");

        let Fila = tablaProcesos.row(tr);

        let datosFila = Fila.data();

        swal.fire({

            html: "Confirma que desea <b>eliminar</b> el proceso <b>" + datosFila.process + "</b>?",
            icon: 'question',
            showDenyButton: true,
            denyButtonText: `No`,
            confirmButtonText: 'Si, eliminar',
            allowOutsideClick: false,
            allowEscapeKey: false

        }).then((result) => {

            if (result.isConfirmed) {
                Swal.fire({
                    title: "Eliminando el Proceso, por favor espere...",
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    type: "DELETE",
                    url: "procesos/" + datosFila.id,
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function (message) {
                        if (message.success === true) {
                            Swal.close();
                            Swal.fire({
                                icon: "success",
                                title: message.message,
                            });

                            $("#process").val("");
                            $("#abbreviation").val("");
                            $("#btnCreateProcess").removeClass("d-none");
                            $("#btnUpdateProcess").addClass("d-none");
                            tablaProcesos.draw();
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
                        //console.log(response);
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
     * Evento para detectar el boton de limpiar rol
     */
    $("#btnClearProcess").on("click", function () {
        $("#process").val("");
        $("#abbreviation").val("");
        $("#btnCreateProcess").removeClass("d-none");
        $("#btnUpdateProcess").addClass("d-none");

        $('#form_process').validate().resetForm();
        $('.form-group').removeClass('has-error');
        $('.form-control').removeClass('border border-red').addClass('border border-dark');
    });


    /**
     * Evento para detectar el boton de buscar
     */
    $("#btnClearSearch").on("click", function () {
        $("#barSearch").val("");

        tablaProcesos.search("").draw();
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
        tablaProcesos.search($value).draw();
    }
});