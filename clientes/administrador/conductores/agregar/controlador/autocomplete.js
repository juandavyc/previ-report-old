const json_autocomplete_departamento = {
  id_input_text: 'form_1_departamento_conductor_input',
  id_input_select: 'form_1_departamento_conductor_select',
  url_select_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/departamento_general/buscar_departamento.php',
  url_insert_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/departamento_general/crear_departamento.php',
  input_value_default: 'SIN_DEPARTAMENTO',
  input_select_default: '0',
  input_childs: [
    {
      id_input_text: 'form_1_ciudad_conductor_input',
      id_input_select: 'form_1_ciudad_conductor_select',
      input_value_default: 'SIN_CIUDAD',
      input_select_default: '0',
    },
  ],
};

autocomplete_with_insert_father(json_autocomplete_departamento);

const json_autocomplete_ciudad = {
  id_input_text: 'form_1_ciudad_conductor_input',
  id_input_select: 'form_1_ciudad_conductor_select',
  url_select_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/ciudad_general/buscar_ciudad.php',
  url_insert_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/ciudad_general/crear_ciudad.php',
  input_value_default: 'SIN_CIUDAD',
  input_select_default: '0',
  input_father_name: 'DEPARTAMENTO ',
  input_father_text: 'form_1_departamento_conductor_input',
  input_father_select: 'form_1_departamento_conductor_select',
};

autocomplete_with_insert_child(json_autocomplete_ciudad);

const json_autocomplete_eps = {
  id_input_text: 'form_3_eps_conductor_input',
  id_input_select: 'form_3_eps_conductor_select',
  url_select_ajax:
    PROTOCOL_HOST + '/clientes/administrador/assets/autocomplete/eps_conductor/buscar_eps.php',
  url_insert_ajax:
    PROTOCOL_HOST + '/clientes/administrador/assets/autocomplete/eps_conductor/crear_eps.php',
  input_value_default: 'SIN_EPS',
  input_select_default: '1',
  input_childs: [],
};

autocomplete_with_insert_father(json_autocomplete_eps);

const json_autocomplete_fdp = {
  id_input_text: 'form_5_fdp_conductor_input',
  id_input_select: 'form_5_fdp_conductor_select',
  url_select_ajax:
    PROTOCOL_HOST + '/clientes/administrador/assets/autocomplete/fdp_conductor/buscar_fdp.php',
  url_insert_ajax:
    PROTOCOL_HOST + '/clientes/administrador/assets/autocomplete/fdp_conductor/crear_fdp.php',
  input_value_default: 'FONDO_PENSION',
  input_select_default: '',
  input_childs: [],
};

autocomplete_with_insert_father(json_autocomplete_fdp);

const json_autocomplete_arl = {
  id_input_text: 'form_4_arl_conductor_input',
  id_input_select: 'form_4_arl_conductor_select',
  url_select_ajax:
    PROTOCOL_HOST + '/clientes/administrador/assets/autocomplete/arl_conductor/buscar_arl.php',
  url_insert_ajax:
    PROTOCOL_HOST + '/clientes/administrador/assets/autocomplete/arl_conductor/crear_arl.php',
  input_value_default: 'SIN_ARL',
  input_select_default: '1',
  input_childs: [],
};

autocomplete_with_insert_father(json_autocomplete_arl);

const json_autocomplete_entidad_examen = {
  id_input_text: 'form_8_entidad_examen_ocupacional_input',
  id_input_select: 'form_8_entidad_examen_ocupacional_select',
  url_select_ajax:
    PROTOCOL_HOST + '/clientes/administrador/assets/autocomplete/entidad_examen/buscar.php',
  url_insert_ajax:
    PROTOCOL_HOST + '/clientes/administrador/assets/autocomplete/entidad_examen/crear.php',
  input_value_default: 'SIN_ENTIDAD',
  input_select_default: '1',
  input_childs: [],
};

autocomplete_with_insert_father(json_autocomplete_entidad_examen);

const json_autocomplete_entidad_curso = {
  id_input_text: 'form_9_entidad_curso_input',
  id_input_select: 'form_9_entidad_curso_select',
  url_select_ajax:
    PROTOCOL_HOST + '/clientes/administrador/assets/autocomplete/entidad_curso/buscar.php',
  url_insert_ajax:
    PROTOCOL_HOST + '/clientes/administrador/assets/autocomplete/entidad_curso/crear.php',
  input_value_default: 'SIN_ENTIDAD',
  input_select_default: '1',
  input_childs: [],
};

autocomplete_with_insert_father(json_autocomplete_entidad_curso);

const json_autocomplete_tipo_curso = {
  id_input_text: 'form_9_tipo_curso_input',
  id_input_select: 'form_9_tipo_curso_select',
  url_select_ajax:
    PROTOCOL_HOST + '/clientes/administrador/assets/autocomplete/tipo_curso/buscar.php',
  url_insert_ajax:
    PROTOCOL_HOST + '/clientes/administrador/assets/autocomplete/tipo_curso/crear.php',
  input_value_default: 'SIN_TIPO_CURSO',
  input_select_default: '1',
  input_childs: [],
};

autocomplete_with_insert_father(json_autocomplete_tipo_curso);

const json_autocomplete_entidad_capacitacion = {
  id_input_text: 'form_10_entidad_capacitacion_input',
  id_input_select: 'form_10_entidad_capacitacion_select',
  url_select_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/entidad_capacitacion/buscar.php',
  url_insert_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/entidad_capacitacion/crear.php',
  input_value_default: 'SIN_ENTIDAD',
  input_select_default: '1',
  input_childs: [],
};

autocomplete_with_insert_father(json_autocomplete_entidad_capacitacion);

const json_autocomplete_tipo_capacitacion = {
  id_input_text: 'form_10_tipo_capacitacion_input',
  id_input_select: 'form_10_tipo_capacitacion_select',
  url_select_ajax:
    PROTOCOL_HOST + '/clientes/administrador/assets/autocomplete/tipo_capacitacion/buscar.php',
  url_insert_ajax:
    PROTOCOL_HOST + '/clientes/administrador/assets/autocomplete/tipo_capacitacion/crear.php',
  input_value_default: 'SIN_TIPO_CAPACITACION',
  input_select_default: '1',
  input_childs: [],
};

autocomplete_with_insert_father(json_autocomplete_tipo_capacitacion);

const json_autocomplete_eps_incapacidad = {
  id_input_text: 'form_11_eps_incapacidad_input',
  id_input_select: 'form_11_eps_incapacidad_select',
  url_select_ajax:
    PROTOCOL_HOST + '/clientes/administrador/assets/autocomplete/eps_conductor/buscar_eps.php',
  url_insert_ajax:
    PROTOCOL_HOST + '/clientes/administrador/assets/autocomplete/eps_conductor/crear_eps.php',
  input_value_default: 'SIN_EPS',
  input_select_default: '1',
  input_childs: [],
};

autocomplete_with_insert_father(json_autocomplete_eps_incapacidad);

const json_autocomplete_arl_incapacidad = {
  id_input_text: 'form_11_arl_incapacidad_input',
  id_input_select: 'form_11_arl_incapacidad_select',
  url_select_ajax:
    PROTOCOL_HOST + '/clientes/administrador/assets/autocomplete/arl_conductor/buscar_arl.php',
  url_insert_ajax:
    PROTOCOL_HOST + '/clientes/administrador/assets/autocomplete/arl_conductor/crear_arl.php',
  input_value_default: 'SIN_ARL',
  input_select_default: '1',
  input_childs: [],
};

autocomplete_with_insert_father(json_autocomplete_arl_incapacidad);

const json_autocomplete_vehiculo_conductor = {
  id_input_text: 'form_12_placa_vehiculo_conductor_input',
  id_input_select: 'form_12_placa_vehiculo_conductor_select',
  url_select_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/vehiculo_conductor/buscar.php',
  url_insert_ajax:
    PROTOCOL_HOST + '/clientes/administrador/assets/autocomplete/vehiculo_conductor/crear.php',
  input_value_default: 'SIN_VEHICULO',
  input_select_default: '1',
  input_childs: [],
};

autocomplete_with_insert_father(json_autocomplete_vehiculo_conductor);

//
autocomplete_with_insert_father({
  id_input_text: 'form_13_nombre_empresa_conductor_input',
  id_input_select: 'form_13_nombre_empresa_conductor_select',
  url_select_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/empresa_general/buscar_empresa.php',
  url_insert_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/empresa_general/crear_empresa.php',
  input_value_default: 'SIN_EMPRESA',
  input_select_default: '1',
  input_childs: [],
});
autocomplete_with_insert_father({
  id_input_text: 'form_1_empresa_input',
  id_input_select: 'form_1_empresa_select',
  url_select_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/empresa_general/buscar_empresa.php',
  url_insert_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/empresa_general/crear_empresa.php',
  input_value_default: 'SIN_EMPRESA',
  input_select_default: '1',
  input_childs: [],
});
