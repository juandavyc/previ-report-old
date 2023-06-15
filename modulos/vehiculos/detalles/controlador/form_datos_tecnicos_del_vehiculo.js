const const_id_vehiculo = $('meta[name="csrf-id"]').attr('content');

let accordion_busqueda = null;

export function fun_datos_tecnicos_del_vehiculo_rtm_accordion(_funtion_name) {
  accordion_busqueda = _funtion_name;
}
$('#form_4_datos_tecnicos').on('submit', function (e) {
  $.confirm({
    title: 'Alerta!',
    content:
      '<center>¿Desea guardar la información de este formulario?</center>',
    columnClass: 'xsmall',
    buttons: {
      si: function () {
        fun_form_4();
      },
      no: function () {},
    },
  });

  e.preventDefault();
  return false;
});
function fun_form_4() {
  let formdata = new FormData($('#form_4_datos_tecnicos')[0]);
  formdata.append('form_4_id_vehiculo', const_id_vehiculo);

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
          '/modulos/vehiculos/detalles/modelo/datos_tecnicos_del_vehiculo/form_datos_tecnicos_del_vehiculo.php',
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
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();
            call_recuperar_session(function (k) {
              fun_form_4();
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
    onClose: function (_param) {},
    buttons: {
      aceptar: function () {},
    },
  });
}
