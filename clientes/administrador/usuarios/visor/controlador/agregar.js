const cabecera_tabla = [
  'nro',
  'cedula',
  'nombre',
  'apellido',
  'empresa',
  'rango',
  'estado',
  'opciones',
];

const botones_tabla = {
  botones: [
    {
      id: 'btn_info',
      icon: 'fas fa-info-circle',
    },
    {
      id: 'btn_link',
      icon: 'fas fa-external-link-square-alt',
    },
  ],
};

let fun_info = null;
let fun_link = null;

export function fun_agregar_functions(_function_info, _function_link) {
  fun_info = _function_info;
  fun_link = _function_link;
}

let temp_cedula = '';

$('#from_1_buscar_cedula').on('submit', function (e) {
  fun_buscar_cedula();
  e.preventDefault();
  return false;
});

$('#agregar_resultados_body').on('click', '#btn_info', function (e) {
  fun_info($(this).attr('btn-id'));
  e.preventDefault();
  return false;
});

$('#agregar_resultados_body').on('click', '#btn_link', function (e) {
  fun_link($(this).attr('btn-id'));
  e.preventDefault();
  return false;
});

function fun_buscar_cedula() {
  temp_cedula = $('#form_1_cedula').val().toUpperCase();
  let form_data = new FormData($('#from_1_buscar_cedula')[0]);

  $('#agregar_resultados_title').show().empty();
  $('#agregar_resultados_body').show().empty();

  let self = $.confirm({
    title: false,
    content: 'Cargando, espere...',
    typeAnimated: true,
    scrollToPreviousElement: false,
    scrollToPreviousElementAnimate: false,
    content: function () {
      return $.ajax({
        url: PROTOCOL_HOST + '/clientes/administrador/usuarios/visor/modelo/buscar_cedula.php',
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
              '<label> - Sin resultados Para esta ( CEDULA ) - </label>'
            );
            $('#agregar_resultados_body').html(
              `<center>               
               <p> La búsqueda no arrojo <b>NINGÚN RESULTADO</b> </p>
               <i class="far fa-frown fa-3x"></i>
               </center>
              <ul>
                <li>Por favor inténtelo de nuevo o más tarde.</li>
                <li>Verifique la información ingresada. </li>
                <li>Si desea <b>crear una usuario con esta CEDULA</b>, pulse en <b>(Crear Usuario).</li>
              </ul>  
              <center>
              <button class="primary small icon solid fa-arrow-right" id="btn_crear_usuario"> Crear Usuario</button>        
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

$('#agregar_resultados_body').on('click', '#btn_crear_usuario', function (e) {
  $.confirm({
    title: 'Alerta',
    content:
      '<center>' +
      'Esta por crear un usuario a esta CEDULA  <br>' +
      '<b> ( ' +
      escapehtmljs(temp_cedula) +
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
          fun_agregar_usuario(temp_cedula);
        },
      },
      no: {
        text: 'No',
        action: function () {},
      },
    },
  });
});

function fun_agregar_usuario(_cedula) {
  let self = $.confirm({
    title: 'Error ',
    content: 'Cargando, espere...',
    typeAnimated: true,
    scrollToPreviousElement: false,
    scrollToPreviousElementAnimate: false,

    content: function () {
      return $.ajax({
        url: PROTOCOL_HOST + '/clientes/administrador/usuarios/visor/modelo/agregar.php',
        type: 'POST',
        data: {
          cedula: _cedula,
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
                '/clientes/administrador/usuarios/detalles/index.php?id=' +
                response.message
            );
          } else if (
            response.status === 'csrf' ||
            response.status === 'session'
          ) {
            self.close();
            call_recuperar_session(function (k) {
              fun_agregar_usuario(_cedula);
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
