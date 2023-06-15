const table_thead = ['NRO', 'TIPO', 'BIMENSUAL', 'INGENIERO', 'EXP', 'VEN', 'OPCIONES'];

const table_buttons = {
  botones: [
    {
      id: 'btn_pdf',
      icon: 'fas fa-file-pdf',
    },
    {
      id: 'btn_delete',
      icon: 'fas fa-times',
    },
  ],
};

let temp_id_vehiculo = '0';
let temp_placa_vehiculo = '';
let temp_id_revision = '0';

$('#form_1_buscar_placa').on('submit', function (e) {
  fun_buscar_placa();
  e.preventDefault();
  return false;
});

$('#form_2_datos').on('submit', function (e) {
  fun_actualizar_documento_confirm();
  e.preventDefault();
  return false;
});

$('#form_3_cargar_revision').on('submit', function (e) {
  fun_agregar_revision();
  e.preventDefault();
  return false;
});


$('#btn-reset-all').on('click', function (e) {
  fun_reset_all();
  e.preventDefault();
  return false;
});

$('#form_2_historial').on('click', '#btn_pdf', function (e) {
  let temp_file_url = $(this).attr('btn-file');

  $.confirm({
    title: 'Alerta',
    content: '<center>¿ Desea visualizar este contenido en?</center> ',
    typeAnimated: true,
    scrollToPreviousElement: false,
    scrollToPreviousElementAnimate: false,
    columnClass: 'xsmall',
    closeIcon: true,
    buttons: {
      esta: {
        text: 'Esta pestaña',
        action: function () {
          window.location.href =
            PROTOCOL_HOST + temp_file_url;
        },
      },
      otra: {
        text: 'Otra pestaña',
        action: function () {
          window.open(
            PROTOCOL_HOST + temp_file_url
          );
        },
      },
    },
  });

  e.preventDefault();
  return false;
});


$('#form_2_historial').on('click', '#btn_delete', function (e) {
  temp_id_revision = $(this).attr('btn-id');
  fun_eliminar_revision_confirm();
  e.preventDefault();
  return false;
});

function fun_actualizar_documento_confirm() {
  $.confirm({
    title: false,
    content: '<center>¿Está seguro que desea actualizar el documento?</center>',
    columnClass: 'xsmall',
    closeIcon: true,
    buttons: {
      si: {
        action: function () {
          fun_actualizar_documento();
        }
      },
      no: {
        action: function () {

        }
      },
    }
  });
}

function fun_actualizar_documento() {

  let form_data = new FormData($('#form_2_datos')[0]);
  form_data.append('form_2_id_vehiculo', temp_id_vehiculo);

  let self = $.confirm({
    title: false,
    content: 'Cargando, espere...',
    typeAnimated: true,
    scrollToPreviousElement: false,
    scrollToPreviousElementAnimate: false,
    content: function () {
      return $.ajax({
        url: PROTOCOL_HOST + '/modulos/previautos/visor/modelo/documento.php',
        type: 'POST',
        data: form_data,
        processData: false,
        contentType: false,
        headers: {
          'csrf-token': $('meta[name="csrf-token"]').attr('content'),
        },
        dataType: 'json',
        timeout: 5000,
      })
        .done(function (response) {
          // console.log(response);

          if (response.status === 'bien') {

            self.setTitle(response.status);
            self.setContent(response.message);
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();
            call_recuperar_session(fun_actualizar_documento);
          }
          else {
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
    onClose: function () {
    },
    buttons: {
      aceptar: function () {

      },
    },
  });

}

function fun_buscar_placa() {

  let temp_status = false;
  temp_placa_vehiculo = $('#form_1_placa').val().toUpperCase();
  let form_data = new FormData($('#form_1_buscar_placa')[0]);


  let self = $.confirm({
    title: false,
    content: 'Cargando, espere...',
    typeAnimated: true,
    scrollToPreviousElement: false,
    scrollToPreviousElementAnimate: false,
    content: function () {
      return $.ajax({
        url: PROTOCOL_HOST + '/modulos/previautos/visor/modelo/buscar_placa.php',
        type: 'POST',
        data: form_data,
        headers: {
          'csrf-token': $('meta[name="csrf-token"]').attr('content'),
        },
        dataType: 'json',
        processData: false,
        contentType: false,
        timeout: 5000,
      })
        .done(function (response) {
          // console.log(response);
          if (response.status === 'bien') {

            self.setTitle(response.status);
            self.setContent('Placa encontrada');
            temp_id_vehiculo = response.message.id;

            $('#form_1_div').hide(200);
            $('#form_2_div').show(200);

            $('#form_2_placa').html(response.message.placa);
            $('#form_2_documento').val(response.message.documento);

            temp_status = true;
            // self.close();
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();
            call_recuperar_session(fun_buscar_placa);
          }
          //sin_resultados
          else if (response.status === "sin_resultados") {
            //

            self.close();
            add_vehiculo_placa()
          }
          else {

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
    onClose: function () {
      if (temp_status == true) {
        get_revision_vehiculo();
      }
    },
    buttons: {
      aceptar: function () {

      },
    },
  });
}

function add_vehiculo_placa() {
  let temp_status = false;
  let self = $.confirm({
    title: false,
    content: 'Cargando, espere...',
    typeAnimated: true,
    scrollToPreviousElement: false,
    scrollToPreviousElementAnimate: false,
    content: function () {
      return $.ajax({
        url: PROTOCOL_HOST + '/modulos/previautos/visor/modelo/agregar.php',
        type: 'POST',
        data: {
          placa: temp_placa_vehiculo
        },
        headers: {
          'csrf-token': $('meta[name="csrf-token"]').attr('content'),
        },
        dataType: 'json',
        timeout: 5000,
      })
        .done(function (response) {

          // console.log(response);

          if (response.status === 'bien') {

            self.setTitle(response.status);
            self.setContent('La placa fue creada en el sistema.');
            temp_id_vehiculo = response.message;

            $('#form_1_div').hide(200);
            $('#form_2_div').show(200);

            $('#form_2_placa').html(temp_placa_vehiculo);

            temp_status = true;
            // self.close();
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();
            call_recuperar_session(add_vehiculo_placa);
          }
          else {
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
    onClose: function () {
      if (temp_status == true) {
        get_revision_vehiculo();
      }
    },
    buttons: {
      aceptar: function () {

      },
    },
  });
}

function get_revision_vehiculo() {


  let self = $.confirm({
    title: false,
    content: 'Cargando, espere...',
    typeAnimated: true,
    scrollToPreviousElement: false,
    scrollToPreviousElementAnimate: false,
    content: function () {
      return $.ajax({
        url: PROTOCOL_HOST + '/modulos/previautos/visor/modelo/buscar_revision.php',
        type: 'POST',
        data: {
          id_vehiculo: temp_id_vehiculo
        },
        headers: {
          'csrf-token': $('meta[name="csrf-token"]').attr('content'),
        },
        dataType: 'json',
        timeout: 5000,
      })
        .done(function (response) {
          console.log(response);
          if (response.status === 'bien') {

            self.setTitle(response.status);
            self.setContent('Revisiones encontradas');

            if ((response.message).length > 0) {
              $('#form_2_historial').html(
                '<table class="alt">' +
                '<thead>' +
                getTheadTable(table_thead, 'NRO', 'DESC') +
                '</thead>' +
                '<tbody>' +
                getTbodyTableCustom(response.message, table_buttons) +
                '</tbody></table>'
              );
            }
            else {
              $('#form_2_historial').html('Sin historial');
            }

          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {

            call_recuperar_session(get_revision_vehiculo);
          } else {

            self.setTitle(response.status);
            self.setContent(response.message);
          }
          self.close();
        })
        .fail(function (response) {
          self.setTitle('Error fatal');
          self.setContent(response.statusText + ' // ' + response.responseText);
          console.log(response);
        });
    },
    onClose: function () {
    },
    buttons: {
      aceptar: function () {

      },
    },
  });
}

function fun_agregar_revision() {

  /// let temp_status = false;
  let form_data = new FormData($('#form_3_cargar_revision')[0]);
  form_data.append('form_3_id_vehiculo', temp_id_vehiculo);

  let temp_status = false;

  let self = $.confirm({
    title: false,
    content: 'Cargando, espere...',
    typeAnimated: true,
    scrollToPreviousElement: false,
    scrollToPreviousElementAnimate: false,
    content: function () {
      return $.ajax({
        url: PROTOCOL_HOST + '/modulos/previautos/visor/modelo/agregar_revision.php',
        type: 'POST',
        data: form_data,
        headers: {
          'csrf-token': $('meta[name="csrf-token"]').attr('content'),
        },
        dataType: 'json',
        processData: false,
        contentType: false,
        timeout: 5000,
      })
        .done(function (response) {
          console.log(response);
          if (response.status === 'bien') {

            self.setTitle(response.status);
            self.setContent(response.message);

            temp_status = true;

            // reset 

          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();
            call_recuperar_session(fun_agregar_revision);
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
    onClose: function () {
      if (temp_status == true) {
        get_revision_vehiculo();

        $('#form_3_cargar_revision').trigger("reset");

      }
    },
    buttons: {
      aceptar: function () {

      },
    },
  });
}

function fun_reset_all() {


  $.confirm({
    title: false,
    content: '<center>¿Está seguro que desea salir?</center>',
    columnClass: 'xsmall',
    closeIcon: true,
    buttons: {
      si: {
        action: function () {

          temp_id_vehiculo = '';
          temp_id_revision = '';
          $('#form_1_buscar_placa').trigger("reset");
          $('#form_2_datos').trigger("reset");
          $('#form_3_cargar_revision').trigger("reset");
          $('#form_2_historial').empty();
          $('#form_1_div').show(200);
          $('#form_2_div').hide(200);
        }
      },
      no: {
        action: function () {

        }
      },
    }
  });

}
function getTbodyTableCustom($array, _json_botones) {
  let inner_html = '';
  $.each($array, function (key, value) {
    inner_html += '<tr id="' + key + '">';
    $.each($array[key], function (keyy, valuee) {
      if (keyy === 'opciones') {
        inner_html += '<td data-label="' + keyy + '">';
        $.each(_json_botones.botones, function (index, valueee) {
          inner_html +=
            '<button '
            + 'btn-id="' + (valuee.id) + '"'
            + 'btn-file="' + (valuee.archivo) + '"'
            + '" id="' + valueee.id +
            '" class="button primary small icon solid ' +
            valueee.icon + '"></button>';
        });
        inner_html += '</td>';
      } else {
        inner_html +=
          '<td data-label="' +
          keyy +
          '" id="table_' +
          keyy +
          '">' +
          escapehtmljs(valuee) +
          '</td>';
      }
    });
    inner_html += '</tr>';
  });
  inner_html += '';
  return inner_html;
}


function fun_eliminar_revision_confirm() {

  $.confirm({
    title: 'Alerta',
    content: '<center>¿Está seguro que desea eliminar esta revisión? </center> ',
    typeAnimated: true,
    scrollToPreviousElement: false,
    scrollToPreviousElementAnimate: false,
    columnClass: 'xsmall',
    closeIcon: true,
    buttons: {
      si: {
        action: function () {
          fun_eliminar_revision();
        },
      },
      no: {
        action: function () {

        },
      },
    },
  });
}

function fun_eliminar_revision() {

  let temp_status = false;
  let self = $.confirm({
    title: false,
    content: 'Cargando, espere...',
    typeAnimated: true,
    scrollToPreviousElement: false,
    scrollToPreviousElementAnimate: false,
    content: function () {
      return $.ajax({
        url: PROTOCOL_HOST + '/modulos/previautos/visor/modelo/eliminar_revision.php',
        type: 'POST',
        data: {
          id_revision: temp_id_revision
        },

        headers: {
          'csrf-token': $('meta[name="csrf-token"]').attr('content'),
        },
        dataType: 'json',
        timeout: 5000,
      })
        .done(function (response) {
          // console.log(response);

          if (response.status === 'bien') {

            self.setTitle(response.status);
            self.setContent(response.message);

            temp_status = true;

          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();
            call_recuperar_session(fun_eliminar_revision);
          }
          else {
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
    onClose: function () {
      if (temp_status == true) {
        get_revision_vehiculo();
      }
    },
    buttons: {
      aceptar: function () {

      },
    },
  });


}