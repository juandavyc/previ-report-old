
export function accordion_lector_datos(_response, _id_accordion) {
  console.log(_response);
  if (_id_accordion == 0) {
    // detalles
    document.title = 'Taller - ' + _response[0].nit + ' - Hoja de Vida ';
    // informacion basica del vehiculo

    $('#form_0_numero_taller_div').html('Taller # ' + _response[0].id);
    $('#form_0_nombre_taller_div').html(_response[0].nombre);
    $('#form_0_nit_taller_div').html(_response[0].nit);

    $('#form_0_nit').html(_response[0].nit);

    $('#form_0_nombre').val(_response[0].nombre);
    $('#form_0_telefono').val(_response[0].telefono);
    $('#form_0_direccion').val(_response[0].direccion);
    $('#form_0_correo').val(_response[0].correo);

    $('#form_0_departamento_input').val(_response[0].departamento);
    $('#form_0_departamento_select').val(_response[0].id_departamento);

    $('#form_0_ciudad_input').val(_response[0].ciudad);
    $('#form_0_ciudad_select').val(_response[0].id_ciudad);
  }
}
