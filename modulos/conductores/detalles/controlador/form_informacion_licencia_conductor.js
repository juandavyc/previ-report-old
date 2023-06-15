
const const_id_vehiculo = $('meta[name="csrf-id"]').attr('content');

let accordion_busqueda = null;
export function fun_licencia_conductor_accordion(_funtion_name) {
  accordion_busqueda = _funtion_name;
}

// console.log($('input[name="form_10_categoria"]:checked').serialize());

$('#form_6_licencia_conductor').on('submit', function (e) {

  let array_cat = [];

  $('input[class="form_categoria"]:checked').each(function () {
    array_cat.push(this.value);
  });

  if (array_cat.length > 4) {

      $.confirm({
        title: 'Alerta',
        content:
          '<center>' +
          'La licencia de conduccion no puede tener mas de' +
          '<b> ( 4 ) </b> categorias de licencia' +
          ' <br>Seleccione las categorias correctas' +
          '</center> ',
        typeAnimated: true,
        scrollToPreviousElement: false,
        scrollToPreviousElementAnimate: false,
        buttons: {
          si: {
            text: 'Ok',
            action: function () {
            },
          },
        },
      });

  } else {
    fun_form_licencia_conductor_accordion(array_cat);

  }


  e.preventDefault();
  return false;
});

function fun_form_licencia_conductor_accordion(_categorias) {

  let status_accordion = false;

  let formdata = new FormData($('#form_6_licencia_conductor')[0]);
  formdata.append("id_conductor", const_id_vehiculo);
  // si no seleccionan ninguna categoriaa
  if(_categorias.length > 0){
    formdata.set('form_6_categoria',_categorias);
  } else{
    // 1 es sin categorias
    formdata.set('form_6_categoria',1);
  }

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
          '/modulos/conductores/detalles/modelo/licencia/guardar.php',
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
            $('#form_6_licencia_conductor').trigger("reset");
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();
            call_recuperar_session(function (k) {
              fun_form_licencia_conductor_accordion(_categorias);
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
        accordion_busqueda(6, false);
        $('html, body').animate(
          { scrollTop: $('#form_6_licencia_conductor_resultados').offset().top - 150 },
          500
        );
      }
    },
    buttons: {
      aceptar: function () { },
    },
  });
}





//// --->>>>>>>>>>>>>>>>> INFORMACION licencia <<<<<<<<<<<<<<<<<<<<<<<<--- 

$('#form_6_licencia_conductor_resultados').on('click', '#btn_info', function (e) {

  fun_info_licencia_conductor($(this).attr('btn-id'));
  e.preventDefault();
  return false;
});

function fun_info_licencia_conductor(_id_licencia_conductor) {
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
          '/modulos/conductores/detalles/modelo/licencia/buscar.php',
        type: 'POST',
        data: {
          id_licencia_conductor: _id_licencia_conductor,
        },
        headers: {
          'csrf-token': $('meta[name="csrf-token"]').attr('content'),
        },
        dataType: 'json',
        timeout: 35000,
      })
        .done(function (response) {
          if (response.status === 'bien') {
            self.setTitle('Detalles licencia Conductor');
            self.setContent(asignar_datos_licencia_conductor(response.message[0]));
            // self.close();
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();

            call_recuperar_session(function (k) {
              fun_info_licencia_conductor(_id_eps_conductor);
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

function asignar_datos_licencia_conductor(_response) {
  // let json_array = (JSON.parse(_response));

  let inner_html = `<div class="row gtr-50 gtr-uniform">
  <div class="col-12 align-center"> 
  <i class="fas fas fa-folder-plus fa-3x"></i>
  </div>
  <div class="col-12"><hr class="hr-text" data-content="Información Licencia ">
  </div><div class="col-3 col-12-small align-center"><label class="label-datos"> Numero Licencia </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.numero_licencia_conduccion}</label>
  </div><div class="col-3 col-12-small align-center"><label class="label-datos"> fecha expedicion </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.fecha_expedicion_licencia_conduccion}</label>
  </div><div class="col-3 col-12-small align-center"><label class="label-datos"> fecha vencimiento </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.fecha_vencimiento_licencia_conduccion}</label>
  </div><div class="col-3 col-12-small align-center"><label class="label-datos"> Estado licencia </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.nombre_estado_licencia}</label>
  </div><div class="col-3 col-12-small align-center"><label class="label-datos"> Restricciones </label>
  </div><div class="col-3 col-12-small"><label class="label-resultados">${_response.restricciones_del_conductor}</label>
  </div>
  <div class="col-12 align-center"><hr class="hr-text" data-content="Categorias de la licencia"></div>
  <div class="col-12 align-center table-wrapper">
  <table class="alt">
      <thead>
          <tr>
              <th>Categoria</th>
              <th>Description</th>
          </tr>
      </thead>
      <tbody>
          <tr>
              <td>${_response.categoria_1}</td>
              <td>${_response.descripcion_categoria_1}</td>
          </tr>
          <tr>
          <td>${_response.categoria_2}</td>
          <td>${_response.descripcion_categoria_2}</td>
          </tr>
          <tr>
          <td>${_response.categoria_3}</td>
          <td>${_response.descripcion_categoria_3}</td>
          </tr>
          <tr>
          <td>${_response.categoria_4}</td>
          <td>${_response.descripcion_categoria_4}</td>
          </tr>
      </tbody>
  </table>
</div>
  <div class="col-12 align-center"><hr class="hr-text" data-content="Fotografía del certificado"></div>
  <div class="col-6 col-6-xsmall align-center"><span class="image fit"><img src="${_response.foto_delantera_licencia_conduccion}"></span><label>Delantera</label></div>
  <div class="col-6 col-6-xsmall align-center"><span class="image fit"><img src="${_response.foto_trasera_licencia_conduccion}"></span><label>Trasera</label></div>`;

  inner_html += `</div>`;

  return inner_html;
}


///// --->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> ELIMINAR (ACTUALIZAR ESTADO) <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<---


$('#form_6_licencia_conductor_resultados').on(
  'click',
  '#btn_delete',
  function (e) {
    let $temp_id_licencia_conductor = $(this).attr('btn-id');
    $.confirm({
      title: 'Alerta',
      content:
        '<center>' +
        'Esta por <b>eliminar</b> un certificado licencia del conductor ' +
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
            fun_info_licencia_conductor_eliminar($temp_id_licencia_conductor);
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

function fun_info_licencia_conductor_eliminar(_id_licencia_conductor) {

  let licencia_status = false;

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
          '/modulos/conductores/detalles/modelo/licencia/eliminar.php',
        type: 'POST',
        data: {
          id_licencia_conductor: _id_licencia_conductor,
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
            licencia_status = true;
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();

            call_recuperar_session(function (k) {
              fun_info_licencia_conductor_eliminar(_id_licencia_conductor);
            });
          } else if (response.status === 'sin_resultados') {
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
      if (licencia_status == true) {
        accordion_busqueda(6, false);
        $('html, body').animate(
          { scrollTop: $('#form_6_licencia_conductor_resultados').offset().top - 150 },
          500
        );
      }
    },
    buttons: {
      aceptar: function () { },
    },
  });
}



$('#btn-agregar-categoria').on('click', function (e) {

  // $.alert("DHJSAKD#");

  const inner_html = `<div class="col-2 col-12-small">
  <label class="label-datos"> Categoria licencia <b class="list-key"></b></label>
</div><div class="col-3 col-12-small ">
<div class="input-container">
    <i class="far fa-hospital icon-input"></i>
    <select id="form_6_categoria_licencia_conductor" name="form_6_categoria_licencia_conductor" required="" value="2">
        <option value="1">A1</option>
        <option value="2">A2</option>
        <option value="3">B1</option>
        <option value="4">B2</option>
        <option value="5">B3</option>
        <option value="6">C1</option>
        <option value="7">C2</option>
        <option value="8">C3</option>
    </select>
</div>
</div><div class="col-1 col-12-small "><button class="button primary small" id="btn-agregar-categoria"><i class="fas fa-plus"></i></button></div>`;

  $('#form_6_licencia_conductor_conductor').append(inner_html);

  // let $temp_id_licencia_conductor = $(this).attr('btn-id');
  // $.confirm({
  //   title: 'Alerta',
  //   content:
  //     '<center>' +
  //     'Esta por <b>eliminar</b> un certificado licencia del conductor ' +
  //     ' <br>¿Esta seguro que desea continuar?' +
  //     '</center> ',
  //   typeAnimated: true,
  //   scrollToPreviousElement: false,
  //   scrollToPreviousElementAnimate: false,
  //   closeIcon: true,
  //   columnClass: 'small',
  //   buttons: {
  //     si: {
  //       text: 'Si',
  //       action: function () {
  //         fun_info_licencia_conductor_eliminar($temp_id_licencia_conductor);
  //       },
  //     },
  //     no: {
  //       text: 'No',
  //       action: function () { },
  //     },
  //   },
  // });


}
);