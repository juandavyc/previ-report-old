const $tabs = $('#tab-visor');
$tabs.responsiveTabs({
  rotate: false,
  startCollapsed: 'accordion',
  collapsible: 'accordion',
  setHash: false,
});
$tabs.responsiveTabs('activate', 0);

export function fun_info_taller(_id_elemento) {
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
          '/modulos/talleres/visor/modelo/buscador_informacion.php',
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
            self.setTitle('Informacion del Taller');
            self.setContent(fun_asignar_datos(response.message[0]));
            // self.close();
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();

            call_recuperar_session(function (k) {
              fun_info_taller(_id_elemento);
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

export function fun_link_taller(_id_taller) {
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
            '/modulos/talleres/detalles/index.php?id=' +
            _id_taller;
        },
      },
      otra: {
        text: 'Otra pestaña',
        action: function () {
          window.open(
            PROTOCOL_HOST +
            '/modulos/talleres/detalles/index.php?id=' +
            _id_taller
          );
        },
      },
    },
  });
}

function fun_asignar_datos(_response) {
  let response = `
  <div class="row">
  <div class="col-12 align-center"> 
  <i class="fas fas fa-industry fa-3x"></i></div><div class="col-12"><hr class="hr-text" data-content="Información">
  </div><div class="col-3 col-12-small"><label class="label-datos "> NIT </label>
  </div><div class="col-9 col-12-small"><label class="label-resultados">${_response.nit}</label>
  </div><div class="col-3 col-12-small"><label  class="label-datos"> NOMBRE </label>
  </div><div class="col-9 col-12-small"><label class="label-resultados">${_response.nombre}</label>
  </div><div class="col-3 col-12-small"><label  class="label-datos"> TELEFONO </label>
  </div><div class="col-9 col-12-small"><label class="label-resultados">${_response.telefono}</label>
  </div><div class="col-3 col-12-small"><label  class="label-datos"> DIRECCION </label>
  </div><div class="col-9 col-12-small"><label class="label-resultados">${_response.direccion}</label>
  </div><div class="col-3 col-12-small"><label  class="label-datos"> DEPARTAMENTO </label>  
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.departamento}</label> 
  </div><div class="col-3 col-12-small"><label  class="label-datos"> CIUDAD </label>  
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.ciudad}</label> 
  </div><div class="col-12 align-center"><hr class="hr-text" data-content="Usuario Responsable">
  </div><div class="col-3 col-12-small"><label  class="label-datos"> NOMBRE </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.usuario}</label>
  </div><div class="col-3 col-12-small"><label  class="label-datos"> FECHA </label>  
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.fecha}</label>
  </div>
  </div>`;

  return response;
}
// $( "#tab-login" ).tabs( { disabled: [1] } );
