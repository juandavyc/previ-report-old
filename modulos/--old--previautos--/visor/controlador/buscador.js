const botones_tabla_buscador = {
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


let fun_link_vehiculo = null;

export function fun_buscador_functions(_function_info, _function_link) {
  fun_info_vehiculo = _function_info;
  fun_link_vehiculo = _function_link;
}

fun_buscador(false);

$('#form_0_buscador').on('submit', function (e) {
  fun_buscador(true);
  e.preventDefault();
  return false;
});

$('#buscador_resultados_pagination').on('click', '#li-data', function (e) {
  if ($(this).attr('data-id') !== '') {
    $('#form_0_page').val($(this).attr('data-id'));
    fun_buscador(false);
  } else {
    $.alert('Pagina incorrecta');
  }
  e.preventDefault();
  return false;
});

$('#buscador_resultados_body').on('click', '#th-data', function (e) {
  $('#form_0_order').val($(this).attr('field-id'));
  $('#form_0_by').val($(this).attr('data-id'));
  $('#form_0_page').val('1');
  fun_buscador(false);
  e.preventDefault();
  return false;
});

$('#form_0_filtro').change(function (e) {
  if ($('#form_0_filtro option:selected').val() == 0) {
    $('#form_0_contenido').val('Todo');
    $('#form_0_contenido').prop('readonly', true);
  } else {
    $('#form_0_contenido').prop('readonly', false);
    $('#form_0_contenido').val('');
  }
  e.preventDefault();
  return false;
});

let temp_id_revision = '';
$('#buscador_resultados_body').on('click', '#btn_delete', function (e) {
  temp_id_revision = $(this).attr('btn-id');
  fun_eliminar_revision_confirm();
  e.preventDefault();
  return false;
});



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
            call_recuperar_session(fun_buscador(false));
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
        fun_buscador(false);
      }
    },
    buttons: {
      aceptar: function () {

      },
    },
  });

}
$('#buscador_resultados_body').on('click', '#btn_pdf', function (e) {

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
/*

*/

function fun_buscador(_type) {
  if (_type == true) {
    $('#form_0_page').val('1');
    $('#form_0_order').val('nro');
    $('#form_0_by').val('desc');
  }

  $('#buscador_resultados_title').show().empty();
  $('#buscador_resultados_body').show().empty();
  $('#buscador_resultados_pagination').show().empty();

  let form_data = new FormData($('#form_0_buscador')[0]);
  let self = $.confirm({
    title: false,
    content: 'Cargando, espere...',
    typeAnimated: true,
    scrollToPreviousElement: false,
    scrollToPreviousElementAnimate: false,
    content: function () {
      return $.ajax({
        url: PROTOCOL_HOST + '/modulos/previautos/visor/modelo/buscador.php',
        type: 'POST',
        data: form_data,
        headers: {
          'csrf-token': $('meta[name="csrf-token"]').attr('content'),
        },
        dataType: 'json',
        processData: false,
        contentType: false,
        timeout: 35000,
      })
        .done(function (response) {
          console.log(response);
          if (response.status === 'bien') {
            self.setTitle('Completado!');
            self.setContent('Espere un momento...');

            $('#buscador_resultados_title').html(getTitleTable(response.title));

            $('#buscador_resultados_body').html(
              '<table class="alt">' +
              '<thead>' +
              getTheadTable(
                response.head['fields'],
                response.head['order'],
                response.head['by']
              ) +
              '</thead>' +
              '<tbody>' +
              getTbodyTableCustom(response.body, botones_tabla_buscador) +
              '</tbody>' +
              '</table>'
            );
            $('#buscador_resultados_pagination').html(
              getPaginationTable(
                response.pages['pages'],
                response.pages['total_pages'],
                '#'
              )
            );
            self.close();
          } else if (response.status === 'sin_resultados') {
            self.setTitle('Completado!');
            self.setContent('Espere un momento...');

            $('#buscador_resultados_body').html(
              '<center>' +
              response.status.toUpperCase() +
              '<br>' +
              response.body +
              '</center>'
            );
            self.close();
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();
            call_recuperar_session(function (k) {
              fun_buscador(_type);
            });
          } else {
            self.setTitle(response.status);
            self.setContent(response.body);
          }
        })
        .fail(function (response) {
          self.setTitle('Error fatal');
          self.setContent(response.statusText + ' // ' + response.responseText);
          console.log(response);
        });
    },
    buttons: {
      aceptar: function () { },
    },
  });
}

// fix 

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
