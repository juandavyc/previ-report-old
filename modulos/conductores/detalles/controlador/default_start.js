const $id_conductor = $('meta[name="csrf-id"]').attr('content');

$('#form_1_id_conductor').val($id_conductor);

$('#form_1_eps_fecha_afiliacion_conductor').val('1800-01-01');

$('.container-datos-basicos-conductor').show();

$('#conductor_agregar_accordion').accordion({
  autoHeight: false,
  collapsible: true,
  navigation: true,
  heightStyle: 'content',
  active: 0, // Activa la primera
});

// // primera consulta para traer los DATOS BASICOS DEL CONDUCTOR (Primer Script que se ejecuta)
// if ($('#form_1_id_conductor').val() !== "") {

//     $.confirm({
//         title: "Error ",
//         content: "Cargando, espere...",
//         typeAnimated: true,
//         scrollToPreviousElement: false,
//         scrollToPreviousElementAnimate: false,

//         content: function () {
//             var self = this;
//             return $.ajax({
//                 url: PROTOCOL_HOST + '/modulos/conductores/detalles/modelo/buscar_datos_conductor_general.php',
//                 type: "POST",
//                 data: {
//                     id_conductor: $id_conductor,
//                     // 1 para la consulta de los datos basicos
//                     id_consulta: 1,
//                 },
//                 headers: {
//                     'csrf-token': $('meta[name="csrf-token"]').attr('content'),
//                 },
//                 dataType: 'json',
//                 timeout: 12000,
//             }).done(function (response) {
//                 console.log(response.message[0]);
//                 if (response.status === "bien") {

//                     self.setTitle(response.status);
//                     self.setContent(response.responseText);
//                     self.close();
//                     assign_form_data(response.message[0], "1");
//                 }
//                 else {
//                     self.setTitle(response.status);
//                     self.setContent(response.message);
//                 }

//             }).fail(function (response) {
//                 console.log("FAIL");
//                 console.log(response);
//                 self.setTitle('Error -> ');
//                 self.setContent(response.responseText);
//             });
//         },
//         buttons: {
//             aceptar: function () {

//             }
//         }
//     });

// } else {

//     //     window.location.href =
//     //         PROTOCOL_HOST +
//     //         '/modulos/conductores/visor/' ;

// }

$('#form_1_informacion_basica').append(
  '<input type="text" id="form_1_id" name="form_1_id" value="' +
    $id_conductor +
    '" autocomplete="off" required="" style="display:none">'
);
