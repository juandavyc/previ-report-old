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
          '/clientes/administrador/preoperacional-super/visor/modelo/informacion_preoperacional.php',
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
          console.log(response);
          if (response.status === 'bien') {
            self.setTitle('Informacion Preoperacional');
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
      aceptar: function () {},
    },
  });
}

export function fun_link(_id_elemento) {
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
            '/clientes/administrador/preoperacional/agregar/index.php?id=' +
            _id_elemento;
        },
      },
      otra: {
        text: 'Otra pestaña',
        action: function () {
          window.open(
            PROTOCOL_HOST +
              '/clientes/administrador/preoperacional/agregar/index.php?id=' +
              _id_elemento
          );
        },
      },
    },
  });
}

export function fun_link_pdf(_id_elemento) {
  $.confirm({
    title: 'Alerta',
    content: '<center>¿ Desea visualizar este contenido ?</center> ',
    typeAnimated: true,
    scrollToPreviousElement: false,
    scrollToPreviousElementAnimate: false,
    columnClass: 'xsmall',
    closeIcon: true,
    buttons: {
      vehiculo: {
        text: 'ACEPTAR',
        action: function () {
          window.open(PROTOCOL_HOST +
          '/pdfs/PREOPERACIONAL_PDF.php?id_preoperacional=' + _id_elemento +'&pre=true'
          );
        },
      },
    },
  });
}

function fun_asignar_datos(_response) {
  let is_vigente = ['-', 'SI', 'NO', 'NO APLICA'];
  console.log(_response);
  let response = `
  <div class="row">
  <div class="col-12 align-center"> 
  <i class="fas fa-paste fa-3x"></i></div><div class="col-12"><hr class="hr-text" data-content="Información"> 

  </div><div class="col-3 col-12-small"><label  class="label-datos"> Placa </label>  
  </div><div class="col-3 col-12-small"><label class="label-resultados"> ${
    _response.vehiculo.placa
  }</label> 
  </div><div class="col-3 col-12-small"><label  class="label-datos"> ESTADO </label>  
  </div><div class="col-3 col-12-small"><label class="label-resultados"> ${
    _response.estado.nombre
  }</label> 
  </div><div class="col-12"><hr class="hr-text-alt" data-content="Vigencia"> 
  </div><div class="col-3 col-12-small"><label  class="label-datos"> Tarjeta de propiedad </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${
    is_vigente[_response.vigente.tarjeta]
  }</label>    
  </div><div class="col-3 col-12-small"><label  class="label-datos"> REVISIÓN TECNICOMECÁNICA </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${
    is_vigente[_response.vigente.tarjeta]
  }</label>
  </div><div class="col-3 col-12-small"><label  class="label-datos"> CERTIFICADO GASES </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${
    is_vigente[_response.vigente.gases]
  }</label>
  </div><div class="col-3 col-12-small"><label  class="label-datos"> PLANILLA DE VIAJE (FUEC)  </label>  
  </div><div class="col-3 col-12-small"><label class="label-resultados"> ${
    is_vigente[_response.vigente.fuec]
  }</label> 
  </div><div class="col-3 col-12-small"><label  class="label-datos"> LICENCIA DE CONDUCCIÓN </label>  
  </div><div class="col-3 col-12-small"><label class="label-resultados"> ${
    is_vigente[_response.vigente.licencia]
  }</label> 
  </div><div class="col-3 col-12-small"><label  class="label-datos"> LICENCIA DE CONDUCCIÓN </label>  
  </div><div class="col-3 col-12-small"><label class="label-resultados"> ${
    is_vigente[_response.vigente.licencia]
  }</label> 
  </div><div class="col-3 col-12-small"><label  class="label-datos"> POLIZAS</label>  
  </div><div class="col-3 col-12-small"><label class="label-resultados"> ${
    is_vigente[_response.vigente.poliza]
  }</label> 
  </div><div class="col-3 col-12-small"><label  class="label-datos"> POLIZA SOAT</label>  
  </div><div class="col-3 col-12-small"><label class="label-resultados"> ${
    is_vigente[_response.vigente.soat]
  }</label> 
  </div><div class="col-12"><hr class="hr-text-alt" data-content="Usuarios"> 
  </div><div class="col-3 col-12-small"><label  class="label-datos"> Autoriza </label>  
  </div><div class="col-9 col-12-small"><label class="label-resultados"> ${
    _response.autoriza.nombre
  }</label> 
  </div><div class="col-3 col-12-small"><label  class="label-datos"> Realiza </label>  
  </div><div class="col-9 col-12-small"><label class="label-resultados"> ${
    _response.realiza.nombre
  }</label> 
  </div><div class="col-3 col-12-small"><label  class="label-datos"> Fecha y Hora </label>  
  </div><div class="col-9 col-12-small"><label class="label-resultados"> ${
    _response.fecha
  }</label>
  
  </div><div class="col-12"><hr class="hr-text-alt" data-content="Firmas"> </div>
  <div class="col-2 col-12-small"></div>
  <div class="col-4 col-12-small align-center">
  <span class="image fit">
  <img src="${_response.autoriza.firma}">
  </span><label>Autoriza</label>
  </div>
  <div class="col-4 col-12-small align-center">
  <span class="image fit">
  <img src="${_response.realiza.firma}">
  </span><label>Mecanico</label>
  </div>
  <div class="col-2 col-12-small"></div>
  </div>`;

  return response;
}
// $( "#tab-login" ).tabs( { disabled: [1] } );
