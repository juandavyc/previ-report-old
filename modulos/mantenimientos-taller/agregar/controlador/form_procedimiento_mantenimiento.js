
const const_id_mantenimiento = $('meta[name="csrf-id"]').attr('content');

let accordion_busqueda = null;
export function fun_procedimiento_mantenimiento_accordion(_funtion_name, _function_vehiculo) {
  accordion_busqueda = _funtion_name;
}

import { firma_1 } from './accordion.js';

$('#form_2_informacion_procedimiento_mantenimientos').on('submit', function (e) {

  fun_form_mantenimiento_conductor_accordion();
  e.preventDefault();
  return false;
});

function fun_form_mantenimiento_conductor_accordion() {


  let fun_form_1_status = false;

  if (firma_1.get_status == false) {
    $.alert("Falta la firma del usuario.");
  }
  else {
   let formdata = new FormData($('#form_2_informacion_procedimiento_mantenimientos')[0])
    formdata.append("id_mantenimiento",const_id_mantenimiento);
    formdata.append("form_1_canvas",firma_1.get_blob);
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
            '/modulos/mantenimientos-taller/agregar/modelo/procedimiento_mantenimiento/guardar.php',
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
              $('#form_2_informacion_procedimiento_mantenimientos').trigger("reset");
              firma_1.set_default();
            } else if (
              response.status === 'csrf' ||
              response.status === 'session'
            ) {
              self.close();
              call_recuperar_session(function (k) {
                fun_form_mantenimiento_conductor_accordion();
              });
            } else if (response.status === 'mal') {
              self.setTitle(response.status);
              self.setContent(response.message);

            } else {
              self.setTitle(response.status);
              self.setContent(response.message);
              $('#form_2_informacion_procedimiento_mantenimientos').trigger("reset");
            }
          })
          .fail(function (response) {
            console.log(response);
            self.setTitle('Error -> ');
            self.setContent(response.responseText);
          });
      },
      buttons: {
        aceptar: function () { },
      },
    });
  }
}





//// --->>>>>>>>>>>>>>>>> INFORMACION vehiculo <<<<<<<<<<<<<<<<<<<<<<<<--- 

$('#form_12_vehiculo_conductor_resultados').on('click', '#btn_info', function (e) {

  fun_info_vehiculo_conductor($(this).attr('btn-id'));
  e.preventDefault();
  return false;
});

function fun_info_vehiculo_conductor(_id_vehiculo_conductor) {
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
          '/modulos/conductores/agregar/modelo/vehiculo_conductor/buscar.php',
        type: 'POST',
        data: {
          id_vehiculo_conductor: _id_vehiculo_conductor,
        },
        headers: {
          'csrf-token': $('meta[name="csrf-token"]').attr('content'),
        },
        dataType: 'json',
        timeout: 35000,
      })
        .done(function (response) {
          if (response.status === 'bien') {
            self.setTitle('Detalles Vehiculo asignado Conductor');
            self.setContent(asignar_datos_vehiculo_conductor(response.message[0]));
            // self.close();
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();

            call_recuperar_session(function (k) {
              fun_info_vehiculo_conductor(_id_vehiculo_conductor);
            });
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
    },
    buttons: {
      aceptar: function () { },
    },
  });
}

function asignar_datos_vehiculo_conductor(_response) {
  // let json_array = (JSON.parse(_response));
  let response = `
  <div class="row">
  <div class="col-12 align-center"> 
  <i class="fas fas fa-car fa-3x"></i></div><div class="col-12"><hr class="hr-text" data-content="Información básica del vehiculo">
  </div><div class="col-3 col-12-small align-center"><label class="label-datos "> PLACA VEHICULO </label>
  </div><div class="col-3 col-12-small align-center"><label class="label-resultados" id="placa_vehiculo">${_response.placa_vehiculo}</label>
  </div><div class="col-3 col-12-small align-center"><label  class="label-datos"> TIPO VEHICULO </label>
  </div><div class="col-3 col-12-small align-center"><label class="label-resultados" id="clase_vehiculo">${_response.nombre_tipo_vehiculo}</label>
  </div><div class="col-3 col-12-small align-center"><label  class="label-datos"> SERVICIO </label>
  </div><div class="col-3 col-12-small align-center"><label class="label-resultados" id="marca_vehiculo">${_response.nombre_servicio}</label>
  </div><div class="col-3 col-12-small align-center"><label  class="label-datos"> MARCA </label>
  </div><div class="col-3 col-12-small align-center"><label class="label-resultados" id="marca_vehiculo">${_response.nombre_marca}</label>
  </div><div class="col-3 col-12-small align-center"><label  class="label-datos"> LINEA </label>  
  </div><div class="col-3 col-12-small align-center"><label class="label-resultados" id="marca_vehiculo">${_response.nombre_linea}</label>
  </div><div class="col-3 col-12-small align-center"><label  class="label-datos"> MODELO </label>
  </div><div class="col-3 col-12-small align-center"><label class="label-resultados" id="marca_vehiculo">${_response.modelo_vehiculo}</label>
  </div><div class="col-3 col-12-small align-center"><label  class="label-datos"> COLOR </label>
  </div><div class="col-3 col-12-small align-center"><label class="label-resultados" id="marca_vehiculo">${_response.nombre_color}</label>
  </div><div class="col-3 col-12-small align-center"><label  class="label-datos"> KILOMETRAJE </label>
  </div><div class="col-3 col-12-small align-center"><label class="label-resultados" id="marca_vehiculo">${_response.kilometraje_vehiculo}</label>
  </div><div class="col-3 col-12-small align-center"><label  class="label-datos"> COMBUSTIBLE </label>
  </div><div class="col-3 col-12-small align-center"><label class="label-resultados" id="marca_vehiculo">${_response.nombre_combustible}</label>
  </div> <div class="col-12"><hr class="hr-text" data-content="Fotografías vehículo"></div>
  <div class="col-3 col-6-xsmall align-center"><span class="image fit"><img src="${_response.foto_delantera}"></span><label>Delantera</label></div>
  <div class="col-3 col-6-xsmall align-center"><span class="image fit"><img src="${_response.foto_costado_izquierdo}"></span><label>C. Izquierdo</label></div>
  <div class="col-3 col-6-xsmall align-center"><span class="image fit"><img src="${_response.foto_trasera}"></span><label>Trasera</label></div>
  <div class="col-3 col-6-xsmall align-center"><span class="image fit"><img src="${_response.foto_costado_derecho}"></span><label>C. Derecho</label></div>
  </div>`;


  return response;
}


///// --->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> ELIMINAR (ACTUALIZAR ESTADO) <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<---


$('#form_12_vehiculo_conductor_resultados').on(
  'click',
  '#btn_delete',
  function (e) {
    let $temp_id_vehiculo_conductor = $(this).attr('btn-id');
    $.confirm({
      title: 'Alerta',
      content:
        '<center>' +
        'Esta por <b>eliminar</b> un certificado vehiculo del conductor ' +
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
            fun_info_vehiculo_conductor_eliminar($temp_id_vehiculo_conductor);
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

/*
$('body').delegate('#form_3_dialog_input', 'click', function() {
input_autocomplete_no_save("#form_3_dialog_input","#form_3_dialog_select","marcas/modelo/buscar_marcas.php");
});*/


function fun_info_vehiculo_conductor_eliminar(_id_vehiculo_conductor) {

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
          '/modulos/conductores/agregar/modelo/vehiculo_conductor/eliminar.php',
        type: 'POST',
        data: {
          id_vehiculo_conductor: _id_vehiculo_conductor,
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
              fun_info_vehiculo_conductor_eliminar(_id_vehiculo_conductor);
            });
          } else if (response.status === 'sin_resultados') {
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
      if (vehiculo_status == true) {
        accordion_busqueda(12, false);
        $('html, body').animate(
          { scrollTop: $('#form_12_vehiculo_conductor_resultados').offset().top - 150 },
          500
        );
      }
    },
    buttons: {
      aceptar: function () { },
    },
  });
}

