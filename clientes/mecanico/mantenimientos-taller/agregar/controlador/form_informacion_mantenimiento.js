const const_id_mantenimiento = $('meta[name="csrf-id"]').attr('content');

//

let accordion_busqueda = null;
export function fun_informacion_mantenimiento_accordion(_funtion_name) {
  accordion_busqueda = _funtion_name;
}

$('#form_1_informacion_mantenimientos').on('submit', function (e) {
  fun_form_1_informacion_mantenimiento();
  e.preventDefault();
  return false;
});

$(
  '#form_1_precio_mano_obra_mantenimiento, #form_1_precio_repuestos_obra_mantenimiento'
).keyup(function () {
  $(this).val(formatMoney($(this).val()));
});
$(
  '#form_1_precio_mano_obra_mantenimiento, #form_1_precio_repuestos_obra_mantenimiento'
).keyup(function () {
  $(this).val(formatMoney($(this).val()));
});

function fun_form_1_informacion_mantenimiento() {
  let formdata = new FormData($('#form_1_informacion_mantenimientos')[0]);
  formdata.append('id_mantenimiento', const_id_mantenimiento);

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
          '/clientes/mecanico/mantenimientos-taller/agregar/modelo/informacion_mantenimiento/guardar_datos_mantenimiento.php',
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
