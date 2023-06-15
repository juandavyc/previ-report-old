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
          '/modulos/siniestros/visor/modelo/buscador_informacion.php',
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
            self.setTitle('Informacion del Siniestro');
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

export function fun_link(_id_siniestro) {
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
            '/modulos/siniestros/detalles/index.php?id=' +
            _id_siniestro;
        },
      },
      otra: {
        text: 'Otra pestaña',
        action: function () {
          window.open(
            PROTOCOL_HOST +
            '/modulos/siniestros/detalles/index.php?id=' +
            _id_siniestro
          );
        },
      },
    },
  });
}

export function fun_link_pdf(_id_siniestro) {


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
            '/pdfs/SINIESTRO_PDF.php?id_siniestro=' +
            _id_siniestro +
            '&sin=true';
        },
      },
      otra: {
        text: 'Otra pestaña',
        action: function () {
          window.window.open(
            PROTOCOL_HOST +
            '/pdfs/SINIESTRO_PDF.php?id_siniestro=' +
            _id_siniestro +
            '&sin=true'
          );
        },
      },
    },
  });
}

function fun_asignar_datos(_response) {
  // console.log(_response.implicados_siniestro);
  let response = `
  <div class="row">
  <div class="col-12 align-center"> 
  <i class="fas fas fa-car fa-3x"></i></div><div class="col-12"><hr class="hr-text" data-content="Información">
  </div><div class="col-3 col-12-small"><label class="label-datos "> Tipo Siniestro </label>
  </div><div class="col-9 col-12-small"><label class="label-resultados">${_response.tipo_siniestro
    }</label>
  </div><div class="col-3 col-12-small"><label  class="label-datos"> Fecha Siniestro </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.fecha
    }</label>
  </div><div class="col-3 col-12-small"><label  class="label-datos"> Hora Siniestro </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.hora
    }</label>
  </div><div class="col-3 col-12-small"><label  class="label-datos"> ciudad </label>
  </div><div class="col-9 col-12-small"><label class="label-resultados">${_response.ciudad
    }</label>
  </div><div class="col-3 col-12-small"><label  class="label-datos"> Heridos </label>  
  </div><div class="col-9 col-12-small"><label class="label-resultados">${(_response.heridos =
      2 ? 'Sin heridos' : 'Con heridos')}</label> 
  </div><div class="col-3 col-12-small"><label  class="label-datos"> Muertos </label>  
  </div><div class="col-3 col-12-small"><label class="label-resultados">${(_response.muertos =
      2 ? 'Sin Fallecidos' : 'Con Fallecidos')}</label> 
  </div><div class="col-3 col-12-small"><label  class="label-datos"> Implicados </label>  
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.implicados_siniestro > 1 ? 'Sin Implicados' : `Con Implicados`
    }</label> 
  </div><div class="col-12"><hr class="hr-text" data-content="Fotografías Siniestro"></div>
  <div class="col-3 col-6-xsmall align-center"><span class="image fit"><img src="${_response.foto_1
    }"></span><label>Foto 1</label></div>
  <div class="col-3 col-6-xsmall align-center"><span class="image fit"><img src="${_response.foto_2
    }"></span><label>Foto 2</label></div>
  <div class="col-3 col-6-xsmall align-center"><span class="image fit"><img src="${_response.foto_3
    }"></span><label>Foto 3</label></div>
  <div class="col-3 col-6-xsmall align-center"><span class="image fit"><img src="${_response.foto_4
    }"></span><label>Foto 4</label></div>
  </div>`;

  return response;
}
// $( "#tab-login" ).tabs( { disabled: [1] } );
