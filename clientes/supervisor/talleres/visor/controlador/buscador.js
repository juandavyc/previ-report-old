const botones_tabla_buscador = {
  botones: [
    {
      id: 'btn_info_taller',
      icon: 'fas fa-info-circle',
    },
    {
      id: 'btn_link_taller',
      icon: 'fas fa-external-link-square-alt',
    },
  ],
};

let fun_info_taller = null;
let fun_link_taller = null;

export function fun_buscador_functions(_function_info, _function_link) {
  fun_info_taller = _function_info;
  fun_link_taller = _function_link;
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

$('#buscador_resultados_body').on('click', '#btn_info_taller', function (e) {
  fun_info_taller($(this).attr('btn-id'));
  e.preventDefault();
  return false;
});

$('#buscador_resultados_body').on('click', '#btn_link_taller', function (e) {
  fun_link_taller($(this).attr('btn-id'));
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
        url: PROTOCOL_HOST + '/clientes/supervisor/talleres/visor/modelo/buscador.php',
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
                getTbodyTable(response.body, botones_tabla_buscador) +
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
      aceptar: function () {},
    },
  });
}