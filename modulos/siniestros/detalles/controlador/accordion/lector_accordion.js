const botones_tabla_certificado = {
  botones: [
    {
      id: 'btn_info',
      icon: 'fas fa-info-circle',
    },
  ],
};

let firma_1 = null;
export function fun_lector_canvas_elements(_firma_1) {
  firma_1 = _firma_1;
}

export function accordion_lector_datos(_response, _id_accordion) {
  //////////////////////////////////
  //// INFORMACION DEL VEHICULO
  // ///////////////////////////////
  if (_id_accordion == 0) {
    // detalles
    document.title = 'Siniestro # ' + _response[0].id + ' - Hoja de Vida ';
    // informacion basica del vehiculo

    $('#form_0_numero_siniestro_div').html('Siniestro # ' + _response[0].id);
    $('#form_0_placa_siniestro_div').html(_response[0].placa);
    $('#form_0_conductor_siniestro_div').html(_response[0].nombre_conductor);
    $('#form_0_empresa_div').html(_response[0].nombre_empresa);

    $('#form_0_placa').html(_response[0].placa);
    $('#form_0_conductor').html(_response[0].nombre_conductor);

    $('#form_0_tipo').val(_response[0].id_tipo);
    $('#form_0_fecha').val(formatdateui(_response[0].fecha_siniestro));
    $('#form_0_hora').val(_response[0].hora);
    // autocomplete
    $('#form_0_departamento_select').val(_response[0].id_departamento);
    $('#form_0_departamento_input').val(_response[0].departamento);

    $('#form_0_ciudad_select').val(_response[0].id_ciudad);
    $('#form_0_ciudad_input').val(_response[0].ciudad);

    $('#form_0_lugar').val(_response[0].direccion);
    $('#form_0_heridos').val(_response[0].heridos);
    $('#form_0_muertos').val(_response[0].muertos);
    $('#form_0_vehiculos_implicados').val(_response[0].implicados_siniestro);
    $('#form_0_descripcion').val(_response[0].descripcion);

    $('#form_0_foto_1').val(_response[0].foto_1);
    $('#form_0_foto_2').val(_response[0].foto_2);
    $('#form_0_foto_3').val(_response[0].foto_3);
    $('#form_0_foto_4').val(_response[0].foto_4);

    // SRC IMAGE
    $('#form_0_foto_1_href > img ').attr('src', _response[0].foto_1);
    $('#form_0_foto_2_href > img ').attr('src', _response[0].foto_2);
    $('#form_0_foto_3_href > img ').attr('src', _response[0].foto_3);
    $('#form_0_foto_4_href > img ').attr('src', _response[0].foto_4);
    // HREF
    $('#form_0_foto_1_href').attr('href', _response[0].foto_1);
    $('#form_0_foto_2_href').attr('href', _response[0].foto_2);
    $('#form_0_foto_3_href').attr('href', _response[0].foto_3);
    $('#form_0_foto_4_href').attr('href', _response[0].foto_4);

    firma_1.set_image(_response[0].firma);
    //
  } else if (_id_accordion == 1) {
    $('#form_1_agentes_resultados').html(
      '<table class="alt">' +
        '<thead>' +
        getTheadTable(
          ['Nro', 'Nombre', 'Telefono', 'Correo', 'Opciones'],
          'Nro',
          'desc'
        ) +
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
  } else if (_id_accordion == 2) {
    $('#form_2_testigos_resultados').html(
      '<table class="alt">' +
        '<thead>' +
        getTheadTable(
          ['Nro', 'Nombre', 'Telefono', 'Correo', 'Direccion', 'Opciones'],
          'Nro',
          'desc'
        ) +
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
  } else if (_id_accordion == 3) {
    $('#form_3_vehiculos_resultados').html(
      '<table class="alt">' +
        '<thead>' +
        getTheadTable(
          ['Nro', 'Placa', 'Marca', 'Conductor', 'Aseguradora', 'Opciones'],
          'Nro',
          'desc'
        ) +
        '</thead>' +
        '<tbody>' +
        getTbodyTable(_response, {
          botones: [
            {
              id: 'btn_info',
              icon: 'fas fa-info-circle',
            },
          ],
        }) +
        '</tbody></table>'
    );
  }
}
