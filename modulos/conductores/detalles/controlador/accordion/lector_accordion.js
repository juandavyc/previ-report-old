const botones_tabla = {
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
export function assign_form_data(_response, _id_consulta, _canvas) {
  // console.log(_canvas.set_image(_response.firma_conductor));
  if (_id_consulta == '1') {
    // DATOS INFORMACIOUN BASICA VEHICULO
    $('#form_0_numero_conductor_div').html('Conductor # ' + _response[0].id);
    $('#form_0_documento_conductor_div').html(_response[0].documento);
    $('#form_0_nombre_conductor_div').html(
      _response[0].nombre + ' ' + _response[0].apellido
    );

    $('#form_1_href_foto_conductor > img ').attr('src', _response[0].foto);
    $('#form_1_href_foto_conductor').attr('href', _response[0].foto);

    $('#form_1_nombre_conductor').val(_response[0].nombre);
    $('#form_1_foto_conductor').val(_response[0].foto);
    $('#form_1_apellido_conductor').val(_response[0].apellido);
    $('#form_1_documento_conductor').html(_response[0].documento);
    $('#form_1_tipo_identificacion').val(_response[0].tipo_documento);
    $('#form_1_tipo_sangre_conductor').val(_response[0].sangre);
    $('#form_1_direccion_conductor').val(_response[0].direccion);
    $('#form_1_telefono_conductor').val(_response[0].telefono);
    $('#form_1_celular_conductor').val(_response[0].celular);
    $('#form_1_whatsapp_conductor').val(_response[0].whatsapp);
    $('#form_1_correo_electronico_conductor').val(_response[0].correo);
    $('#form_1_ciudad_conductor_input').val(_response[0].nombre_ciudad);
    $('#form_1_ciudad_conductor_select').val(_response[0].id_ciudad);
    $('#form_1_departamento_conductor_input').val(
      _response[0].nombre_departamento
    );
    $('#form_1_departamento_conductor_select').val(
      _response[0].id_departamento
    );
    // empresa
    $('#form_1_empresa_input').val(_response[0].empresa);
    $('#form_1_empresa_select').val(_response[0].id_empresa);

    _canvas.set_image(_response[0].firma);
  } else if (_id_consulta == '2') {
    const table_thead = ['id', 'Nombre', 'Telefono', 'Parentesco', 'Opciones'];

    $('#form_2_contacto_emergencia_resultados').html(
      '<table class="alt">' +
        '<thead>' +
        getTheadTable(table_thead, 'id', 'desc') +
        '</thead>' +
        '<tbody>' +
        getTbodyTable(_response, botones_tabla) +
        '</tbody></table>'
    );

    //eps
  } else if (_id_consulta == '3') {
    const table_thead = [
      'id',
      'Nombre',
      'fecha_afiliacion',
      'Estado',
      'Opciones',
    ];

    $('#form_3_eps_resultados').html(
      '<table class="alt">' +
        '<thead>' +
        getTheadTable(table_thead, 'id', 'desc') +
        '</thead>' +
        '<tbody>' +
        getTbodyTable(_response, botones_tabla) +
        '</tbody></table>'
    );
    //arl
  } else if (_id_consulta == '4') {
    const table_thead = [
      'id',
      'Nombre',
      'fecha_afiliacion',
      'Estado',
      'Opciones',
    ];

    $('#form_4_arl_resultados').html(
      '<table class="alt">' +
        '<thead>' +
        getTheadTable(table_thead, 'id', 'desc') +
        '</thead>' +
        '<tbody>' +
        getTbodyTable(_response, botones_tabla) +
        '</tbody></table>'
    );
    //fondo pension
  } else if (_id_consulta == '5') {
    const table_thead = [
      'id',
      'Nombre',
      'fecha_afiliacion',
      'Estado',
      'Opciones',
    ];

    $('#form_5_fdp_resultados').html(
      '<table class="alt">' +
        '<thead>' +
        getTheadTable(table_thead, 'id', 'desc') +
        '</thead>' +
        '<tbody>' +
        getTbodyTable(_response, botones_tabla) +
        '</tbody></table>'
    );
    //Licencia
  } else if (_id_consulta == '6') {
    const table_thead = [
      'id',
      'numero',
      'expedicion',
      'vencimiento',
      'categoria_1',
      'categoria_2',
      'categoria_3',
      'categoria_4',
      'Opciones',
    ];

    $('#form_6_licencia_conductor_resultados').html(
      '<table class="alt">' +
        '<thead>' +
        getTheadTable(table_thead, 'id', 'desc') +
        '</thead>' +
        '<tbody>' +
        getTbodyTable(_response, botones_tabla) +
        '</tbody></table>'
    );
    //comparendos
  } else if (_id_consulta == '7') {
    // console.log(response);

    const table_thead = [
      'id',
      'fecha_comparendo',
      'tipo_comparendo',
      'motivo_comparendo',
      'Opciones',
    ];

    $('#form_7_comparendo_multa_sancion_resultados').html(
      '<table class="alt">' +
        '<thead>' +
        getTheadTable(table_thead, 'id', 'desc') +
        '</thead>' +
        '<tbody>' +
        getTbodyTable(_response, botones_tabla) +
        '</tbody></table>'
    );
  } else if (_id_consulta == '8') {
    // console.log(response);

    const table_thead = [
      'id',
      'expedicion',
      'vencimiento',
      'tipo_examen',
      'entidad',
      'Opciones',
    ];

    $('#form_8_examen_ocupacional_resultados').html(
      '<table class="alt">' +
        '<thead>' +
        getTheadTable(table_thead, 'id', 'desc') +
        '</thead>' +
        '<tbody>' +
        getTbodyTable(_response, botones_tabla) +
        '</tbody></table>'
    );
  } else if (_id_consulta == '9') {
    // console.log(response);

    const table_thead = [
      'id',
      'nombre_curso',
      'realizacion',
      'vencimiento',
      'entidad',
      'logro',
      'Opciones',
    ];

    $('#form_9_cursos_conductor_resultados').html(
      '<table class="alt">' +
        '<thead>' +
        getTheadTable(table_thead, 'id', 'desc') +
        '</thead>' +
        '<tbody>' +
        getTbodyTable(_response, botones_tabla) +
        '</tbody></table>'
    );
  } else if (_id_consulta == '10') {
    // console.log(response);

    const table_thead = [
      'id',
      'nombre_capacitacion',
      'realizacion',
      'tipo',
      'entidad',
      'duracion',
      'Opciones',
    ];

    $('#form_10_capacitaciones_conductor_resultados').html(
      '<table class="alt">' +
        '<thead>' +
        getTheadTable(table_thead, 'id', 'desc') +
        '</thead>' +
        '<tbody>' +
        getTbodyTable(_response, botones_tabla) +
        '</tbody></table>'
    );
  } else if (_id_consulta == '11') {
    // console.log(response);

    const table_thead = ['id', 'dias', 'concepto', 'eps', 'arl', 'Opciones'];

    $('#form_11_incapacidades_conductor_resultados').html(
      '<table class="alt">' +
        '<thead>' +
        getTheadTable(table_thead, 'id', 'desc') +
        '</thead>' +
        '<tbody>' +
        getTbodyTable(_response, botones_tabla) +
        '</tbody></table>'
    );
  } else if (_id_consulta == '12') {
    // console.log(response);
    const table_thead = [
      'id',
      'placa',
      'asignacion',
      'tipo',
      'servicio',
      'Opciones',
    ];

    $('#form_12_vehiculo_conductor_resultados').html(
      '<table class="alt">' +
        '<thead>' +
        getTheadTable(table_thead, 'id', 'desc') +
        '</thead>' +
        '<tbody>' +
        getTbodyTable(_response, botones_tabla) +
        '</tbody></table>'
    );
  } else if (_id_consulta == '13') {
    // console.log(response);
    const table_thead = [
      'id',
      'empresa',
      'contrato',
      'asignacion',
      'vencimiento',
      'Opciones',
    ];

    $('#form_13_empresa_conductor_resultados').html(
      '<table class="alt">' +
        '<thead>' +
        getTheadTable(table_thead, 'id', 'desc') +
        '</thead>' +
        '<tbody>' +
        getTbodyTable(_response, botones_tabla) +
        '</tbody></table>'
    );
  }
}
