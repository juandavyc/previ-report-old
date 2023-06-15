const $tabs = $('#tab-visor');
$tabs.responsiveTabs({
  rotate: false,
  startCollapsed: 'accordion',
  collapsible: 'accordion',
  setHash: false,
});
$tabs.responsiveTabs('activate', 0);
// $( "#tab-login" ).tabs( { disabled: [1] } );

export function fun_info_vehiculo(_id_vehiculo) {
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
          '/clientes/administrador/vehiculos/visor/modelo/buscar_informacion_basica_btn.php',
        type: 'POST',
        data: {
          id_vehiculo: _id_vehiculo,
        },
        headers: {
          'csrf-token': $('meta[name="csrf-token"]').attr('content'),
        },
        dataType: 'json',
        timeout: 35000,
      })
        .done(function (response) {
          if (response.status === 'bien') {
            self.setTitle('Informacion del vehiculo');
            self.setContent(asignar_datos_vehiculo(response.message[0]));
            // self.close();
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();

            call_recuperar_session(function (k) {
              fun_info_vehiculo(_id_vehiculo);
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

export function fun_pdf_vehiculo(_id_vehiculo) {
  $.confirm({
    title: 'Alerta',
    content:
      '<center> Clickee el contenido de PDF que desea visualizar </center> ',
    typeAnimated: true,
    scrollToPreviousElement: false,
    scrollToPreviousElementAnimate: false,
    columnClass: 'xsmall',
    closeIcon: true,
    buttons: {
      vehiculo: {
        text: 'VEHICULAR',
        action: function () {
          window.open(
            PROTOCOL_HOST +
              '/pdfs/hoja_vehicular.php?id_vehiculo=' +
              _id_vehiculo +
              '&info=true'
          );
        },
      },
      hdv: {
        text: 'Hoja de vida',
        action: function () {
          window.open(
            PROTOCOL_HOST +
              '/pdfs/hoja_vehicular.php?id_vehiculo=' +
              _id_vehiculo +
              '&all=true'
          );
        },
      },
    },
  });
}

export function fun_link_vehiculo(_id_vehiculo) {
  $.confirm({
    title: 'Alerta',
    content: '<center>¿ Desea visualizar este contenido en ?</center> ',
    typeAnimated: true,
    scrollToPreviousElement: false,
    scrollToPreviousElementAnimate: false,
    columnClass: 'xsmall',
    closeIcon: true,
    buttons: {
      esta: {
        text: 'Esta pestaña',
        action: function () {
          window.location.href =
            PROTOCOL_HOST +
            '/clientes/administrador/vehiculos/agregar/index.php?id=' +
            _id_vehiculo;
        },
      },
      otra: {
        text: 'Otra pestaña',
        action: function () {
          window.open(
            PROTOCOL_HOST +
              '/clientes/administrador/vehiculos/agregar/index.php?id=' +
              _id_vehiculo
          );
        },
      },
    },
  });
}

function asignar_datos_vehiculo(_response) {
  let response = `
  <div class="row">
  <div class="col-12 align-center"> 
  <i class="fas fas fa-car fa-3x"></i></div><div class="col-12"><hr class="hr-text" data-content="Información básica del vehiculo">
  </div><div class="col-3 col-12-small"><label class="label-datos "> PLACA VEHICULO </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.placa}</label>
  </div><div class="col-3 col-12-small"><label  class="label-datos"> TIPO VEHICULO </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados" >${_response.tipo}</label>
  </div><div class="col-3 col-12-small"><label  class="label-datos"> CLASE </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados" >${_response.clase}</label>
  </div><div class="col-3 col-12-small"><label  class="label-datos"> SERVICIO </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados" >${_response.servicio}</label>
  </div><div class="col-3 col-12-small"><label  class="label-datos"> MARCA </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados" >${_response.marca}</label>
  </div><div class="col-3 col-12-small"><label  class="label-datos"> LINEA </label>  
  </div><div class="col-3 col-12-small"><label class="label-resultados" >${_response.linea}</label>
  </div><div class="col-3 col-12-small"><label  class="label-datos"> MODELO </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados" >${_response.modelo}</label>
  </div><div class="col-3 col-12-small"><label  class="label-datos"> COLOR </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados" >${_response.color}</label>
  </div><div class="col-3 col-12-small"><label  class="label-datos"> KILOMETRAJE </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados" >${_response.kilometraje}</label>
  </div><div class="col-3 col-12-small"><label  class="label-datos"> COMBUSTIBLE </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados" >${_response.combustible}</label>
  </div><div class="col-3 col-12-small"><label  class="label-datos"> EMPRESA </label>
  </div><div class="col-9 col-12-small"><label class="label-resultados" >${_response.nombre_empresa}</label>
  </div> <div class="col-12"><hr class="hr-text" data-content="Fotografías vehículo"></div>
  <div class="col-3 col-6-xsmall"><span class="image fit"><img src="${_response.foto_delantera}"></span><label>Delantera</label></div>
  <div class="col-3 col-6-xsmall"><span class="image fit"><img src="${_response.foto_costado_izquierdo}"></span><label>C. Izquierdo</label></div>
  <div class="col-3 col-6-xsmall"><span class="image fit"><img src="${_response.foto_trasera}"></span><label>Trasera</label></div>
  <div class="col-3 col-6-xsmall"><span class="image fit"><img src="${_response.foto_costado_derecho}"></span><label>C. Derecho</label></div>
  </div>`;

  return response;
}
