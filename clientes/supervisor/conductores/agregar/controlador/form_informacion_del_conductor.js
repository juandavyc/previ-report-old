
const const_id_vehiculo = $('meta[name="csrf-id"]').attr('content');
import {firma_1} from './accordion.js';
// habeas_data();


let accordion_busqueda = null;
export function fun_informacion_conductor_accordion(_funtion_name) {
  accordion_busqueda = _funtion_name;
}

$('#form_1_informacion_basica').on('submit', function (e) {

  fun_form_2_informacion_del_conductor();
  e.preventDefault();
  return false;
});

function fun_form_2_informacion_del_conductor() {

  let fun_form_1_status = false;

if (firma_1.get_status == false) {
  $.alert("Falta la firma del usuario.");
}
else {
  var result = {};
  $.each($('#form_1_informacion_basica').serializeArray(), function () {
      result[this.name] = this.value;
  });
  result['form_1_canvas'] = firma_1.get_blob;

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
          '/clientes/supervisor/conductores/agregar/modelo/datos_basicos_conductor/guardar_datos_basicos_conductor.php',
        type: 'POST',
        data: result,
        headers: {
          'csrf-token': $('meta[name="csrf-token"]').attr('content'),
        },
        dataType: 'json',
        timeout: 5000,
      })
        .done(function (response) {
          if (response.status === 'bien') {
            // console.log(firma_1);
            self.setTitle(response.status);
            self.setContent(response.message);
            // firma_1.set_default();
            fun_form_1_status = true;
            

          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();
            call_recuperar_session(function (k) {
                fun_form_2_informacion_del_conductor();
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
    onClose: function (_param) {
      if (fun_form_1_status = true) {
        accordion_busqueda(1, false, firma_1);
      }
    },
    buttons: {
      aceptar: function () {},
    },
  });
  }
}

