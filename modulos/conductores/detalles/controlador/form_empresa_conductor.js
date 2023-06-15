const const_id_vehiculo = $('meta[name="csrf-id"]').attr('content');

let accordion_busqueda = null;
let accordion_empresa = null;
export function fun_empresa_conductor_accordion(
  _funtion_name,
  _function_empresa
) {
  accordion_busqueda = _funtion_name;
  accordion_empresa = _function_empresa;
}
$('.btn-crear-empresa').on('click', function (e) {
  accordion_empresa();
  e.preventDefault();
  return false;
});

$('#form_13_empresa_conductor').on('submit', function (e) {
  fun_form_empresa_conductor_accordion();
  e.preventDefault();
  return false;
});

function fun_form_empresa_conductor_accordion() {
  let status_accordion = false;

  let formdata = new FormData($('#form_13_empresa_conductor')[0]);
  formdata.append('id_conductor', const_id_vehiculo);

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
          '/modulos/conductores/detalles/modelo/empresa_conductor/guardar.php',
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
            $('#form_13_empresa_conductor').trigger('reset');
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();
            call_recuperar_session(function (k) {
              fun_form_empresa_conductor_accordion();
            });
          } else if (response.status === 'mal') {
            self.setTitle(response.status);
            self.setContent(response.message);
            $('#form_13_empresa_conductor').trigger('reset');
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
        accordion_busqueda(13, false);
        $('html, body').animate(
          {
            scrollTop:
              $('#form_13_empresa_conductor_resultados').offset().top - 150,
          },
          500
        );
      }
    },
    buttons: {
      aceptar: function () {},
    },
  });
}

//// --->>>>>>>>>>>>>>>>> INFORMACION vehiculo <<<<<<<<<<<<<<<<<<<<<<<<---

$('#form_13_empresa_conductor_resultados').on(
  'click',
  '#btn_info',
  function (e) {
    fun_info_empresa_conductor($(this).attr('btn-id'));
    e.preventDefault();
    return false;
  }
);

function fun_info_empresa_conductor(_id_empresa_conductor) {
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
          '/modulos/conductores/detalles/modelo/empresa_conductor/buscar.php',
        type: 'POST',
        data: {
          id_empresa_conductor: _id_empresa_conductor,
        },
        headers: {
          'csrf-token': $('meta[name="csrf-token"]').attr('content'),
        },
        dataType: 'json',
        timeout: 35000,
      })
        .done(function (response) {
          if (response.status === 'bien') {
            self.setTitle('Detalles de <b>Empresa<b>');
            self.setContent(
              asignar_datos_empresa_conductor(response.message[0])
            );
            // self.close();
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();

            call_recuperar_session(function (k) {
              fun_info_empresa_conductor(_id_empresa_conductor);
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

function asignar_datos_empresa_conductor(_response) {
  // let json_array = (JSON.parse(_response));
  let response = `
  <div class="row">
  <div class="col-12 align-center"> 
  <i class="fas fas fa-car fa-3x"></i></div><div class="col-12"><hr class="hr-text" data-content="Información básica de la Empresa">
  </div><div class="col-3 col-12-small align-center"><label class="label-datos "> FECHA ASIGNACION </label>
  </div><div class="col-3 col-12-small align-center"><label class="label-resultados" id="placa_vehiculo">${_response.fecha_asignacion}</label>
  </div><div class="col-3 col-12-small align-center"><label  class="label-datos"> USUARIO </label>
  </div><div class="col-3 col-12-small align-center"><label class="label-resultados" id="clase_vehiculo">${_response.nombre_usuario}</label>
  </div><div class="col-3 col-12-small align-center"><label  class="label-datos"> NIT EMPRESA </label>
  </div><div class="col-3 col-12-small align-center"><label class="label-resultados" id="marca_vehiculo">${_response.nit}</label>
  </div><div class="col-3 col-12-small align-center"><label  class="label-datos"> NOMBRE EMPRESA </label>
  </div><div class="col-3 col-12-small align-center"><label class="label-resultados" id="marca_vehiculo">${_response.nombre_empresa}</label>
  </div><div class="col-3 col-12-small align-center"><label  class="label-datos"> CONDUCTOR </label>  
  </div><div class="col-3 col-12-small align-center"><label class="label-resultados" id="marca_vehiculo">${_response.nombre_conductor}</label>
  </div><div class="col-3 col-12-small align-center"><label  class="label-datos"> TELEFONO EMPRESA </label>
  </div><div class="col-3 col-12-small align-center"><label class="label-resultados" id="marca_vehiculo">${_response.telefono}</label>
  </div>                                                      
  </div>`;

  return response;
}

///// --->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> ELIMINAR (ACTUALIZAR ESTADO) <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<---

$('#form_13_empresa_conductor_resultados').on(
  'click',
  '#btn_delete',
  function (e) {
    let $temp_id_empresa_conductor = $(this).attr('btn-id');
    $.confirm({
      title: 'Alerta',
      content:
        '<center>' +
        'Esta por <b>eliminar</b> una asignacion de Empresa del conductor ' +
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
            fun_info_empresa_conductor_eliminar($temp_id_empresa_conductor);
          },
        },
        no: {
          text: 'No',
          action: function () {},
        },
      },
    });
  }
);

/*
$('body').delegate('#form_3_dialog_input', 'click', function() {
input_autocomplete_no_save("#form_3_dialog_input","#form_3_dialog_select","marcas/modelo/buscar_marcas.php");
});*/

function fun_info_empresa_conductor_eliminar(_id_empresa_conductor) {
  let vehiculo_status = false;

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
          '/modulos/conductores/detalles/modelo/empresa_conductor/eliminar.php',
        type: 'POST',
        data: {
          id_empresa_conductor: _id_empresa_conductor,
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
            vehiculo_status = true;
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();

            call_recuperar_session(function (k) {
              fun_info_empresa_conductor_eliminar(_id_empresa_conductor);
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
    onClose: function () {
      if (vehiculo_status == true) {
        accordion_busqueda(13, false);
        $('html, body').animate(
          {
            scrollTop:
              $('#form_13_empresa_conductor_resultados').offset().top - 150,
          },
          500
        );
      }
    },
    buttons: {
      aceptar: function () {},
    },
  });
}
