let firma_1 = null;
export function fun_lector_canvas_elements(_firma_1) {
  firma_1 = _firma_1;
}

export function accordion_lector_datos(_response, _id_accordion) {
  console.log(_response);

  if (_id_accordion == 0) {
    // detalles
    document.title = 'Usuario - ' + _response[0].cedula + ' - Hoja de Vida ';

    $('#form_0_numero_usuario_div').html('Usuario # ' + _response[0].id);
    $('#form_0_nombre_usuario_div').html(
      _response[0].nombre + ' ' + _response[0].apellido
    );
    $('#form_0_cedula_usuario_div').html(+_response[0].cedula);

    // informacion basica del vehiculo
    $('#form_0_href_foto > img ').attr('src', _response[0].foto);
    $('#form_0_href_foto').attr('href', _response[0].foto);
    $('#form_0_foto_usuario').val(_response[0].foto);

    $('#form_0_cedula').html(_response[0].cedula);

    $('#form_0_nombre').val(_response[0].nombre);
    $('#form_0_apellido').val(_response[0].apellido);
    $('#form_0_telefono').val(_response[0].telefono);
    $('#form_0_correo').val(_response[0].correo);
    $('#form_0_fecha_nacimiento').val(
      formatdateui(_response[0].fecha_nacimiento)
    );

    $('#form_0_empresa_select').val(_response[0].id_empresa);
    $('#form_0_empresa_input').val(_response[0].empresa);

    $('#form_0_rango').val(_response[0].id_rango).change();

    $('#form_0_taller_select').val(_response[0].id_taller);
    $('#form_0_taller_input').val(_response[0].taller);

    // taller

    firma_1.set_image(_response[0].firma);
  } else if (_id_accordion == 1) {
    $('#form_1_estado_div').html('Estado actual del usuario: ' + _response[0].estado);
    $('#form_1_estado').val(_response[0].id_estado).change();
  } else if (_id_accordion == 2) {

    $('#form_2_fecha_div').html('Fecha de contraseña: ' + _response[0].fecha_contrasenia);
    // $('#form_1_estado').val(_response[0].id_estado).change();
  }

}
