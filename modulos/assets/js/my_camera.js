/* HTML */
/* <div id="camera-content"> <div class="container-camera"> <div class="row gtr-50 gtr-uniform"> <div class="col-12" id="camera-name"> <label> My Camera V3 </label> </div> <div class="col-12 align-center" id="camera-message-top"> ESTE LADO ARRIBA </div> <div class="col-12 align-center" id="camera-canvas"> <input type="hidden" value="" id="camera_canvas_folder"> <video id="camera_video" class="camera_video_off" style=""> Video stream not available. </video> <canvas id="camera_canvas"></canvas> </div> <div class="col-12" id="camera-control"> <div class="row gtr-50 gtr-uniform"> <div class="col-6 col-12-mobilep" style="padding-top: 8px;"> <button id="btn-camera-upload" class="button primary small fit btn-camera"> Guardar</button> </div> <div class="col-6 col-12-mobilep" style="padding-top: 8px;"> <button id="btn-camera-take" class="button primary small fit btn-camera"> Tomar foto </button> </div> <div class="col-6 col-12-mobilep" style="padding-top: 8px;"> <button id="btn-camera-reload" class="button primary small fit btn-camera"> Corregir </button> </div> <div class="col-6 col-12-mobilep" style="padding-top: 8px;"> <button id="btn-camera-exit" class="button primary small fit btn-camera"> Cerrar </button> </div> </div> </div> </div> </div> </div>*/
/* invocar js */
/*fun_camera_photo('https://192.168.1.50/modulos/test_drag_and_drop/', 30, 0);*/

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
    dropzone_start({
      id_container: 'container_filechooser',
      id_input: 'form_dropzone',
      limit_input: 1,
      message: 'hola',
      folder: 'archivos',
    });
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
    let temp_input = $(this).attr('data-id');
    $.confirm({
      title: 'Alerta',
      content: '<center>¿ Desea visualizar este contenido en ?</center>',
      typeAnimated: true,
      scrollToPreviousElement: false,
      scrollToPreviousElementAnimate: false,
      columnClass: 'xsmall',
      closeIcon: true,
      buttons: {
        esta: {
          text: 'Esta pestaña',
          action: function () {
            window.location.href =
              PROTOCOL_HOST + '/' + $('#' + temp_input).val();
          },
        },
        otra: {
          text: 'Otra pestaña',
          action: function () {
            window.open(PROTOCOL_HOST + '/' + $('#' + temp_input).val());
          },
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
    $('#filechooser-content').hide(100);
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
            url: PROTOCOL_HOST + '/modulos/assets/php/my_camera_upload.php',
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
            timeout: 30000,
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

let dropzone_id_input = '',
  dropzone_file_folder = '';
$('.btn-file-open').on('click', function (e) {
  dropzone_id_input = $(this).attr('input-id');
  dropzone_file_folder = $(this).attr('data-folder');

  $('#page-wrapper').hide(100);
  $('#camera-content').hide(100);
  $('#filechooser-content').show(100);

  dropzone_reset('container_filechooser', 'form_dropzone', 'form_folder');

  e.preventDefault();
  return false;
});

function dropzone_start(_json_dropzone) {
  let hidden_input_value = {
    status: 'sin_archivos',
    file: [],
  };
  const array_types = [
    'application/x-zip-compressed',
    'text/plain',
    'application/pdf',
    'application/msword',
    'application/vnd.ms-excel',
    'application/vnd.ms-powerpoint',
    'image/jpeg',
    'image/png',
  ];

  // container principal
  $('#' + _json_dropzone.id_container).addClass('dropzone-container');
  // input
  $('#' + _json_dropzone.id_input).addClass('dropzone-input');
  // limite del input
  $('#' + _json_dropzone.id_input).attr(
    'data-limit',
    _json_dropzone.limit_input
  );

  // mensaje del container
  $('#' + _json_dropzone.id_container + ' .dropzone-wrapper').prepend(
    '<div class="dropzone-message">' +
      '<i class="fas fa-cloud-upload-alt fa-2x"></i>' +
      '<p>' +
      _json_dropzone.message +
      '</p>' +
      '</div>'
  );
  // container preview
  $('#' + _json_dropzone.id_container).append(
    '<div class="row gtr-50 gtr-uniform dropzpone-preview" id="' +
      _json_dropzone.id_container +
      '_preview_zone"></div> '
  );
  // container controles
  $('#' + _json_dropzone.id_container).append(
    '<div class="dropzpone-control">' +
      '<div class="row gtr-25 gtr-uniform">' +
      '<div class="col-6 col-12-mobilep">' +
      '<button class="button primary small fit btn-guardar-dropzone" disabled> Guardar </button>' +
      '</div>' +
      '<div class="col-6 col-12-mobilep">' +
      '<button class="button primary small fit btn-limpiar-dropzone"> Corregir </button>' +
      '</div>' +
      '<div class="col-6 col-12-mobilep">' +
      '<button class="button primary small fit btn-formatos-dropzone"> Ayuda </button>' +
      '</div>' +
      '<div class="col-6 col-12-mobilep">' +
      '<button class="button primary small fit btn-salir-dropzone"> Salir </button>' +
      '</div>' +
      '</div>' +
      '</div>'
  );
  // drag events
  $('#' + _json_dropzone.id_container + '.dropzone-wrapper').on(
    'dragover',
    function (e) {
      $(this).addClass('dragover');
      e.preventDefault();
      e.stopPropagation();
    }
  );

  $('#' + _json_dropzone.id_container + '.dropzone-wrapper').on(
    'dragleave',
    function (e) {
      e.preventDefault();
      e.stopPropagation();
      $(this).removeClass('dragover');
    }
  );
  // leer los archivos
  $('#' + _json_dropzone.id_input).change(function () {
    // reset
    dropzone_reset(
      _json_dropzone.id_container + '_preview_zone',
      '',
      hidden_input_value
    );

    if ($(this).prop('files').length > 0) {
      if ($(this).prop('files').length <= _json_dropzone.limit_input) {
        drop_zone_temp_files(this, _json_dropzone.id_container, array_types);
      } else {
        $.alert('Numero de archivos no permitido');
        dropzone_reset(
          _json_dropzone.id_container,
          _json_dropzone.id_input,
          hidden_input_value
        );
      }
    } else {
      $.alert('Ningún archivo seleccionado');
      dropzone_reset(
        _json_dropzone.id_container,
        _json_dropzone.id_input,
        hidden_input_value
      );
    }
  });

  $('#' + _json_dropzone.id_container + ' .btn-limpiar-dropzone').on(
    'click',
    function (e) {
      dropzone_reset(
        _json_dropzone.id_container,
        _json_dropzone.id_input,
        hidden_input_value
      );
      e.preventDefault();
      return false;
    }
  );
  $('#' + _json_dropzone.id_container + ' .btn-formatos-dropzone').on(
    'click',
    function (e) {
      $.alert('<b>Formatos permitidos</b> <br>' + array_types.join('<br>'));

      e.preventDefault();
      return false;
    }
  );

  $('#' + _json_dropzone.id_container + ' .btn-salir-dropzone').on(
    'click',
    function (e) {
      $('#page-wrapper').show(100);
      $('#filechooser-content').hide(100);
      $('#camera-content').hide(100);

      setTimeout(function () {
        $('html, body').animate(
          { scrollTop: $('#' + dropzone_id_input).offset().top - 120 },
          200
        );
      }, 500);
      e.preventDefault();
      return false;
    }
  );
  $('#' + _json_dropzone.id_container + ' .btn-guardar-dropzone').on(
    'click',
    function (e) {
      let temp_file_count = 0;
      _array_next_file();

      function callback_next(callback) {
        let formData = new FormData();
        formData.append(
          'file',
          $('#' + _json_dropzone.id_input).prop('files')[temp_file_count]
        );
        formData.append('folder', dropzone_file_folder);

        $.confirm({
          title: 'Error ',
          content: 'Cargando, espere...',
          typeAnimated: true,
          scrollToPreviousElement: false,
          scrollToPreviousElementAnimate: false,
          content: function () {
            var self = this;
            return $.ajax({
              url: PROTOCOL_HOST + '/modulos/assets/php/hoja_subir_archivo.php',
              dataType: 'json',
              type: 'POST',
              data: formData,
              contentType: false,
              cache: false,
              processData: false,
              headers: {
                'csrf-token': $('meta[name="csrf-token"]').attr('content'),
              },
              timeout: 30000,
            })
              .done(function (response) {
                console.log(response);
                hidden_input_value.status = 'con_archivos';

                hidden_input_value.file.push({
                  src: response.src,
                  name: response.name,
                  size: response.size,
                });

                $('#page-wrapper').show(100);
                $('#filechooser-content').hide(100);
                $('#camera-content').hide(100);

                $('#' + dropzone_id_input).val(response.src);

                setTimeout(function () {
                  $('html, body').animate(
                    {
                      scrollTop: $('#' + dropzone_id_input).offset().top - 120,
                    },
                    200
                  );
                }, 500);

                callback(response);
                self.close();
              })
              .fail(function (response) {
                self.setTitle('Error fatal');
                self.setContent(
                  response.statusText + ' // ' + response.responseText
                );
                callback(response);
                console.log(response);
              });
          },
          buttons: {
            aceptar: function () {},
          },
          onDestroy: function () {},
        });
      }

      function _array_next_file() {
        if (
          temp_file_count <
          $('#' + _json_dropzone.id_input).prop('files').length
        ) {
          callback_next(function (result) {
            temp_file_count++;
            _array_next_file(
              $('#' + _json_dropzone.id_input).prop('files')[temp_file_count]
            );
          });
        } else {
          drop_zone_show_files(
            hidden_input_value,
            _json_dropzone.id_container,
            true
          );
          // Aca oculto
        }
      }

      e.preventDefault();
      return false;
    }
  );
}

function drop_zone_temp_files(_input, _id_container, _array_types) {
  let temp_array_files = {
    file: [],
  };
  let temp_array_errores = '';

  $.each($(_input).prop('files'), function (index, value) {
    if (_array_types.includes(value.type)) {
      if (value.size < 40000000) {
        temp_array_files.file.push({
          src: false,
          name: value.name,
          size: value.size,
        });
      } else {
        temp_array_errores +=
          'archivo: ' + escapehtmljs(slice_smart(value.name, 20, 17)) + '<br>';
        temp_array_errores += 'error: <b>pesa mas de 40mb </b><br>';
      }
    } else {
      temp_array_errores +=
        'archivo: ' + escapehtmljs(slice_smart(value.name, 20, 17)) + '<br>';
      temp_array_errores += 'error: <b>Extensión no admitida </b> <br>';
    }
  });
  if (temp_array_errores.length > 0) {
    $.alert(temp_array_errores);

    dropzone_reset(_id_container, _input.id, '');
  } else {
    $('#' + _id_container + ' .btn-guardar-dropzone').prop('disabled', false);
    drop_zone_show_files(temp_array_files, _id_container, false);
  }
}

function dropzone_reset(_id_container, _temp_input_file, _array, _task) {
  $('#' + _id_container + '_preview_zone').html('');
  $('#' + _id_container + ' .dropzone-wrapper').show();
  if (_temp_input_file.length != 0) {
    $('#' + _temp_input_file).val('');
  }
  $('#' + _id_container + ' .btn-guardar-dropzone').prop('disabled', true);
  $('#' + _id_container + ' .dropzone_hidden_src').val('');
  _array.status = 'sin_archivos';
  _array.file = [];
}

function drop_zone_show_files(_response, _id_container, _src) {
  let html_preview = '<div class="col-12"> ';

  if (_src == true) {
    html_preview +=
      '<label class="icon solid fa-list"> Archivos subidos al servidor </label> <hr>';
    $('#' + _id_container + ' .dropzone-wrapper').hide();
    $('#' + _id_container + ' .btn-guardar-dropzone').prop('disabled', true);

    $('#' + _id_container + ' .dropzone_hidden_src').val(
      JSON.stringify(_response)
    );
  } else {
    html_preview +=
      '<label class="icon solid fa-check-double"> Listado de archivos a subir </label> <hr>';
  }
  html_preview += '</div>';

  $.each(_response.file, function (key, value) {
    html_preview +=
      '<div class="col-6 col-12-small dropzone-temp-file">' +
      '<div class="dropzone-temp-icon">' +
      set_file_icon(get_file_extension(value.name)) +
      '</div>' +
      '<div class="dropzone-temp-description">' +
      '<p>' +
      '<b> Nombre : </b>' +
      escapehtmljs(slice_smart(value.name, 20, 17)) +
      '<b> | ' +
      get_file_extension(value.name).toUpperCase() +
      ' | </b>' +
      '<br>' +
      '<b> Size : </b>' +
      escapehtmljs(get_file_exact_size(value.size)) +
      '<br>' +
      '<b> URL : </b>';

    if (value.src == false) {
      html_preview += ' ARCHIVO_SIN_SUBIR';
    } else {
      html_preview +=
        '<a href="' +
        PROTOCOL_HOST +
        '/' +
        value.src +
        '" target="_blank"> CLICK PARA VER ARCHIVO ' +
        '</a>';
    }

    html_preview += '</p>' + '</div>' + '</div>';
  });
  $('#' + _id_container + '_preview_zone').html(html_preview);
}
