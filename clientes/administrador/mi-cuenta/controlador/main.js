import './default_start.js';

import { fun_accordion_consulta } from './accordion.js';
import { fun_informacion_accordion } from './form_informacion.js';
import { fun_contrasenia_accordion } from './form_contrasenia.js';

// informacion basica
fun_accordion_consulta(0, true);
fun_informacion_accordion(fun_accordion_consulta);
fun_contrasenia_accordion(fun_accordion_consulta);