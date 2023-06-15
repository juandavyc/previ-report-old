// import './autocomplete.js';
import { fun_accordion_busqueda } from './accordion.js';
import { fun_procedimiento_mantenimiento_accordion } from './form_procedimiento_mantenimiento.js';
import { fun_informacion_mantenimiento_accordion } from './form_informacion_mantenimiento.js';
import { fun_repuestos_mantenimiento_acordion } from './form_repuestos_mantenimiento.js';
import { fun_fotos_mantenimiento_accordion } from './form_fotos_mantenimiento.js';

let return_camera = fun_camera_photo(
  'https://' +
    $(location).attr('host') +
    '/clientes/supervisor/mantenimientos-taller/agregar/index.php?id=' +
    $('meta[name="csrf-id"]').attr('content'),
  $('meta[name="csrf-id"]').attr('content'),
  0
);

if (return_camera == true) {
  fun_accordion_busqueda(1, false);
  fun_procedimiento_mantenimiento_accordion(fun_accordion_busqueda);
  fun_informacion_mantenimiento_accordion(fun_accordion_busqueda);
  fun_repuestos_mantenimiento_acordion(fun_accordion_busqueda);
  fun_fotos_mantenimiento_accordion(fun_accordion_busqueda);
}
