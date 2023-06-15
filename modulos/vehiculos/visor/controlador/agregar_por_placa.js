const cabecera_tabla_agregar_vehiculo = [
  'NRO',
  'PLACA',
  'TIPO',
  'CLASE',
  'SERVICIO',
  'EMPRESA',
  'OPCIONES',
];

const botones_tabla_agregar_vehiculo = {
  botones: [
    {
      id: 'btn_info_vehiculo',
      icon: 'fas fa-info-circle',
    },
    {
      id: 'btn_link_vehiculo',
      icon: 'fas fa-external-link-square-alt',
    },
  ],
};

autocomplete_with_insert_father({
  id_input_text: 'form_1_empresa_input',
  id_input_select: 'form_1_empresa_select',
  url_select_ajax:
    PROTOCOL_HOST +
    '/modulos/assets/autocomplete/empresa_general/buscar_empresa.php',
  url_insert_ajax:
    PROTOCOL_HOST + '/modulos/usuarios/visor/modelo/crear_empresa.php',
  input_value_default: '',
  input_select_default: '1',
  input_childs: [],
  is_todo: false,
});

let fun_info = null,
  fun_link = null;

export function fun_agregar_fuctions(_fun_info, _fun_link) {
  fun_info = _fun_info;
  fun_link = _fun_link;
}

let $temp_placa = '',
  $temp_empresa = 0;

$('#form_1_buscar_placa').on('submit', function (e) {
  buscar_por_placa();
  e.preventDefault();
  return false;
});

$('#agregar_resultados_body').on('click', '#btn_info_vehiculo', function (e) {
  fun_info($(this).attr('btn-id'));
  e.preventDefault();
  return false;
});

$('#agregar_resultados_body').on('click', '#btn_crear_vehiculo', function (e) {
  $.confirm({
    title: 'Alerta',
    content:
      '<center>' +
      'Esta por crear un vehículo con la placa <br>' +
      '<b> ( ' +
      escapehtmljs($temp_placa) +
      ' ) </b> <br>' +
      'Para le empresa <br>' +
      '<b> ( ' +
      escapehtmljs($('#form_1_empresa_input').val()) +
      ' ) </b> <br>' +
      '¿Esta seguro que desea continuar?' +
      '</center> ',
    typeAnimated: true,
    scrollToPreviousElement: false,
    scrollToPreviousElementAnimate: false,
    closeIcon: true,
    columnClass: 'small',
    buttons: {
      si: {
        text: 'Si',
        action: function () {
          agregar_vehiculo($temp_placa, $temp_empresa);
        },
      },
      no: {
        text: 'No',
        action: function () { },
      },
    },
  });
});

$('#agregar_resultados_body').on('click', '#btn_link_vehiculo', function (e) {
  fun_link($(this).attr('btn-id'));
});

function buscar_por_placa() {
  $temp_placa = $('#form_1_placa').val().toUpperCase();
  $temp_empresa = $('#form_1_empresa_select').val();

  let form_data = new FormData($('#form_1_buscar_placa')[0]);
  $.confirm({
    title: false,
    content: 'Cargando, espere...',
    typeAnimated: true,
    scrollToPreviousElement: false,
    scrollToPreviousElementAnimate: false,
    content: function () {
      var self = this;
      return $.ajax({
        url: PROTOCOL_HOST + '/modulos/vehiculos/visor/modelo/buscar_placa.php',
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
          if (response.status === 'bien') {
            self.setTitle('Completado!');
            self.setContent('Espere un momento...');

            $('#agregar_resultados_body').html(
              '<div class="col-12 align-center"> <label> - Resultado de la búsqueda - </label> </div>' +
              '<div class="col-12">' +
              '<table class="alt">' +
              '<thead>' +
              getTheadTable(cabecera_tabla_agregar_vehiculo, 'NRO', 'desc') +
              '</thead>' +
              '<tbody>' +
              getTbodyTable(response.body, botones_tabla_agregar_vehiculo) +
              '</tbody>' +
              '</table>' +
              '</div>' +
              '<div class="col-12 align-center"> <label> - Fin de la búsqueda - </label> </div>'
            );
            self.close();
          } else if (response.status === 'sin_resultados') {
            self.setTitle('Completado!');
            self.setContent('Espere un momento...');
            $('#agregar_resultados_body').html(
              '<br><div class="col-6" ></div><br>'
            );
            $('#agregar_resultados_body').html(
              '<div class="col-12 align-center"> <label> - Sin resultados Para esta ( placa ) - </label> </div>' +
              '<div class="col-12 align-center">' +
              '<button class="primary small" id="btn_crear_vehiculo">Click para Crear Vehiculo</button>' +
              '</div>'
            );
            self.close();
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();
            call_recuperar_session(buscar_por_placa);
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

function agregar_vehiculo(_placa, _empresa) {
  let self = $.confirm({
    title: 'Error ',
    content: 'Cargando, espere...',
    typeAnimated: true,
    scrollToPreviousElement: false,
    scrollToPreviousElementAnimate: false,
    content: function () {
      return $.ajax({
        url:
          PROTOCOL_HOST +
          '/modulos/vehiculos/visor/modelo/agregar_por_placa.php',
        type: 'POST',
        data: {
          placa: _placa,
          empresa: _empresa,
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
            self.close();
            window.location.replace(
              PROTOCOL_HOST +
              '/modulos/vehiculos/detalles/index.php?id=' +
              response.message
            );
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();
            call_recuperar_session(function (k) {
              agregar_vehiculo(_placa, _empresa);
            });
          } else {
            self.setTitle(response.status);
            self.setContent(response.body);
          }
        })
        .fail(function (response) {
          console.log(response);
          self.setTitle('Error -> ');
          self.setContent(response.responseText);
        });
    },
    buttons: {
      aceptar: function () { },
    },
  });
}
