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
          '/clientes/supervisor/mantenimientos-super/visor/modelo/informacion_mantenimiento.php',
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
            self.setTitle('Informacion del Mantenimiento');
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
            '/clientes/supervisor/mantenimientos-taller/agregar/index.php?id=' +
            _id_elemento;
        },
      },
      otra: {
        text: 'Otra pestaña',
        action: function () {
          window.open(
            PROTOCOL_HOST +
              '/clientes/supervisor/mantenimientos-taller/agregar/index.php?id=' +
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
          '/pdfs/MANTENIMIENTO_PDF.php?id_mantenimiento=' + _id_elemento +'&mant=true'
          );
        },
      },
    },
  });
}

function fun_asignar_datos(_response) {
  console.log(_response);
  let response = `
  <div class="row">
  <div class="col-12 align-center"> 
  <i class="fas fas fa-car fa-3x"></i></div><div class="col-12"><hr class="hr-text" data-content="Información"> 

  </div><div class="col-3 col-12-small"><label  class="label-datos"> Placa </label>  
  </div><div class="col-9 col-12-small"><label class="label-resultados"> ${
    _response.placa
  }</label> 
  </div><div class="col-3 col-12-small"><label  class="label-datos"> Orden </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${(_response.orden =
    2 ? 'SI' : 'NO')}</label>    
  </div><div class="col-3 col-12-small"><label  class="label-datos"> Numero orden </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${
    _response.numero_orden
  }</label>
  </div><div class="col-3 col-12-small"><label  class="label-datos"> Tipo de Mantenimiento </label>
  </div><div class="col-9 col-12-small"><label class="label-resultados">${
    _response.nombre_tipo
  }</label>
  </div><div class="col-3 col-12-small"><label  class="label-datos"> Fecha mantenimiento </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${
    _response.fecha_mantenimiento
  }</label>
  </div><div class="col-3 col-12-small"><label  class="label-datos"> Precio Mano de Obra </label>  
  </div><div class="col-3 col-12-small"><label class="label-resultados">$ ${formatMoney(
    _response.precio_mano_de_obra
  )}</label> 
  </div><div class="col-3 col-12-small"><label  class="label-datos"> Cantidad de Repuestos </label>  
  </div><div class="col-3 col-12-small"><label class="label-resultados"> ${
    _response.cantidad_respuestos
  }</label> 
  </div><div class="col-3 col-12-small"><label  class="label-datos"> Precio de Repuestos </label>  
  </div><div class="col-3 col-12-small"><label class="label-resultados">$ ${formatMoney(
    _response.precio_repuestos
  )}</label> 
  </div><div class="col-3 col-12-small"><label  class="label-datos"> Fecha de inicio </label>  
  </div><div class="col-3 col-12-small"><label class="label-resultados"> ${
    _response.fecha_inicio
  }</label> 
  </div><div class="col-3 col-12-small"><label  class="label-datos"> Fecha Finalizado </label>  
  </div><div class="col-3 col-12-small"><label class="label-resultados"> ${
    _response.fecha_fin
  }</label> 
  </div><div class="col-3 col-12-small"><label  class="label-datos"> Autoriza </label>  
  </div><div class="col-9 col-12-small"><label class="label-resultados"> ${
    _response.nombre_autoriza
  }</label> 
  </div><div class="col-3 col-12-small"><label  class="label-datos"> Mecanico </label>  
  </div><div class="col-9 col-12-small"><label class="label-resultados"> ${
    _response.nombre_mecanico
  }</label> 
  </div><div class="col-3 col-12-small"><label  class="label-datos"> Taller </label>  
  </div><div class="col-9 col-12-small"><label class="label-resultados"> ${
    _response.nombre_taller + ' - ' + _response.nit_taller
  }</label> 
  </div><div class="col-12"><hr class="hr-text" data-content="Firmas"></div>
  <div class="col-2 col-12-small"></div>
  <div class="col-4 col-12-small align-center">
  <span class="image fit">
  <img src="${_response.firma_supervisor}">
  </span><label>Autoriza</label>
  </div>
  <div class="col-4 col-12-small align-center">
  <span class="image fit">
  <img src="${_response.firma_mecanico}">
  </span><label>Mecanico</label>
  </div>
  <div class="col-2 col-12-small"></div>
  </div>`;

  return response;
}
// $( "#tab-login" ).tabs( { disabled: [1] } );
