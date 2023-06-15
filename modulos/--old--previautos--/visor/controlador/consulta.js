let status_consulta = false;
$('#form_consulta').on('submit', function (e) {
    fun_consulta_reset(false);
    let self = $.confirm({
        title: false,
        content: 'Cargando, espere...',
        typeAnimated: true,
        scrollToPreviousElement: false,
        scrollToPreviousElementAnimate: false,
        content: function () {
            return $.ajax({
                url: PROTOCOL_HOST + '/modulos/previautos/visor/modelo/consultar.php',
                type: 'POST',
                data: new FormData($('#form_consulta')[0]),
                processData: false,
                contentType: false,
                headers: {
                    'csrf-token': $('meta[name="csrf-token"]').attr('content'),
                },
                dataType: 'json',
                timeout: 5000,
            })
                .done(function (response) {
                    console.log(response);

                    if (response.status === 'bien') {
                        status_consulta = true;
                        self.setTitle(response.status);
                        self.setContent('Espere un momento...');
                        self.close(response);

                        $('#consulta-paso-1').hide(200);
                        $('#consulta-paso-2').show(200);
                    } else {
                        self.setTitle(response.status);
                        self.setContent(response.message);
                    }
                })
                .fail(function (response) {
                    self.setTitle('Error fatal');
                    self.setContent(response.statusText + ' // ' + response.responseText);
                    console.log(response);
                });
        },
        onClose: function (_param = false) {
            if (status_consulta == true) {
                fun_read_consulta(_param);
            }
        },
        buttons: {
            aceptar: function () {

            },
        },
    });


    e.preventDefault();
    return false;
});

function fun_read_consulta(_response) {


    $('#resultado_placa').html(_response.placa);
    $('#resultado_documento').html(_response.documento);

    // generate table
    let table_html = `
    <table class="alt">
    <thead>
        <tr>
            <th class="th-data-active"> NRO</th>
            <th>TIPO</th>
            <th>BIMENSUAL</th>
            <th>EXP</th>
            <th>VEN</th>
            <th>INGENIERO</th>
            <th>OPCIONES</th>
        </tr>
    </thead>`;
    table_html += `<tbody>`
    $.each(_response.message, function (key, value) {
        table_html += `
        <tr>
        <td data-label="nro">${(parseInt(key) + 1)}</td>
        <td data-label="tipo">${(value.tipo)}</td>
        <td data-label="biemensual">${(value.bimensual)}</td>
        <td data-label="exp">${(value.expedicion)}</td></td>
        <td data-label="ven">${(value.vencimiento)}</td>
        <td data-label="ingeniero">${(value.ingeniero)}</td>
        <td data-label="opciones">
            <button class="primary small icon solid fa-file-pdf" data-filepath="${(value.archivo)}" id="btn-preview"></button>
            <button class="primary small icon solid fa-download" data-filepath="${(value.archivo)}" id="btn-download"></button>
        </td>
        </tr>
        `;
    });

    table_html += `</tbody>`
    $('#resultado_table').html(table_html);

}

//click
$('#resultado_table').on('click', '#btn-preview', function (e) {
    let temp_data_value = $(this).attr('data-filepath');
    $.confirm({
        title: 'Alerta',
        content: '<embed src="https://docs.google.com/gview?url=https://previreport.com/' + temp_data_value + '&pid=explorer&efh=false&a=v&chrome=false&embedded=true" width="100%" height="400"></embed> ',
        typeAnimated: true,
        scrollToPreviousElement: false,
        scrollToPreviousElementAnimate: false,
        columnClass: 'medium',
        closeIcon: true,
        onOpenBefore: function () {
            $("html").css({
                "overflow": "hidden",
            });
        },
        onClose: function () {
            $("html").css({
                "overflow": '',
            });

        },
        buttons: {
            aceptar: {
                action: function () {

                },
            },

        },
    });
    e.preventDefault();
    return false;
});
$('#resultado_table').on('click', '#btn-download', function (e) {
    let temp_data_value = $(this).attr('data-filepath');
    window.open(
        PROTOCOL_HOST + temp_data_value
    );
    e.preventDefault();
    return false;
});
$('#resultado_btn_bottom,#resultado_btn_top ').on('click', function (e) {
    fun_consulta_reset(true);


    e.preventDefault();
    return false;
});

function fun_consulta_reset(_show = false) {
    if (_show == true) {
        $('#consulta-paso-1').show(200);
        $('#consulta-paso-2').hide(200);
        $('#form_consulta').trigger("reset");
    }
    $('#resultado_placa').empty();
    $('#resultado_documento').empty();
}