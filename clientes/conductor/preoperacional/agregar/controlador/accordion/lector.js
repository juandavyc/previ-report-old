// const botones_tabla = {
//     botones: [
//       {
//         id: 'btn_info',
//         icon: 'fas fa-info-circle',
//       },
//     ],
//   };
export function assign_form_data(_response, _id_consulta, _canvas) {
    //   console.log(_response[0]);
    
    if (_id_consulta == '1') {
        
        
        $('#form_0_placa_preoperativo').html(_response[0].placa_vehiculo);

        $('#form_0_numero_preoperativo').html('PREOPERATIVO #'+_response[0].id_preoperacional);



        if (_response[0].tarjeta_propiedad_vigencia == '1') {
            $('#form_1_vigencia_tarjeta_propiedad_si').prop('checked', true);
        } else if (_response[0].tarjeta_propiedad_vigencia == '2') {
            $('#form_1_vigencia_tarjeta_propiedad_no').prop('checked', true);
        } else {
            $('#form_1_vigencia_tarjeta_propiedad_no_aplica').prop('checked', true);
        }

        $('#form_1_fecha_vencimiento_tarjeta_propiedad').val(_response[0].tarjeta_propiedad_fecha);
        $('#form_1_entidad_tarjeta_propiedad').val(_response[0].tarjeta_propiedad_entidad);
      
    

        if (_response[0].revision_rtm_vigencia == '1') {
            $('#form_1_vigencia_rtm_si').prop('checked', true);
        } else if (_response[0].revision_rtm_vigencia == '2') {
            $('#form_1_vigencia_rtm_no').prop('checked', true);
        } else {
            $('#form_1_vigencia_rtm_no_aplica').prop('checked', true);
        }

        $('#form_1_fecha_vencimiento_rtm').val(_response[0].revision_rtm_fecha);
        $('#form_1_entidad_rtm').val(_response[0].revision_rtm_entidad);
      

        
        if (_response[0].certificado_gases_vigencia == '1') {
            $('#form_1_vigencia_certificado_gases_si').prop('checked', true);
        } else if (_response[0].certificado_gases_vigencia == '2') {
            $('#form_1_vigencia_certificado_gases_no').prop('checked', true);
        } else {
            $('#form_1_vigencia_certificado_gases_no_aplica').prop('checked', true);
        }

        $('#form_1_fecha_vencimiento_gases').val(_response[0].certificado_gases_fecha);
        $('#form_1_entidad_gases').val(_response[0].certificado_gases_entidad);
      


        if (_response[0].planilla_fuec_vigencia == '1') {
            $('#form_1_vigencia_fuec_si').prop('checked', true);
        } else if (_response[0].planilla_fuec_vigencia == '2') {
            $('#form_1_vigencia_fuec_no').prop('checked', true);
        } else {
            $('#form_1_vigencia_fuec_no_aplica').prop('checked', true);
        }

        $('#form_1_fecha_vencimiento_fuec').val(_response[0].planilla_fuec_fecha);
        $('#form_1_expide_fuec').val(_response[0].planilla_fuec_entidad);
      


        if (_response[0].licencia_conduccion_vigencia == '1') {
            $('#form_1_vigencia_licencia_conduccion_si').prop('checked', true);
        } else if (_response[0].licencia_conduccion_vigencia == '2') {
            $('#form_1_vigencia_licencia_conduccion_no').prop('checked', true);
        } else {
            $('#form_1_vigencia_licencia_conduccion_no_aplica').prop('checked', true);
        }

        $('#form_1_fecha_vencimiento_licencia_conductor').val(_response[0].licencia_conduccion_fecha);
        $('#form_1_entidad_licencia_conduccion').val(_response[0].licencia_conduccion_entidad);
      


        if (_response[0].poliza_vigencia == '1') {
            $('#form_1_vigencia_poliza_si').prop('checked', true);
        } else if (_response[0].poliza_vigencia == '2') {
            $('#form_1_vigencia_poliza_no').prop('checked', true);
        } else {
            $('#form_1_vigencia_poliza_no_aplica').prop('checked', true);
        }

        $('#form_1_fecha_vencimiento_poliza').val(_response[0].poliza_fecha);
        $('#form_1_entidad_poliza').val(_response[0].poliza_entidad);
      


        if (_response[0].poliza_soat_vigencia == '1') {
            $('#form_1_vigencia_soat_si').prop('checked', true);
        } else if (_response[0].poliza_soat_vigencia == '2') {
            $('#form_1_vigencia_soat_no').prop('checked', true);
        } else {
            $('#form_1_vigencia_soat_no_aplica').prop('checked', true);
        }

        $('#form_1_fecha_vencimiento_poliza_soat').val(_response[0].poliza_soat_fecha);
        $('#form_1_entidad_poliza_soat').val(_response[0].poliza_soat_entidad);

        $('#form_1_foto_tacometro_kilometraje').val(_response[0].foto_tacometro_kilometraje);
        $('#form_1_foto_tacometro_combustible').val(_response[0].foto_tacometro_combustible);
      

    }


}
