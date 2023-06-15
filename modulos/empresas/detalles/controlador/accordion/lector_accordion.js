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
  //////////////////////////////////
  //// INFORMACION DEL VEHICULO
  // //////////////////////////////////
  // $global_placa = _response[0].placa_vehiculo;

  if (_id_accordion == 0) {
    // detalles
    document.title = 'Empresa - ' + _response[0].nit + ' - Hoja de Vida ';
    // informacion basica del vehiculo

    $('#form_0_numero_empresa_div').html('Empresa # ' + _response[0].id);
    $('#form_0_nombre_empresa_div').html(_response[0].nombre);
    $('#form_0_nit_empresa_div').html(_response[0].nit);

    $('#form_0_nit').html(_response[0].nit);
    $('#form_0_nombre').val(_response[0].nombre);

    $('#form_0_telefono').val(_response[0].telefono);
    $('#form_0_direccion').val(_response[0].direccion);
    $('#form_0_correo').val(_response[0].correo);
    // departamento
    $('#form_0_departamento_select').val(_response[0].id_departamento);
    $('#form_0_departamento_input').val(_response[0].departamento);
    $('#form_0_ciudad_select').val(_response[0].id_ciudad);
    $('#form_0_ciudad_input').val(_response[0].ciudad);
  } else if (_id_accordion == 1) {
    $('#form_1_certificado_resultados').html(
      '<table class="alt">' +
        '<thead>' +
        getTheadTable(
          [
            'nro',
            'Tipo',
            'Numero',
            'Entidad',
            'Fecha exp',
            'Fecha ven',
            'opciones',
          ],
          'nro',
          'desc'
        ) +
        '</thead>' +
        '<tbody>' +
        getTbodyTable(_response, botones_tabla_certificado) +
        '</tbody></table>'
    );
  } else if (_id_accordion == 2) {
    $('#form_2_estado_div').html(
      'Estado actual de la empresa: ' + _response[0].estado
    );
    $('#form_2_estado').val(_response[0].id_estado).change();
  }
}
