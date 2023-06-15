const const_id = $('meta[name="csrf-id"]').attr('content');

let accordion_busqueda = null;

export function fun_vehiculo_accordion(_funtion_name) {
  accordion_busqueda = _funtion_name;
}

$('#form_3_vehiculo_implicado').on('submit', function (e) {
  $.confirm({
    title: 'Alerta!',
    content:
      '<center>¿Desea guardar la información de este formulario?</center>',
    columnClass: 'xsmall',
    buttons: {
      si: function () {
        fun_form_3_submit();
      },
      no: function () {},
    },
  });

  e.preventDefault();
  return false;
});

function fun_form_3_submit() {
  $('#form_3_vehiculos_resultados').empty();
  let formdata = new FormData($('#form_3_vehiculo_implicado')[0]);
  formdata.append('form_3_id_siniestro', const_id);
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
          '/clientes/conductor/siniestros/detalles/modelo/vehiculo/form.php',
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
              fun_form_3_submit();
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
        accordion_busqueda(3, false);
        $('html, body').animate(
          { scrollTop: $('#accordion_consulta_3').offset().top - 150 },
          500
        );
      }
    },
    buttons: {
      aceptar: function () {},
    },
  });
}
$('#form_3_vehiculos_resultados').on('click', '#btn_info', function (e) {
  fun_info_vehiculo($(this).attr('btn-id'));
  e.preventDefault();
  return false;
});

function fun_info_vehiculo(_id_elemento) {
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
          '/clientes/conductor/siniestros/detalles/modelo/vehiculo/informacion.php',
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
            self.setTitle('Detalles Vehículo Implicado');
            self.setContent(fun_asignar_datos(response.message[0]));
            // self.close();
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();

            call_recuperar_session(function (k) {
              fun_info_vehiculo(_id_elemento);
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

function fun_asignar_datos(_response) {
  console.log(_response);

  let inner_html = `<div class="row">
  <div class="col-12 align-center"> 
  <i class="fas fas fa-car fa-3x"></i>
  </div>
  <div class="col-12"><hr class="hr-text" data-content="Datos del Vehículo"></div>
  <div class="col-2 col-12-small "><label class="label-datos"> Placa </label></div>
  <div class="col-10 col-12-small"><label class="label-resultados">${_response.placa}</label></div>
  <div class="col-2 col-12-small "><label class="label-datos"> Marca </label></div>
  <div class="col-4 col-12-small"><label class="label-resultados">${_response.marca}</label></div>
  <div class="col-2 col-12-small "><label class="label-datos"> Modelo </label></div>
  <div class="col-4 col-12-small"><label class="label-resultados">${_response.modelo}</label></div>
  <div class="col-12"><hr class="hr-text" data-content="Datos del Conductor"></div>
  <div class="col-2 col-12-small "><label class="label-datos"> Nombre </label></div>
  <div class="col-10 col-12-small"><label class="label-resultados">${_response.conductor}</label></div>
  <div class="col-2 col-12-small "><label class="label-datos">Telefono </label></div>
  <div class="col-4 col-12-small"><label class="label-resultados">${_response.telefono}</label></div>
  <div class="col-2 col-12-small "><label class="label-datos">Correo </label></div>
  <div class="col-4 col-12-small"><label class="label-resultados">${_response.correo}</label></div>
  <div class="col-2 col-12-small "><label class="label-datos">Direccion </label></div>
  <div class="col-4 col-12-small"><label class="label-resultados">${_response.direccion}</label></div>
  <div class="col-12"><hr class="hr-text" data-content="Aseguradora"></div>
  <div class="col-2 col-12-small "><label class="label-datos">Nombre </label></div>
  <div class="col-4 col-12-small"><label class="label-resultados">${_response.aseguradora}</label></div>
  <div class="col-2 col-12-small "><label class="label-datos">Telefono </label></div>
  <div class="col-4 col-12-small"><label class="label-resultados">${_response.aseguradora_telefono}</label></div>
  <div class="col-12"><hr class="hr-text" data-content="Poliza"></div>
  <div class="col-2 col-12-small "><label class="label-datos">Tipo </label></div>
  <div class="col-4 col-12-small"><label class="label-resultados">${_response.poliza}</label></div>
  <div class="col-2 col-12-small "><label class="label-datos">Aseguradora </label></div>
  <div class="col-4 col-12-small"><label class="label-resultados">${_response.poliza_aseguradora}</label></div>
  <div class="col-2 col-12-small "><label class="label-datos">Fecha Expedicion </label></div>
  <div class="col-4 col-12-small"><label class="label-resultados">${_response.fecha_expedicion}</label></div>
  <div class="col-2 col-12-small "><label class="label-datos">Fecha Vencimiento </label></div>
  <div class="col-4 col-12-small"><label class="label-resultados">${_response.fecha_vencimiento}</label></div>
  <div class="col-12 "><hr class="hr-text" data-content="Responsable"></div>
  <div class="col-2 col-12-small"><label class="label-datos"> Usuario </label></div>
  <div class="col-4 col-12-small"><label class="label-resultados">${_response.usuario}</label></div>
  <div class="col-2 col-12-small"><label class="label-datos"> Fecha y hora</label></div>
  <div class="col-4 col-12-small"><label class="label-resultados">${_response.fecha}</label></div>`;

  return inner_html;
}
