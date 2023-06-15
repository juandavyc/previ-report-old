import { assign_form_data } from './accordion/lector_accordion.js';

$('.accordion-conductor-consulta').on('click', function (e) {
  fun_accordion_consulta($(this).attr('data-id'), true);
  e.preventDefault();
  return false;
});

export function fun_accordion_consulta(_temp_data_id, _check) {
  // console.log(_temp_data_id);

  if (
    $('#gestion_accordion').accordion('option', 'active') !== false ||
    _check == false
  ) {

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
            '/clientes/administrador/mi-cuenta/modelo/buscar_informacion.php',
          type: 'POST',
          data: {
            id_consulta: _temp_data_id,
          },
          headers: {
            'csrf-token': $('meta[name="csrf-token"]').attr('content'),
          },
          dataType: 'json',
          timeout: 12000,
        })
          .done(function (response) {
            // console.log(response);
            if (response.status === 'bien') {
              assign_form_data(response.message, _temp_data_id);
              self.setTitle(response.status);
              self.setContent(response.responseText);
              self.close();
            } else if (response.status === 'sin_resultados') {
              $(
                '#gestion_accordion' +
                _temp_data_id +
                ' .accordion_form_resultados'
              ).html('Sin historial');
              self.close();
            } else if (
              response.status === 'csrf' ||
              response.status === 'session'
            ) {

              console.log("dsadasdsa");
              self.close();
              call_recuperar_session(function (k) {
                fun_accordion_consulta(_temp_data_id, _check);
              });
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
        aceptar: function () { },
      },
    });
  }
}

