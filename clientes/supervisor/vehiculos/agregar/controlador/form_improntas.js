const const_id_vehiculo = $('meta[name="csrf-id"]').attr('content');

let accordion_busqueda = null;

export function fun_improntas_accordion(_funtion_name) {
  accordion_busqueda = _funtion_name;
}

$('.improntas-images-link').viewbox({
  margin: 50,
  resizeDuration: 300,
  openDuration: 200,
  closeDuration: 200,
  closeButton: true,
  navButtons: true,
  closeOnSideClick: true,
});

$('#form_11_improntas').on('submit', function (e) {
  //fun_form_2_certificado_rtm_resultados();

  $.confirm({
    title: 'Alerta!',
    content:
      '<center>¿Desea guardar la información de este formulario?</center>',
    columnClass: 'xsmall',
    buttons: {
      si: function () {
        fun_form_11();
      },
      no: function () {},
    },
  });

  e.preventDefault();
  return false;
});

function fun_form_11() {
  let formdata = new FormData($('#form_11_improntas')[0]);
  formdata.append('form_11_id_vehiculo', const_id_vehiculo);

  let fun_form_status = false;

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
          '/clientes/supervisor/vehiculos/agregar/modelo/improntas/form.php',
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
              fun_form_11();
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
        accordion_busqueda(11, false);
        $('html, body').animate(
          {
            scrollTop: $('#accordion_vehiculo_consulta_11').offset().top - 150,
          },
          500
        );
      }
    },
    buttons: {
      aceptar: function () {},
    },
  });
}