/* HTML */
/* <div id="camera-content"> <div class="container-camera"> <div class="row gtr-50 gtr-uniform"> <div class="col-12" id="camera-name"> <label> My Camera V3 </label> </div> <div class="col-12 align-center" id="camera-message-top"> ESTE LADO ARRIBA </div> <div class="col-12 align-center" id="camera-canvas"> <input type="hidden" value="" id="camera_canvas_folder"> <video id="camera_video" class="camera_video_off" style=""> Video stream not available. </video> <canvas id="camera_canvas"></canvas> </div> <div class="col-12" id="camera-control"> <div class="row gtr-50 gtr-uniform"> <div class="col-6 col-12-mobilep" style="padding-top: 8px;"> <button id="btn-camera-upload" class="button primary small fit btn-camera"> Guardar</button> </div> <div class="col-6 col-12-mobilep" style="padding-top: 8px;"> <button id="btn-camera-take" class="button primary small fit btn-camera"> Tomar foto </button> </div> <div class="col-6 col-12-mobilep" style="padding-top: 8px;"> <button id="btn-camera-reload" class="button primary small fit btn-camera"> Corregir </button> </div> <div class="col-6 col-12-mobilep" style="padding-top: 8px;"> <button id="btn-camera-exit" class="button primary small fit btn-camera"> Cerrar </button> </div> </div> </div> </div> </div> </div>*/
/* invocar js */
/*fun_camera_photo('https://192.168.1.50/clientes/supervisor/test_drag_and_drop/', 30, 0);*/

function fun_camera_photo(_https_url, _id_photo, _rotate) {
  let fun_camera_return = false;
  // _https_url :: url segura del modulo -> https://blablalb
  // _id_photo :: un id para identificar el archivo (id_conductor,id_vehiculo..)
  // _rotate :: 0,90,180,360,5,10 grados.

  $('#page-wrapper').show();
  $('#camera-content').hide();
  $('#camera_video').hide();
  $('#camera_canvas').show();
  let camera_streaming = false;

  const camera_video = document.getElementById('camera_video');
  const camera_canvas = document.getElementById('camera_canvas');

  let camera_canvas_context = camera_canvas.getContext('2d');
  let canvas_is_dragging = false;

  let camera_photo_id = _id_photo;
  const camera_photo_rotate = _rotate;

  let camera_id_input = '';
  let camera_photo_folder = '';

  let camera_canvas_image = new Image();

  let camera_width_video = window.innerWidth - 100;
  let camera_height_video = window.innerHeight - 300;

  if (window.location.protocol === 'http:') {
    let $url_href = _https_url;
    //const $url_video =
    //   'http://192.168.1.100:88/images/recepcion/respaldo/como_habilitar_https.mp4';
    const $url_video = '';
    document.querySelector('body').classList.remove('is-preload', 'landing');

    $('body').html(
      '<section class="wrapper style4 container small">' +
        '<div class="row gtr-50 gtr-uniform">' +
        '<div class="col-12 align-center"> <h2>Se requiere <b class="https_green">HTTPS</b></h2> </div>' +
        '<div class="col-12 align-center"> <label> Este módulo requiere HTTPS, para poder usar servicios de cámara. ' +
        '<a href="https://es.wikipedia.org/wiki/Protocolo_seguro_de_transferencia_de_hipertexto" target="_blank">¿Que es HTTPS?</a> <br>' +
        'Video de como activar <b class="https_green">HTTPS</b></label></div>' +
        '<div class="col-8 col-12-mobilep align-center">' +
        //'<video class="https_video" controls autoplay="" muted="" loop="" height="450px">' +
        // '<source src="' +
        // $url_video +
        // '" type="video/mp4">Video stream not available.' +
        // '</video>' +
        '</div>' +
        '<div class="col-4 col-12-mobilep align-left">' +
        '<div class="row gtr-50 gtr-uniform">' +
        '<div class="col-12 align-center">' +
        '<a class="button primary small fit" href="javascript:history.back()"> ' +
        'VOLVER ' +
        '</a>' +
        '</div>' +
        '<div class="col-12 align-center">' +
        '<a class="button primary small fit" href="' +
        _https_url +
        '" > USAR HTTPS ' +
        '</a>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</section>'
    );

    fun_camera_return = false;
  } else {
    fun_camera_return = true;
  }

  // atributos del video.

  camera_video.setAttribute('width', camera_width_video);
  camera_video.setAttribute('height', camera_height_video);

  camera_canvas.setAttribute('width', camera_width_video);
  camera_canvas.setAttribute('height', camera_height_video);

  $(window).on('resize', function () {
    resizeCanvas();
  });

  function resizeCanvas() {
    camera_video.setAttribute('width', camera_width_video);
    camera_video.setAttribute('height', camera_height_video);

    camera_canvas.setAttribute('width', camera_width_video);
    camera_canvas.setAttribute('height', camera_height_video);
  }
  $('.btn-photo-take').on('click', function (e) {
    camera_status(true);

    $('#page-wrapper').hide();
    $('#camera-content').show();
    e.preventDefault();
    return false;
  });
  $('.cbx-camera').change(function (e) {
    if (this.checked) {
      $('#' + $(this).attr('button-id')).attr('disabled', true);
    } else {
      $('#' + $(this).attr('button-id')).attr('disabled', false);
    }
    e.preventDefault();
    return false;
  });
  $('.btn-camera-show').on('click', function (e) {
    $.confirm({
      title: 'Foto',
      content:
        '<center><img src="' +
        PROTOCOL_HOST +
        '/' +
        $('#' + $(this).attr('data-id')).val() +
        '"></center>',
      boxWidth: '365px',
      useBootstrap: false,
      closeIcon: true,
      buttons: {
        aceptar: {
          action: function () {},
        },
      },
    });
    e.preventDefault();
    return false;
  });
  // Encender camara
  $('#btn-camera-on, #btn-camera-reload').on('click', function (e) {
    camera_status(true);
    e.preventDefault();
    return false;
  });
  // Apagar camara
  $('#btn-camera-off').on('click', function (e) {
    camera_status(false);
    e.preventDefault();
    return false;
  });
  // Tomar foto
  $('#btn-camera-take').on('click', function (e) {
    camera_take_photo();
    e.preventDefault();
    return false;
  });
  $('.btn-camera-open').on('click', function (e) {
    camera_id_input = $(this).attr('input-id');
    camera_photo_folder = $(this).attr('data-folder');

    $('#page-wrapper').hide(100);
    $('#camera-content').show(100);
    camera_status(true);

    e.preventDefault();
    return false;
  });

  function camera_canvas_upload() {
    let $temp_status = 1;
    if (camera_streaming == true) {
      $.alert('La camara aun esta encendida');
    } else {
      let self = $.confirm({
        title: 'Espere... ',
        content: 'Cargando, espere...',
        typeAnimated: true,
        scrollToPreviousElement: false,
        scrollToPreviousElementAnimate: false,
        content: function () {
          return $.ajax({
            url: PROTOCOL_HOST + '/clientes/supervisor/assets/php/my_camera_upload.php',
            type: 'POST',
            data: {
              camera_image_base64: camera_canvas.toDataURL(),
              camera_image_folder: camera_photo_folder,
              camera_image_id: camera_photo_id,
              camera_image_rotate: camera_photo_rotate,
            },
            headers: {
              'csrf-token': $('meta[name="csrf-token"]').attr('content'),
            },
            dataType: 'json',
            timeout: 3000,
          })
            .done(function (response) {
              if (response.status === 'bien') {
                self.setTitle(response.status);
                self.setContentAppend(
                  '<center><b>Imagen guardada</b> </center>'
                );
                $('#' + camera_id_input).val(response.src);
                $('#page-wrapper').show();
                $('#camera-content').hide();
                $temp_status = 2;

                setTimeout(function () {
                  self.close();
                }, 1000);
              } else if (
                response.status === 'csrf' ||
                response.status === 'session'
              ) {
                self.close();
                call_recuperar_session(camera_canvas_upload);
              } else {
                self.setTitle(response.status);
                self.setContentAppend(response.message);
              }
            })
            .fail(function (response) {
              self.setTitle('Error fatal');
              self.setContent(
                response.statusText + ' // ' + response.responseText
              );
              console.log(response);
            });
        },
        buttons: {
          aceptar: function () {},
        },

        onClose: function () {
          $('html, body').animate(
            { scrollTop: $('#' + camera_id_input).offset().top - 140 },
            500
          );
        },
      });
    }
  }

  $('#btn-camera-upload').on('click', function (e) {
    camera_canvas_upload();
    e.preventDefault();
    return false;
  });
  $('#btn-camera-exit').on('click', function (e) {
    $.confirm({
      title: false,
      content: '<center>¿Esta seguro que desea cerrar la camara?</center>',
      boxWidth: '365px',
      useBootstrap: false,
      buttons: {
        Si: {
          action: function () {
            camera_status(false);
            camera_elements_status(2);

            $('#camera-content').hide();
            $('#page-wrapper').show();

            setTimeout(function () {
              $('html, body').animate(
                { scrollTop: $('#' + camera_id_input).offset().top - 140 },
                500
              );
            }, 500);
          },
        },
        No: {
          keys: ['N'],
          action: function () {},
        },
      },
    });
    //camera_take_photo();
    e.preventDefault();
    return false;
  });
  function camera_status($status) {
    // encendido
    if ($status == true) {
      if (camera_streaming == false) {
        navigator.mediaDevices
          .getUserMedia({
            video: {
              facingMode: 'environment',
            },
            audio: false,
          })
          .then(function (stream) {
            camera_video.srcObject = stream;
            camera_video.play();
            camera_streaming = true;
            camera_elements_status(1);
          })
          .catch(function (err) {
            $.alert('An error occurred: ' + err);
            camera_streaming = false;
          });
      } else {
        $.alert('La camara ya esta encendida');
      }
    }
    // apagado
    else {
      if (camera_streaming == true) {
        camera_video.srcObject.getTracks().forEach(function (track) {
          track.stop();
          camera_streaming = false;
          camera_elements_status(2);
        });
      } else {
        camera_streaming = false;
        // $.alert('La camara no esta encendida');
      }
    }
  }

  function camera_elements_status($task) {
    // Encendida
    if ($task == 1) {
      $('#btn-camera-on').prop('disabled', true);
      $('#btn-camera-off').prop('disabled', false);
      $('#btn-camera-upload').prop('disabled', true);
      $('#btn-camera-reload').prop('disabled', true);
      $('#btn-camera-take').prop('disabled', false);

      $('#camera_video')
        .removeClass('camera_video_off')
        .addClass('camera_video_on');
      $('#camera_video').show();
      $('#camera_canvas').hide();
    }
    // Apagada
    else if ($task == 2) {
      $('#btn-camera-on').prop('disabled', false);
      $('#btn-camera-off').prop('disabled', true);
      $('#btn-camera-upload').prop('disabled', true);
      $('#btn-camera-reload').prop('disabled', true);
      $('#btn-camera-take').prop('disabled', true);

      $('#camera_video')
        .removeClass('camera_video_on')
        .addClass('camera_video_off');
      $('#camera_video').hide();
      $('#camera_canvas').show();
    }

    // Tomar foto
    else if ($task == 3) {
      $('#btn-camera-on').prop('disabled', false);
      $('#btn-camera-off').prop('disabled', true);
      $('#btn-camera-upload').prop('disabled', false); // habilitado
      $('#btn-camera-reload').prop('disabled', false); // habilitado
      $('#btn-camera-take').prop('disabled', true); // no habliitado

      $('#camera_video')
        .removeClass('camera_video_on')
        .addClass('camera_video_off');

      $('#camera_video').hide();
      $('#camera_canvas').show();
    }
  }

  function camera_take_photo() {
    if (camera_streaming == true) {
      camera_canvas_reset();

      camera_canvas_context.drawImage(
        camera_video,
        0,
        0,
        camera_width_video,
        camera_height_video
      );

      camera_video.srcObject.getTracks().forEach(function (track) {
        track.stop();
      });

      camera_status(false);
      // Le dice que active unos botones especificos
      camera_elements_status(3);
    } else {
      $.alert('La camara no esta encendida.');
    }
  }

  function camera_canvas_reset() {
    camera_canvas_context.clearRect(
      0,
      0,
      camera_canvas.width,
      camera_canvas.height
    );
    camera_canvas_context.beginPath();
  }

  return fun_camera_return;
}
