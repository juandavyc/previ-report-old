let fun_info = null;
let fun_link = null;

export function fun_agregar_functions(_function_info, _function_link) {
  fun_info = _function_info;
  fun_link = _function_link;
}

$('#form_1_buscar_placa_siniestro').on('submit', function (e) {
  fun_buscar_vehiculo_siniestro();
  e.preventDefault();
  return false;
});
$('#form_2_buscar_documento_siniestro').on('submit', function (e) {
  fun_buscar_datos_conductor_btn();
  e.preventDefault();
  return false;
});
$('#form_2_limpiar_formulario').on('click', function (e) {
  fun_btn_reset(this);
  e.preventDefault();
  return false;
});

// autocomplete_with_insert_father({
//   id_input_text: 'form_1_empresa_input',
//   id_input_select: 'form_1_empresa_select',
//   url_select_ajax:
//     PROTOCOL_HOST +
//     '/clientes/conductor/assets/autocomplete/empresa_general/buscar_empresa.php',
//   url_insert_ajax:
//     PROTOCOL_HOST + '/clientes/conductor/usuarios/visor/modelo/crear_empresa.php',
//   input_value_default: '',
//   input_select_default: '0',
//   input_childs: [
//     {
//       id_input_text: 'form_1_placa_input',
//       id_input_select: 'form_1_placa_select',
//       input_value_default: '',
//       input_select_default: '0',
//     },
//     {
//       id_input_text: 'form_2_documento_input',
//       id_input_select: 'form_2_documento_select',
//       input_value_default: '',
//       input_select_default: '0',
//     },
//   ],
// });

// autocomplete_with_insert_child({
//   id_input_text: 'form_1_placa_input',
//   id_input_select: 'form_1_placa_select',
//   url_select_ajax:
//     PROTOCOL_HOST +
//     '/clientes/conductor/assets/autocomplete/vehiculo_conductor/buscar_empresa.php',
//   url_insert_ajax:
//     PROTOCOL_HOST + '/clientes/conductor/siniestros/visor/modelo/crear_vehiculo.php',
//   input_value_default: '',
//   input_select_default: '0',
//   input_father_name: 'EMPRESA',
//   input_father_text: 'form_1_empresa_input',
//   input_father_select: 'form_1_empresa_select',
// });

autocomplete_with_insert_child({
  id_input_text: 'form_2_documento_input',
  id_input_select: 'form_2_documento_select',
  url_select_ajax:
    PROTOCOL_HOST +
    '/clientes/conductor/assets/autocomplete/conductor_general/buscar_empresa.php',
  url_insert_ajax:
    PROTOCOL_HOST + '/clientes/conductor/siniestros/visor/modelo/crear_conductor.php',
  input_value_default: '',
  input_select_default: '0',
  input_father_name: 'EMPRESA',
  input_father_text: 'form_1_empresa_input',
  input_father_select: 'form_1_empresa_select',
});

autocomplete_with_insert_child({
  id_input_text: 'form_1_placa_input',
  id_input_select: 'form_1_placa_select',
  url_select_ajax:
    PROTOCOL_HOST +
    '/clientes/conductor/assets/autocomplete/vehiculo_conductor/buscar.php',
  url_insert_ajax:
    PROTOCOL_HOST + '/clientes/conductor/assets/autocomplete/vehiculo_conductor/crear.php',
  input_value_default: 'SIN_VEHICULO',
  input_select_default: '1',
  input_childs: [],
});

function fun_btn_reset(self) {
  $('#agregar_resultados_body').hide();
  $('#form_2_buscar_documento_siniestro').trigger('reset');
  $('#form_2_buscar_documento_siniestro').hide();
  $('#form_1_placa_input').attr('readonly', false);
  $('#form_1_buscar_placa_siniestro').show();
  // $('#agregar_resultados_body').hide();
}

function fun_buscar_vehiculo_siniestro() {
  let temp_placa = $('#form_1_placa_select').val();

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
          '/clientes/conductor/siniestros/visor/modelo/buscar_vehiculo_siniestro.php',
        type: 'POST',
        data: {
          placa: temp_placa,
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
            self.setTitle('Completado!');
            self.setContent('Espere un momento...');
            $('#form_1_placa_input').attr('readonly', true);
            $('#form_2_documento_input').val(
              response.message[0].numero_documento
            );

            $('#form_2_documento_select').val(response.message[0].id_conductor);
            $('#form_2_empresa').val($('#form_1_empresa_select').val());

            $('#form_1_buscar_placa_siniestro').hide(100);
            $('#form_2_buscar_documento_siniestro').show(100);

            self.close();
          } else if (response.status === 'sin_resultados') {
            self.setTitle('Completado!');
            self.setContent('Sin resultados');
            self.close();
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();
            call_recuperar_session(fun_buscar_vehiculo_siniestro);
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
    buttons: {
      aceptar: function () {},
    },
  });
}

function fun_buscar_datos_conductor_btn() {
  let form_data = new FormData($('#form_2_buscar_documento_siniestro')[0]);
  form_data.append('id_vehiculo', $('#form_1_placa_select').val());

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
          '/clientes/conductor/siniestros/visor/modelo/buscar_datos_conductor.php',
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
            self.setTitle('Datos del conductor');
            self.setContent(lector_conductor_datos(response.conductor[0]));
          } else if (response.status === 'sin_resultados') {
            self.setTitle('Completado!');
            self.setContent('Espere un momento...');
            self.close();
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();
            call_recuperar_session(fun_buscar_datos_conductor_btn);
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
      aceptar: function () {
        fun_crear_siniestro(form_data);
      },
      cancelar: function () {},
    },
  });
}

function fun_crear_siniestro(datos) {
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
          '/clientes/conductor/siniestros/visor/modelo/crear_siniestro.php',
        type: 'POST',
        data: datos,
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
            self.close();

            window.location.replace(
              PROTOCOL_HOST +
                '/clientes/conductor/siniestros/detalles/index.php?id=' +
                response.message
            );
          } else if (response.status === 'sin_resultados') {
            self.setTitle('Completado!');
            self.setContent('Espere un momento...');
            self.close();
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();
            call_recuperar_session(fun_buscar_datos_conductor_btn);
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

function lector_conductor_datos(_response) {
  console.log(_response);
  let inner_html = `<div class="row gtr-50 gtr-uniform" style="overflow-x: hidden;overflow-y: hidden;">
  <div class="col-12 align-center"> 
  <i class="fas fa-camera-retro fa-3x"></i>
  </div>
  <div class="col-12"><hr class="hr-text" data-content="Foto del conductor">
  </div>
  <div class="col-4 col-12-small"></div>
  <div class="col-4 col-12-small">
  <a href="${PROTOCOL_HOST}${_response.foto}" target="_blank">
  <span class="image fit">
  <img src="${PROTOCOL_HOST}${_response.foto}" class="dialog-image" alt="fotografia_del_certificado">
  </span>
  </a>
  </div>
  <br><br><br>
  <div class="col-4 col-12-small"></div>
  `;
  inner_html += `<div class="col-12 align-center"> 
  <i class="fas fa-user fa-3x"></i>
  </div>
  <div class="col-12">
  <hr class="hr-text" data-content="Información Básica del conductor">
  </div>
  <div class="col-3 col-12-small"><label class="label-datos"> Nombre Completo </label>
  </div>
  <div class="col-3 col-12-small"><label class="label-resultados">${_response.nombre}</label>
  </div>
  <div class="col-3 col-12-small"><label class="label-datos"> Documento de identidad </label>
  </div>
  <div class="col-3 col-12-small"><label class="label-resultados">${_response.documento}</label>
  </div>
  <div class="col-3 col-12-small"><label class="label-datos"> telefono conductor </label>
  </div>
  <div class="col-3 col-12-small"><label class="label-resultados">${_response.telefono}</label>
  </div>
  <div class="col-3 col-12-small"><label class="label-datos"> celular conductor </label>
  </div>
  <div class="col-3 col-12-small"><label class="label-resultados">${_response.celular}</label>
  </div>
  <div class="col-3 col-12-small"><label class="label-datos"> Correo electrónico </label>
  </div>
  <div class="col-3 col-12-small"><label class="label-resultados">${_response.correo}</label>
  </div>
  <div class="col-3 col-12-small"><label class="label-datos"> Tipo de sangre (RH) </label>
  </div>
  <div class="col-3 col-12-small"><label class="label-resultados">${_response.sangre}</label>
  </div>
  </div>`;

  return inner_html;
}
