$(document).ready(function () {

    /**
     * Variables globales
     */
    let tablaUsuarios = $("#users-datatable").DataTable({

        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.0.5/i18n/es-ES.json',
        },

        destroy: true,
        processing: true,
        serverSide: true,
        autoWidth: false,
        responsive: true,
        ordering: false,
        lengthMenu: [
            [7],
            ["7"]
        ],

        dom:
            "<'row'<'col-sm-8'><'col-sm-4'>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",

        ajax: {
            url: "listar_usuarios",
            type: "GET",
        },

        columns: [
            {
                data: "id",
                class: "dt-center fw-bolder p-1",
            },
            {
                data: "name",
                class: "fw-bolder p-1",
            },
            {
                data: "user_identification",
                class: "dt-center fw-bolder p-1",
            },
            {
                data: "email",
                class: "dt-center fw-bolder p-1",
            },
            {
                data: "process",
                class: "dt-center fw-bolder p-1",
            },
            {
                data: "rol_usuario",
                class: "dt-center fw-bolder p-1",
            },
            {
                class: "dt-center p-1",
                data: "state",

                render: function (data, type, row, meta) {
                    if (data == 0) {
                        return `<span class="badge bg-danger fs-14px p-1 pe-2 ps-2">Retirado</span>`;
                    } else {
                        return `<span class="badge bg-success fs-14px p-1 pe-2 ps-2">Activo</span>`;
                    }
                },
            },
            {
                class: "dt-center p-1",
                data: null,
                render: function (data, type, row, meta) {
                    return `<div class="row">
                    <div class="action-buttons text-center">
                    <button type="button" id="btnEditarPermisosUsuario" class="btn btn-warning btn-sm m-1 p-1">
                    Modificar
                    </button>
                    </div>
                    </div>`;
                },
            },
        ],

        drawCallback: function (row, data, start, end, display) {

            var usuarios = this.api();

            $(usuarios.column(0).header()).addClass('bg-gradient-orange text-black');
            $(usuarios.column(1).header()).addClass('bg-gradient-orange text-black');
            $(usuarios.column(2).header()).addClass('bg-gradient-orange text-black');
            $(usuarios.column(3).header()).addClass('bg-gradient-orange text-black');
            $(usuarios.column(4).header()).addClass('bg-gradient-orange text-black');
            $(usuarios.column(5).header()).addClass('bg-gradient-orange text-black');
            $(usuarios.column(6).header()).addClass('bg-gradient-orange text-black');
            $(usuarios.column(7).header()).addClass('bg-gradient-orange text-black');

        },

        footerCallback: function (row, data, start, end, display) {

        },
    });


    /**
     * Evento para detectar el boton de modificar permisos de usuario
     */
    tablaUsuarios.on("click", "button", function () {
        let tr = $(this).closest("tr");

        let Fila = tablaUsuarios.row(tr);

        let datosFila = Fila.data();

        id = datosFila.id;

        if ($(this).attr("id") == "btnEditarPermisosUsuario") {
            $("#idUser").val(datosFila.id);
            $("#nameUser").val(datosFila.name);
            $("#emailUser").val(datosFila.email);
            $("#selectProcessUser").val(datosFila.process_id);
            $("#selectRolUser").val(datosFila.rol_usuario);
            if (datosFila.state == 0) {
                $("#retiredUser").prop("checked", true);
                $('#selectRolUser').attr('disabled', true);
                $('#stateUser').attr('disabled', true);
                $('#activeUser').attr('disabled', true);
            } else if (datosFila.state == 1) {
                $("#activeUser").prop("checked", true);
                $('#selectRolUser').attr('disabled', false);
                $('#stateUser').attr('disabled', false);
                $('#activeUser').attr('disabled', false);
            }
            $("#modalPermisosUsuario").modal("show");
        }
    });


    /**
     * Evento para detectar si hubo algun cambio en los permisos del usuario y habilitar el boton de guardado
     */
    $("input, select").change(function () {
        $("#btnUpdate").prop("disabled", false);
    });

    $("#btnUpdate").on("click", function () {
        swal.fire({

            html: "Confirma que desea <b>Modificar</b> el usuario <br> <b>" + $("#nameUser").val() + "</b>?",
            icon: 'question',
            showDenyButton: true,
            denyButtonText: `No`,
            confirmButtonText: 'Si',
            allowOutsideClick: false,
            allowEscapeKey: false

        }).then((result) => {
            let id_usuario = $("#idUser").val();
            let proceso_id = $("#selectProcessUser").val();
            let rol_id = $("#selectRolUser").val();
            let estado = $("input:radio[name=stateUser]:checked").val();
            Swal.fire({
                title: "Modificando el usuario, por favor espere...",
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            $.ajax({
                type: "PUT",
                url: "actualizar_permisos/" + id_usuario,
                data: {
                    process_id: proceso_id,
                    rol_id: rol_id,
                    state: estado,
                },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                dataType: "json",
                success: function (data) {
                    Swal.close();
                    Swal.fire({
                        icon: "success",
                        title: "Se actualizaron los permisos correctamente",
                    });

                    $("#modalPermisosUsuario").modal("hide");
                    $("#btnUpdate").prop("disabled", true);
                    tablaUsuarios.draw();

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
        });

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
        tablaUsuarios.search($value).draw();
    }
    /**
     * Filtro personalizado para las columnas de Rol y Estado de usuario.
     */
    $(".select-filtrar").change(function () {
        tablaUsuarios
            .column($(this).data("column"))
            .search($(this).val())
            .draw();
    });
});
