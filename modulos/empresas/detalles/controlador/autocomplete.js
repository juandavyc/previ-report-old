const json_autocomplete_departamento = {
  id_input_text: 'form_0_departamento_input',
  id_input_select: 'form_0_departamento_select',
  url_select_ajax:
    PROTOCOL_HOST +
    '/modulos/assets/autocomplete/departamento_general/buscar_departamento.php',
  url_insert_ajax:
    PROTOCOL_HOST +
    '/modulos/assets/autocomplete/departamento_general/crear_departamento.php',
  input_value_default: 'SIN DEPARTAMENTO',
  input_select_default: '1',
  input_childs: [
    {
      id_input_text: 'form_1_linea_vehiculo_input',
      id_input_select: 'form_1_linea_vehiculo_select',
      input_value_default: 'SIN CIUDAD',
      input_select_default: '1',
    },
  ],
};

autocomplete_with_insert_father(json_autocomplete_departamento);

const json_autocomplete_datos_departamento = {
  id_input_text: 'form_0_ciudad_input',
  id_input_select: 'form_0_ciudad_select',
  url_select_ajax:
    PROTOCOL_HOST +
    '/modulos/assets/autocomplete/ciudad_general/buscar_ciudad.php',
  url_insert_ajax:
    PROTOCOL_HOST +
    '/modulos/assets/autocomplete/ciudad_general/crear_ciudad.php',
  input_value_default: 'SIN CIUDAD',
  input_select_default: '0',
  input_father_name: 'DEPARTAMENTO ',
  input_father_text: 'form_0_departamento_input',
  input_father_select: 'form_0_departamento_select',
};

autocomplete_with_insert_child(json_autocomplete_datos_departamento);

const json_autocomplete_entidad_certificado = {
  id_input_text: 'form_1_entidad_certificado_input',
  id_input_select: 'form_1_entidad_certificado_select',
  url_select_ajax:
    PROTOCOL_HOST +
    '/modulos/assets/autocomplete/entidad_certificados_general/buscar.php',
  url_insert_ajax:
    PROTOCOL_HOST +
    '/modulos/assets/autocomplete/entidad_certificados_general/crear.php',
  input_value_default: 'SIN ENTIDAD',
  input_select_default: '1',
  input_childs: [],
};

autocomplete_with_insert_father(json_autocomplete_entidad_certificado);

const json_autocomplete_tipo_certificado = {
  id_input_text: 'form_1_tipo_certificado_input',
  id_input_select: 'form_1_tipo_certificado_select',
  url_select_ajax:
    PROTOCOL_HOST +
    '/modulos/assets/autocomplete/tipo_certificados_general/buscar.php',
  url_insert_ajax:
    PROTOCOL_HOST +
    '/modulos/assets/autocomplete/tipo_certificados_general/crear.php',
  input_value_default: 'SIN TIPO',
  input_select_default: '1',
  input_childs: [],
};

autocomplete_with_insert_father(json_autocomplete_tipo_certificado);
