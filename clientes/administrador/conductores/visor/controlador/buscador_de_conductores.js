const botones_tabla_buscador = {
  botones: [
    {
      id: 'btn_info_conductor',
      icon: 'fas fa-info-circle',
    },
    {
      id: 'btn_link_conductor',
      icon: 'fas fa-external-link-square-alt',
    },
    {
      id: 'btn_link_pdf',
      icon: 'far fa-file-pdf',
    },
  ],
};
const table_thead = ['id', 'placa', 'Opciones'];
const botones_tabla_vehiculo_conductor = {
  botones: [
    {
      id: 'btn_link',
      icon: 'fas fa-external-link-alt',
    },
  ],
};

buscador_de_conductores(false);

let fun_info = null,
  fun_link = null;
export function fun_buscador(_fun_info, _fun_link) {
  fun_info = _fun_info;
  fun_link = _fun_link;
}

autocomplete_with_insert_father({
  id_input_text: 'form_0_empresa_input',
  id_input_select: 'form_0_empresa_select',
  url_select_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/empresa_general/buscar_empresa.php',
  url_insert_ajax:
    PROTOCOL_HOST + '/clientes/administrador/usuarios/visor/modelo/crear_empresa.php',
  input_value_default: 'TODO',
  input_select_default: '0',
  input_childs: [],
  is_todo: true,
});

$('#form_0_buscador').on('submit', function (e) {
  buscador_de_conductores(true);
  e.preventDefault();
  return false;
});

$('#buscador_resultados_pagination').on('click', '#li-data', function (e) {
  if ($(this).attr('data-id') !== '') {
    $('#form_0_page').val($(this).attr('data-id'));
    buscador_de_conductores(false);
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
  buscador_de_conductores(false);

  e.preventDefault();
  return false;
});

$('#form_0_filtro').change(function (e) {
  if ($('#form_0_filtro option:selected').val() == 0) {
    $('#form_0_contenido').val('Todo');
    $('#form_0_contenido').prop('readonly', true);
  } else {
    // console.log("");
    $('#form_0_contenido').prop('readonly', false);
    $('#form_0_contenido').val('');
  }
  e.preventDefault();
  return false;
});

$('#buscador_resultados_body').on('click', '#btn_link_pdf', function (e) {
  fun_link_pdf($(this).attr('btn-id'));
  e.preventDefault();
  return false;
});
export function fun_link_pdf(_id_conductor) {
  $.confirm({
    title: 'Alerta',
    content: '<center>¿ Desea visualizar este PDF en ?</center> ',
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
            PROTOCOL_HOST +
            '/pdfs/CONDUCTOR_PDF.php?id_conductor=' +
            _id_conductor+'&all=true';
        },
      },
      otra: {
        text: 'Otra pestaña',
        action: function () {
          window.open(
            PROTOCOL_HOST +
              '/pdfs/CONDUCTOR_PDF.php?id_conductor=' +
              _id_conductor +
              '&all=true'
          );
        },
      },
    },
  });
}

function pdf_conductor(_id_vehiculo) {
  $.confirm({
    title: 'Alerta',
    content:
      '<center> Clickee el contenido de PDF que desea visualizar </center> ',
    typeAnimated: true,
    scrollToPreviousElement: false,
    scrollToPreviousElementAnimate: false,
    columnClass: 'xsmall',
    closeIcon: true,
    buttons: {
      vehiculo: {
        text: 'CONDUCTOR',
        action: function () {
          window.open(
            PROTOCOL_HOST +
              '/pdfs/hoja_vehicular.php?id_vehiculo=' +
              _id_vehiculo +
              '&con=true'
          );
        },
      },
    },
  });
}

$('#buscador_resultados_body').on('click', '#btn_info_conductor', function (e) {
  fun_info($(this).attr('btn-id'));
  e.preventDefault();
  return false;
});

$('#buscador_resultados_body').on('click', '#btn_link_vehiculo', function (e) {
  fun_link($(this).attr('btn-id'));
  e.preventDefault();
  return false;
});

function buscador_de_conductores(_type) {
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
          '/clientes/administrador/conductores/visor/modelo/buscador_de_conductores.php',
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
              buscador_de_conductores(_type);
            });
          } else {
            self.setTitle(response.status);
            self.setContent(response.body);
          }
        })
        .fail(function (response) {
          self.setTitle('Error fatal');
          self.setContent(response.statusText + ' // ' + response.responseText);
          // console.log(response);
        });
    },
    buttons: {
      aceptar: function () {},
    },
  });
}

$('#buscador_resultados_body').on('click', '#btn_link_conductor', function (e) {
  let $id_conductor = $(this).attr('btn-id');
  $.confirm({
    title: 'Alerta',
    content: '<center>¿ Desea visualizar este contenido en ?</center> ',
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
            PROTOCOL_HOST +
            '/clientes/administrador/conductores/agregar/index.php?id=' +
            $id_conductor;
        },
      },
      otra: {
        text: 'Otra pestaña',
        action: function () {
          window.open(
            PROTOCOL_HOST +
              '/clientes/administrador/conductores/agregar/index.php?id=' +
              $id_conductor
          );
        },
      },
    },
  });
  e.preventDefault();
  return false;
});
