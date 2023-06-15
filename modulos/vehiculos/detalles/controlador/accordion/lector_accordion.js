const botones_tabla_certificado = {
  botones: [
    {
      id: 'btn_info',
      icon: 'fas fa-info-circle',
    },
    {
      id: 'btn_delete',
      icon: 'fas fa-times',
    },
  ],
};

export function accordion_lector_datos(_response, _id_accordion) {
  console.log(_response);
  if (_id_accordion == 1) {
    // detalles
    document.title = 'Vehículo - ' + _response[0].placa + ' - Hoja de Vida ';

    // informacion basica del vehiculo

    $('#form_0_numero_vehiculo_div').html('Vehiculo # ' + _response[0].id);
    $('#form_0_clase_vehiculo_div').html(_response[0].clase);

    $('#form_0_placa, #form_1_placa').html(_response[0].placa);

    $('#form_1_fecha_matricula').val(
      formatdateui(_response[0].fecha_matricula)
    );
    $('#form_1_licencia_transito').val(_response[0].numero_licencia);

    // Dispara el evento change
    $('#form_1_tipo_vehiculo').val(_response[0].id_tipo).change();

    $('#form_1_servicio_vehiculo').val(_response[0].id_servicio);

    $('#form_1_empresa_input').val(_response[0].nombre_empresa);
    $('#form_1_empresa_select').val(_response[0].id_empresa);

    $('#form_1_clase_vehiculo_input').val(_response[0].clase);
    $('#form_1_clase_vehiculo_select').val(_response[0].id_clase);
    // informacion detallada del vehiculo
    $('#form_1_marca_vehiculo_input').val(_response[0].marca);
    $('#form_1_marca_vehiculo_select').val(_response[0].id_marca);

    $('#form_1_linea_vehiculo_input').val(_response[0].linea);
    $('#form_1_linea_vehiculo_select').val(_response[0].id_linea);

    $('#form_1_modelo_vehiculo').val(_response[0].modelo);

    $('#form_1_color_vehiculo_input').val(_response[0].color);
    $('#form_1_color_vehiculo_select').val(_response[0].id_color);

    $('#form_1_serie_vehiculo').val(_response[0].numero_serie);
    $('#form_1_motor_vehiculo').val(_response[0].numero_motor);

    $('#form_1_vin_vehiculo').val(_response[0].vin);
    $('#form_1_cilindraje_vehiculo').val(_response[0].cilindraje);
    // $('#form_1_potencia_vehiculo').val(_response[0].potencia_vehiculo);
    $('#form_1_kilometraje_vehiculo').val(_response[0].kilometraje);

    $('#form_1_carroceria_vehiculo_input').val(_response[0].carroceria);
    $('#form_1_carroceria_vehiculo_select').val(_response[0].id_carroceria);

    $('#form_1_combustible_vehiculo').val(_response[0].id_combustible);

    if (_response[0].gravamene == '1') {
      $('#form_1_gravamenes_a_la_propiedad_si').prop('checked', true);
    } else {
      $('#form_1_gravamenes_a_la_propiedad_no').prop('checked', true);
    }

    if (_response[0].clasico_antiguo == '1') {
      $('#form_1_clasico_o_antiguo_si').prop('checked', true);
    } else {
      $('#form_1_clasico_o_antiguo_no').prop('checked', true);
    }

    if (_response[0].repotenciado == '1') {
      $('#form_1_repotenciado_si').prop('checked', true);
    } else {
      $('#form_1_repotenciado_no').prop('checked', true);
    }

    if (_response[0].ensenianza == '1') {
      $('#form_1_vehiculo_ensenianza_si').prop('checked', true);
    } else {
      $('#form_1_vehiculo_ensenianza_no').prop('checked', true);
    }

    if (_response[0].regrabacion_motor == '1') {
      $('#form_1_regrabacion_motor_si').prop('checked', true);
      $('#form_1_numero_regrabacion_motor').val(
        _response[0].numero_regrabacion_motor
      );
    } else {
      $('#form_1_regrabacion_motor_no').prop('checked', true);
      // $('#form_1_numero_regrabacion_motor').val('NO')
    }

    if (_response[0].regrabacion_chasis == '1') {
      $('#form_1_regrabacion_chasis_si').prop('checked', true);
      $('#form_1_numero_regrabacion_chasis').val(
        _response[0].numero_regrabacion_chasis
      );
    } else {
      $('#form_1_regrabacion_chasis_no').prop('checked', true);
      // $('#form_1_numero_regrabacion_motor').val('NO')
    }

    if (_response[0].regrabacion_serie == '1') {
      $('#form_1_regrabacion_serie_si').prop('checked', true);
      $('#form_1_numero_regrabacion_serie').val(
        _response[0].numero_regrabacion_serie
      );
    } else {
      $('#form_1_regrabacion_serie_no').prop('checked', true);
      // $('#form_1_numero_regrabacion_motor').val('NO')
    }

    if (_response[0].regrabacion_serie == '1') {
      $('#form_1_regrabacion_vin_si').prop('checked', true);
      $('#form_1_numero_regrabacion_vin').val(
        _response[0].numero_regrabacion_vin
      );
    } else {
      $('#form_1_regrabacion_vin_no').prop('checked', true);
      // $('#form_1_numero_regrabacion_motor').val('NO')
    }

    $('#form_1_autoridad_de_transito_input').val(
      _response[0].autoridad_de_transito
    );
    $('#form_1_autoridad_de_transito_select').val(
      _response[0].id_autoridad_de_transito
    );

    // pintar la placa
    $('#form_0_placa')
      .removeClass()
      .addClass(vh_placa_css(_response[0].id_servicio));
  } else if (_id_accordion == 2) {
    const table_thead = [
      'nro',
      'Certificado',
      'Expedicion',
      'Vencimiento',
      'CDA',
      'Opciones',
    ];

    $('#form_2_certificado_rtm_resultados').html(
      '<table class="alt">' +
        '<thead>' +
        getTheadTable(table_thead, 'nro', 'desc') +
        '</thead>' +
        '<tbody>' +
        getTbodyTable(_response, botones_tabla_certificado) +
        '</tbody></table>'
    );
  } else if (_id_accordion == 3) {
    const table_thead = [
      'nro',
      'Póliza',
      'Expedicion',
      'Vencimiento',
      'Aseguradora',
      'Opciones',
    ];

    $('#form_3_poliza_soat_resultados').html(
      '<table class="alt">' +
        '<thead>' +
        getTheadTable(table_thead, 'nro', 'desc') +
        '</thead>' +
        '<tbody>' +
        getTbodyTable(_response, botones_tabla_certificado) +
        '</tbody></table>'
    );
  } else if (_id_accordion == 4) {
    $('#form_4_capacidad_de_carga').val(_response[0].capacidad_carga);
    $('#form_4_peso_bruto_vehicular').val(_response[0].peso_bruto);
    $('#form_4_capacidad_de_pasajeros').val(_response[0].capacidad_pasajeros);
    $('#form_4_capacidad_de_pasajeros_sentados').val(
      _response[0].capacidad_pasajeros_sentados
    );
    $('#form_4_numero_de_ejes').val(_response[0].numero_ejes);
  } else if (_id_accordion == 5) {
    const table_thead = [
      'nro',
      'Numero',
      'Expedicion',
      'Vencimiento',
      'Lugar',
      'Opciones',
    ];

    $('#form_5_revision_preventiva_resultados').html(
      '<table class="alt">' +
        '<thead>' +
        getTheadTable(table_thead, 'nro', 'desc') +
        '</thead>' +
        '<tbody>' +
        getTbodyTable(_response, botones_tabla_certificado) +
        '</tbody></table>'
    );
  } else if (_id_accordion == 6) {
    const table_thead = [
      'nro',
      'Empresa',
      'Numero',
      'Expedicion',
      'Vecimiento',
      'Estado',
      'Opciones',
    ];

    $('#form_6_tarjeta_de_operacion_resultados').html(
      '<table class="alt">' +
        '<thead>' +
        getTheadTable(table_thead, 'nro', 'desc') +
        '</thead>' +
        '<tbody>' +
        getTbodyTable(_response, botones_tabla_certificado) +
        '</tbody></table>'
    );
  } else if (_id_accordion == 7) {
    const table_thead = [
      'id',
      'Numero',
      'Aseguradora',
      'Tipo',
      'Expedicion',
      'vecimiento',
      'opciones',
    ];

    $('#form_7_polizas_resultados').html(
      '<table class="alt">' +
        '<thead>' +
        getTheadTable(table_thead, 'id', 'desc') +
        '</thead>' +
        '<tbody>' +
        getTbodyTable(_response, botones_tabla_certificado) +
        '</tbody></table>'
    );
  } else if (_id_accordion == 8) {
    const table_thead = [
      'id',
      'Numero',
      'Entidad',
      'Tipo',
      'Expedicion',
      'vecimiento',
      'opciones',
    ];

    $('#form_8_certificados_resultados').html(
      '<table class="alt">' +
        '<thead>' +
        getTheadTable(table_thead, 'id', 'desc') +
        '</thead>' +
        '<tbody>' +
        getTbodyTable(_response, botones_tabla_certificado) +
        '</tbody></table>'
    );
  } else if (_id_accordion == 9) {
    const table_thead = [
      'id',
      'Numero',
      'Entidad',
      'Tipo',
      'Fecha Solicitud',
      'Estado',
      'Opciones',
    ];

    $('#form_9_solicitudes_resultados').html(
      '<table class="alt">' +
        '<thead>' +
        getTheadTable(table_thead, 'id', 'desc') +
        '</thead>' +
        '<tbody>' +
        getTbodyTable(_response, botones_tabla_certificado) +
        '</tbody></table>'
    );
  } else if (_id_accordion == 10) {
    console.log(_response[0]);
    // SRC IMAGE
    $('#form_10_href_delantera > img ').attr(
      'src',
      _response[0].foto_delantera
    );

    $('#form_10_href_costado_izquierdo > img ').attr(
      'src',
      _response[0].foto_costado_izquierdo
    );

    $('#form_10_href_trasera > img ').attr('src', _response[0].foto_trasera);
    $('#form_10_href_costado_derecho > img ').attr(
      'src',
      _response[0].foto_costado_derecho
    );
    // HREF
    $('#form_10_href_delantera').attr('href', _response[0].foto_delantera);

    $('#form_10_href_costado_izquierdo').attr(
      'href',
      _response[0].foto_costado_izquierdo
    );

    $('#form_10_href_trasera').attr('href', _response[0].foto_trasera);
    $('#form_10_href_costado_derecho').attr(
      'href',
      _response[0].foto_costado_derecho
    );

    // valores formulario
    $('#form_10_foto_delantera').val(_response[0].foto_delantera);
    $('#form_10_foto_costado_izquierdo').val(
      _response[0].foto_costado_izquierdo
    );
    $('#form_10_foto_trasera').val(_response[0].foto_trasera);
    $('#form_10_foto_costado_derecho').val(_response[0].foto_costado_derecho);
  } else if (_id_accordion == 11) {
      
      
    $('#form_11_href_chasis > img ').attr('src', _response[0].impronta_chasis);
    $('#form_11_href_serial > img ').attr('src', _response[0].impronta_serial);
    $('#form_11_href_motor > img ').attr('src', _response[0].impronta_motor);
    $('#form_11_href_impronta_opcional_1 > img ').attr('src', _response[0].impronta_opcional_1);
    $('#form_11_href_impronta_opcional_2 > img ').attr('src', _response[0].impronta_opcional_2);
    $('#form_11_href_impronta_opcional_3 > img ').attr('src', _response[0].impronta_opcional_3);

    // HREF
    $('#form_11_href_chasis').attr('href', _response[0].impronta_chasis);
    $('#form_11_href_serial').attr('href', _response[0].impronta_serial);
    $('#form_11_href_motor').attr('href', _response[0].impronta_motor);
    $('#form_11_href_impronta_opcional_1').attr('href', _response[0].impronta_opcional_1);
    $('#form_11_href_impronta_opcional_2').attr('href', _response[0].impronta_opcional_2);
    $('#form_11_href_impronta_opcional_3').attr('href', _response[0].impronta_opcional_3);

    // valores formulario
    $('#form_11_chasis').val(_response[0].impronta_chasis);
    $('#form_11_serial').val(_response[0].impronta_serial);
    $('#form_11_motor').val(_response[0].impronta_motor);
    $('#form_11_opcional_1').val(_response[0].impronta_opcional_1);
    $('#form_11_opcional_2').val(_response[0].impronta_opcional_2);
    $('#form_11_opcional_3').val(_response[0].impronta_opcional_3);
    
    
  } else if (_id_accordion == 12) {
    // SRC IMAGE

    $('#form_12_href_licencia_delantera > img ').attr(
      'src',
      _response[0].licencia_transito_delantera
    );
    $('#form_12_href_licencia_trasera > img ').attr(
      'src',
      _response[0].licencia_transito_trasera
    );

    // HREF
    $('#form_12_href_licencia_delantera').attr(
      'href',
      _response[0].licencia_transito_delantera
    );
    $('#form_12_href_licencia_trasera').attr(
      'href',
      _response[0].licencia_transito_trasera
    );
    // valores formulario
    $('#form_12_delantera').val(_response[0].licencia_transito_delantera);
    $('#form_12_trasera').val(_response[0].licencia_transito_trasera);
  }
}
