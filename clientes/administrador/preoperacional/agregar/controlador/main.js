// import './autocomplete.js';
import { fun_accordion_busqueda } from './accordion.js';
import {fun_preoperativo_accordion} from './form_documentos_preoperativo.js'
import {fun_preoperativo_listado_accordion} from './form_lista_verificacion_preoperativo.js'

let return_camera = fun_camera_photo(
  'https://' +
    $(location).attr('host') +
    '/clientes/administrador/preoperacional/agregar/index.php?id=' +
    $('meta[name="csrf-id"]').attr('content'),
  $('meta[name="csrf-id"]').attr('content'),
  0
);

if (return_camera == true) {
  fun_accordion_busqueda(0, false);
  fun_preoperativo_accordion(fun_accordion_busqueda);
  fun_preoperativo_listado_accordion(fun_accordion_busqueda);

}