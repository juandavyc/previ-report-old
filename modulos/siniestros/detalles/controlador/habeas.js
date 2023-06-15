
////////////////////////////////////////////////////////
// HABEAS //////////////////////////////////////////////
////////////////////////////////////////////////////////

$("#div_dialog_habeas").dialog({
  width: 'auto', // overcomes width:'auto' and maxWidth bug
  maxWidth: 400,
  height: 'auto',
  maxHeight: 600,
  // position: 'top',
  draggable: false,
  resizable: false,
  modal: true,
  autoOpen: true,
  fluid: true,
  closeOnEscape: false,
  open: function (event, ui) {
    $(this).parent().children().children('.ui-dialog-titlebar-close').hide();
    // mobileps
    $("body").css({
      "overflow": "hidden"
    });

  },
  beforeClose: function (event, ui) {
    $("body").css({
      "overflow": '',
      'position': ''
    });
  },
  close: function () {
    $('#form_habeas').trigger("reset");
    // window.location.reload();
  }
});


setTimeout(function () {
  $("#habeas_input_submit").focus();
}, 500);

const json_firma_habeas = {
  id_container: 'canvas_firma_habeas',
  title_label: 'Firma',
  responsive: '#canvas_firma_habeas',
};
let firma_habeas = new canvas_firma(json_firma_habeas);


$('#form_habeas').on('submit', function (e) {

  if (firma_habeas.get_status == false) {
    $.alert("Falta la firma del usuario.");
  }
  else {

    let formdata = new FormData($('#form_habeas')[0]);
    formdata.append('canvas_firma_habeas', firma_habeas.get_blob);
    formdata.append('url', window.location.href);
    formdata.append('id', $('meta[name="csrf-id"]').attr('content'));
    formdata.append('task', 3); // siniestro


    let self = $.confirm({
      title: 'Error',
      content: 'Cargando, Espere ...',
      typeAnimated: true,
      scrollToPreviousElement: false,
      scrollToPreviousElementAnimate: false,
      content: function () {
        return $.ajax({
          url: PROTOCOL_HOST + '/modulos/habeas/save_habeas.php',
          type: 'POST',
          contentType: false,
          processData: false,
          data: formdata,
          headers: {
            'csrf-token': $('meta[name="csrf-token"]').attr('content'),
          },
          dataType: 'json',
          timeout: 5000,
        }).done(function (response) {
          if (response.status === 'bien') {
            self.setTitle(response.status);
            self.setContent(response.message);
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {

            call_recuperar_session(function (k) {
              fun_form_2_informacion_del_conductor();
            });
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
      buttons: {
        aceptar: function () { },
      },
      onClose() {
        $('#div_dialog_habeas').dialog('close');
      }
    });
  }
  e.preventDefault();
});

$('#div_dialog_habeas').dialog('open');



$('#habeas_no_acepto').on('click', function (e) {

  let self = $.confirm({
    title: 'Alerta!',
    content:
      '<center>Se le redireccionará a el inicio de sesión</center>',
    columnClass: 'xsmall',
    buttons: {
      OK: function () {
        window.location.href =
          PROTOCOL_HOST +
          '/modulos/cerrar.php';
      },
      Volver: function () { },
    },
  });


});