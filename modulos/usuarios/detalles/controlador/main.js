import {
  fun_accordion_busqueda,
  fun_accordion_canvas_elements,
} from './accordion.js';
import { fun_informacion_accordion, firma_1 } from './form_informacion.js';
import { fun_estado_accordion } from './form_estado.js';
import { fun_restablecer_accordion } from './form_restablecer.js';
//import { fun_certificado_accordion } from './form_certificado.js';

let return_camera = fun_camera_photo(
  'https://' +
  $(location).attr('host') +
  '/modulos/usuarios/detalles/index.php?id=' +
  $('meta[name="csrf-id"]').attr('content'),
  $('meta[name="csrf-id"]').attr('content'),
  0
);

if (return_camera == true) {
  fun_accordion_busqueda(0, false);
  fun_informacion_accordion(fun_accordion_busqueda);
  // all canvas
  fun_accordion_canvas_elements(firma_1);
  fun_estado_accordion(fun_accordion_busqueda);
  fun_restablecer_accordion(fun_accordion_busqueda);
}
