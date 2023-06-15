import { assign_form_data } from './accordion/lector.js';

$('#mantenimientos_agregar_accordion').accordion({
  autoHeight: false,
  collapsible: true,
  active: false,
  animate: 220,
  // navigation: true,
  heightStyle: 'content',
  active: 0, // Activa la primera
});

const json_firma_1 = {
  id_container: 'canvas_firma_1',
  title_label: 'firma Usuario',
  responsive: '#canvas_firma_1',
};
export let firma_1 = new canvas_firma(json_firma_1);

const const_id_mantenimiento = $('meta[name="csrf-id"]').attr('content');

$('.accordion-mantenimientos-consulta').on('click', function (e) {
  fun_accordion_busqueda($(this).attr('data-id'), true);
  e.preventDefault();
  return false;
});

$('#form_0_btn_link_pdf').on('click', function (e) {
  $.confirm({
    title: 'Alerta',
    content: '<center>¿ Desea visualizar este contenido ?</center> ',
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
            '/pdfs/MANTENIMIENTO_PDF.php?id_mantenimiento=' +
            const_id_mantenimiento +
            '&mant=true';
        },
      },
      otra: {
        text: 'Otra pestaña',
        action: function () {
          window.open(
            PROTOCOL_HOST +
              '/pdfs/MANTENIMIENTO_PDF.php?id_mantenimiento=' +
              const_id_mantenimiento +
              '&mant=true'
          );
        },
      },
    },
  });
  e.preventDefault();
  return false;
});

export function fun_accordion_busqueda(_temp_data_id, _check) {
  if (
    $('#vehiculo_agregar_accordion').accordion('option', 'active') !== false ||
    _check == false
  ) {
    // LIMPIA EL FORMULARIO
    $('#accordion-mantenimientos-consulta' + _temp_data_id + ' > form').trigger(
      'reset'
    );
    $('#accordion-mantenimientos-consulta' + _temp_data_id + ' > form')
      .find('input[type=hidden]')
      .each(function () {
        $(this).val($(this).attr('data-default'));
      });
    // LETRERO DE CARGANDO
    $(
      '#accordion-mantenimientos-consulta' +
        _temp_data_id +
        ' .accordion_form_resultados'
    ).html('Cargando, espere ...');
    if (_temp_data_id > 0) {
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
              id_mantenimiento: const_id_mantenimiento,
            },
            headers: {
              'csrf-token': $('meta[name="csrf-token"]').attr('content'),
            },
            dataType: 'json',
            timeout: 35000,
          })
            .done(function (response) {
              console.log(response);
              if (response.status === 'bien') {
                // console.log(response.message);
                assign_form_data(response.message, _temp_data_id, firma_1);

                self.close();
              } else if (
                response.status === 'csrf' ||
                response.status === 'session'
              ) {
                self.close();
                call_recuperar_session(function (k) {
                  fun_accordion_busqueda(_temp_data_id, _check);
                });
              } else if (response.message === 'Sin resultados') {
                // console.log(_temp_data_id);
                $(
                  '#acordion_mantenimiento_consulta_' +
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
        onDestroy: function () {},
        buttons: {
          aceptar: function () {},
        },
      });
    }
  }
}
