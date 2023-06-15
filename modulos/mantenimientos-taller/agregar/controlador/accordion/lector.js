const botones_tabla = {
  botones: [
    {
      id: 'btn_info',
      icon: 'fas fa-info-circle',
    },
  ],
};
export function assign_form_data(_response, _id_consulta, _canvas) {
  //console.log(_response[0]);
  if (_id_consulta == '1') {
    $('#form_0_numero_mantenimiento_div').html(
      'Mantenimiento # ' + _response[0].id_mantenimiento
    );

    $('#form_0_mantenimiento_placa').html(_response[0].placa_vehiculo);

    $('#form_0_empresa_div').html(_response[0].nombre_empresa);

    $('#form_1_tipo_mantenimiento').val(_response[0].id_tipo_mantenimiento);
    $('#form_1_fecha_mantenimiento').val(_response[0].fecha_mantenimiento);
    $('#form_1_direccion_mantenimiento').val(
      _response[0].direccion_mantenimiento
    );
    $('#form_1_precio_mano_obra_mantenimiento').val(
      _response[0].precio_mano_obra_mantenimiento
    );
    $('#form_1_precio_repuestos_obra_mantenimiento').val(
      _response[0].precio_repuestos_mantenimiento_total
    );
    $('#form_1_cantidad_repuestos_obra_mantenimiento').val(
      _response[0].cantidad_repuestos_mantenimiento_total
    );
  } else if (_id_consulta == '2') {
    $('#form_2_repuesto_mantenimiento').val(_response[0].repuesto_a_utilizar);
    $('#form_2_fecha_inicial_mantenimiento').val(
      _response[0].fecha_inicio_mantenimiento
    );
    $('#form_2_hora_inicio_mantenimiento').html(
      _response[0].time_hora_siniestro
    );
    $('#form_2_descripcion_trabajo_a_realizar').val(
      _response[0].descripcion_trabajo_a_realizar
    );
    $('#form_2_descripcion_procedimiento_realizado').val(
      _response[0].descripcion_procedimiento_realizado
    );
    $('#form_2_fecha_final_mantenimiento').val(
      _response[0].fecha_fin_mantenimiento
    );
    $('#form_2_hora_final_mantenimiento').val(
      _response[0].time_hora_fin_siniestro
    );
    _canvas.set_image(_response[0].firma_mecanico);
  } else if (_id_consulta == '3') {
    const table_thead = [
      'id',
      'descripcion',
      'categoria',
      'usuario',
      'fecha_guardado',
      'Opciones',
    ];

    $('#form_3_fotos_resultados').html(
      '<table class="alt">' +
        '<thead>' +
        getTheadTable(table_thead, 'id', 'desc') +
        '</thead>' +
        '<tbody>' +
        getTbodyTable(_response, botones_tabla) +
        '</tbody></table>'
    );

    //eps
  } else if (_id_consulta == '4') {
    const table_thead = ['id', 'nombre', 'cantidad', 'valor', 'Opciones'];

    $('#form_4_repuestos_resultados').html(
      '<table class="alt">' +
        '<thead>' +
        getTheadTable(table_thead, 'id', 'desc') +
        '</thead>' +
        '<tbody>' +
        getTbodyTable(_response, {
          botones: [
            {
              id: 'btn_question',
              icon: 'fas fa-question',
            },
          ],
        }) +
        '</tbody></table>'
    );
  }
}
