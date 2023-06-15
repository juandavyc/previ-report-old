const cabecera_tabla_agregar_conductor = [
  'nro',
  'documento',
  'nombre',
  'apellido',
  'empresa',
  'opciones',
];

const botones_tabla_agregar_conductor = {
  botones: [
    {
      id: 'btn_info_conductor',
      icon: 'fas fa-info-circle',
    },
    {
      id: 'btn_link_conductor',
      icon: 'fas fa-external-link-square-alt',
    },
  ],
};

let fun_info = null,
  fun_link = null;

export function fun_agregar(_fun_info, _fun_link) {
  fun_info = _fun_info;
  fun_link = _fun_link;
}

let $temp_cedula = '',
  $temp_empresa = 0;
let id = '';

autocomplete_with_insert_father({
  id_input_text: 'form_1_empresa_input',
  id_input_select: 'form_1_empresa_select',
  url_select_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/empresa_general/buscar_empresa.php',
  url_insert_ajax:
    PROTOCOL_HOST + '/clientes/administrador/usuarios/visor/modelo/crear_empresa.php',
  input_value_default: '',
  input_select_default: '1',
  input_childs: [],
  is_todo: false,
});

$('#form_buscar_cedula').on('submit', function (e) {
  buscador_por_cedula();
  e.preventDefault();
  return false;
});

function buscador_por_cedula() {
  $temp_cedula = $('#form_1_cedula').val().toUpperCase();
  // $temp_empresa = $('#form_1_empresa_select').val();

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
          '/clientes/administrador/conductores/visor/modelo/buscar_conductor.php',
        type: 'POST',
        data: {
          cedula: $temp_cedula,
          // empresa: $temp_empresa,
        },
        headers: {
          'csrf-token': $('meta[name="csrf-token"]').attr('content'),
        },
        dataType: 'json',
      })

        .done(function (response) {
          console.log(response);
          if (response.status === 'bien') {
            self.setTitle('Completado!');
            self.setContent('Espere un momento...');
            $('#agregar_resultados_body').html(
              '<div class="col-12 align-center"> <label> - Resultado de la búsqueda - </label> </div>' +
                '<div class="col-12">' +
                '<table class="alt">' +
                '<thead>' +
                getTheadTable(cabecera_tabla_agregar_conductor, 'nro', 'desc') +
                '</thead>' +
                '<tbody>' +
                getTbodyTable(response.body, botones_tabla_agregar_conductor) +
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
              '<div class="col-12 align-center"> <label> - Sin resultados Para esta ( cedula ) - </label> </div>' +
                '<div class="col-12 align-center">' +
                '<button class="primary small" id="btn_crear_conductor">Click para Crear conductor </button>' +
                '</div>'
            );
            self.close();
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();
            call_recuperar_session(buscador_por_cedula);
          } else {
            self.setTitle(response.status);
            self.setContent(response.body);
          }
        })
        .fail(function (response) {
          self.setTitle('Error');
          self.setContent(response.responseText);
          console.log('fail');
          console.log(response);
        });
    },
    buttons: {
      aceptar: function () {},
    },
  });
}

$('#agregar_resultados_body').on('click', '#btn_info_conductor', function (e) {
  fun_info($(this).attr('btn-id'));
  e.preventDefault();
  return false;
});

$('#agregar_resultados_body').on('click', '#btn_link_conductor', function (e) {
  fun_link($(this).attr('btn-id'));
  e.preventDefault();
  return false;
});

$('#agregar_resultados_body').on('click', '#btn_crear_conductor', function (e) {
  $.confirm({
    title: 'Alerta',
    content:
      '<center>' +
      'Esta por crear un vehículo con la placa <br>' +
      '<b> ( ' +
      escapehtmljs($temp_cedula) +
      ' ) </b> <br>' +
      '¿Esta seguro que desea continuar?' +
      '</center> ',
    typeAnimated: true,
    scrollToPreviousElement: false,
    scrollToPreviousElementAnimate: false,
    buttons: {
      si: {
        text: 'Si',
        action: function () {
          agregar_conductor($temp_cedula, $temp_empresa);
        },
      },
      no: {
        text: 'No',
        action: function () {},
      },
    },
  });
});

function agregar_conductor(_cedula, _empresa) {
  $.confirm({
    title: 'Error ',
    content: 'Cargando, espere...',
    typeAnimated: true,
    scrollToPreviousElement: false,
    scrollToPreviousElementAnimate: false,

    content: function () {
      var self = this;
      return $.ajax({
        url:
          PROTOCOL_HOST +
          '/clientes/administrador/conductores/visor/modelo/agregar_por_cedula.php',
        type: 'POST',
        data: {
          cedula: _cedula,
          empresa: _empresa,
        },
        headers: {
          'csrf-token': $('meta[name="csrf-token"]').attr('content'),
        },
        dataType: 'json',
        timeout: 12000,
      })
        .done(function (response) {
          console.log(response);
          if (response.status === 'bien') {
            self.close();

            window.location.replace(
              PROTOCOL_HOST +
                '/clientes/administrador/conductores/agregar/index.php?id=' +
                response.message
            );
          } else {
            self.setTitle(response.status);
            self.setContent(response.message);
          }
        })
        .fail(function (response) {
          console.log(response);
          self.setTitle('Error -> ');
          self.setContent(response.responseText);
        });
    },
    buttons: {
      aceptar: function () {},
    },
  });
}
