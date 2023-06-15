const const_id_vehiculo = $('meta[name="csrf-id"]').attr('content');

let accordion_busqueda = null;

export function fun_informacion_vehiculo_rtm_accordion(_funtion_name) {
  accordion_busqueda = _funtion_name;
}
$(
  'input[type=radio][name=form_1_regrabacion_motor],' +
    'input[type=radio][name=form_1_regrabacion_chasis],' +
    'input[type=radio][name=form_1_regrabacion_serie], ' +
    'input[type=radio][name=form_1_regrabacion_vin] '
).change(function () {
  radio_regrabacion_input($(this).val(), $(this).attr('data-input'));
});

function radio_regrabacion_input(_value, _data_input) {
  if (_value == '1') {
    $('#' + _data_input).val('');
  } else {
    $('#' + _data_input).val('NO');
  }
}

$('#form_1_informacion_basica').on('submit', function (e) {
  $.confirm({
    title: 'Alerta!',
    content:
      '<center>¿Desea guardar la información de este formulario?</center>',
    columnClass: 'xsmall',
    buttons: {
      si: function () {
        fun_form_1_informacion_vehiculo();
      },
      no: function () {},
    },
  });
  e.preventDefault();
  return false;
});

function fun_form_1_informacion_vehiculo() {
  let formdata = new FormData($('#form_1_informacion_basica')[0]);
  formdata.append('form_1_id_vehiculo', const_id_vehiculo);

  let fun_form_status = false;

  $.confirm({
    title: 'Error ',
    content: 'Cargando, espere...',
    typeAnimated: true,
    scrollToPreviousElement: false,
    scrollToPreviousElementAnimate: false,
    content: function () {
      var self = this;
      return $.ajax({
        url:
          PROTOCOL_HOST +
          '/clientes/administrador/vehiculos/agregar/modelo/informacion_vehiculo/form_informacion_vehiculo.php',
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
            fun_form_status = true;
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();
            call_recuperar_session(function (k) {
              fun_form_1_informacion_vehiculo();
            });
          } else if (response.status === 'sin_resultados') {
            self.close();
          } else {
            self.setTitle(response.status);
            self.setContent(response.message);
          }
        })
        .fail(function (response) {
          self.setTitle('Error fatal');
          self.setContent(response.statusText + ' // ' + response.responseText);
          console.log(response);
        });
    },
    onClose: function (_param) {
      if (fun_form_status == true) {
        accordion_busqueda(1, false);
      }
    },
    buttons: {
      aceptar: function () {},
    },
  });
}
