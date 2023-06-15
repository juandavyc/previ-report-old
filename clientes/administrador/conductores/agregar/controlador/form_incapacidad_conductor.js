

const const_id_vehiculo = $('meta[name="csrf-id"]').attr('content');

let accordion_busqueda = null;
export function fun_incapacidad_conductor_accordion(_funtion_name) {
  accordion_busqueda = _funtion_name;
}

$('#form_11_incapacidad_conductor').on('submit', function (e) {

  fun_form_incapacidad_conductor_accordion();
  e.preventDefault();
  return false;
});

function fun_form_incapacidad_conductor_accordion() {

  let status_accordion = false;

  let formdata = new FormData($('#form_11_incapacidad_conductor')[0]);
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
          '/clientes/administrador/conductores/agregar/modelo/incapacidad_conductor/guardar.php',
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
            $('#form_11_incapacidad_conductor').trigger("reset");
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();
            call_recuperar_session(function (k) {
              fun_form_incapacidad_conductor_accordion();
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
    },
    onClose: function (_param) {
      if (status_accordion == true) {
        accordion_busqueda(11, false);
        $('html, body').animate(
          { scrollTop: $('#form_11_incapacidades_conductor_resultados').offset().top - 150 },
          500
        );
      }
    },
    buttons: {
      aceptar: function () { },
    },
  });
}





//// --->>>>>>>>>>>>>>>>> INFORMACION incapacidad <<<<<<<<<<<<<<<<<<<<<<<<--- 

$('#form_11_incapacidades_conductor_resultados').on('click', '#btn_info', function (e) {

  fun_info_incapacidad_conductor($(this).attr('btn-id'));
  e.preventDefault();
  return false;
});

function fun_info_incapacidad_conductor(_id_incapacidad_conductor) {
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
          '/clientes/administrador/conductores/agregar/modelo/incapacidad_conductor/buscar.php',
        type: 'POST',
        data: {
          id_incapacidad_conductor: _id_incapacidad_conductor,
        },
        headers: {
          'csrf-token': $('meta[name="csrf-token"]').attr('content'),
        },
        dataType: 'json',
        timeout: 35000,
      })
        .done(function (response) {
          if (response.status === 'bien') {
            self.setTitle('Detalles incapacidad Conductor');
            self.setContent(asignar_datos_incapacidad_conductor(response.message[0]));
            // self.close();
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();

            call_recuperar_session(function (k) {
              fun_info_incapacidad_conductor(_id_incapacidad_conductor);
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

function asignar_datos_incapacidad_conductor(_response) {
  // let json_array = (JSON.parse(_response));

  let inner_html = `<div class="row gtr-50 gtr-uniform">
  <div class="col-12 align-center"> 
  <i class="fas fas fa-folder-plus fa-3x"></i>
  </div>
  <div class="col-12"><hr class="hr-text" data-content="Información incapacidad">
  </div><div class="col-3 col-12-small align-center"><label class="label-datos"> Conductor </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.nombre_conductor}</label>
  </div><div class="col-3 col-12-small align-center"><label class="label-datos"> Dias Incapacidad </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.numero_dias_incapacidad_conductor}</label>
  </div><div class="col-3 col-12-small align-center"><label class="label-datos"> Concepto incapacidad </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.concepto_incapacidad_conductor}</label>
  </div><div class="col-3 col-12-small align-center"><label class="label-datos"> EPS incapacidad  </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.nombre_eps}</label>
  </div><div class="col-3 col-12-small align-center"><label class="label-datos"> ARL incapacidad  </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.nombre_arl}</label>
  </div><div class="col-3 col-12-small align-center"><label class="label-datos"> Fecha inicio incapacidad  </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.fecha_inicio_incapacidad}</label>
  </div><div class="col-3 col-12-small align-center"><label class="label-datos"> Fecha fin incapacidad  </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.fecha_inicio_incapacidad}</label>
  </div><div class="col-12 align-center"><hr class="hr-text" data-content="Fotografía de incapacidad"></div> `
  ;
  

  inner_html += `<div class="col-4 col-12-small"></div>
    <div class="col-4 col-12-small">
    <a href="${PROTOCOL_HOST}${_response.foto_incapacidad_conductor}" target="_blank">
    <span class="image fit">
    <img src="${PROTOCOL_HOST}${_response.foto_incapacidad_conductor}" class="dialog-image" alt="fotografia_del_certificado">
    </span>
    </a>
    </div>
    <div class="col-4 col-12-small"></div>`;

  inner_html += `</div>`;

  return inner_html;
}


///// --->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> ELIMINAR (ACTUALIZAR ESTADO) <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<---


$('#form_11_incapacidades_conductor_resultados').on(
  'click',
  '#btn_delete',
  function (e) {
    let $temp_id_incapacidad_conductor = $(this).attr('btn-id');
    $.confirm({
      title: 'Alerta',
      content:
        '<center>' +
        'Esta por <b>eliminar</b> un certificado incapacidad del conductor ' +
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
            fun_info_incapacidad_conductor_eliminar($temp_id_incapacidad_conductor);
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

function fun_info_incapacidad_conductor_eliminar(_id_incapacidad_conductor) {

  let incapacidad_status = false;

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
          '/clientes/administrador/conductores/agregar/modelo/incapacidad_conductor/eliminar.php',
        type: 'POST',
        data: {
          id_incapacidad_conductor: _id_incapacidad_conductor,
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
            incapacidad_status = true;
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();

            call_recuperar_session(function (k) { 
              fun_info_incapacidad_conductor_eliminar(_id_incapacidad_conductor);
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
      if (incapacidad_status == true) {
        accordion_busqueda(11, false);
        $('html, body').animate(
          { scrollTop: $('#form_11_incapacidades_conductor_resultados').offset().top - 150 },
          500
        );
      }
    },
    buttons: {
      aceptar: function () { },
    },
  });
}


