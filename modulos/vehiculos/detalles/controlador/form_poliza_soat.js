const const_id_vehiculo = $('meta[name="csrf-id"]').attr('content');

let accordion_busqueda = null;

export function fun_poliza_soat_accordion(_funtion_name) {
  accordion_busqueda = _funtion_name;
}

$('#form_3_poliza_soat').on('submit', function (e) {
  //fun_form_2_certificado_rtm_resultados();

  $.confirm({
    title: 'Alerta!',
    content:
      '<center>¿Desea guardar la información de este formulario?</center>',
    columnClass: 'xsmall',
    buttons: {
      si: function () {
        fun_form_3_poliza_soat_resultados();
      },
      no: function () {},
    },
  });

  e.preventDefault();
  return false;
});

// aca evento de informacion y eliminar

function fun_form_3_poliza_soat_resultados() {
  $('#form_2_certificado_rtm_resultados').empty();

  let formdata = new FormData($('#form_3_poliza_soat')[0]);
  formdata.append('form_3_id_vehiculo', const_id_vehiculo);

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
          '/modulos/vehiculos/detalles/modelo/poliza_soat/form_poliza_soat.php',
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
              fun_form_3_poliza_soat_resultados();
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
        accordion_busqueda(3, false);
        $('html, body').animate(
          { scrollTop: $('#accordion_vehiculo_consulta_3').offset().top - 150 },
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

$('#form_3_poliza_soat_resultados').on('click', '#btn_info', function (e) {
  fun_info_poliza_soat($(this).attr('btn-id'));
  e.preventDefault();
  return false;
});

$('#form_3_poliza_soat_resultados').on('click', '#btn_delete', function (e) {
  let $temp_id_certificado = $(this).attr('btn-id');
  $.confirm({
    title: 'Alerta',
    content:
      '<center>' +
      'Esta por <b>eliminar</b> una póliza SOAT ' +
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
          fun_delete_poliza_soat($temp_id_certificado);
        },
      },
      no: {
        text: 'No',
        action: function () {},
      },
    },
  });
});

function fun_delete_poliza_soat(_id_poliza) {
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
          '/modulos/vehiculos/detalles/modelo/poliza_soat/eliminar_poliza_soat.php',
        type: 'POST',
        data: {
          id_poliza: _id_poliza,
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
              fun_delete_poliza_soat(_id_poliza);
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
        accordion_busqueda(3, false);
        $('html, body').animate(
          { scrollTop: $('#accordion_vehiculo_consulta_3').offset().top - 150 },
          500
        );
      }
    },
    buttons: {
      aceptar: function () {},
    },
  });
}

function fun_info_poliza_soat(_id_poliza) {
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
          '/modulos/vehiculos/detalles/modelo/poliza_soat/buscar_informacion_poliza_soat.php',
        type: 'POST',
        data: {
          id_poliza: _id_poliza,
        },
        headers: {
          'csrf-token': $('meta[name="csrf-token"]').attr('content'),
        },
        dataType: 'json',
        timeout: 35000,
      })
        .done(function (response) {
          if (response.status === 'bien') {
            self.setTitle('Detalles póliza SOAT');
            self.setContent(asignar_datos_poliza_soat(response.message[0]));
            // self.close();
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();

            call_recuperar_session(function (k) {
              fun_info_poliza_soat(_id_poliza);
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

function asignar_datos_poliza_soat(_response) {
  // let json_array = (JSON.parse(_response));

  let inner_html = `<div class="row">
  <div class="col-12 align-center"> 
  <i class="fas fas fa-car fa-3x"></i>
  </div>
  <div class="col-12"><hr class="hr-text" data-content="Información de la Póliza SOAT">
  </div><div class="col-3 col-12-small "><label class="label-datos"> Placa Vehiculo </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.vehiculo.placa}</label>
  </div><div class="col-3 col-12-small "><label class="label-datos"> Numero de póliza </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.numero}</label>
  </div><div class="col-3 col-12-small "><label class="label-datos"> Fecha de expedicion </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.fecha_expedicion}</label>
  </div><div class="col-3 col-12-small "><label class="label-datos"> Fecha Vencimiento   </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.fecha_vencimiento}</label>
  </div><div class="col-3 col-12-small "><label class="label-datos"> Aseguradora </label>
  </div><div class="col-9 col-12-small"><label class="label-resultados">${_response.aseguradora.nombre}</label>
  </div><div class="col-12 "><hr class="hr-text" data-content="Responsable">
  </div><div class="col-3 col-12-small "><label class="label-datos"> Usuario </label>  
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.usuario.nombre}</label>
  </div><div class="col-3 col-12-small "><label class="label-datos"> Fecha y hora</label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.fecha}</label>
  </div><div class="col-12 "><hr class="hr-text" data-content="Fotografía de la Póliza SOAT"></div>`;

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
