import {
  accordion_lector_datos,
  fun_lector_canvas_elements,
} from './accordion/lector_accordion.js';

$('#vehiculo_agregar_accordion').accordion({
  autoHeight: false,
  collapsible: true,
  active: false,
  animate: 220,
  // navigation: true,
  heightStyle: 'content',
  active: 0, // Activa la primera
});

const const_id_usuario = $('meta[name="csrf-id"]').attr('content');

$('.accordion_consulta').on('click', function (e) {
  fun_accordion_busqueda($(this).attr('data-id'), true);
  e.preventDefault();
  return false;
});

export function fun_accordion_canvas_elements(_firma_1) {
  fun_lector_canvas_elements(_firma_1);
}

export function fun_accordion_busqueda(_temp_data_id, _check) {
  if (
    $('#vehiculo_agregar_accordion').accordion('option', 'active') !== false ||
    _check == false
  ) {
    // LIMPIA EL FORMULARIO
    $('#accordion_consulta_' + _temp_data_id + ' > form').trigger('reset');
    $('#accordion_consulta_' + _temp_data_id + ' > form')
      .find('input[type=hidden]')
      .each(function () {
        $(this).val($(this).attr('data-default'));
      });
    // LETRERO DE CARGANDO
    $(
      '#accordion_consulta_' + _temp_data_id + ' .accordion_form_resultados'
    ).html('Cargando, espere ...');

    let self = $.confirm({
      title: false,
      content: 'Cargando, espere...',
      typeAnimated: true,
      scrollToPreviousElement: false,
      scrollToPreviousElementAnimate: false,
      content: function () {
        return $.ajax({
          url: 'modelo/buscar_datos_por_id.php',
          type: 'POST',
          data: {
            id_accordion: _temp_data_id,
            id_usuario: const_id_usuario,
          },
          headers: {
            'csrf-token': $('meta[name="csrf-token"]').attr('content'),
          },
          dataType: 'json',
          timeout: 35000,
        })
          .done(function (response) {
            // console.log(response);
            if (response.status === 'bien') {
              // console.log(response.message);
              accordion_lector_datos(response.message, _temp_data_id);

              self.close();
            } else if (
              response.status === 'csrf' ||
              response.status === 'session'
            ) {
              self.close();
              call_recuperar_session(function (k) {
                fun_accordion_busqueda(_temp_data_id, _check);
              });
            } else if (response.status === 'sin_resultados') {
              $(
                '#accordion_consulta_' +
                _temp_data_id +
                ' .accordion_form_resultados'
              ).html('Sin historial');
              self.close();
            } else {
              self.setTitle(response.status);
              self.setContent(response.body);
            }
          })
          .fail(function (response) {
            self.setTitle('Error fatal');
            self.setContent(
              response.statusText + ' // ' + response.responseText
            );
            console.log(response);
          });
      },
      onDestroy: function () { },
      buttons: {
        aceptar: function () { },
      },
    });
  }
}