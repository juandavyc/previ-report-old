const const_id = $('meta[name="csrf-id"]').attr('content');

let accordion_busqueda = null;

export function fun_informacion_accordion(_funtion_name) {
  accordion_busqueda = _funtion_name;
}

const json_firma_usuario = {
  id_container: 'canvas_firma_usuario',
  title_label: 'Firme en el recuadro blanco',
  responsive: '#canvas_firma_usuario',
};

export let firma_1 = new canvas_firma(json_firma_usuario);

autocomplete_with_insert_father({
  id_input_text: 'form_0_empresa_input',
  id_input_select: 'form_0_empresa_select',
  url_select_ajax:
    PROTOCOL_HOST +
    '/modulos/assets/autocomplete/empresa_general/buscar_empresa.php',
  url_insert_ajax:
    PROTOCOL_HOST +
    '/modulos/assets/autocomplete/empresa_general/crear_empresa.php',
  input_value_default: 'SIN EMPRESA',
  input_select_default: '1',
  input_childs: [],
});
autocomplete_with_insert_father({
  id_input_text: 'form_0_taller_input',
  id_input_select: 'form_0_taller_select',
  url_select_ajax:
    PROTOCOL_HOST + '/modulos/assets/autocomplete/taller_general/buscar.php',
  url_insert_ajax:
    PROTOCOL_HOST + '/modulos/assets/autocomplete/taller_general/crear.php',
  input_value_default: 'NO TIENE',
  input_select_default: '1',
  input_childs: [],
});

$('#form_0_rango').on('change', function (e) {
  // rol mecanico
  if (this.value == '6') {
    $('#container-taller').show(200);
    $('#form_0_taller_input').attr('required', true);
  } else {
    $('#container-taller').hide(200);
    $('#form_0_taller_select').val('1'); // default
    $('#form_0_taller_input').val('NO TIENE');
    $('#form_0_taller_input').attr('required', false);
  }
});

$('#form_0_informacion_usuario').on('submit', function (e) {
  $.confirm({
    title: 'Alerta!',
    content:
      '<center>¿Desea guardar la información de este formulario?</center>',
    columnClass: 'xsmall',
    buttons: {
      si: function () {
        fun_form_0_submit();
      },
      no: function () { },
    },
  });

  e.preventDefault();
  return false;
});

function fun_form_0_submit() {
  if (firma_1.get_status == false) {
    $.alert('Falta la firma del usuario.');
  } else {
    let formdata = new FormData($('#form_0_informacion_usuario')[0]);
    formdata.append('form_0_id_usuario', const_id);
    formdata.append('form_0_firma', firma_1.get_blob);

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
            '/modulos/usuarios/detalles/modelo/informacion_usuario/form_informacion.php',
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
        // if (fun_form_1_status == true) {
        //   accordion_busqueda(1, false);
        // }
      },
      buttons: {
        aceptar: function () { },
      },
    });
  }
}

// autocomplete
