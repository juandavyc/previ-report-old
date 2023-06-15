const const_id = $('meta[name="csrf-id"]').attr('content');

let accordion_busqueda = null;

export function fun_certificado_accordion(_funtion_name) {
  accordion_busqueda = _funtion_name;
}

$('#form_1_certificado_rtm').on('submit', function (e) {
  $.confirm({
    title: 'Alerta!',
    content:
      '<center>¿Desea guardar la información de este formulario?</center>',
    columnClass: 'xsmall',
    buttons: {
      si: function () {
        fun_form_2_submit();
      },
      no: function () {},
    },
  });

  e.preventDefault();
  return false;
});

function fun_form_2_submit() {
  $('#form_2_certificado_rtm_resultados').empty();

  let formdata = new FormData($('#form_1_certificado_rtm')[0]);
  formdata.append('form_1_id_empresa', const_id);

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
          '/modulos/empresas/detalles/modelo/certificado/form.php',
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
              fun_form_2_submit();
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
      if (fun_form_status == true) {
        accordion_busqueda(1, false);
        $('html, body').animate(
          { scrollTop: $('#accordion_consulta_1').offset().top - 150 },
          500
        );
      }
    },
    buttons: {
      aceptar: function () {},
    },
  });
}

// Eventos

$('#form_1_certificado_resultados').on('click', '#btn_info', function (e) {
  fun_info_certificado($(this).attr('btn-id'));
  e.preventDefault();
  return false;
});

$('#form_1_certificado_resultados').on('click', '#btn_delete', function (e) {
  let $temp_id_certificado = $(this).attr('btn-id');
  $.confirm({
    title: 'Alerta',
    content:
      '<center>' +
      'Esta por <b>eliminar</b> un certificado ' +
      ' <br>¿Esta seguro que desea continuar?' +
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
          fun_delete_certificado($temp_id_certificado);
        },
      },
      no: {
        text: 'No',
        action: function () {},
      },
    },
  });
});

function fun_delete_certificado(_id_elemento) {
  let fun_delete_status = false;

  let self = $.confirm({
    title: false,
    content: 'Cargando, espere...',
    typeAnimated: true,
    scrollToPreviousElement: false,
    scrollToPreviousElementAnimate: false,
    closeIcon: true,
    content: function () {
      return $.ajax({
        url:
          PROTOCOL_HOST +
          '/modulos/empresas/detalles/modelo/certificado/eliminar.php',
        type: 'POST',
        data: {
          id_elemento: _id_elemento,
        },
        headers: {
          'csrf-token': $('meta[name="csrf-token"]').attr('content'),
        },
        dataType: 'json',
        timeout: 35000,
      })
        .done(function (response) {
          if (response.status === 'bien') {
            self.setTitle('Eliminado');
            self.setContent(response.message);

            fun_delete_status = true;
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();

            call_recuperar_session(function (k) {
              fun_delete_certificado(_id_elemento);
            });
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
    onClose: function () {
      if (fun_delete_status == true) {
        accordion_busqueda(1, false);
        $('html, body').animate(
          { scrollTop: $('#accordion_consulta_1').offset().top - 150 },
          500
        );
      }
    },
    buttons: {
      aceptar: function () {},
    },
  });
}

function fun_info_certificado(_id_elemento) {
  let self = $.confirm({
    title: false,
    content: 'Cargando, espere...',
    typeAnimated: true,
    scrollToPreviousElement: false,
    scrollToPreviousElementAnimate: false,
    closeIcon: true,
    columnClass: 'large',
    content: function () {
      return $.ajax({
        url:
          PROTOCOL_HOST +
          '/modulos/empresas/detalles/modelo/certificado/informacion.php',
        type: 'POST',
        data: {
          id_elemento: _id_elemento,
        },
        headers: {
          'csrf-token': $('meta[name="csrf-token"]').attr('content'),
        },
        dataType: 'json',
        timeout: 35000,
      })
        .done(function (response) {
          if (response.status === 'bien') {
            self.setTitle('Detalles certificado');
            self.setContent(fun_asignar_datos(response.message[0]));
            // self.close();
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();

            call_recuperar_session(function (k) {
              fun_info_certificado(_id_elemento);
            });
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
    buttons: {
      aceptar: function () {},
    },
  });
}

function fun_asignar_datos(_response) {
  // let json_array = (JSON.parse(_response));

  console.log(_response);

  let inner_html = `<div class="row">
  <div class="col-12 align-center"> 
  <i class="fas fas fa-car fa-3x"></i>
  </div>
  <div class="col-12"><hr class="hr-text" data-content="Información certificado"></div>
  <div class="col-3 col-12-small "><label class="label-datos"> Tipo </label></div>
  <div class="col-3 col-12-small"><label class="label-resultados">${_response.tipo}</label></div>
  <div class="col-3 col-12-small "><label class="label-datos"> numero </label></div>
  <div class="col-3 col-12-small"><label class="label-resultados">${_response.nombre}</label></div>
  <div class="col-3 col-12-small "><label class="label-datos"> Entidad </label></div>
  <div class="col-9 col-12-small"><label class="label-resultados">${_response.entidad}</label></div>
  <div class="col-3 col-12-small "><label class="label-datos"> Fecha de expedicion </label></div>
  <div class="col-3 col-12-small"><label class="label-resultados">${_response.fecha_expedicion}</label></div>
  <div class="col-3 col-12-small "><label class="label-datos"> Fecha de vencimiento </label></div>
  <div class="col-3 col-12-small"><label class="label-resultados">${_response.fecha_vencimiento}</label></div>
  <div class="col-12 "><hr class="hr-text" data-content="Responsable"></div>
  <div class="col-3 col-12-small"><label class="label-datos"> Usuario </label></div>
  <div class="col-3 col-12-small"><label class="label-resultados">${_response.usuario}</label></div>
  <div class="col-3 col-12-small"><label class="label-datos"> Fecha y hora</label></div>
  <div class="col-3 col-12-small"><label class="label-resultados">${_response.fecha}</label></div>
  <div class="col-12 "><hr class="hr-text" data-content="Fotografía del certificado"></div>`;

  inner_html += `<div class="col-4 col-12-small"></div>
    <div class="col-4 col-12-small">
    <a href="${PROTOCOL_HOST}${_response.foto}" target="_blank">
    <span class="image fit">
    <img src="${PROTOCOL_HOST}${_response.foto}" class="dialog-image" alt="fotografia_del_certificado">
    </span>
    </a>
    </div>
    <div class="col-4 col-12-small"></div>`;

  inner_html += `</div>`;

  return inner_html;
}
