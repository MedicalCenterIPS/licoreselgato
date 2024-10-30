$(function () {

    $('select').select2();

    let registerIndicators = $("#table_energy").DataTable({
        destroy: true,
        processing: true,
        lengthChange: false,
        searching: false,
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
        },

        ordering: false,
        ajax: {
            url: "getPercentage1",
            type: "GET",
        },

        columns: [
            {
                data: "month",
                class: "dt-center fw-bolder p-1",
                orderable: false
            },
            {
                data: "total_amount",
                class: "dt-center fw-bolder p-1",
                orderable: false
            },
            {
                data: "Aviomar",
                class: "dt-center fw-bolder p-1",
                render: function (data) {
                    return data + "%";
                },
                orderable: false
            },
            {
                data: "Snider",
                class: "dt-center fw-bolder p-1",
                render: function (data) {
                    return data + "%";
                },
                orderable: false
            },
            {
                data: "Colvan",
                class: "dt-center fw-bolder p-1",
                render: function (data) {
                    return data + "%";
                },
                orderable: false
            }
        ],

        drawCallback: function () {
            var roles = this.api();

            $(roles.column(0).header()).addClass('bg-tables-general');
            $(roles.column(1).header()).addClass('bg-tables-general');
            $(roles.column(2).header()).addClass('bg-tables-general');
            $(roles.column(3).header()).addClass('bg-tables-general');
            $(roles.column(4).header()).addClass('bg-tables-general');
        },
    });

    let registerIndicators2 = $("#table_whater").DataTable({

        destroy: true,
        processing: true,
        lengthChange: false,
        searching: false,
        ordering: false,
        ajax: {
            url: "getPercentage2",
            type: "GET",

        },

        columns: [
            {
                data: "month",
                class: "dt-center fw-bolder p-1",
                orderable: false
            },
            {
                data: "total_amount",
                class: "dt-center fw-bolder p-1",
                orderable: false
            },
            {
                data: "aviomar",
                class: "dt-center fw-bolder p-1",
                render: function (data, type, row) {
                    return data + "%";
                },
                orderable: false
            },
            {
                data: "snider",
                class: "dt-center fw-bolder p-1",
                render: function (data, type, row) {
                    return data + "%";
                },
                orderable: false
            },
            {
                data: "colvan",
                class: "dt-center fw-bolder p-1",
                render: function (data, type, row) {
                    return data + "%";
                },
                orderable: false
            }

        ],

        drawCallback: function (row, data, start, end, display) {

            var roles = this.api();

            $(roles.column(0).header()).addClass('bg-tables-general');
            $(roles.column(1).header()).addClass('bg-tables-general');
            $(roles.column(2).header()).addClass('bg-tables-general');
            $(roles.column(3).header()).addClass('bg-tables-general');
            $(roles.column(4).header()).addClass('bg-tables-general');
        },


    });

    let registerIndicators3 = $("#table_waste").DataTable({

        destroy: true,
        processing: true,
        lengthChange: false,
        searching: false,
        ordering: false,
        ajax: {
            url: "getPercentage3",
            type: "GET",

        },

        columns: [
            {
                data: "month",
                class: "dt-center fw-bolder p-1",
                orderable: false
            },
            {
                data: "total_amount",
                class: "dt-center fw-bolder p-1",
                orderable: false
            },
            {
                data: "aviomar",
                class: "dt-center fw-bolder p-1",
                render: function (data, type, row) {
                    return data + "%";
                },
                orderable: false
            },
            {
                data: "snider",
                class: "dt-center fw-bolder p-1",
                render: function (data, type, row) {
                    return data + "%";
                },
                orderable: false
            },
            {
                data: "colvan",
                class: "dt-center fw-bolder p-1",
                render: function (data, type, row) {
                    return data + "%";
                },
                orderable: false
            }

        ],

        drawCallback: function (row, data, start, end, display) {

            var roles = this.api();

            $(roles.column(0).header()).addClass('bg-tables-general');
            $(roles.column(1).header()).addClass('bg-tables-general');
            $(roles.column(2).header()).addClass('bg-tables-general');
            $(roles.column(3).header()).addClass('bg-tables-general');
            $(roles.column(4).header()).addClass('bg-tables-general');
        },

    });

    let registerIndicators4 = $("#table_whater_r").DataTable({

        destroy: true,
        processing: true,
        lengthChange: false,
        searching: false,
        ordering: false,
        ajax: {
            url: "getPercentage4",
            type: "GET",

        },

        columns: [
            {
                data: "month",
                class: "dt-center fw-bolder p-1",
                orderable: false
            },
            {
                data: "total_amount",
                class: "dt-center fw-bolder p-1",
                orderable: false
            },
            {
                data: "Aviomar",
                class: "dt-center fw-bolder p-1",
                render: function (data, type, row) {
                    return data + "%";
                },
                orderable: false
            },
            {
                data: "Snider",
                class: "dt-center fw-bolder p-1",
                render: function (data, type, row) {
                    return data + "%";
                },
                orderable: false
            },
            {
                data: "Colvan",
                class: "dt-center fw-bolder p-1",
                render: function (data, type, row) {
                    return data + "%";
                },
                orderable: false
            }

        ],

        drawCallback: function (row, data, start, end, display) {

            var roles = this.api();

            $(roles.column(0).header()).addClass('bg-tables-general');
            $(roles.column(1).header()).addClass('bg-tables-general');
            $(roles.column(2).header()).addClass('bg-tables-general');
            $(roles.column(3).header()).addClass('bg-tables-general');
            $(roles.column(4).header()).addClass('bg-tables-general');
        },


    });

    let registerIndicators5 = $("#table_trainings1").DataTable({

        destroy: true,
        processing: true,
        lengthChange: false,
        searching: false,
        ordering: false,
        ajax: {
            url: "getPercentage5",
            type: "GET",

        },

        columns: [
            {
                data: "month",
                class: "dt-center fw-bolder p-1",
                orderable: false
            },
            {
                data: "Aviomar",
                class: "dt-center fw-bolder p-1",
                orderable: false
            },
            {
                data: "Snider",
                class: "dt-center fw-bolder p-1",
                orderable: false
            },
            {
                data: "Colvan",
                class: "dt-center fw-bolder p-1",
                orderable: false
            },
            {
                data: "total",
                class: "dt-center fw-bolder p-1",
                orderable: false
            },

        ],

        drawCallback: function (row, data, start, end, display) {

            var roles = this.api();

            $(roles.column(0).header()).addClass('bg-tables-general');
            $(roles.column(1).header()).addClass('bg-tables-general');
            $(roles.column(2).header()).addClass('bg-tables-general');
            $(roles.column(3).header()).addClass('bg-tables-general');
            $(roles.column(4).header()).addClass('bg-tables-general');
        },


    });

    let registerIndicators6 = $("#table_trainings2").DataTable({

        destroy: true,
        processing: true,
        lengthChange: false,
        searching: false,

        ajax: {
            url: "getPercentage6",
            type: "GET",

        },

        columns: [
            {
                data: "month",
                class: "dt-center fw-bolder p-1",
                orderable: false
            },
            {
                data: "Aviomar",
                class: "dt-center fw-bolder p-1",
                orderable: false
            },
            {
                data: "Snider",
                class: "dt-center fw-bolder p-1",
                orderable: false
            },
            {
                data: "Colvan",
                class: "dt-center fw-bolder p-1",
                orderable: false
            },
            {
                data: "total",
                class: "dt-center fw-bolder p-1",
                orderable: false
            },

        ],

        drawCallback: function (row, data, start, end, display) {

            var roles = this.api();

            $(roles.column(0).header()).addClass('bg-tables-general');
            $(roles.column(1).header()).addClass('bg-tables-general');
            $(roles.column(2).header()).addClass('bg-tables-general');
            $(roles.column(3).header()).addClass('bg-tables-general');
            $(roles.column(4).header()).addClass('bg-tables-general');
        },
    });

    $('#filter_year, #filter_month, #filter_site').on('change', function () {
        let year = $('#filter_year').val();
        let month = $('#filter_month').val();
        let site = $('#filter_site').val();

        console.log(year, month, site);
        $.ajax({
            url: 'getPercentage1',
            method: 'GET',
            data: {
                year: year,
                month: month,
                site: site
            },
            success: function (response) {
                registerIndicators.clear().rows.add(response.data).draw();
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });


    $('#filter_year_a, #filter_month_a').on('change', function () {
        let year = $('#filter_year_a').val();
        let month = $('#filter_month_a').val();

        $.ajax({
            url: 'getPercentage2',
            method: 'GET',
            data: {
                year: year,
                month: month,
            },
            success: function (response) {
                registerIndicators2.clear().rows.add(response.data).draw();
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });


    $('#filter_year_re, #filter_month_re').on('change', function () {
        let year = $('#filter_year_re').val();
        let month = $('#filter_month_re').val();

        $.ajax({
            url: 'getPercentage3',
            method: 'GET',
            data: {
                year: year,
                month: month,
            },
            success: function (response) {
                registerIndicators3.clear().rows.add(response.data).draw();
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });


    $('#filter_year_r, #filter_month_r').on('change', function () {
        let year = $('#filter_year_r').val();
        let month = $('#filter_month_r').val();

        $.ajax({
            url: 'getPercentage4',
            method: 'GET',
            data: {
                year: year,
                month: month,
            },
            success: function (response) {
                registerIndicators4.clear().rows.add(response.data).draw();
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });


    $('#filter_month_cap1, #filter_year_cap1').on('change', function () {
        let year = $('#filter_year_cap1').val();
        let month = $('#filter_month_cap1').val();

        $.ajax({
            url: 'getPercentage5',
            method: 'GET',
            data: {
                year: year,
                month: month,
            },
            success: function (response) {
                registerIndicators5.clear().rows.add(response.data).draw();
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });

    $('#filter_month_cap2, #filter_year_cap2').on('change', function () {
        let year = $('#filter_year_cap2').val();
        let month = $('#filter_month_cap2').val();

        $.ajax({
            url: 'getPercentage6',
            method: 'GET',
            data: {
                year: year,
                month: month,
            },
            success: function (response) {
                registerIndicators6.clear().rows.add(response.data).draw();
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });


    $('.table_energy tbody').on('mouseenter', 'tr', function () {
        $(this).addClass('hovered');
    }).on('mouseleave', 'tr', function () {
        $(this).removeClass('hovered');
    });


    $('.table_energy tbody').on('click', 'tr', function () {
        if ($(this).hasClass('color2')) {
            $(this).removeClass('color2');
        } else {
            registerIndicators.$('tr.color2').removeClass('color2');
            $(this).addClass('color2');
        }
    });



})

function clear_indicators() {
    $('#filter_site').val('1').trigger('change');
    $('#filter_month').val('').trigger('change');
    $('#filter_year').val('').trigger('change');
}
function clear_indicators1() {
    $('#filter_site_r').val('1').trigger('change');
    $('#filter_month_r').val('').trigger('change');
    $('#filter_year_r').val('').trigger('change');
}
function clear_indicators2() {
    $('#filter_site_a').val('1').trigger('change');
    $('#filter_month_a').val('').trigger('change');
    $('#filter_year_a').val('').trigger('change');
}
function clear_indicators3() {
    $('#filter_site_re').val('1').trigger('change');
    $('#filter_month_re').val('').trigger('change');
    $('#filter_year_re').val('').trigger('change');
}
function clear_indicators4() {
    $('#filter_site_cap1').val('1').trigger('change');
    $('#filter_month_cap1').val('').trigger('change');
    $('#filter_year_cap1').val('').trigger('change');
}
