const const_id_vehiculo = $('meta[name="csrf-id"]').attr('content');

let accordion_busqueda = null;

export function fun_tarjeta_de_operacion_accordion(_funtion_name) {
  accordion_busqueda = _funtion_name;
}


$('.btn-crear-empresa').on('click', function (e) {
  $.confirm({
    title: 'Alerta!',
    content:
      '<center>Para poder crear una empresa, Comuniquese con PREVIAUTOS </center>',
    columnClass: 'xsmall',
    closeIcon: true,
    buttons: {
      aceptar: function() {
      }
    },
  });

  e.preventDefault();
  return false;
});

$('#form_6_tarjeta_de_operacion').on('submit', function (e) {
  $.confirm({
    title: 'Alerta!',
    content:
      '<center>¿Desea guardar la información de este formulario?</center>',
    columnClass: 'xsmall',
    buttons: {
      si: function () {
        fun_form_6();
      },
      no: function () {},
    },
  });

  e.preventDefault();
  return false;
});

// aca evento de informacion y eliminar

function fun_form_6() {
  $('#form_6_tarjeta_de_operacion_resultados').empty();

  let formdata = new FormData($('#form_6_tarjeta_de_operacion')[0]);
  formdata.append('form_6_id_vehiculo', const_id_vehiculo);

  let fun_form_status = false;

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
          '/clientes/administrador/vehiculos/agregar/modelo/tarjeta_de_operacion/form.php',
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
            fun_form_status = true;
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();
            call_recuperar_session(function (k) {
              fun_form_6();
            });
          } else if (response.status === 'sin_resultados') {
            self.close();
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
      if (fun_form_status == true) {
        accordion_busqueda(6, false);
        $('html, body').animate(
          { scrollTop: $('#accordion_vehiculo_consulta_6').offset().top - 150 },
          500
        );
      }
    },
    buttons: {
      aceptar: function () {},
    },
  });
}

$('#form_6_tarjeta_de_operacion_resultados').on(
  'click',
  '#btn_info',
  function (e) {
    fun_info_form_6($(this).attr('btn-id'));
    e.preventDefault();
    return false;
  }
);

$('#form_6_tarjeta_de_operacion_resultados').on(
  'click',
  '#btn_delete',
  function (e) {
    let $id_elemento = $(this).attr('btn-id');
    $.confirm({
      title: 'Alerta',
      content:
        '<center>' +
        'Esta por <b>eliminar</b> una Tarjeta de Operación ' +
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
            fun_delete_form_6($id_elemento);
          },
        },
        no: {
          text: 'No',
          action: function () {},
        },
      },
    });
  }
);

function fun_info_form_6(_id_elemento) {
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
          '/clientes/administrador/vehiculos/agregar/modelo/tarjeta_de_operacion/informacion.php',
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
            self.setTitle('Detalles Tarjeta de Operación');
            self.setContent(fun_info_form_6_datos(response.message[0]));
            // self.close();
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();

            call_recuperar_session(function (k) {
              fun_info_form_6(_id_elemento);
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

function fun_delete_form_6(_id_elemento) {
  let fun_delete_status = false;

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
          '/clientes/administrador/vehiculos/agregar/modelo/tarjeta_de_operacion/eliminar.php',
        type: 'POST',
        data: {
          id_elemento: _id_elemento,
          id_vehiculo: const_id_vehiculo,
        },
        headers: {
          'csrf-token': $('meta[name="csrf-token"]').attr('content'),
        },
        dataType: 'json',
        timeout: 35000,
      })
        .done(function (response) {
          if (response.status === 'bien') {
            self.setTitle('Eliminado');
            self.setContent(response.message);

            fun_delete_status = true;
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();

            call_recuperar_session(function (k) {
              fun_delete_form_6(_id_elemento);
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
    onClose: function () {
      if (fun_delete_status == true) {
        accordion_busqueda(6, false);
        $('html, body').animate(
          { scrollTop: $('#accordion_vehiculo_consulta_6').offset().top - 150 },
          500
        );
      }
    },
    buttons: {
      aceptar: function () {},
    },
  });
}

function fun_info_form_6_datos(_response) {
  // let json_array = (JSON.parse(_response));

  let inner_html = `<div class="row">
  <div class="col-12 align-center"> 
  <i class="fas fas fa-car fa-3x"></i>
  </div>
  <div class="col-12"><hr class="hr-text" data-content="Información Tarjeta de Operación">
  </div><div class="col-3 col-12-small "><label class="label-datos"> Placa Vehiculo </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.vehiculo.placa}</label>
  </div><div class="col-3 col-12-small "><label class="label-datos"> Numero </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.numero}</label>
  </div><div class="col-3 col-12-small "><label class="label-datos"> Modalidad de Transporte </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.transporte.nombre}</label>
  </div><div class="col-3 col-12-small "><label class="label-datos"> Modalidad Servicio </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.servicio.nombre}</label>
  </div><div class="col-3 col-12-small "><label class="label-datos"> Radio De Accion </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.radio.nombre}</label>
  </div><div class="col-12 ">
  </div><div class="col-3 col-12-small "><label class="label-datos"> Fecha Expedicion <b>(dd/mm/aaaa)</b> </label>  
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.fecha_expedicion}</label>
  </div><div class="col-3 col-12-small "><label class="label-datos"> Fecha Vencimiento <b>(dd/mm/aaaa)</b> </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.fecha_vencimiento}</label>
  </div><div class="col-3 col-12-small "><label class="label-datos"> Estado Tarjeta Operacion  </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.estado.nombre}</label>
  </div><div class="col-12 "><hr class="hr-text" data-content="Empresa Afiliadora">
  </div><div class="col-3 col-12-small "><label class="label-datos"> Nombre </label>  
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.empresa.nombre}</label>
  </div><div class="col-3 col-12-small "><label class="label-datos"> Nit</label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.empresa.nit}</label>
  </div><div class="col-12 "><hr class="hr-text" data-content="Responsable">
  </div><div class="col-3 col-12-small "><label class="label-datos"> Usuario </label>  
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.usuario.nombre}</label>
  </div><div class="col-3 col-12-small "><label class="label-datos"> Fecha y hora</label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.fecha}</label>
  </div><div class="col-12 "><hr class="hr-text" data-content="Fotografía Tarjeta de Operación"></div>`;

  inner_html += `<div class="col-4 col-12-small"></div>
    <div class="col-4 col-12-small">
    <a href="${PROTOCOL_HOST}${_response.foto}" target="_blank">
    <span class="image fit">
    <img src="${PROTOCOL_HOST}${_response.foto}" class="dialog-image" alt="fotografia">
    </span>
    </a>
    </div>
    <div class="col-4 col-12-small"></div>`;

  inner_html += `</div>`;

  return inner_html;
}
