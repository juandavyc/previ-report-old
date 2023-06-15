const const_id_mantenimiento = $('meta[name="csrf-id"]').attr('content');

let accordion_busqueda = null;
export function fun_repuestos_mantenimiento_acordion(_funtion_name) {
  accordion_busqueda = _funtion_name;
}

$('#form_4_repuesto_mantenimiento').on('submit', function (e) {
  fun_form_repuestos_mantenimiento_accordion();
  e.preventDefault();
  return false;
});

$('#form_4_valor_repuesto').keyup(function () {
  $(this).val(formatMoney($(this).val()));
});
$('#form_4_valor_repuesto').keyup(function () {
  $(this).val(formatMoney($(this).val()));
});

function fun_form_repuestos_mantenimiento_accordion() {
  let status_accordion = false;

  let formdata = new FormData($('#form_4_repuesto_mantenimiento')[0]);
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
          '/clientes/supervisor/mantenimientos-taller/agregar/modelo/informacion_repuestos_mantenimiento/guardar_informacion_repuesto.php',
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
            status_accordion = true;
            $('#form_4_repuesto_mantenimiento').trigger('reset');
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();
            call_recuperar_session(function (k) {
              fun_form_vehiculo_conductor_accordion();
            });
          } else if (response.status === 'mal') {
            self.setTitle(response.status);
            self.setContent(response.message);
            $('#form_4_repuesto_mantenimiento').trigger('reset');
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
      if (status_accordion == true) {
        accordion_busqueda(4, false);
        $('html, body').animate(
          { scrollTop: $('#form_4_repuestos_resultados').offset().top - 150 },
          500
        );
      }
    },
    buttons: {
      aceptar: function () {},
    },
  });
}

$('#form_4_repuestos_resultados').on('click', '#btn_question', function (e) {
  $.alert('<center>Eventos Desactivados</center>');
  e.preventDefault();
  return false;
});
