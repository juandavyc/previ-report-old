const const_id = $('meta[name="csrf-id"]').attr('content');
const json_firma_usuario = {
  id_container: 'canvas_firma_usuario',
  title_label: 'Firme en el recuadro blanco',
  responsive: '#canvas_firma_usuario',
};

$('.siniestro-images-link').viewbox({
  margin: 50,
  resizeDuration: 300,
  openDuration: 200,
  closeDuration: 200,
  closeButton: true,
  navButtons: true,
  closeOnSideClick: true,
});

let accordion_busqueda = null;

export function fun_informacion_siniestro_accordion(_funtion_name) {
  accordion_busqueda = _funtion_name;
}

export let firma_1 = new canvas_firma(json_firma_usuario);

$('#form_0_informacion').on('submit', function (e) {
  $.confirm({
    title: 'Alerta!',
    content:
      '<center>¿Desea guardar la información de este formulario?</center>',
    columnClass: 'xsmall',
    buttons: {
      si: function () {
        fun_form_0_submit();
      },
      no: function () {},
    },
  });

  e.preventDefault();
  return false;
});

function fun_form_0_submit() {
  if (firma_1.get_status == false) {
    $.alert('Falta la firma del usuario.');
  } else {
    let formdata = new FormData($('#form_0_informacion')[0]);
    formdata.append('form_0_id_siniestro', const_id);
    formdata.append('form_0_firma', firma_1.get_blob);

    let form_status = false;

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
            '/clientes/conductor/siniestros/detalles/modelo/informacion_siniestro/form_informacion.php',
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
              form_status = true;
            } else if (
              response.status === 'csrf' ||
              response.status === 'session'
            ) {
              self.close();
              call_recuperar_session(function (k) {
                fun_form_0_submit();
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
        if (form_status == true) {
          accordion_busqueda(0, false);
          $('html, body').animate(
            { scrollTop: $('#accordion_consulta_0').offset().top - 150 },
            500
          );
        }
      },
      buttons: {
        aceptar: function () {},
      },
    });
  }
}
