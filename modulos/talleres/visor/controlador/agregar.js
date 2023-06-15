const cabecera_tabla = ['NRO', 'NIT', 'NOMBRE', 'DIRECCION', 'OPCIONES'];

const botones_tabla = {
  botones: [
    {
      id: 'btn_info_taller',
      icon: 'fas fa-info-circle',
    },
    {
      id: 'btn_link_taller',
      icon: 'fas fa-external-link-square-alt',
    },
  ],
};

autocomplete_with_insert_father({
  id_input_text: 'form_1_empresa_taller_input',
  id_input_select: 'form_1_empresa_taller_select',
  url_select_ajax:
    PROTOCOL_HOST +
    '/modulos/assets/autocomplete/empresa_general/buscar_empresa.php',
  url_insert_ajax:
    PROTOCOL_HOST + 'modulos/talleres/visor/modelo/crear_empresas.php',
  input_value_default: '',
  input_select_default: '1',
  input_childs: [],
  // is_todo: false,
});

let fun_info_taller = null;
let fun_link_taller = null;

export function fun_agregar_functions(_function_info, _function_link) {
  fun_info_taller = _function_info;
  fun_link_taller = _function_link;
}

let $temp_nit = '';
let $temp_empresa = '';


$('#from_1_buscar_nit').on('submit', function (e) {
  fun_buscar_nit();
  e.preventDefault();
  return false;
});

$('#agregar_resultados_body').on('click', '#btn_info_taller', function (e) {
  fun_info_taller($(this).attr('btn-id'));
  e.preventDefault();
  return false;
});

$('#agregar_resultados_body').on('click', '#btn_link_taller', function (e) {
  fun_link_taller($(this).attr('btn-id'));
  e.preventDefault();
  return false;
});

function fun_buscar_nit() {
  $temp_nit = $('#form_1_nit').val().toUpperCase();
  $temp_empresa = $('#form_1_empresa_taller_select').val().toUpperCase();
  let form_data = new FormData($('#from_1_buscar_nit')[0]);

console.log($temp_empresa);

  $('#agregar_resultados_title').show().empty();
  $('#agregar_resultados_body').show().empty();

  $.confirm({
    title: false,
    content: 'Cargando, espere...',
    typeAnimated: true,
    scrollToPreviousElement: false,
    scrollToPreviousElementAnimate: false,
    content: function () {
      var self = this;
      return $.ajax({
        url: PROTOCOL_HOST + '/modulos/talleres/visor/modelo/buscar_nit.php',
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
            self.setTitle('Completado!');
            self.setContent('Espere un momento...');

            $('#agregar_resultados_title').html(
              '<label> - Resultado de la búsqueda - </label>'
            );

            $('#agregar_resultados_body').html(
              '<table class="alt">' +
                '<thead>' +
                getTheadTable(cabecera_tabla, 'nro', 'desc') +
                '</thead>' +
                '<tbody>' +
                getTbodyTable(response.body, botones_tabla) +
                '</tbody>' +
                '</table>'
            );
            self.close();
          } else if (response.status === 'sin_resultados') {
            self.setTitle('Completado!');
            self.setContent('Espere un momento...');

            $('#agregar_resultados_title').html(
              '<label> - Sin resultados Para este ( NIT ) - </label>'
            );
            $('#agregar_resultados_body').html(
              `<center>               
               <p> La búsqueda no arrojo <b>NINGÚN RESULTADO</b> </p>
               <i class="far fa-frown fa-3x"></i>
               </center>
              <ul>
                <li>Por favor inténtelo de nuevo o más tarde.</li>
                <li>Verifique la información ingresada. </li>
                <li>Si desea <b>crear una empresa con este NIT</b>, pulse en <b>(Crear Taller).</li>
              </ul>  
              <center>
              <button class="primary small icon solid fa-arrow-right" id="btn_crear_taller"> Crear Taller</button>        
              </center>`
            );

            self.close();
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();
            call_recuperar_session(fun_buscar_nit);
          } else {
            self.setTitle(response.status);
            self.setContent(response.body);
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

$('#agregar_resultados_body').on('click', '#btn_crear_taller', function (e) {
  $.confirm({
    title: 'Alerta',
    content:
      '<center>' +
      'Esta por crear un taller con este NIT  <br>' +
      '<b> ( ' +
      escapehtmljs($temp_nit) +
      ' ) </b> <br>' +
      'Con la empresa  <br>' +
      '<b> ( ' +
      escapehtmljs($temp_empresa) +
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
          fun_agregar_taller($temp_nit,$temp_empresa);
        },
      },
      no: {
        text: 'No',
        action: function () {},
      },
    },
  });
});

function fun_agregar_taller(_nit,_empresa) {
  let self = $.confirm({
    title: 'Error ',
    content: 'Cargando, espere...',
    typeAnimated: true,
    scrollToPreviousElement: false,
    scrollToPreviousElementAnimate: false,

    content: function () {
      return $.ajax({
        url: PROTOCOL_HOST + '/modulos/talleres/visor/modelo/agregar.php',
        type: 'POST',
        data: {
          nit: _nit,
          empresa: _empresa,
        },
        headers: {
          'csrf-token': $('meta[name="csrf-token"]').attr('content'),
        },
        dataType: 'json',
        timeout: 5000,
      })
        .done(function (response) {
          console.log(response);
          if (response.status === 'bien') {
            self.close();

            window.location.replace(
              PROTOCOL_HOST +
                '/modulos/talleres/detalles/index.php?id=' +
                response.message
            );
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();
            call_recuperar_session(function (k) {
              fun_agregar_taller(_nit);
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
    buttons: {
      aceptar: function () {},
    },
  });
}
