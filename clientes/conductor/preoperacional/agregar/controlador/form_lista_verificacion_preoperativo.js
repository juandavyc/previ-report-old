const const_id_preoperativo = $('meta[name="csrf-id"]').attr('content');

let accordion_busqueda = null;
export function fun_preoperativo_listado_accordion(_funtion_name) {
  accordion_busqueda = _funtion_name;
}

import { firma_1 } from './accordion.js';

$('#form_1_informacion_lista_informacion_preoperacional').on('submit', function (e) {
  fun_form_1_listado_mantenimiento();
  e.preventDefault();
  return false;
});

$("#select_all").on('change', function (e) {

  let array_1 = $('select[data-id=1]');

  for (let element of array_1) {

    if ($(this).val() == 1) {
      $(element).val('N/A');
    } else if ($(this).val() == 2) {
      $(element).val('BUENO');
    } else if ($(this).val() == 3) {
      $(element).val('REGULAR');
    } else {
      $(element).val('MALO');
    }
  }

});

function fun_form_1_listado_mantenimiento() {


  let fun_form_1_status = false;

  if (firma_1.get_status == false) {
    $.alert("Falta la firma del usuario.");
  }
  else {
    let formdata = new FormData($('#form_1_informacion_lista_informacion_preoperacional')[0]);
    formdata.append('id_preoperativo', const_id_preoperativo);
    formdata.append("form_1_canvas", firma_1.get_blob);

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
            '/clientes/conductor/preoperacional/agregar/modelo/listado_preoperativo/guardar_listado_preoperativo.php',
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
            console.log(response);
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
      }, onClose: function (_param) {
          window.location.href =
            PROTOCOL_HOST +
            '/clientes/conductor/preoperacional-super/visor/';
      },
      buttons: {
        aceptar: function () { },
      },
    });
  }
}
