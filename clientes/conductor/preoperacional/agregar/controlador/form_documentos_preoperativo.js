const const_id_preoperativo = $('meta[name="csrf-id"]').attr('content');

//

let accordion_busqueda = null;
export function fun_preoperativo_accordion(_funtion_name) {
  accordion_busqueda = _funtion_name;
}

$('#form_1_informacion_documentos_preoperacional').on('submit', function (e) {
  fun_form_1_informacion_mantenimiento();
  e.preventDefault();
  return false;
});

function fun_form_1_informacion_mantenimiento() {
  let formdata = new FormData($('#form_1_informacion_documentos_preoperacional')[0]);
  formdata.append('id_preoperativo', const_id_preoperativo);

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
          '/clientes/conductor/preoperacional/agregar/modelo/documentos_preoperativo/guardar_datos_preoperativo.php',
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
            // $('#form_1_informacion_mantenimientos').trigger('reset');
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();
            call_recuperar_session(function (k) {
              fun_form_1_informacion_mantenimiento();
            });
          } else {
            self.setTitle(response.status);
            self.setContent(response.message);
            // $('#form_1_informacion_mantenimientos').trigger('reset');
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
