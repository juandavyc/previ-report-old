let $tabs = $('#tab-visor');
$tabs.responsiveTabs({
  rotate: false,
  startCollapsed: 'accordion',
  collapsible: 'accordion',
  // setHash: true,
  // animation: 'slide',
  active: 0,
});

export function fun_link(_id_conductor) {
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
            '/clientes/supervisor/conductores/agregar/index.php?id=' +
            _id_conductor;
        },
      },
      otra: {
        text: 'Otra pestaña',
        action: function () {
          window.open(
            PROTOCOL_HOST +
              '/clientes/supervisor/vehiculos/agregar/index.php?id=' +
              _id_conductor
          );
        },
      },
    },
  });
}

export function fun_info(_id_conductor) {
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
          '/clientes/supervisor/conductores/visor/modelo/buscar_informacion_basica_btn.php',
        type: 'POST',
        data: {
          id_conductor: _id_conductor,
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
            self.setTitle('Informacion del Conductor');
            self.setContent(asignar_datos_conductor(response.message[0]));
            // self.close();
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();

            call_recuperar_session(function (k) {
              fun_info_conductor(_id_conductor);
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

function asignar_datos_conductor(_response) {
  console.log(_response);

  let inner_html = `
  <div class="row">
    <div class="col-12 align-center"> 
      <i class="fas fa-camera-retro fa-3x"></i>
    <hr class="hr-text" data-content="Foto del conductor">
    </div>
    <div class="col-4 col-12-small"></div>
    <div class="col-4 col-12-small">
      <a href="${PROTOCOL_HOST}${_response.foto_conductor}" target="_blank">
        <span class="image fit">
          <img src="${PROTOCOL_HOST}${_response.foto_conductor}" class="dialog-image" alt="fotografia_del_certificado">
        </span>
      </a>
    </div>
    <div class="col-4 col-12-small"></div>
    <div class="col-12 align-center"> 
      <hr class="hr-text" data-content="Información Básica del conductor">
    </div>
    <div class="col-3 col-12-small"><label class="label-datos"> Documento de identidad </label></div>
    <div class="col-9 col-12-small"><label class="label-resultados">
    ${_response.nombre_tipo_identificacion} - ${_response.numero_documento}</label>
    </div>
    <div class="col-3 col-12-small"><label class="label-datos"> Nombre Completo </label></div>
    <div class="col-9 col-12-small"><label class="label-resultados">${_response.nombre_conductor}</label></div>
    <div class="col-3 col-12-small"><label class="label-datos"> Telefono </label></div>
    <div class="col-3 col-12-small">
      <label class="label-resultados">
      ${_response.telefono_conductor}
      </label>
    </div>
    <div class="col-3 col-12-small"><label class="label-datos"> Celular </label></div>
    <div class="col-3 col-12-small">
      <label class="label-resultados">
        ${_response.celular_conductor}
      </label>
    </div>
    <div class="col-3 col-12-small"><label class="label-datos"> Correo electrónico </label></div>
    <div class="col-3 col-12-small">
      <label class="label-resultados">
        ${_response.correo_conductor}
      </label>
    </div>
    <div class="col-3 col-12-small"><label class="label-datos"> Tipo de sangre (RH) </label></div>
    <div class="col-3 col-12-small">
      <label class="label-resultados">
        ${_response.nombre_tipo_sangre}
      </label>
    </div> 
    <div class="col-12 align-center"> 
      <hr class="hr-text" data-content="Contacto de emergencia (El más reciente)">
    </div>
    <div class="col-3 col-12-small"><label class="label-datos"> Nombre </label></div>
    <div class="col-9 col-12-small">
      <label class="label-resultados">
        ${_response.nombre_contacto_de_emergencia_conductor}
      </label>
    </div> 
    <div class="col-3 col-12-small"><label class="label-datos"> Telefono </label></div>
    <div class="col-3 col-12-small">
      <label class="label-resultados">
        ${_response.telefono_contacto_de_emergencia_conductor}
      </label>
    </div> 
    <div class="col-3 col-12-small"><label class="label-datos"> Parentesco </label></div>
    <div class="col-3 col-12-small">
      <label class="label-resultados">
        ${_response.parentesco_contacto_de_emergencia_conductor}
      </label>
    </div> 
    <div class="col-12 align-center"> 
      <hr class="hr-text" data-content="Vehículo asignado (El más reciente)">
    </div>
    <div class="col-3 col-12-small"><label class="label-datos"> Placa </label></div>
    <div class="col-9 col-12-small">
      <label class="label-resultados">
        ${_response.placa_vehiculo}
      </label>
    </div> 
  </div>
  `;

  return inner_html;
}
