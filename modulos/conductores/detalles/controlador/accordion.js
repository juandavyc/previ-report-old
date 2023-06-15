import { assign_form_data } from './accordion/lector_accordion.js';

const $id_conductor = $('meta[name="csrf-id"]').attr('content');
// habeas_data();
$('#form_1_id_conductor').val($id_conductor);

// import {json_firma_1} from './form_informacion_del_conductor.js';
//    let firma_1 = new canvas_firma(json_firma_1);

const json_firma_1 = {
  id_container: 'canvas_firma_1',
  title_label: 'Firma del Conductor',
  responsive: '#canvas_firma_1',
};
export let firma_1 = new canvas_firma(json_firma_1);

$('.accordion-conductor-consulta').on('click', function (e) {
  // // id_consulta -> 1 para datos basicos/ tab 1
  // // id_consulta -> 2 para datos de emergencia del conductor
  // // id_consulta -> 3 para datos de afiliaciones
  fun_accordion_consulta_conductor($(this).attr('data-id'), true);
  e.preventDefault();
  return false;
});

export function fun_accordion_consulta_conductor(_temp_data_id, _check) {
  // console.log(_temp_data_id);

  if (
    $('#vehiculo_agregar_accordion').accordion('option', 'active') !== false ||
    _check == false
  ) {
     // LIMPIA EL FORMULARIO
    $('#acordion_conductor_consulta_' + _temp_data_id + ' > form').trigger(
      'reset'
    );
    $('#acordion_conductor_consulta_' + _temp_data_id + ' > form')
      .find('input[type=hidden]')
      .each(function () {
        $(this).val($(this).attr('data-default'));
      });
    // LETRERO DE CARGANDO
    $(
      '#acordion_conductor_consulta_' +
        _temp_data_id +
        ' .accordion_form_resultados'
    ).html('Cargando, espere ...');

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
            '/modulos/conductores/detalles/modelo/buscar_datos_conductor_general.php',
          type: 'POST',
          data: {
            id_conductor: $id_conductor,
            id_consulta: _temp_data_id,
          },
          headers: {
            'csrf-token': $('meta[name="csrf-token"]').attr('content'),
          },
          dataType: 'json',
          timeout: 12000,
        })
          .done(function (response) {
            // console.log(response.message);
            if (response.status === 'bien') {
              if (response.message[0].firma_conductor == 'SIN_FIRMA') {
                firma_1.set_status(false);
              }
              firma_1.set_status(true);
              assign_form_data(response.message, _temp_data_id, firma_1);
              self.setTitle(response.status);
              self.setContent(response.responseText);
              self.close();
            } else if (
              response.status === 'csrf' ||
              response.status === 'session'
            ) {
              self.close();
              call_recuperar_session(function (k) {
                fun_accordion_consulta_conductor(_temp_data_id, _check);
              });
            }
            else if (response.status === 'sin_resultados') {
              $(
                '#acordion_conductor_consulta_' +
                  _temp_data_id +
                  ' .accordion_form_resultados'
              ).html('Sin historial');
              self.close();
            } else {
              self.setTitle(response.status);
              self.setContent(response.message);
            }
          })
          .fail(function (response) {
            console.log('FAIL');
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
}
export function fun_crear_vehiculo() {
  $.confirm({
    title: 'Alerta!',
    content:
      '<center>Para poder crear un vehículo, solo se puede desde el módulo vehículos </center>',
    columnClass: 'xsmall',
    closeIcon: true,
    buttons: {
      esta: {
        text: 'Esta pestaña',
        action: function () {
          window.location.href = PROTOCOL_HOST + '/modulos/vehiculos/visor/';
        },
      },
      otra: {
        text: 'Otra pestaña',
        action: function () {
          window.open(PROTOCOL_HOST + '/modulos/vehiculos/visor/');
        },
      },
    },
  });
}
export function fun_crear_empresa() {
  $.confirm({
    title: 'Alerta!',
    content:
      '<center>Para poder crear una empresa, solo se puede desde el módulo empresas </center>',
    columnClass: 'xsmall',
    closeIcon: true,
    buttons: {
      esta: {
        text: 'Esta pestaña',
        action: function () {
          window.location.href = PROTOCOL_HOST + '/modulos/empresas/visor/';
        },
      },
      otra: {
        text: 'Otra pestaña',
        action: function () {
          window.open(PROTOCOL_HOST + '/modulos/empresas/visor/');
        },
      },
    },
  });
}
