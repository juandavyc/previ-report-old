const botones_tabla_buscador = {
  botones: [
    {
      id: 'btn_info_vehiculo',
      icon: 'fas fa-info-circle',
    },
    {
      id: 'btn_link_vehiculo',
      icon: 'fas fa-external-link-square-alt',
    },
    {
      id: 'btn_link_pdf',
      icon: 'far fa-file-pdf',
    },
  ],
};

let fun_info = null,
fun_pdf = null,
  fun_link = null;

export function fun_buscador_fuctions(_fun_info, _fun_link,_fun_pdf) {
  fun_info = _fun_info;
  fun_link = _fun_link;
  fun_pdf = _fun_pdf;
}

autocomplete_with_insert_father({
  id_input_text: 'form_0_empresa_input',
  id_input_select: 'form_0_empresa_select',
  url_select_ajax:
    PROTOCOL_HOST +
    '/clientes/supervisor/assets/autocomplete/empresa_general/buscar_empresa.php',
  url_insert_ajax:
    PROTOCOL_HOST + '/clientes/supervisor/usuarios/visor/modelo/crear_empresa.php',
  input_value_default: 'TODO',
  input_select_default: '0',
  input_childs: [],
  is_todo: true,
});
buscador_de_vehiculos(false);

$('#form_0_buscador').on('submit', function (e) {
  buscador_de_vehiculos(true);

  e.preventDefault();
  return false;
});

$('#buscador_resultados_pagination').on('click', '#li-data', function (e) {
  if ($(this).attr('data-id') !== '') {
    $('#form_0_page').val($(this).attr('data-id'));
    buscador_de_vehiculos(false);
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
  buscador_de_vehiculos(false);

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

$('#buscador_resultados_body').on('click', '#btn_info_vehiculo', function (e) {
  fun_info($(this).attr('btn-id'));
  e.preventDefault();
  return false;
});

$('#buscador_resultados_body').on('click', '#btn_link_vehiculo', function (e) {
  fun_link($(this).attr('btn-id'));
  e.preventDefault();
  return false;
});

$('#buscador_resultados_body').on('click', '#btn_link_pdf', function (e) {
  fun_pdf($(this).attr('btn-id'));
  e.preventDefault();
  return false;
});

function buscador_de_vehiculos(_type) {
  if (_type == true) {
    $('#form_0_page').val('1');
    $('#form_0_order').val('nro');
    $('#form_0_by').val('desc');
  }
  $('#buscador_resultados_title').html('');
  $('#buscador_resultados_body').html('');
  $('#buscador_resultados_pagination').html('');

  let form_data = new FormData($('#form_0_buscador')[0]);
  let self = $.confirm({
    title: false,
    content: 'Cargando, espere...',
    typeAnimated: true,
    scrollToPreviousElement: false,
    scrollToPreviousElementAnimate: false,
    content: function () {
      return $.ajax({
        url:
          PROTOCOL_HOST +
          '/clientes/supervisor/vehiculos/visor/modelo/buscador_de_vehiculos.php',
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
              buscador_de_vehiculos(_type);
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
