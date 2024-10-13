
$('.SelectIn').select2({
    minimumResultsForSearch: -1
});

$('.SelectOut').select2({
    dropdownParent: $("#modalUnitProduction"),
    minimumResultsForSearch: -1
});

let registersTable = $("#table_pu").DataTable({
    language: {
        url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
    },

    dom:
        "<'row'<'col-sm-8'><'col-sm-4'>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-5'i><'col-sm-7'>>",

    processing: false,
    serverSide: false,
    autoWidth: false,
    ordering: true,
    responsive: true,

    ajax: {
        url: "upregisters-data",
        type: "GET",
    },

    columns: [
        { data: "site", class: "dt-center fw-bolder p-1" },
        { data: "type", class: "fw-bolder p-1" },
        { data: "month", class: "dt-center fw-bolder p-1" },
        { data: "year", class: "dt-center fw-bolder p-1" },
        { data: "company", class: "dt-center fw-bolder p-1" },
        { data: "amount", class: "dt-center fw-bolder p-1" },
        {
            class: "dt-center p-1",
            data: null,
            width: "18%",
            render: function (data, type, row, meta) {
                return `<div class="row">
                        <div class="d-flex justify-content-center">
                            <div class="action-buttons text-center">
                                <button type="button" id="update-pu" class="btn btn-white border border-0 text-blue btn-sm m-0 me-2 p-1 pe-2 ps-2" data-toggle="tooltip" title="Editar">
                                    <i class="fa fa-marker fa-lg"></i>
                                </button>
                            </div>
                            <div class="action-buttons text-center">
                                <button type="button" id="btnDeleteRegister" class="btn btn-white border border-0 text-red btn-sm m-0 p-1 pe-2 ps-2" data-toggle="tooltip" title="Eliminar">
                                    <i class="fa fa-trash fa-lg"></i>
                                </button>
                            </div>
                        </div>
                    </div>`;
            },
        },
    ],

    drawCallback: function (row, data, start, end, display) {
        var table = this.api();
        $(table.column(0).header()).addClass('bg-gradient-green text-white');
        $(table.column(1).header()).addClass('bg-gradient-green text-white');
        $(table.column(2).header()).addClass('bg-gradient-green text-white');
        $(table.column(3).header()).addClass('bg-gradient-green text-white');
        $(table.column(4).header()).addClass('bg-gradient-green text-white');
        $(table.column(5).header()).addClass('bg-gradient-green text-white');
        $(table.column(6).header()).addClass('bg-gradient-green text-white');
    },


    footerCallback: function (row, data, start, end, display) {

    },
});

$('#btnAddUnit').on('click', function () {
    $('#modalUnitProduction').modal('show');
});

$('#site_f, #year_f, #month_f').on('change', function () {
    let site = $('#site_f').val();
    let year = $('#year_f').val();
    let month = $('#month_f').val();

    $.ajax({
        url: 'upregisters-data',
        method: 'GET',
        data: {
            site: site,
            year: year,
            month: month,
        },
        success: function (response) {
            registersTable.clear().rows.add(response.data).draw();
        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    });
});


/**
 * Reglas y mensajes de la validacion del formulario de las rutas
 */
var rulesfrmRoutes = {
    site: {
        required: true
    },
    type_collaborator: {
        required: true
    },
    month: {
        required: true
    },
    year: {
        required: true
    },
    amount: {
        required: true,
        number: true
    },
    company: {
        required: true,
    },
    tipor: {
        required: true,
    }
};

var messagesfrmRoutes = {
    site: {
        required: "Selecciona una sede"
    },
    type_collaborator: {
        required: "Seleccionar tipo de sociedad"
    },
    month: {
        required: "Seleccionar mes"
    },
    year: {
        required: "Seleccionar año"
    },
    company: {
        required: "Seleccionar empresa"
    },
    amount: {
        required: "Ingresar la cantidad",
        number: "Solo numeros "
    },
    tipor: {
        required: "Seleccionar tipo de registro",
    }
};

initializeValidation('#form_up', rulesfrmRoutes, messagesfrmRoutes);

$('#register_form_pu').on('click', function (e) {
    if (!$('#form_up').valid()) {
        e.preventDefault();
    } else {
        $('#register_form_pu').prop('disabled', true);
        Swal.fire({
            title: "Creando su solicitud, por favor espere...",
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        var formData = {
            id_site: $('#site').val(),
            id_type: $('#type_collaborator').val(),
            month: $('#month').val(),
            year: $('#year').val(),
            amount: $('#amount').val(),
            company: $('#company').val(),
            _token: $('meta[name="csrf-token"]').attr('content') // Agrega el token CSRF
        };

        $.ajax({
            url: '/unidades_produccion',
            type: 'POST',
            data: formData,
            success: function (response) {
                Swal.hideLoading();
                Swal.fire({
                    text: '"Su registro ha sido almacenado de manera exitosa!',
                    icon: 'success',
                    confirmButtonText: 'Continuar'
                });
                $('#register_form_pu').prop('disabled', false);
                clearForm('#form_up');
                $('#table_pu').DataTable().ajax.reload();
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: "warning",
                    title: "¡No pudimos guardar tu registro!",
                    text: "Por favor recarga la pagina e intenta nuevamente, si persiste el error comunicalo a mesa de ayuda",
                    allowOutsideClick: false
                });
            }
        });
    }
});

$('#update_form_pu').on('click', function (e) {
    e.preventDefault();
    let tr = $('#table_pu').DataTable().row('.selected').node();
    let row_selected = registersTable.row(tr);
    let dataRow = row_selected.data();
    console.log(dataRow.id);
    if (!$('#form_up').valid()) {
        e.preventDefault();
    } else {
        Swal.fire({
            title: "Actualizando su registro, por favor espere...",
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        var formData = {
            id_site: $('#site').val(),
            id_type: $('#type_collaborator').val(),
            month: $('#month').val(),
            year: $('#year').val(),
            amount: $('#amount').val(),
            company: $('#company').val(),
            _token: $('meta[name="csrf-token"]').attr('content')
        };
        $.ajax({
            url: 'unidades_produccion/' + dataRow.id,
            type: 'PUT',
            data: formData,
            success: function (response) {
                Swal.hideLoading();
                Swal.fire({
                    text: '"Su registro ha sido actualizado de manera exitosa!',
                    icon: 'success',
                    confirmButtonText: 'Continuar'
                });
                $('#table_pu').DataTable().ajax.reload();
                clearForm('#form_up');
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: "warning",
                    title: "¡No pudimos actualizar tu registro!",
                    text: "Por favor recarga la pagina e intenta nuevamente, si persiste el error comunicalo a mesa de ayuda",
                    allowOutsideClick: false
                });
            }
        });
    }
});


$('#table_pu tbody').on('mouseenter', 'tr', function () {
    $(this).addClass('hovered');
}).on('mouseleave', 'tr', function () {
    $(this).removeClass('hovered');
});

// Evento para resaltar la fila al hacer clic
$('#table_pu tbody').on('click', 'tr', function () {
    console.log('esta clik');
    if ($(this).hasClass('color2')) {
        $(this).removeClass('color2');
    } else {
        registersTable.$('tr.color2').removeClass('color2');
        $(this).addClass('color2');
    }
});

$('#table_pu').on('click', '#update-pu', function () {
    $('#register_form_pu').prop('hidden', true);
    $('#update_form_pu').prop('hidden', false);
    let tr = $(this).closest('tr');
    let row_selected = registersTable.row(tr).data();
    $.ajax({
        url: 'unidades_produccion/' + row_selected.id + '/edit',
        type: "GET",
        success: function (response) {
            console.log(response.company);
            $('#site').val(response.id_site).trigger('change');
            $('#type_collaborator').val(response.id_type).trigger('change');
            $('#month').val(response.month).trigger('change');
            $('#year').val(response.year).trigger('change');
            $('#amount').val(response.amount);
            $('#company').val(response.company).trigger('change');
            $('#register_form_pu').prop('hidden', true);
            $('#update_form_pu').prop('hidden', false);
        },
        error: function (xhr, status, error) {
            // Maneja los errores si es necesario
        }
    });
});


$('#table_pu').on('click', '#btnDeleteRegister', function () {
    let tr = $(this).closest('tr');
    let row_selected = registersTable.row(tr).data();
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡Perderás este registro!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminarlo!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'unidades_produccion/' + row_selected.id,
                type: "DELETE",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function (response) {
                    Swal.fire(
                        'Eliminado!',
                        'Tu registro ha sido eliminado.',
                        'success'
                    );
                    $('#table_pu').DataTable().ajax.reload();
                    clearForm('#form_up');
                },
                error: function (xhr, status, error) {
                    Swal.fire({
                        icon: "warning",
                        title: "¡No pudimos eliminar tu registro!",
                        text: "Por favor recarga la pagina e intenta nuevamente, si persiste el error comunicalo a mesa de ayuda",
                        allowOutsideClick: false
                    });
                }
            });
        }
    });
});

function initializeValidation(formId, rules, messages) {
    $(formId).validate({
        errorElement: 'div',
        errorClass: 'help-block',
        focusInvalid: false,
        ignore: "",

        rules: rules,
        messages: messages,

        errorPlacement: function (error, element) {
            if (element.is('input[type=checkbox]') || element.is('input[type=radio]')) {
                var controls = element.closest('div[class*="col-"]');
                if (controls.find(':checkbox,:radio').length > 1) controls.append(error);
                else error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
            }
            else if (element.is('.chosen-select')) {
                error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
            }
            else if (element.hasClass("select2-hidden-accessible")) {
                error.insertAfter(element.next('span.select2'));
            }
            else error.insertAfter(element.parent());
        },

        highlight: function (element) {
            // Añade clase de error al contenedor más cercano del Select2
            if ($(element).hasClass("select2-hidden-accessible")) {
                $(element).next('span.select2').closest('.form-group').addClass('has-error');
            } else {
                $(element).closest('.form-group').addClass('has-error');
                $(element).closest('.form-control').removeClass('border border-dark');
            }
        },

        unhighlight: function (element) {
            // Quita clase de error del contenedor más cercano del Select2
            if ($(element).hasClass("select2-hidden-accessible")) {
                $(element).next('span.select2').closest('.form-group').removeClass('has-error');
            } else {
                $(element).closest('.form-group').removeClass('has-error');
                $(element).closest('.form-control').addClass('border border-dark');
            }
        }
    });
}


function clear_f() {
    $('#site_f').val('').trigger('change');
    $('#month_f').val('').trigger('change');
    $('#year_f').val('').trigger('change');
}

function clearForm(formId) {
    var form = $(formId);
    var inputs = form.find('input, select, textarea');

    inputs.each(function () {
        var input = $(this);
        if (input.is('select')) {
            input.val(null).trigger('change');
        } else if (input.is('input[type="checkbox"]') || input.is('input[type="radio"]')) {
            input.prop('checked', false);
        } else {
            input.val('');
        }

        $(formId).validate().resetForm();
        $(formId).find('.form-group').removeClass('has-error').removeClass('has-info');
    });
}

