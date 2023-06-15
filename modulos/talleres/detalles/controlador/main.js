import './autocomplete.js';
import { fun_accordion_busqueda } from './accordion.js';
import { fun_informacion_taller_accordion } from './form_informacion_taller.js';

let return_camera = fun_camera_photo(
  'https://' +
    $(location).attr('host') +
    '/modulos/talleres/detalles/index.php?id=' +
    $('meta[name="csrf-id"]').attr('content'),
  $('meta[name="csrf-id"]').attr('content'),
  0
);

if (return_camera == true) {
  // habeas_data();
  fun_accordion_busqueda(0, false);
  fun_informacion_taller_accordion(fun_accordion_busqueda);
}
