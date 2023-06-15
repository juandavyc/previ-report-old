
import './default_start.js';
import './autocomplete.js';
import './canvas_general.js';


import { fun_accordion_consulta_conductor, fun_crear_vehiculo, fun_crear_empresa } from './accordion.js';
// import { fun_canvas_general } from './canvas_general.js';

// import './form_informacion_del_vehiculo.js'; 
import { fun_informacion_conductor_accordion } from './form_informacion_del_conductor.js';
import { fun_informacion_emergencia_conductor_accordion } from './form_informacion_de_emergencia_conductor.js';
import { fun_eps_conductor_accordion } from './form_eps_conductor.js';
import { fun_arl_conductor_accordion } from './form_arl_conductor.js';
import { fun_fdp_conductor_accordion } from './form_fondo_pension_conductor.js';
import { fun_licencia_conductor_accordion } from './form_informacion_licencia_conductor.js';
import { fun_comparendo_multa_sancion_conductor_accordion } from './form_comparendo_multa_sancion.js';
import { fun_examen_ocupacional_conductor_accordion } from './form_examen_ocupacional.js';
import { fun_curso_conductor_accordion } from './form_curso_conductor.js';
import { fun_capacitacion_conductor_accordion } from './form_capacitacion_conductor.js';
import { fun_incapacidad_conductor_accordion } from './form_incapacidad_conductor.js';
import { fun_vehiculo_conductor_accordion } from './form_vehiculo_conductor.js';
import { fun_empresa_conductor_accordion } from './form_empresa_conductor.js';

// fun_fdp_conductor_accordion
let return_camera = fun_camera_photo(
    'https://' +
    $(location).attr('host') +
    '/modulos/conductores/detalles/index.php?id=' +
    $('meta[name="csrf-id"]').attr('content'),
    $('meta[name="csrf-id"]').attr('content'),
    0
);

if (return_camera == true) {
    // habeas_data();
    // Acordion para certificado rtm
    fun_accordion_consulta_conductor(1, true);
    fun_informacion_conductor_accordion(fun_accordion_consulta_conductor);
    fun_informacion_emergencia_conductor_accordion(fun_accordion_consulta_conductor);
    fun_eps_conductor_accordion(fun_accordion_consulta_conductor);
    fun_arl_conductor_accordion(fun_accordion_consulta_conductor);
    fun_fdp_conductor_accordion(fun_accordion_consulta_conductor);
    fun_licencia_conductor_accordion(fun_accordion_consulta_conductor);
    fun_comparendo_multa_sancion_conductor_accordion(fun_accordion_consulta_conductor);
    fun_examen_ocupacional_conductor_accordion(fun_accordion_consulta_conductor);
    fun_curso_conductor_accordion(fun_accordion_consulta_conductor);
    fun_capacitacion_conductor_accordion(fun_accordion_consulta_conductor);
    fun_incapacidad_conductor_accordion(fun_accordion_consulta_conductor);
    fun_vehiculo_conductor_accordion(fun_accordion_consulta_conductor, fun_crear_vehiculo);
    fun_empresa_conductor_accordion(fun_accordion_consulta_conductor, fun_crear_empresa);
}
