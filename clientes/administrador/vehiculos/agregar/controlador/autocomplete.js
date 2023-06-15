// form 1 -> informacion

autocomplete_with_insert_father({
  id_input_text: 'form_1_empresa_input',
  id_input_select: 'form_1_empresa_select',
  url_select_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/empresa_general/buscar_empresa.php',
  url_insert_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/empresa_general/crear_empresa.php',
  input_value_default: 'SIN EMPRESA',
  input_select_default: '1',
  input_childs: [],
});

autocomplete_with_insert_father({
  id_input_text: 'form_1_clase_vehiculo_input',
  id_input_select: 'form_1_clase_vehiculo_select',
  url_select_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/clase_vehiculo/buscar_clase.php',
  url_insert_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/clase_vehiculo/crear_clase.php',
  input_value_default: 'SIN CLASE',
  input_select_default: '1',
  input_childs: [],
});

autocomplete_with_insert_father({
  id_input_text: 'form_1_marca_vehiculo_input',
  id_input_select: 'form_1_marca_vehiculo_select',
  url_select_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/marca_vehiculo/buscar_marca.php',
  url_insert_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/marca_vehiculo/crear_marca.php',
  input_value_default: 'SIN MARCA',
  input_select_default: '0',
  input_childs: [
    {
      id_input_text: 'form_1_linea_vehiculo_input',
      id_input_select: 'form_1_linea_vehiculo_select',
      input_value_default: 'SIN LINEA',
      input_select_default: '0',
    },
  ],
});

autocomplete_with_insert_child({
  id_input_text: 'form_1_linea_vehiculo_input',
  id_input_select: 'form_1_linea_vehiculo_select',
  url_select_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/linea_vehiculo/buscar_linea.php',
  url_insert_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/linea_vehiculo/crear_linea.php',
  input_value_default: 'SIN LINEA',
  input_select_default: '0',
  input_father_name: 'MARCA ',
  input_father_text: 'form_1_marca_vehiculo_input',
  input_father_select: 'form_1_marca_vehiculo_select',
});

autocomplete_with_insert_father({
  id_input_text: 'form_1_color_vehiculo_input',
  id_input_select: 'form_1_color_vehiculo_select',
  url_select_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/color_general/buscar_color.php',
  url_insert_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/color_general/crear_color.php',
  input_value_default: 'SIN COLOR',
  input_select_default: '1',
  input_childs: [],
});

autocomplete_with_insert_father({
  id_input_text: 'form_1_carroceria_vehiculo_input',
  id_input_select: 'form_1_carroceria_vehiculo_select',
  url_select_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/carroceria_vehiculo/buscar_carroceria.php',
  url_insert_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/carroceria_vehiculo/crear_carroceria.php',
  input_value_default: 'SIN CARROCERIA',
  input_select_default: '1',
  input_childs: [],
});

autocomplete_with_insert_father({
  id_input_text: 'form_1_autoridad_de_transito_input',
  id_input_select: 'form_1_autoridad_de_transito_select',
  url_select_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/autoridad_transito/buscar_autoridad_transito.php',
  url_insert_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/autoridad_transito/crear_autoridad_transito.php',
  input_value_default: 'SIN AUTORIDAD DE TRANSITO',
  input_select_default: '1',
  input_childs: [],
});

// form 2 -> rtm

autocomplete_with_insert_father({
  id_input_text: 'form_2_nombre_cda_input',
  id_input_select: 'form_2_nombre_cda_select',
  url_select_ajax:
    PROTOCOL_HOST + '/clientes/administrador/assets/autocomplete/cda_general/buscar_cda.php',
  url_insert_ajax:
    PROTOCOL_HOST + '/clientes/administrador/assets/autocomplete/cda_general/crear_cda.php',
  input_value_default: 'SIN CDA',
  input_select_default: '1',
  input_childs: [],
});

// form 3 -> soat

autocomplete_with_insert_father({
  id_input_text: 'form_3_aseguradora_soat_input',
  id_input_select: 'form_3_aseguradora_soat_select',
  url_select_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/aseguradora_soat_general/buscar_aseguradora_soat.php',
  url_insert_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/aseguradora_soat_general/crear_aseguradora_soat.php',
  input_value_default: 'SIN ASEGURADORA',
  input_select_default: '1',
  input_childs: [],
});

// form 5 -> preventiva

autocomplete_with_insert_father({
  id_input_text: 'form_5_nombre_preventiva_input',
  id_input_select: 'form_5_nombre_preventiva_select',
  url_select_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/preventiva_vehiculo/buscar_preventiva.php',
  url_insert_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/preventiva_vehiculo/crear_preventiva.php',
  input_value_default: 'SIN LUGAR PREVENTIVA',
  input_select_default: '1',
  input_childs: [],
});

// form 6 -> tarjeta_de_operacion

autocomplete_with_insert_father({
  id_input_text: 'form_6_nombre_empresa_afiliadora_input',
  id_input_select: 'form_6_nombre_empresa_afiliadora_select',
  url_select_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/empresa_general/buscar_empresa.php',
  url_insert_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/empresa_general/crear_empresa.php',
  input_value_default: 'SIN EMPRESA',
  input_select_default: '1',
  input_childs: [],
});

autocomplete_with_insert_father({
  id_input_text: 'form_6_modalidad_transporte_input',
  id_input_select: 'form_6_modalidad_transporte_select',
  url_select_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/modalidad_transporte_general/buscar.php',
  url_insert_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/modalidad_transporte_general/crear.php',
  input_value_default: 'SIN MODALIDAD TRANSPORTE',
  input_select_default: '1',
  input_childs: [],
});

autocomplete_with_insert_father({
  id_input_text: 'form_6_radio_de_accion_input',
  id_input_select: 'form_6_radio_de_accion_select',
  url_select_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/rango_de_accion_general/buscar.php',
  url_insert_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/rango_de_accion_general/crear.php',
  input_value_default: 'SIN RADIO ACCION',
  input_select_default: '1',
  input_childs: [],
});

autocomplete_with_insert_father({
  id_input_text: 'form_6_modalidad_servicio_input',
  id_input_select: 'form_6_modalidad_servicio_select',
  url_select_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/modalidad_servicio_general/buscar.php',
  url_insert_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/modalidad_servicio_general/crear.php',
  input_value_default: 'SIN MODALIDAD SERVICIO',
  input_select_default: '1',
  input_childs: [],
});

// form 7 -> polizas

autocomplete_with_insert_father({
  id_input_text: 'form_7_aseguradora_input',
  id_input_select: 'form_7_aseguradora_select',
  url_select_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/aseguradora_poliza_general/buscar.php',
  url_insert_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/aseguradora_poliza_general/crear.php',
  input_value_default: 'SIN_EMPRESA',
  input_select_default: '1',
  input_childs: [],
});

autocomplete_with_insert_father({
  id_input_text: 'form_7_tipo_poliza_input',
  id_input_select: 'form_7_tipo_poliza_select',
  url_select_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/tipo_poliza_general/buscar.php',
  url_insert_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/tipo_poliza_general/crear.php',
  input_value_default: 'SIN_TIPO_POLIZA',
  input_select_default: '1',
  input_childs: [],
});

// form 8 -> certificado

autocomplete_with_insert_father({
  id_input_text: 'form_8_entidad_certificado_input',
  id_input_select: 'form_8_entidad_certificado_select',
  url_select_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/entidad_certificados_general/buscar.php',
  url_insert_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/entidad_certificados_general/crear.php',
  input_value_default: 'SIN_ENTIDAD',
  input_select_default: '1',
  input_childs: [],
});

autocomplete_with_insert_father({
  id_input_text: 'form_8_tipo_certificado_input',
  id_input_select: 'form_8_tipo_certificado_select',
  url_select_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/tipo_certificados_general/buscar.php',
  url_insert_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/tipo_certificados_general/crear.php',
  input_value_default: 'SIN_TIPO',
  input_select_default: '1',
  input_childs: [],
});

// form -> 9 solicitud

autocomplete_with_insert_father({
  id_input_text: 'form_9_entidad_transito_input',
  id_input_select: 'form_9_entidad_transito_select',
  url_select_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/entidad_transito_general/buscar.php',
  url_insert_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/entidad_transito_general/crear.php',
  input_value_default: 'SIN ENTIDAD TRANSITO',
  input_select_default: '1',
  input_childs: [],
});

autocomplete_with_insert_father({
  id_input_text: 'form_9_tipo_solicitud_input',
  id_input_select: 'form_9_tipo_solicitud_select',
  url_select_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/tipo_solicitud_general/buscar.php',
  url_insert_ajax:
    PROTOCOL_HOST +
    '/clientes/administrador/assets/autocomplete/tipo_solicitud_general/crear.php',
  input_value_default: 'SIN ENTIDAD TRANSITO',
  input_select_default: '1',
  input_childs: [],
});
