const json_firma_responsable = {
  id_container: 'canvas_firma_autoriza',
  title_label: 'Firme en el recuadro blanco',
  responsive: '#canvas_firma_autoriza',
};

export let firma_1 = new canvas_firma(json_firma_responsable);

autocomplete_with_insert_father({
  id_input_text: 'form_1_empresa_input',
  id_input_select: 'form_1_empresa_select',
  url_select_ajax:
    PROTOCOL_HOST +
    '/clientes/conductor/assets/autocomplete/empresa_general/buscar_empresa.php',
  url_insert_ajax:
    PROTOCOL_HOST + '/clientes/conductor/usuarios/visor/modelo/crear_empresa.php',
  input_value_default: '',
  input_select_default: '0',
  input_childs: [
    {
      id_input_text: 'form_1_vehiculo_input',
      id_input_select: 'form_1_vehiculo_select',
      input_value_default: '',
      input_select_default: '0',
    },
  ],
});

autocomplete_with_insert_child({
  id_input_text: 'form_1_vehiculo_input',
  id_input_select: 'form_1_vehiculo_select',
  url_select_ajax:
    PROTOCOL_HOST +
    '/clientes/conductor/assets/autocomplete/vehiculo_conductor/buscar_empresa.php',
  url_insert_ajax:
    PROTOCOL_HOST + '/clientes/conductor/siniestros/visor/modelo/crear_vehiculo.php',
  input_value_default: '',
  input_select_default: '0',
  input_father_name: 'EMPRESA',
  input_father_text: 'form_1_empresa_input',
  input_father_select: 'form_1_empresa_select',
});

$('#form_1_info_vehiculo').click(function (e) {
  let $temp_id_vehiculo = $('#form_1_vehiculo_select').val();
  if ($temp_id_vehiculo > 0) {
    fun_info_vehiculo($temp_id_vehiculo);
  } else {
    $.alert('La placa no cumple los requisitos minimos');
  }
  e.preventDefault();
  return false;
});

$('#form_1_vehiculo_input').click(function () {
  $('#form_1_submit').attr('disabled', true);
});
$('#form_1_reset').click(function () {
  $('#form_1_nuevo_mantenimiento').trigger('reset');
  // hidden
  $('#form_1_nuevo_mantenimiento')
    .find('input[type=hidden]')
    .each(function () {
      $(this).val($(this).attr('data-default'));
    });
  $('#form_1_submit').attr('disabled', true);
});
$('#form_1_nuevo_mantenimiento').on('submit', function (e) {
  $.confirm({
    title: 'Alerta',
    content:
      '<center>' +
      'Esta por Asignar una preoperacional para: <br>' +
      '<b> ( ' +
      escapehtmljs($('#form_1_vehiculo_input').val()) +
      ' ) </b> ' +
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
          fun_form_1_submit();
        },
      },
      no: {
        text: 'No',
        action: function () {},
      },
    },
  });

  e.preventDefault();
  return false;
});

function fun_form_1_submit() {
  if (firma_1.get_status == false) {
    $.alert('Falta la firma de quien Autoriza');
  } else {
    let form_data = new FormData($('#form_1_nuevo_mantenimiento')[0]);
    form_data.append('form_1_firma', firma_1.get_blob);

    let self = $.confirm({
      title: false,
      content: 'Cargando, espere...',
      typeAnimated: true,
      scrollToPreviousElement: false,
      scrollToPreviousElementAnimate: false,
      content: function () {
        return $.ajax({
          url:
            PROTOCOL_HOST +
            '/clientes/conductor/preoperacional-super/visor/modelo/crear_preoperacional.php',
          type: 'POST',
          data: form_data,
          headers: {
            'csrf-token': $('meta[name="csrf-token"]').attr('content'),
          },
          dataType: 'json',
          processData: false,
          contentType: false,
          timeout: 5000,
        })
          .done(function (response) {
            console.log(response);
            if (response.status === 'bien') {
              self.close();

              window.location.replace(
                PROTOCOL_HOST +
                  '/clientes/conductor/preoperacional/agregar/index.php?id=' +
                  response.message
              );
            } else if (response.status === 'sin_resultados') {
              self.setTitle('Completado!');
              self.setContent('Espere un momento...');
              self.close();
            } else if (
              response.status === 'csrf' ||
              response.status === 'session'
            ) {
              self.close();
              call_recuperar_session(fun_form_1_submit);
            } else {
              self.setTitle(response.status);
              self.setContent(response.body);
            }
          })
          .fail(function (response) {
            self.setTitle('Error fatal');
            self.setContent(
              response.statusText + ' // ' + response.responseText
            );
            console.log(response);
          });
      },
      buttons: {
        aceptar: function () {},
      },
    });
  }
}

function fun_info_vehiculo(_id_vehiculo) {
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
          '/clientes/conductor/mantenimientos-super/visor/modelo/informacion_vehiculo.php',
        type: 'POST',
        data: {
          id_vehiculo: _id_vehiculo,
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
            self.setTitle('Informacion del vehiculo');
            self.setContent(asignar_datos_vehiculo(response.message[0]));
            // self.close();
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();

            call_recuperar_session(function (k) {
              fun_info_vehiculo(_id_vehiculo);
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
      aceptar: function () {
        $('#form_1_submit').attr('disabled', false);
      },
    },
  });
}

// <div class="col-12">
function asignar_datos_vehiculo(_response) {
  $('#form_1_empresa').val(_response.id_empresa);
  let response = `
  <div class="row">
  <div class="col-12 align-center"> 
  <i class="fas fas fa-car fa-3x"></i></div><div class="col-12"><hr class="hr-text" data-content="Información básica del vehiculo">
  </div><div class="col-3 col-12-small"><label class="label-datos "> PLACA VEHICULO </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.placa}</label>
  </div><div class="col-3 col-12-small"><label  class="label-datos"> TIPO VEHICULO </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.tipo}</label>
  </div><div class="col-3 col-12-small"><label  class="label-datos"> SERVICIO </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.servicio}</label>
  </div><div class="col-3 col-12-small"><label  class="label-datos"> MARCA </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados" >${_response.marca}</label>
  </div><div class="col-3 col-12-small"><label  class="label-datos"> LINEA </label>  
  </div><div class="col-3 col-12-small"><label class="label-resultados" >${_response.linea}</label>
  </div><div class="col-3 col-12-small"><label  class="label-datos"> MODELO </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados" >${_response.modelo}</label>
  </div><div class="col-3 col-12-small"><label  class="label-datos"> COLOR </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados" >${_response.color}</label>
  </div><div class="col-3 col-12-small"><label  class="label-datos"> KILOMETRAJE </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados" >${_response.kilometraje}</label>
  </div><div class="col-3 col-12-small"><label  class="label-datos"> COMBUSTIBLE </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados" >${_response.combustible}</label>
  </div> <div class="col-12"><hr class="hr-text" data-content="Fotografías vehículo"></div>
  <div class="col-3 col-6-xsmall"><span class="image fit"><img src="${_response.foto_delantera}"></span><label>Delantera</label></div>
  <div class="col-3 col-6-xsmall"><span class="image fit"><img src="${_response.foto_costado_izquierdo}"></span><label>C. Izquierdo</label></div>
  <div class="col-3 col-6-xsmall"><span class="image fit"><img src="${_response.foto_trasera}"></span><label>Trasera</label></div>
  <div class="col-3 col-6-xsmall"><span class="image fit"><img src="${_response.foto_costado_derecho}"></span><label>C. Derecho</label></div>
  </div>`;

  return response;
}
