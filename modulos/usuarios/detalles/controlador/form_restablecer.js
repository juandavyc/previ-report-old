const const_id = $('meta[name="csrf-id"]').attr('content');

let accordion_busqueda = null;

export function fun_restablecer_accordion(_funtion_name) {
  accordion_busqueda = _funtion_name;
}

$('#form_2_estado_usuario').on('submit', function (e) {
  $.confirm({
    title: 'Alerta!',
    content:
      '<center>¿Desea guardar la información de este formulario?</center>',
    columnClass: 'xsmall',
    buttons: {
      si: function () {
        fun_form_2_submit();
      },
      no: function () { },
    },
  });
  e.preventDefault();
  return false;
});

function fun_form_2_submit() {

  let formdata = new FormData($('#form_2_estado_usuario')[0]);
  formdata.append('form_2_id_usuario', const_id);

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
          '/modulos/usuarios/detalles/modelo/restablecer_usuario/restablecer.php',
        type: 'POST',
        data: formdata,
        contentType: false,
        cache: false,
        processData: false,
        headers: {
          'csrf-token': $('meta[name="csrf-token"]').attr('content'),
        },
        dataType: 'json',
        timeout: 5000,
      })
        .done(function (response) {
          if (response.status === 'bien') {
            self.setTitle(response.status);
            self.setContent(response.message);

            accordion_busqueda(2, false);

          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();
            call_recuperar_session(function (k) {
              fun_form_2_submit();
            });
          } else if (response.status === 'sin_resultados') {
            self.close();
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
    onClose: function (_param) {

    },
    buttons: {
      aceptar: function () { },
    },
  });

}