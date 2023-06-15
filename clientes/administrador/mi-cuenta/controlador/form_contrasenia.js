let accordion_busqueda = null;
export function fun_contrasenia_accordion(_funtion_name) {
  accordion_busqueda = _funtion_name;
}


$('.icon-right').click(function () {

  let temp_status = $(this).attr('data-check');
  let temp_input = $(this).attr('data-id');
  if (temp_status == 1) {
    $(this).attr('data-check', 2);
    $('#' + temp_input).prop('type', 'text');

  }
  else {
    $(this).attr('data-check', 1);
    $('#' + temp_input).prop('type', 'password');
  }

});





$('#form_1_contrasenia').on('submit', function (e) {

  $.confirm({
    title: 'Alerta',
    content:
      '<center>' +
      '¿Está seguro de que desea cambiar su contrasenia?' +
      '</center> ',
    typeAnimated: true,
    scrollToPreviousElement: false,
    scrollToPreviousElementAnimate: false,
    closeIcon: true,
    columnClass: 'small',
    buttons: {
      si: {
        text: 'Si',
        action: function () {
          fun_form_1_submit();
        },
      },
      no: {
        text: 'No',
        action: function () { },
      },
    },
  });

  e.preventDefault();
  return false;
});


function fun_form_1_submit() {
  let formdata = new FormData($('#form_1_contrasenia')[0]);

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
          '/clientes/administrador/mi-cuenta/modelo/guardar_contrasenia.php',
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

            setTimeout(function () {
              self.close();
              window.location.href = PROTOCOL_HOST + '/clientes/administrador/cerrar.php';
            }, 2000);

          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();
            call_recuperar_session(function (k) {
              fun_form_1_submit();
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
    },
    buttons: {
      aceptar: function () { },
    },
  });

}


