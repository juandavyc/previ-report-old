
const const_id_vehiculo = $('meta[name="csrf-id"]').attr('content');

let accordion_busqueda = null;
export function fun_examen_ocupacional_conductor_accordion(_funtion_name) {
  accordion_busqueda = _funtion_name;
}

$('#form_8_examen_ocupacional_conductor').on('submit', function (e) {

  fun_form_examen_ocupacional_conductor_accordion();
  e.preventDefault();
  return false;
});

function fun_form_examen_ocupacional_conductor_accordion() {

  let status_accordion = false;

  let formdata = new FormData($('#form_8_examen_ocupacional_conductor')[0]);
  formdata.append("id_conductor",const_id_vehiculo);

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
          '/modulos/conductores/detalles/modelo/examen_ocupacional/guardar.php',
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
            status_accordion = true;
            $('#form_8_examen_ocupacional_conductor').trigger("reset");
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();
            call_recuperar_session(function (k) {
              fun_form_examen_ocupacional_conductor_accordion();
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
      if (status_accordion == true) {
        accordion_busqueda(8, false);
        $('html, body').animate(
          { scrollTop: $('#form_8_examen_ocupacional_resultados').offset().top - 150 },
          500
        );
      }
    },
    buttons: {
      aceptar: function () { },
    },
  });
}





//// --->>>>>>>>>>>>>>>>> INFORMACION examen_ocupacional <<<<<<<<<<<<<<<<<<<<<<<<--- 

$('#form_8_examen_ocupacional_resultados').on('click', '#btn_info', function (e) {

  fun_info_examen_ocupacional_conductor($(this).attr('btn-id'));
  e.preventDefault();
  return false;
});

function fun_info_examen_ocupacional_conductor(_id_examen_ocupacional_conductor) {
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
          '/modulos/conductores/detalles/modelo/examen_ocupacional/buscar.php',
        type: 'POST',
        data: {
          id_examen_ocupacional_conductor: _id_examen_ocupacional_conductor,
        },
        headers: {
          'csrf-token': $('meta[name="csrf-token"]').attr('content'),
        },
        dataType: 'json',
        timeout: 35000,
      })
        .done(function (response) {
          if (response.status === 'bien') {
            self.setTitle('Detalles examen_ocupacional Conductor');
            self.setContent(asignar_datos_examen_ocupacional_conductor(response.message[0]));
            // self.close();
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();

            call_recuperar_session(function (k) {
              fun_info_examen_ocupacional_conductor(_id_examen_ocupacional_conductor);
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
      aceptar: function () { },
    },
  });
}

function asignar_datos_examen_ocupacional_conductor(_response) {
  // let json_array = (JSON.parse(_response));

  let inner_html = `<div class="row gtr-50 gtr-uniform">
  <div class="col-12 align-center"> 
  <i class="fas fas fa-folder-plus fa-3x"></i>
  </div>
  <div class="col-12"><hr class="hr-text" data-content="Información afiliacion examen_ocupacional">
  </div><div class="col-3 col-12-small align-center"><label class="label-datos"> fecha expedicion </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.fecha_expedicion_examen}</label>
  </div><div class="col-3 col-12-small align-center"><label class="label-datos"> fecha vencimiento </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.fecha_vencimiento_examen}</label>
  </div><div class="col-3 col-12-small align-center"><label class="label-datos"> Entidad que expide </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.nombre_entidad_examen}</label>
  </div><div class="col-3 col-12-small align-center"><label class="label-datos"> Recomendaciones </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.recomendaciones}</label>
  </div><div class="col-12 align-center"><hr class="hr-text" data-content="Fotografía del certificado"></div>`;

  inner_html += `<div class="col-4 col-12-small"></div>
    <div class="col-4 col-12-small">
    <a href="${PROTOCOL_HOST}${_response.foto_examen}" target="_blank">
    <span class="image fit">
    <img src="${PROTOCOL_HOST}${_response.foto_examen}" class="dialog-image" alt="fotografia_del_certificado">
    </span>
    </a>
    </div>
    <div class="col-4 col-12-small"></div>`;

  inner_html += `</div>`;

  return inner_html;
}


///// --->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> ELIMINAR (ACTUALIZAR ESTADO) <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<---


$('#form_8_examen_ocupacional_resultados').on(
  'click',
  '#btn_delete',
  function (e) {
    let $temp_id_examen_ocupacional_conductor = $(this).attr('btn-id');
    $.confirm({
      title: 'Alerta',
      content:
        '<center>' +
        'Esta por <b>eliminar</b> un certificado examen_ocupacional del conductor ' +
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
            fun_info_examen_ocupacional_conductor_eliminar($temp_id_examen_ocupacional_conductor);
          },
        },
        no: {
          text: 'No',
          action: function () { },
        },
      },
    });
  }
);

function fun_info_examen_ocupacional_conductor_eliminar(_id_examen_ocupacional_conductor) {

  let examen_ocupacional_status = false;

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
          '/modulos/conductores/detalles/modelo/examen_ocupacional/eliminar.php',
        type: 'POST',
        data: {
          id_examen_ocupacional_conductor: _id_examen_ocupacional_conductor,
        },
        headers: {
          'csrf-token': $('meta[name="csrf-token"]').attr('content'),
        },
        dataType: 'json',
        timeout: 35000,
      })
        .done(function (response) {
          if (response.status === 'bien') {
            self.setTitle(response.status);
            self.setContent(response.message);
            // self.close();
            examen_ocupacional_status = true;
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();

            call_recuperar_session(function (k) { 
              fun_info_examen_ocupacional_conductor_eliminar(_id_examen_ocupacional_conductor);
            });
          } else if(response.status === 'sin_resultados'){
            self.close();
          }
            else {
            self.setTitle(response.status);
            self.setContent(response.message);
          }
        })
        .fail(function (response) {
          self.setTitle('Error fatal');
          self.setContent(response.statusText + ' // ' + response.responseText);
          console.log(response);
        });
    }, onClose: function () {
      if (examen_ocupacional_status == true) {
        accordion_busqueda(8, false);
        $('html, body').animate(
          { scrollTop: $('#form_8_examen_ocupacional_resultados').offset().top - 150 },
          500
        );
      }
    },
    buttons: {
      aceptar: function () { },
    },
  });
}


