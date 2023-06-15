

const json_autocomplete_departamentoo = {
  id_input_text: 'form_0_departamento_input',
  id_input_select: 'form_0_departamento_select',
  url_select_ajax:
    PROTOCOL_HOST + 
    '/modulos/assets/autocomplete/departamento_general/buscar_departamento.php',
  url_insert_ajax:
    PROTOCOL_HOST +
    '/modulos/assets/autocomplete/departamento_general/crear_departamento.php',
  input_value_default: 'SIN_DEPARTAMENTO',
  input_select_default: '0',
  input_childs: [
    {
      id_input_text: 'form_0_ciudad_input',
      id_input_select: 'form_0_ciudad_select',
      input_value_default: 'SIN_CIUDAD',
      input_select_default: '0',
    },
  ],
};

autocomplete_with_insert_father(json_autocomplete_departamentoo);

const json_autocomplete_ciudadd = {
  id_input_text: 'form_0_ciudad_input',
  id_input_select: 'form_0_ciudad_select',
  url_select_ajax:
    PROTOCOL_HOST +
    '/modulos/assets/autocomplete/ciudad_general/buscar_ciudad.php',
  url_insert_ajax:
    PROTOCOL_HOST +
    '/modulos/assets/autocomplete/ciudad_general/crear_ciudad.php',
  input_value_default: 'SIN_CIUDAD',
  input_select_default: '0',
  input_father_name: 'DEPARTAMENTO ',
  input_father_text: 'form_0_departamento_input',
  input_father_select: 'form_0_departamento_select',
};

autocomplete_with_insert_child(json_autocomplete_ciudadd);
