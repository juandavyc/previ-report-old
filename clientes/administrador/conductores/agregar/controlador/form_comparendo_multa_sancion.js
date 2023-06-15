
const const_id_vehiculo = $('meta[name="csrf-id"]').attr('content');

let accordion_busqueda = null;
export function fun_comparendo_multa_sancion_conductor_accordion(_funtion_name) {
  accordion_busqueda = _funtion_name;
}

$('#form_7_comparendo_multa_sancion_conductor').on('submit', function (e) {

  fun_form_comparendo_conductor_accordion();
  e.preventDefault();
  return false;
});

function fun_form_comparendo_conductor_accordion() {

  let status_accordion = false;

  let formdata = new FormData($('#form_7_comparendo_multa_sancion_conductor')[0]);
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
          '/clientes/administrador/conductores/agregar/modelo/comparendo_multa_sancion/guardar_datos_comparendos_multas_sanciones.php',
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
            $('#form_7_comparendo_multa_sancion_conductor').trigger("reset");
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();
            call_recuperar_session(function (k) {
              fun_form_comparendo_conductor_accordion();
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
        accordion_busqueda(7, false);
        $('html, body').animate(
          { scrollTop: $('#form_7_comparendo_multa_sancion_resultados').offset().top - 150 },
          500
        );
      }
    },
    buttons: {
      aceptar: function () { },
    },
  });
}





//// --->>>>>>>>>>>>>>>>> INFORMACION ARL <<<<<<<<<<<<<<<<<<<<<<<<--- 

$('#form_7_comparendo_multa_sancion_resultados').on('click', '#btn_info', function (e) {

  fun_info_copmparendo_conductor($(this).attr('btn-id'));
  e.preventDefault();
  return false;
});

function fun_info_copmparendo_conductor(_id_comparendo_conductor) {
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
          '/clientes/administrador/conductores/agregar/modelo/comparendo_multa_sancion/buscar_comparendo_multa_sancion.php',
        type: 'POST',
        data: {
          id_comparendo_conductor: _id_comparendo_conductor,
        },
        headers: {
          'csrf-token': $('meta[name="csrf-token"]').attr('content'),
        },
        dataType: 'json',
        timeout: 35000,
      })
        .done(function (response) {
          if (response.status === 'bien') {
            self.setTitle('Detalles <b>Comparendo</b> Conductor');
            self.setContent(asignar_datos_comparendo_multa_sancion_conductor(response.message[0]));
            // self.close();
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();

            call_recuperar_session(function (k) {
              fun_info_copmparendo_conductor(_id_comparendo_conductor);
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

function asignar_datos_comparendo_multa_sancion_conductor(_response) {
  // let json_array = (JSON.parse(_response));

  let inner_html = `<div class="row gtr-50 gtr-uniform">
  <div class="col-12 align-center"> 
  <i class="fas fas fa-folder-plus fa-3x"></i>
  </div>
  <div class="col-12"><hr class="hr-text" data-content="Información afiliacion Comparendo">
  </div><div class="col-3 col-12-small align-center"><label class="label-datos"> Tipo Comparendo </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.nombre_tipo_comparendo_conductor}</label>
  </div><div class="col-3 col-12-small align-center"><label class="label-datos"> Motivo </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.motivo_comparendo_conductor}</label>
  </div><div class="col-3 col-12-small align-center"><label class="label-datos"> Fecha comparendo</label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.fecha_comparendo_conductor}</label>
  </div><div class="col-12 align-center"><hr class="hr-text" data-content="Fotografía del comparendo"></div>`;

  inner_html += `<div class="col-4 col-12-small"></div>
    <div class="col-4 col-12-small">
    <a href="${PROTOCOL_HOST}${_response.foto_comparendo_conductor}" target="_blank">
    <span class="image fit">
    <img src="${PROTOCOL_HOST}${_response.foto_comparendo_conductor}" class="dialog-image" alt="fotografia_del_certificado">
    </span>
    </a>
    </div>
    <div class="col-4 col-12-small"></div>`;

  inner_html += `</div>`;

  return inner_html;
}


///// --->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> ELIMINAR (ACTUALIZAR ESTADO) <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<---


$('#form_7_comparendo_multa_sancion_resultados').on(
  'click',
  '#btn_delete',
  function (e) {
    let $temp_id_comparendo_multa_sancion_conductor = $(this).attr('btn-id');
    $.confirm({
      title: 'Alerta',
      content:
        '<center>' +
        'Esta por <b>eliminar</b> un comparendo/multa/sanción del conductor ' +
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
            fun_info_comparendo_multa_sancion_conductor_eliminar($temp_id_comparendo_multa_sancion_conductor);
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

function fun_info_comparendo_multa_sancion_conductor_eliminar(_id_comparendo_conductor) {

  let comparendo_status = false;

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
          '/clientes/administrador/conductores/agregar/modelo/comparendo_multa_sancion/eliminar_comparendo_multa_sancion.php',
        type: 'POST',
        data: {
          _id_comparendo_conductor: _id_comparendo_conductor,
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
            comparendo_status = true;
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();

            call_recuperar_session(function (k) { 
              fun_info_comparendo_multa_sancion_conductor_eliminar(_id_comparendo_conductor);
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
      if (comparendo_status == true) {
        accordion_busqueda(7, false);
        $('html, body').animate(
          { scrollTop: $('#form_7_comparendo_multa_sancion_resultados').offset().top - 150 },
          500
        );
      }
    },
    buttons: {
      aceptar: function () { },
    },
  });
}


