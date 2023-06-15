
const const_id_vehiculo = $('meta[name="csrf-id"]').attr('content');

let accordion_busqueda = null;
export function fun_fdp_conductor_accordion(_funtion_name) {
  accordion_busqueda = _funtion_name;
}

$('#form_5_fondo_pension_conductor').on('submit', function (e) {

  fun_form_fdp_conductor_accordion();
  e.preventDefault();
  return false;
}); 

function fun_form_fdp_conductor_accordion() {

  let status_accordion = false;

  let formdata = new FormData($('#form_5_fondo_pension_conductor')[0]);
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
          '/modulos/conductores/detalles/modelo/fondo_pension/guardar_datos_fondo_pension_conductor.php',
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
            $('#form_5_fondo_pension_conductor').trigger("reset");

          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();
            call_recuperar_session(function (k) {
              fun_form_fdp_conductor_accordion();
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
        accordion_busqueda(5, false);
        $('html, body').animate(
          { scrollTop: $('#form_5_fdp_resultados').offset().top - 150 },
          500
        );
      }
    },
    buttons: {
      aceptar: function () { },
    },
  });
}




//// --->>>>>>>>>>>>>>>>> INFORMACION fondo_pension <<<<<<<<<<<<<<<<<<<<<<<<--- 

$('#form_5_fdp_resultados').on('click', '#btn_info', function (e) {

  fun_info_fondo_pension_conductor($(this).attr('btn-id'));
  e.preventDefault();
  return false;
});

function fun_info_fondo_pension_conductor(_id_fondo_pension_conductor) {
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
          '/modulos/conductores/detalles/modelo/fondo_pension/buscar_informacion_fondo_pension.php',
        type: 'POST',
        data: {
          id_fondo_pension_conductor: _id_fondo_pension_conductor,
        },
        headers: {
          'csrf-token': $('meta[name="csrf-token"]').attr('content'),
        },
        dataType: 'json',
        timeout: 35000,
      })
        .done(function (response) {
          if (response.status === 'bien') {
            self.setTitle('Detalles fondo de pension');
            self.setContent(asignar_datos_fondo_pension_conductor(response.message[0]));
            // self.close();
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();

            call_recuperar_session(function (k) {
              fun_info_fondo_pension_conductor(_id_eps_conductor);
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

function asignar_datos_fondo_pension_conductor(_response) {
  // let json_array = (JSON.parse(_response));

  let inner_html = `<div class="row gtr-50 gtr-uniform">
  <div class="col-12 align-center"> 
  <i class="fas fas fa-folder-plus fa-3x"></i>
  </div>
  <div class="col-12"><hr class="hr-text" data-content="Información afiliacion fondo pension">
  </div><div class="col-3 col-12-small align-center"><label class="label-datos"> Conductor </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.nombre_conductor}</label>
  </div><div class="col-3 col-12-small align-center"><label class="label-datos"> Eps </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.nombre_fondo_pension}</label>
  </div><div class="col-3 col-12-small align-center"><label class="label-datos"> Fecha de afiliacion </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.fecha_afiliacion_fondo_pension}</label>
  </div><div class="col-3 col-12-small align-center"><label class="label-datos"> Estado afiliacion  </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.nombre_estado_fondo_pension}</label>
  </div><div class="col-12 align-center"><hr class="hr-text" data-content="Fotografía del certificado"></div>`;

  inner_html += `<div class="col-4 col-12-small"></div>
    <div class="col-4 col-12-small">
    <a href="${PROTOCOL_HOST}${_response.foto_fondo_pension_conductor}" target="_blank">
    <span class="image fit">
    <img src="${PROTOCOL_HOST}${_response.foto_fondo_pension_conductor}" class="dialog-image" alt="fotografia_del_certificado">
    </span>
    </a>
    </div>
    <div class="col-4 col-12-small"></div>`;

  inner_html += `</div>`;

  return inner_html;
}


///// --->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> ELIMINAR (ACTUALIZAR ESTADO) <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<---


$('#form_5_fdp_resultados').on(
  'click',
  '#btn_delete',
  function (e) {
    let $temp_id_fondo_pension_conductor = $(this).attr('btn-id');
    $.confirm({
      title: 'Alerta',
      content:
        '<center>' +
        'Esta por <b>eliminar</b> un certificado (fondo de pension) del conductor ' +
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
            fun_info_fondo_pension_conductor_eliminar($temp_id_fondo_pension_conductor);
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

function fun_info_fondo_pension_conductor_eliminar(_id_fondo_pension_conductor) {

  let fondo_pension_status = false;

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
          '/modulos/conductores/detalles/modelo/fondo_pension/eliminar_fondo_pension_conductor.php',
        type: 'POST',
        data: {
          id_fondo_pension_conductor: _id_fondo_pension_conductor,
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
            fondo_pension_status = true;
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();

            call_recuperar_session(function (k) { 
              fun_info_fondo_pension_conductor_eliminar(_id_fondo_pension_conductor);
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
      if (fondo_pension_status == true) {
        accordion_busqueda(5, false);
        $('html, body').animate(
          { scrollTop: $('#form_5_fdp_resultados').offset().top - 150 },
          500
        );
      }
    },
    buttons: {
      aceptar: function () { },
    },
  });
}





