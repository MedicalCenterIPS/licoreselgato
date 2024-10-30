$('.SelectIn').select2({
    minimumResultsForSearch: -1
});



let registersTable = $("#table_service_consumption_records").DataTable({
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
        url: "upregisters_services_data",
        type: "GET",
    },

    columns: [
        { data: "site", class: "dt-center fw-bolder p-1" },
        { data: "service", class: "fw-bolder p-1" },
        { data: "account", class: "dt-center fw-bolder p-1" },
        { data: "month", class: "dt-center fw-bolder p-1" },
        { data: "year", class: "dt-center fw-bolder p-1" },
        { data: "company", class: "dt-center fw-bolder p-1" },
        { data: "amount", class: "dt-center fw-bolder p-1" },
        {
            class: "dt-center p-1",
            data: null,
            width: "10%",
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
        $(table.column(7).header()).addClass('bg-gradient-green text-white');
    },


    footerCallback: function (row, data, start, end, display) {

    },
});

$('#btnAddConsumption').on('click', function () {
    $('#modalServiceConsumptionRecords').modal('show');
    $('.SelectOut').select2({
        dropdownParent: $("#modalServiceConsumptionRecords"),
        minimumResultsForSearch: -1
    });
});

var rulesfrmRoutes = {
    site: {
        required: true
    },
    account: {
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
    company_service_consumption: {
        required: true,
    },
    type_service: {
        required: true,
    }
};

var messagesfrmRoutes = {
    site: {
        required: "Selecciona una sede"
    },
    account: {
        required: "Por favor ingrese un numero de cuenta"
    },
    month: {
        required: "Seleccionar mes"
    },
    year: {
        required: "Seleccionar año"
    },
    company_service_consumption: {
        required: "Seleccionar empresa"
    },
    amount: {
        required: "Ingresar la cantidad",
        number: "Solo numeros "
    },
    type_service: {
        required: "Seleccionar que tipo de servicio registrar",
    }
};

initializeValidation('#form_service_co', rulesfrmRoutes, messagesfrmRoutes);

$('#register_form_service_co').on('click', function (e) {
    if (!$('#form_service_co').valid()) {
        e.preventDefault();
    } else {
        $('#register_form_service_co').prop('disabled', true);
        Swal.fire({
            title: "Creando su solicitud, por favor espere...",
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
       var data = $('#form_service_co').serialize();
        $.ajax({
            url: '/consumo_servicios',
            type: 'POST',
            data: data,
            success: function (response) {
                Swal.hideLoading();
                Swal.fire({
                    icon: 'success',
                    title: 'Agregado con Éxito!',
                    text: '"Su registro ha sido almacenado de manera exitosa!',
                    confirmButtonText: 'Entendido',
                    confirmButtonColor: '#d33',
                    allowOutsideClick: false,
                    customClass: {
                        popup: 'animated shake',
                    },
                    background: '#fcf8e3',
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    }
                });
                $('#register_form_service_co').prop('disabled', false);
                clearForm('#form_service_co');
                $('#table_service_consumption_records').DataTable().ajax.reload();
            },
            error: function(xhr) {
                Swal.hideLoading();
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    var errorMessages = '';
                    $.each(errors, function(key, messages) {
                        errorMessages += messages.join(', ') + '\n';
                    });

                    Swal.fire({
                        title: 'Errores de validación!',
                        text: errorMessages,
                        icon: 'error',
                        confirmButtonText: 'Entendido',
                        confirmButtonColor: '#d33',
                        allowOutsideClick: false,
                        background: '#f8d7da',
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Hubo un error inesperado.',
                        icon: 'error',
                        confirmButtonText: 'Entendido',
                        confirmButtonColor: '#d33',
                        allowOutsideClick: false,
                        background: '#f8d7da',
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        }
                    });
                }
            }
        });
    }
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

function clear_f_cons() {
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