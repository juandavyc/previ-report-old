import './autocomplete.js';
import { fun_accordion_busqueda } from './accordion.js';
import { fun_informacion_empresa_accordion } from './from_informacion_empresa.js';
import { fun_certificado_accordion } from './form_certificado.js';
import { fun_estado_accordion } from './form_estado.js';

let return_camera = fun_camera_photo(
  'https://' +
    $(location).attr('host') +
    '/modulos/empresas/detalles/index.php?id=' +
    $('meta[name="csrf-id"]').attr('content'),
  $('meta[name="csrf-id"]').attr('content'),
  0
);

if (return_camera == true) {
  // habeas_data();
  fun_accordion_busqueda(0, false);
  fun_informacion_empresa_accordion(fun_accordion_busqueda);
  fun_certificado_accordion(fun_accordion_busqueda);
  fun_estado_accordion(fun_accordion_busqueda);
}

// $.confirm({
//   title: 'HABEAS DATA',
//   content: `<div class="habeas-data-chimbo">
//   <center>
//   AUTORIZACIÓN PARA EL TRATAMIENTO DE DATOS PERSONALES<br>
// </center>
// <br>

//   De conformidad con lo definido por la Ley 1581 de 2012, el Decreto Reglamentario 1377 de 2013, la Circular Externa 002 de 2015 expedida por la Superintendencia de Industria y Comercio:

//       Autorizo de manera libre, voluntaria, previa, explícita, informada e inequívoca al PREVENTIVA DE AUTOS SAS para que en los términos legalmente establecidos realice la recolección, almacenamiento, uso, circulación, supresión y en general, el tratamiento de los datos personales que he procedido a entregar o que entregaré, en virtud de las relaciones legales, contractuales, comerciales y/o de cualquier otra que surja, en desarrollo y ejecución de los fines descritos en el presente documento.

//       Realice la recolección, almacenamiento, uso, circulación, supresión, y en general, tratamiento de mis datos personales, incluyendo datos sensibles, como mis huellas digitales, firmas, fotografías, videos y demás datos que puedan llegar a ser considerados como sensibles de conformidad con la Ley, para que dicho Tratamiento se realice con el fin de lograr las finalidades relativas a ejecutar el control, seguimiento, monitoreo, vigilancia y, en general, garantizar la seguridad de sus instalaciones; así como para documentar las actividades pertinentes y adecuados para la realización y el registro de la revisión preventiva, avaluó, peritaje Revisión Técnico Documental, y cualquier otro servicio ofrecido por PREVIAUTOS SAS o que ofrezca cualquier tercero dentro de las instalaciones de acuerdo con la normatividad vigente.

//       Dicha autorización para adelantar el tratamiento de mis datos personales se extiende durante la totalidad del tiempo en el que pueda llegar consolidarse un vínculo o este persista por cualquier circunstancia con el PREVENTIVA DE AUTOS SAS y con posterioridad al finiquito del mismo, siempre que tal tratamiento se encuentre relacionado con las finalidades para las cuales los datos personales, fueron inicialmente suministrados.

//       En ese sentido, declaro conocer que los datos personales objeto de tratamiento, serán utilizados específicamente de acuerdo con el objeto social del PREVENTIVA DE AUTOS SAS y en especial para todos aquellos fines, legales, contractuales, comerciales y personales descritos en la “Política de Tratamiento de Datos GE-DS-009” del PREVENTIVA DE AUTOS SAS.

//       Der igual forma, declaro que me han sido informados y conozco los derechos que el ordenamiento legal y la jurisprudencia, conceden al titular de los datos personales y que incluyen entre otras prerrogativas las que a continuación se relacionan: (i) Conocer, actualizar y rectificar datos personales frente a los responsables o encargados del tratamiento. Este derecho se podrá ejercer, entre otros frente a datos parciales, inexactos, incompletos, fraccionados, que induzcan a error, o aquellos cuyo tratamiento esté expresamente prohibido o no haya sido autorizado; (ii) solicitar prueba de la autorización otorgada al responsable del tratamiento salvo cuando expresamente se exceptúe como requisito para el tratamiento; (iii) ser informado por el responsable del tratamiento o el encargado del tratamiento, previa solicitud, respecto del uso que le ha dado a mis datos personales; (iv) presentar ante la Superintendencia de Industria y Comercio quejas por infracciones al régimen de protección de datos personales; (v) revocar la autorización y/o solicitar la supresión del dato personal cuando en el tratamiento no se respeten los principios, derechos y garantías constitucionales y legales, (vi) acceder en forma gratuita a mis datos personales que hayan sido objeto de Tratamiento.

//   Las políticas para la protección de datos adoptada por el PREVENTIVA DE AUTOS SAS, se encuentran en la sala de espera

//   Finalmente, manifiesto conocer que en los casos en que requiera ejercer los derechos anteriormente mencionados, la solicitud respectiva podrá ser elevada a través de los mecanismos dispuestos para tal fin por el PREVENTIVA DE AUTOS SAS que corresponden a los siguientes:

//   Correo electrónico: preventivasdeautos@gmail.com
//   Correspondencia:  Dg 16 #96ª-35 Bogotá D.C., Colombia
//   </div>
//   <div class="canvas-container" id="canvas_firma_1">
//   <label id="canvas-title">
//   Firma empleado
//   </label>
//   <canvas id="canvas_firma_1_graficos" width="542.483" height="206.24392857142857"></canvas>
//   <br>
//   <button class="button primary small icon solid fa-undo" id="canvas_firma_1_borrar"> Corregir</button>
//   </div>
//   `,
//   columnClass: 'medium',
//   buttons: {
//       aceptar: function () {
//           // $.alert('Confirmed!');
//       },
//   }
// });

// const json_firma_1 = {
//   id_container: 'canvas_firma_1',
//   title_label: 'firma 1 test',
//   responsive: '#canvas_firma_1',
//  };
//  let firma_1 = new canvas_firma(json_firma_1);
// $('#suboton').on('click', function (e) {
//  console.log(firma_1.get_status);
//  firma_1.canvas_default();
//  firma_1.set_image('http://192.168.1.50/images/sin_imagen.png');
//  firma_1.get_blob;
//  return false;
// });

// Acordion para cmodulos

/*
import * as infomarcion_vehiculo_js from './form_informacion_del_vehiculo.js'; 
import * as certificado_rtm_js from './form_certificado_rtm.js';


var xx = new infomarcion_vehiculo_js();*/

// informacion del vehiculo

// import './save_basic_information_form.js';

/*
//elementos de inicio, get form data
default_start();
//codigos de autocomplete
autocomplete();
// save form
save_basic_information_form();*/
