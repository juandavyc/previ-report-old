const $tabs = $('#tab-visor');
$tabs.responsiveTabs({
  rotate: false,
  startCollapsed: 'accordion',
  collapsible: 'accordion',
  setHash: false,
});
$tabs.responsiveTabs('activate', 0);

export function fun_info(_id_elemento) {
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
          '/modulos/usuarios/visor/modelo/buscador_informacion.php',
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
            self.setTitle('Informacion del Usuario');
            self.setContent(fun_asignar_datos(response.message[0]));
            // self.close();
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();

            call_recuperar_session(function (k) {
              fun_info(_id_elemento);
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

export function fun_link(_id_empresa) {
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
            '/modulos/usuarios/detalles/index.php?id=' +
            _id_empresa;
        },
      },
      otra: {
        text: 'Otra pestaña',
        action: function () {
          window.open(
            PROTOCOL_HOST +
            '/modulos/usuarios/detalles/index.php?id=' +
            _id_empresa
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
  <i class="fas fas fa-user fa-3x"></i></div><div class="col-12"><hr class="hr-text" data-content="Información">
  </div><div class="col-3 col-12-small"><label class="label-datos "> Cedula </label>
  </div><div class="col-9 col-12-small"><label class="label-resultados">${_response.cedula}</label>
  </div><div class="col-3 col-12-small"><label  class="label-datos"> Nombre </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.nombre}</label>
  </div><div class="col-3 col-12-small"><label  class="label-datos"> Apellido </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.apellido}</label>
  </div><div class="col-3 col-12-small"><label  class="label-datos"> Telefono </label>
  </div><div class="col-9 col-12-small"><label class="label-resultados">${_response.telefono}</label>
  </div><div class="col-3 col-12-small"><label  class="label-datos"> Correo </label>  
  </div><div class="col-9 col-12-small"><label class="label-resultados">${_response.correo}</label> 
  </div><div class="col-3 col-12-small"><label  class="label-datos"> Rango </label>  
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.rango}</label> 
  </div><div class="col-3 col-12-small"><label  class="label-datos"> Estado cuenta </label>  
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.estado}</label> 
  </div><div class="col-12 align-center"><hr class="hr-text" data-content="Firma">
  </div><div class="col-4 col-12-small">
  </div><div class="col-4 col-12-small align-center"><span class="image fit"><img src="${_response.firma}"></span>  
  </div><div class="col-4 col-12-small">
  </div><div class="col-12 align-center"><hr class="hr-text" data-content="Empresa">
  </div><div class="col-3 col-12-small"><label  class="label-datos"> Nit </label>
  </div><div class="col-9 col-12-small"><label class="label-resultados">${_response.nit}</label>
  </div><div class="col-3 col-12-small"><label  class="label-datos"> Nombre </label>
  </div><div class="col-9 col-12-small"><label class="label-resultados">${_response.empresa}</label>
  </div><div class="col-12 align-center"><hr class="hr-text" data-content="Taller">
  </div><div class="col-3 col-12-small"><label  class="label-datos"> Taller </label>
  </div><div class="col-9 col-12-small"><label class="label-resultados">${_response.taller}</label>
  </div><div class="col-12 align-center"><hr class="hr-text" data-content="Usuario Responsable">
  </div><div class="col-3 col-12-small"><label  class="label-datos"> Usuario </label>    
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.usuario}</label>
  </div><div class="col-3 col-12-small"><label  class="label-datos"> Fecha </label>    
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.fecha}</label>
  </div>
  </div>`;

  return response;
}
// $( "#tab-login" ).tabs( { disabled: [1] } );
