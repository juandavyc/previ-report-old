import './autocomplete.js';
import { fun_accordion_busqueda } from './accordion.js';
import { fun_informacion_vehiculo_rtm_accordion } from './form_informacion_del_vehiculo.js';
import { fun_certificado_rtm_accordion } from './form_certificado_rtm.js';
import { fun_poliza_soat_accordion } from './form_poliza_soat.js';
import { fun_datos_tecnicos_del_vehiculo_rtm_accordion } from './form_datos_tecnicos_del_vehiculo.js';
import { fun_revision_preventiva_accordion } from './form_revision_preventiva.js';
import { fun_tarjeta_de_operacion_accordion } from './form_tarjeta_de_operacion.js';
import { fun_polizas_accordion } from './form_polizas.js';
import { fun_certificados } from './form_certificados.js';
import { fun_solicitudes_accordion } from './form_solicitudes.js';
import { fun_fotografias_vehiculo_accordion } from './form_fotografias_vehiculo.js';
import { fun_improntas_accordion } from './form_improntas.js';
import { fun_licencia_transito_accordion } from './form_licencia_transito.js';

let return_camera = fun_camera_photo(
  'https://192.168.1.50/clientes/administrador/vehiculos/agregar/index.php?id=' +
    $('meta[name="csrf-id"]').attr('content'),
  $('meta[name="csrf-id"]').attr('content'),
  0
);

//
if (return_camera == true) {
  // habeas_data();

  fun_accordion_busqueda(1, false);

  fun_informacion_vehiculo_rtm_accordion(fun_accordion_busqueda);
  fun_certificado_rtm_accordion(fun_accordion_busqueda);
  fun_poliza_soat_accordion(fun_accordion_busqueda);
  fun_datos_tecnicos_del_vehiculo_rtm_accordion(fun_accordion_busqueda);
  fun_revision_preventiva_accordion(fun_accordion_busqueda);
  fun_tarjeta_de_operacion_accordion(fun_accordion_busqueda);
  fun_polizas_accordion(fun_accordion_busqueda);
  fun_certificados(fun_accordion_busqueda);
  fun_solicitudes_accordion(fun_accordion_busqueda);
  fun_fotografias_vehiculo_accordion(fun_accordion_busqueda);
  fun_improntas_accordion(fun_accordion_busqueda);
  fun_licencia_transito_accordion(fun_accordion_busqueda);
}

/*

const json_firma_1 = {
  id_container: 'canvas_firma_1',
  title_label: 'firma 1 test',
  responsive: '#canvas_firma_1',
 };
 let firma_1 = new canvas_firma(json_firma_1);
$('#suboton').on('click', function (e) {
 console.log(firma_1.get_status);
 firma_1.canvas_default();
 firma_1.set_image('http://192.168.1.50/images/sin_imagen.png');
 firma_1.get_blob;
 return false;
});


// Acordion para cclientes/administrador

/*
import * as infomarcion_vehiculo_js from './form_informacion_del_vehiculo.js'; 
import * as certificado_rtm_js from './form_certificado_rtm.js';


var xx = new infomarcion_vehiculo_js();*/

// informacion del vehiculo

// import './save_basic_information_form.js';

/*
//elementos de inicio, get form data
default_start();
//codigos de autocomplete
autocomplete();
// save form
save_basic_information_form();*/
