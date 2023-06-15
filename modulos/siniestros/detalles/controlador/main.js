import './autocomplete.js';
import {
  fun_accordion_busqueda,
  fun_accordion_canvas_elements,
} from './accordion.js';
import {
  fun_informacion_siniestro_accordion,
  firma_1,
} from './form_informacion_siniestro.js';

import { fun_agente_accordion } from './form_agente.js';
import { fun_testigo_accordion } from './form_testigo.js';
import { fun_vehiculo_accordion } from './form_vehiculo.js';
let return_camera = fun_camera_photo(
  'https://' +
    $(location).attr('host') +
    '/modulos/siniestros/detalles/index.php?id=' +
    $('meta[name="csrf-id"]').attr('content'),
  $('meta[name="csrf-id"]').attr('content'),
  0
);
if (return_camera == true) {
  fun_accordion_busqueda(0, false);
  fun_informacion_siniestro_accordion(fun_accordion_busqueda);
  fun_agente_accordion(fun_accordion_busqueda);
  fun_testigo_accordion(fun_accordion_busqueda);
  fun_vehiculo_accordion(fun_accordion_busqueda);
  // all canvas
  fun_accordion_canvas_elements(firma_1);
}
