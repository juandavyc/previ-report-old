const const_id_vehiculo = $('meta[name="csrf-id"]').attr('content');

let accordion_busqueda = null;

export function fun_certificados(_funtion_name) {
  accordion_busqueda = _funtion_name;
}

$('#form_8_certificados').on('submit', function (e) {
  //fun_form_2_certificado_rtm_resultados();

  $.confirm({
    title: 'Alerta!',
    content:
      '<center>¿Desea guardar la información de este formulario?</center>',
    columnClass: 'xsmall',
    buttons: {
      si: function () {
        fun_form_8();
      },
      no: function () {},
    },
  });

  e.preventDefault();
  return false;
});

// aca evento de informacion y eliminar

function fun_form_8() {
  $('#form_8_certificados_resultados').empty();

  let formdata = new FormData($('#form_8_certificados')[0]);
  formdata.append('form_8_id_vehiculo', const_id_vehiculo);

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
          '/modulos/vehiculos/detalles/modelo/certificados/form.php',
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
              fun_form_8();
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
        accordion_busqueda(8, false);
        $('html, body').animate(
          { scrollTop: $('#accordion_vehiculo_consulta_8').offset().top - 150 },
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

$('#form_8_certificados_resultados').on('click', '#btn_info', function (e) {
  fun_form_8_info($(this).attr('btn-id'));
  e.preventDefault();
  return false;
});

$('#form_8_certificados_resultados').on('click', '#btn_delete', function (e) {
  let $temp_id_certificado = $(this).attr('btn-id');
  $.confirm({
    title: 'Alerta',
    content:
      '<center>' +
      'Esta por <b>eliminar</b> un Certificado ' +
      ' <br>¿Esta seguro que desea continuar?' +
      '</center> ',
    typeAnimated: true,
    scrollToPreviousElement: false,
    scrollToPreviousElementAnimate: false,
    closeIcon: true,
    columnClass: 'xsmall',
    buttons: {
      si: {
        text: 'Si',
        action: function () {
          fun_delete_form_8($temp_id_certificado);
        },
      },
      no: {
        text: 'No',
        action: function () {},
      },
    },
  });
});

function fun_delete_form_8(_id_elemento) {
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
          '/modulos/vehiculos/detalles/modelo/certificados/eliminar.php',
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
              fun_delete_form_8(_id_elemento);
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
        accordion_busqueda(8, false);
        $('html, body').animate(
          { scrollTop: $('#accordion_vehiculo_consulta_8').offset().top - 150 },
          500
        );
      }
    },
    buttons: {
      aceptar: function () {},
    },
  });
}

function fun_form_8_info(_id_elemento) {
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
          '/modulos/vehiculos/detalles/modelo/certificados/informacion.php',
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
            self.setTitle('Detalles póliza');
            self.setContent(fun_asignar_form_8(response.message[0]));
            // self.close();
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();

            call_recuperar_session(function (k) {
              fun_form_8_info(_id_elemento);
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

function fun_asignar_form_8(_response) {
  // let json_array = (JSON.parse(_response));

  let inner_html = `<div class="row">
  <div class="col-12 align-center"> 
  <i class="fas fas fa-car fa-3x"></i>
  </div>
  <div class="col-12"><hr class="hr-text" data-content="Información de la Certificado">
  </div><div class="col-3 col-12-small"><label class="label-datos"> Placa Vehiculo </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.placa_vehiculo}</label>
  </div><div class="col-3 col-12-small"><label class="label-datos"> Numero del certificado </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.numero_certificado}</label>
  </div><div class="col-3 col-12-small"><label class="label-datos"> Fecha de expedicion</label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.fecha_expedicion_certificado}</label>
  </div><div class="col-3 col-12-small"><label class="label-datos"> Fecha Vencimiento </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.fecha_vencimiento_certificado}</label>
  </div><div class="col-3 col-12-small"><label class="label-datos"> Entidad que certifica </label>
  </div><div class="col-9 col-12-small"><label class="label-resultados">${_response.nombre_entidad_certificado}</label>
  </div><div class="col-12"><hr class="hr-text" data-content="Responsable">
  </div><div class="col-3 col-12-small"><label class="label-datos"> Usuario </label>  
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.nombre_usuario} ${_response.apellido_usuario}</label>
  </div><div class="col-3 col-12-small"><label class="label-datos"> Fecha y hora</label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.fecha_formulario}</label>
  </div><div class="col-12"><hr class="hr-text" data-content="Fotografía del Certificado"></div>`;

  inner_html += `<div class="col-4 col-12-small"></div>
    <div class="col-4 col-12-small">
    <a href="${PROTOCOL_HOST}${_response.foto_certificado}" target="_blank">
    <span class="image fit">
    <img src="${PROTOCOL_HOST}${_response.foto_certificado}" class="dialog-image" alt="fotografia_del_certificado">
    </span>
    </a>
    </div>
    <div class="col-4 col-12-small"></div>`;

  inner_html += `</div>`;

  return inner_html;
}
