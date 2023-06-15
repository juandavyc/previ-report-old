const const_id_vehiculo = $('meta[name="csrf-id"]').attr('content');

let accordion_busqueda = null;

export function fun_solicitudes_accordion(_funtion_name) {
  accordion_busqueda = _funtion_name;
}

$('#form_9_solicitudes').on('submit', function (e) {
  //fun_form_2_certificado_rtm_resultados();

  $.confirm({
    title: 'Alerta!',
    content:
      '<center>¿Desea guardar la información de este formulario?</center>',
    columnClass: 'xsmall',
    buttons: {
      si: function () {
        fun_form_9();
      },
      no: function () {},
    },
  });

  e.preventDefault();
  return false;
});

// aca evento de informacion y eliminar

function fun_form_9() {
  $('#form_9_solicitudes_resultados').empty();

  let formdata = new FormData($('#form_9_solicitudes')[0]);
  formdata.append('form_9_id_vehiculo', const_id_vehiculo);

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
          '/modulos/vehiculos/detalles/modelo/solicitudes/form.php',
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
              fun_form_9();
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
        accordion_busqueda(9, false);
        $('html, body').animate(
          { scrollTop: $('#accordion_vehiculo_consulta_9').offset().top - 150 },
          500
        );
      }
    },
    buttons: {
      aceptar: function () {},
    },
  });
}

$('#form_9_solicitudes_resultados').on('click', '#btn_info', function (e) {
  fun_form_9_info($(this).attr('btn-id'));
  e.preventDefault();
  return false;
});

function fun_form_9_info(_id_elemento) {
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
          '/modulos/vehiculos/detalles/modelo/solicitudes/informacion.php',
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
            self.setContent(fun_asignar_form_9(response.message[0]));
            // self.close();
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();

            call_recuperar_session(function (k) {
              fun_form_9_info(_id_elemento);
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

function fun_asignar_form_9(_response) {
  // let json_array = (JSON.parse(_response));

  let inner_html = `<div class="row">
  <div class="col-12 align-center"> 
  <i class="fas fas fa-car fa-3x"></i>
  </div>
  <div class="col-12"><hr class="hr-text" data-content="Información de la Solicitud">
  </div><div class="col-3 col-12-small"><label class="label-datos"> Placa Vehiculo </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.placa_vehiculo}</label>
  </div><div class="col-3 col-12-small"><label class="label-datos"> Numero del solicitud </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.numero_solicitud}</label>
  </div><div class="col-3 col-12-small"><label class="label-datos"> Fecha de solicitud</label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.fecha_solicitud}</label>
  </div><div class="col-3 col-12-small"><label class="label-datos"> Estado de solicitud </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.nombre_estado_solicitud}</label>
  </div><div class="col-3 col-12-small"><label class="label-datos"> Entidad de transito</label>
  </div><div class="col-9 col-12-small"><label class="label-resultados">${_response.nombre_entidad_transito}</label>  
  </div><div class="col-12"><hr class="hr-text" data-content="Responsable">
  </div><div class="col-3 col-12-small"><label class="label-datos"> Usuario </label>  
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.nombre_usuario} ${_response.apellido_usuario}</label>
  </div><div class="col-3 col-12-small"><label class="label-datos"> Fecha y hora</label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.fecha_formulario}</label>
  </div><div class="col-12"><hr class="hr-text" data-content="Fotografía de la solicitud"></div>`;

  inner_html += `<div class="col-4 col-12-small"></div>
    <div class="col-4 col-12-small">
    <a href="${PROTOCOL_HOST}${_response.foto_solicitud}" target="_blank">
    <span class="image fit">
    <img src="${PROTOCOL_HOST}${_response.foto_solicitud}" class="dialog-image" alt="fotografia_del_certificado">
    </span>
    </a>
    </div>
    <div class="col-4 col-12-small"></div>`;

  inner_html += `</div>`;

  return inner_html;
}

// Eventos

$('#form_9_solicitudes_resultados').on('click', '#btn_delete', function (e) {
  let $temp_id = $(this).attr('btn-id');
  $.confirm({
    title: 'Alerta',
    content:
      '<center>' +
      'Esta por <b>eliminar</b> una Solicitud ' +
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
          fun_delete_form_9($temp_id);
        },
      },
      no: {
        text: 'No',
        action: function () {},
      },
    },
  });
});

function fun_delete_form_9(_id_elemento) {
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
          '/modulos/vehiculos/detalles/modelo/solicitudes/eliminar.php',
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
              fun_delete_form_9(_id_elemento);
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
        accordion_busqueda(9, false);
        $('html, body').animate(
          { scrollTop: $('#accordion_vehiculo_consulta_9').offset().top - 150 },
          500
        );
      }
    },
    buttons: {
      aceptar: function () {},
    },
  });
}
