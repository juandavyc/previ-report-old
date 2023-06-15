
const const_id_mantenimiento = $('meta[name="csrf-id"]').attr('content');

let accordion_busqueda = null;
export function fun_fotos_mantenimiento_accordion(_funtion_name) {
  accordion_busqueda = _funtion_name;
}

$('#form_3_fotos_mantenimiento').on('submit', function (e) {

  fun_form_3_fotos_mantenimiento();
  e.preventDefault();
  return false;
});

function fun_form_3_fotos_mantenimiento() {

let status_accordion = false;

let formdata = new FormData($('#form_3_fotos_mantenimiento')[0]);
formdata.append("id_mantenimiento", const_id_mantenimiento);

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
        '/clientes/administrador/mantenimientos-taller/agregar/modelo/fotos_mantenimiento/guardar_foto.php',
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
          $('#form_3_fotos_mantenimiento').trigger("reset");
        } else if (
          response.status === 'csrf' ||
          response.status === 'session'
        ) {
          self.close();
          call_recuperar_session(function (k) {
            fun_form_3_fotos_mantenimiento();
          });
        } else if (response.status === 'mal') {
          self.setTitle(response.status);
          self.setContent(response.message);
          $('#form_3_fotos_mantenimiento').trigger("reset");
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
      accordion_busqueda(3, false);
      $('html, body').animate(
        { scrollTop: $('#form_3_fotos_resultados').offset().top - 150 },
        500
      );
    }
  },
  buttons: {
    aceptar: function () { },
  },
});
}





//// --->>>>>>>>>>>>>>>>> INFORMACION vehiculo <<<<<<<<<<<<<<<<<<<<<<<<--- 

$('#form_3_fotos_resultados').on('click', '#btn_info', function (e) {

fun_info_foto($(this).attr('btn-id'));
e.preventDefault();
return false;
});

function fun_info_foto(_id_foto_mantenimiento) {
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
        '/clientes/administrador/mantenimientos-taller/agregar/modelo/fotos_mantenimiento/informacion_foto.php',
      type: 'POST',
      data: {
        id_foto_mantenimiento: _id_foto_mantenimiento,
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
          self.setTitle('Detalles Vehiculo asignado Conductor');
          self.setContent(asignar_datos_informacion_foto(response.message[0]));
          // self.close();
        } else if (
          response.status === 'csrf' ||
          response.status === 'session'
        ) {
          self.close();

          call_recuperar_session(function (k) {
            fun_info_vehiculo_conductor(_id_foto_mantenimiento);
          });
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
  },
  buttons: {
    aceptar: function () { },
  },
});
}

function asignar_datos_informacion_foto(_response) {

let response = `
<div class="row">
<div class="col-12 align-center"> 
<i class="fas fas fa-car fa-3x"></i></div><div class="col-12"><hr class="hr-text" data-content="Informacion detallada de la fotografia">
</div>
<div class="col-3 col-12-small align-center"><label class="label-datos"> Tipo Foto</label>
</div>
<div class="col-3 col-12-small align-center"><label class="label-resultados" id="placa_vehiculo">${_response.categoria}</label>
</div>
<div class="col-3 col-12-small align-center"><label  class="label-datos"> USUARIO </label>
</div>
<div class="col-3 col-12-small align-center"><label class="label-resultados" id="clase_vehiculo">${_response.usuario}</label>
</div> 
<div class="col-3 col-12-small align-center"><label class="label-datos"> DESCRIPCION</label>
</div>
<div class="col-3 col-12-small align-center"><label class="label-resultados" id="placa_vehiculo">${_response.descripcion}</label>
</div>
<div class="col-3 col-12-small align-center"><label  class="label-datos"> FECHA </label>
</div>
<div class="col-3 col-12-small align-center"><label class="label-resultados" id="clase_vehiculo">${_response.fecha}</label>
</div> 
<div class="col-12">
<hr class="hr-text" data-content="Fotografías vehículo"></div>
<div class="col-3" col-12-xsmall></div>
<div class="col-6 col-12-xsmall"><span class="image fit"><img src="${_response.foto}"></span><label></label></div>
<div class="col-3" col-12-xsmall></div>
</div>`;


return response;
}
