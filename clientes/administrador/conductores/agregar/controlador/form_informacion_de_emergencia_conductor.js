
const const_id_vehiculo = $('meta[name="csrf-id"]').attr('content');

let accordion_busqueda = null;
export function fun_informacion_emergencia_conductor_accordion(_funtion_name) {
  accordion_busqueda = _funtion_name;
}

$('#form_2_informacion_emergencia_conductor').on('submit', function (e) {
  //fun_form_2_certificado_rtm_resultados();
  fun_form_emergencia_conductor_accordion();
  e.preventDefault();
  return false;
});
function fun_form_emergencia_conductor_accordion() {

  let status_accordion = false;

  let formdata = new FormData($('#form_2_informacion_emergencia_conductor')[0]);
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
          '/clientes/administrador/conductores/agregar/modelo/contacto_emergencia/guardar_datos_emergencia_conductor.php',
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
            $('#form_2_informacion_emergencia_conductor').trigger("reset");
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();
            call_recuperar_session(function (k) {
              fun_form_emergencia_conductor_accordion();
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
    }, onClose: function (_param) {
      if (status_accordion == true) {
        accordion_busqueda(2, false);
        $('html, body').animate(
          { scrollTop: $('#form_2_contacto_emergencia_resultados').offset().top - 150 },
          500
        );
      }
    },
    buttons: {
      aceptar: function () { },
    },
  });
}




//// --->>>>>>>>>>>>>>>>> INFORMACION contacto_emergencia <<<<<<<<<<<<<<<<<<<<<<<<--- 

$('#form_2_contacto_emergencia_resultados').on('click', '#btn_info', function (e) {

  fun_info_contacto_emergencia_conductor($(this).attr('btn-id'));
  e.preventDefault();
  return false;
});

function fun_info_contacto_emergencia_conductor(_id_contacto_emergencia_conductor) {
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
          '/clientes/administrador/conductores/agregar/modelo/contacto_emergencia/buscar_informacion_contacto_emergencia.php',
        type: 'POST',
        data: {
          id_contacto_emergencia_conductor: _id_contacto_emergencia_conductor,
        },
        headers: {
          'csrf-token': $('meta[name="csrf-token"]').attr('content'),
        },
        dataType: 'json',
        timeout: 35000,
      })
        .done(function (response) {
          if (response.status === 'bien') {
            self.setTitle('Detalles de Emergencia del Conductor');
            self.setContent(asignar_datos_contacto_emergencia_conductor(response.message[0]));
            // self.close();
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();

            call_recuperar_session(function (k) {
              fun_info_contacto_emergencia_conductor(_id_eps_conductor);
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

function asignar_datos_contacto_emergencia_conductor(_response) {

  console.log(_response);

  let inner_html = `<div class="row gtr-50 gtr-uniform">
  <div class="col-12 align-center"> 
  <i class="fas fas fa-folder-plus fa-3x"></i>
  </div>
  <div class="col-12"><hr class="hr-text" data-content="Información de emergencia">
  </div><div class="col-3 col-12-small align-center"><label class="label-datos"> Nombre de contacto </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.nombre}</label>
  </div><div class="col-3 col-12-small align-center"><label class="label-datos"> Telefono de contacto </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.telefono}</label>
  </div><div class="col-3 col-12-small align-center"><label class="label-datos"> parentesco de contacto</label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.parentesco}</label>
  </div>`;

  inner_html += `</div>`;

  return inner_html;
}


///// --->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> ELIMINAR (ACTUALIZAR ESTADO) <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<---


$('#form_2_contacto_emergencia_resultados').on(
  'click',
  '#btn_delete',
  function (e) {
    let $temp_id_contacto_emergencia_conductor = $(this).attr('btn-id');
    $.confirm({
      title: 'Alerta',
      content:
        '<center>' +
        'Esta por <b>eliminar</b> un contacto de emergencia del conductor ' +
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
            fun_info_contacto_emergencia_conductor_eliminar($temp_id_contacto_emergencia_conductor);
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

function fun_info_contacto_emergencia_conductor_eliminar(_id_contacto_emergencia_conductor) {

  let contacto_emergencia_status = false;

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
          '/clientes/administrador/conductores/agregar/modelo/contacto_emergencia/eliminar_contacto_emergencia_conductor.php',
        type: 'POST',
        data: {
          id_contacto_emergencia_conductor: _id_contacto_emergencia_conductor,
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
            contacto_emergencia_status = true;
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();

            call_recuperar_session(function (k) { 
              fun_info_contacto_emergencia_conductor_eliminar(_id_contacto_emergencia_conductor);
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
      if (contacto_emergencia_status == true) {
        accordion_busqueda(2, false);
        $('html, body').animate(
          { scrollTop: $('#form_2_contacto_emergencia_resultados').offset().top - 150 },
          500
        );
      }
    },
    buttons: {
      aceptar: function () { },
    },
  });
}



