// style="overflow-x: hidden;overflow-y: hidden;"
/* AUTOCOMPLETE V2 */

// $.alert("DSADASD");
function autocomplete_with_insert_father($json_object) {
  // console.log($json_object);

  $('#' + $json_object.id_input_text).addClass('ui-autocomplete-input');
  $('#' + $json_object.id_input_text).focusin(function () {
    let $json_data_status = {
      is_ajax: false,
      is_selected: false,
      is_found_item: false,
      array_items: [],
    };

    autocomplete_father_ajax();
    function autocomplete_father_ajax() {
      $('#' + $json_object.id_input_text)
        .autocomplete({
          delay: 100,
          autoFocus: true,
          minLength: 1,
          source: function (request, response) {
            if (request.term.length > 0) {
              $json_data_status.is_ajax = false;
              $json_data_status.is_selected = false;
              $json_data_status.is_found_item = false;

              $.ajax({
                url: $json_object.url_select_ajax,
                type: 'POST',
                dataType: 'json',
                data: {
                  palabra: request.term.trim().toUpperCase(),
                },
                headers: {
                  'csrf-token': $('meta[name="csrf-token"]').attr('content'),
                },
                dataType: 'json',
                timeout: 5000,
                success: function (data) {
                  $json_data_status.is_ajax = true;
                  if (data.status === 'bien') {
                    $json_data_status.array_items = data.options;
                    response(
                      $.map(data.options, function (item) {
                        return {
                          value: item.nombre,
                          id: item.id,
                        };
                      })
                    );
                  } else if (
                    data.status === 'csrf' ||
                    data.status === 'session'
                  ) {
                    $json_data_status.is_selected = true;

                    $('#' + $json_object.id_input_text).val(
                      $json_object.input_value_default
                    );
                    $('#' + $json_object.id_input_select).val(
                      $json_object.input_select_default
                    );
                    call_recuperar_session(autocomplete_father_ajax);
                  } else if (
                    data.status === 'sin_resultado' ||
                    data.status === 'base_de_datos'
                  ) {
                    response(
                      $.map(data.options, function (item) {
                        return {
                          value: item.nombre,
                          id: item.id,
                        };
                      })
                    );
                  } else {
                    $json_data_status.array_items = [];
                  }
                },
                error: function (data) {
                  console.log(data);
                  $.alert(data.statusText + ' // Error de comunicacion');
                  $('#' + $json_object.id_input_text).val(
                    $json_object.input_value_default
                  );
                  $('#' + $json_object.id_input_select).val(
                    $json_object.input_select_default
                  );
                },
              });
            }
          },
          select: function (event, ui) {
            $('#' + $json_object.id_input_text).val(ui.item.value);
            $('#' + $json_object.id_input_select).val(ui.item.id);

            $.each($json_object.input_childs, function (key, valor) {
              $('#' + valor.id_input_text).val(valor.input_value_default);
              $('#' + valor.id_input_select).val(valor.input_select_default);
            });

            $json_data_status.is_selected = true;
          },
          change: function (event, ui) {
            // No entro al ajax

            if ($json_data_status.is_ajax == false) {
              $.alert('Campo requerido ');
              $('#' + $json_object.id_input_text).val(
                $json_object.input_value_default
              );
              $('#' + $json_object.id_input_select).val(
                $json_object.input_select_default
              );
            }
            // si entro al ajax
            else {
              if ($json_data_status.is_selected == false) {
                // Busca para seleccionar el item
                $.each($json_data_status.array_items, function (key, valor) {
                  if (
                    $('#' + $json_object.id_input_text)
                      .val()
                      .toLowerCase() === valor.nombre.toLowerCase()
                  ) {
                    $('#' + $json_object.id_input_text).val(valor.nombre);
                    $('#' + $json_object.id_input_select).val(valor.id);
                    $json_data_status.is_found_item = true;
                  }
                });
                // El item no fue seleccionado
                if ($json_data_status.is_found_item == false) {
                  autocomplete_insert_item($json_object);
                }
              }
            }
          },
        })
        .data('ui-autocomplete')._renderItem = function (ul, item) {
          // si todo existe
          if (
            item.id == 0 &&
            item.value == 'TODO' &&
            typeof $json_object.is_todo !== 'undefined' &&
            $json_object.is_todo == true
          ) {
            return $('<li class="ui-state">' + item.value + '</li>').appendTo(ul);
          } else {
            if (item.id == 0) {
              return $(
                '<li class="ui-state-disabled">' + item.value + '</li>'
              ).appendTo(ul);
            } else {
              return $('<li>')
                .append('<a>' + item.value + '</a>')
                .appendTo(ul);
            }
          }
        };
    }
  });
  $('#' + $json_object.id_input_text).focusout(function () {
    if ($('#' + $json_object.id_input_select).val() == 0) {
      // Afecta todos los hijos

      $.each($json_object.input_childs, function (key, valor) {
        $('#' + valor.id_input_text).val(valor.input_value_default);
        $('#' + valor.id_input_select).val(valor.input_select_default);
      });
    }
  });
}

function autocomplete_insert_item($json_object) {
  if (
    $('#' + $json_object.id_input_text)
      .val()
      .trim().length > 0
  ) {
    $.confirm({
      title: '¡Alto ahi! ',
      content:
        '<center> ' +
        'Este elemento no existe ...  <br> ' +
        '( <b>' +
        escapehtmljs(
          $('#' + $json_object.id_input_text)
            .val()
            .toUpperCase()
        ) +
        '</b> )' +
        '<br>¿Desea crearlo?' +
        '</center>',
      columnClass: 'xsmall',
      buttons: {
        button_yes: {
          text: 'Si',
          action: function () {
            autocomplete_insert_ajax();
          },
        },
        button_no: {
          text: 'No',
          action: function () {
            $('#' + $json_object.id_input_text).val(
              $json_object.input_value_default
            );
            $('#' + $json_object.id_input_select).val(
              $json_object.input_select_default
            );
          },
        },
      },
    });

    function autocomplete_insert_ajax() {
      $.confirm({
        title: 'Espere... ',
        content: 'Cargando, espere...',
        typeAnimated: true,
        scrollToPreviousElement: false,
        scrollToPreviousElementAnimate: false,
        content: function () {
          var self = this;
          return $.ajax({
            url: $json_object.url_insert_ajax,
            type: 'POST',
            data: {
              nombre_elemento: $('#' + $json_object.id_input_text)
                .val()
                .toUpperCase(),
            },
            headers: {
              'csrf-token': $('meta[name="csrf-token"]').attr('content'),
            },
            dataType: 'json',
            timeout: 5000,
          })
            .done(function (response) {
              if (response.status === 'bien') {
                self.setTitle('Completado');
                self.setContentAppend(
                  '<center><b>( ' +
                  response.nombre +
                  ' )</b><br>Fue creado correctamente </center>'
                );

                $('#' + $json_object.id_input_text).val(response.nombre);
                $('#' + $json_object.id_input_select).val(response.id);
              } else if (
                response.status === 'csrf' ||
                response.status === 'session'
              ) {
                $('#' + $json_object.id_input_text).val(
                  $json_object.input_value_default
                );
                $('#' + $json_object.id_input_select).val(
                  $json_object.input_select_default
                );
                self.close();
                call_recuperar_session(autocomplete_insert_ajax);
              } else {
                self.setTitle(response.status);
                self.setContentAppend(response.id);

                $('#' + $json_object.id_input_text).val(
                  $json_object.input_value_default
                );
                $('#' + $json_object.id_input_select).val(
                  $json_object.input_select_default
                );
              }
            })
            .fail(function (response) {
              self.setTitle('Error fatal');
              self.setContent(
                response.statusText + ' // ' + response.responseText
              );
              console.log(response);

              $('#' + $json_object.id_input_text).val(
                $json_object.input_value_default
              );
              $('#' + $json_object.id_input_select).val(
                $json_object.input_select_default
              );
            });
        },
        buttons: {
          aceptar: function () { },
        },
      });
    }
  } else {
    $.alert('No puede ser vacio');
    $('#' + $json_object.id_input_text).val($json_object.input_value_default);
    $('#' + $json_object.id_input_select).val(
      $json_object.input_select_default
    );
  }
}

function autocomplete_with_insert_child($json_object) {
  $('#' + $json_object.id_input_text).addClass('ui-autocomplete-input');
  $('#' + $json_object.id_input_text).focusin(function () {
    let $json_data_status = {
      is_ajax: false,
      is_selected: false,
      is_found_item: false,
      array_items: [],
    };
    //
    if ($('#' + $json_object.input_father_select).val() != 0) {
      $('#' + $json_object.id_input_text)
        .autocomplete({
          delay: 100,
          autoFocus: true,
          minLength: 1,
          source: function (request, response) {
            console.log(request.term.length);

            if (request.term.length > 0) {
              $json_data_status.is_ajax = false;
              $json_data_status.is_selected = false;
              $json_data_status.is_found_item = false;

              $.ajax({
                url: $json_object.url_select_ajax,
                type: 'POST',
                dataType: 'json',
                data: {
                  palabra: request.term.trim().toUpperCase(),
                  id_father: $('#' + $json_object.input_father_select).val(),
                },
                headers: {
                  'csrf-token': $('meta[name="csrf-token"]').attr('content'),
                },
                dataType: 'json',
                timeout: 5000,
                success: function (data) {
                  $json_data_status.is_ajax = true;

                  if (data.status === 'bien') {
                    $json_data_status.array_items = data.options;
                    response(
                      $.map(data.options, function (item) {
                        return {
                          value: item.nombre,
                          id: item.id,
                        };
                      })
                    );
                  } else if (
                    data.status === 'csrf' ||
                    data.status === 'session'
                  ) {
                    $json_data_status.is_selected = true;

                    $('#' + $json_object.id_input_text).val(
                      $json_object.input_value_default
                    );
                    $('#' + $json_object.id_input_select).val(
                      $json_object.input_select_default
                    );
                    recuperar_session();
                  } else if (
                    data.status === 'sin_resultado' ||
                    data.status === 'base_de_datos'
                  ) {
                    response(
                      $.map(data.options, function (item) {
                        return {
                          value: item.nombre,
                          id: item.id,
                        };
                      })
                    );
                  } else {
                    $json_data_status.array_items = [];
                  }
                },
                error: function (data) {
                  console.log(data);
                  $.alert(data.statusText + ' // Error de comunicacion');
                  $('#' + $json_object.id_input_text).val(
                    $json_object.input_value_default
                  );
                  $('#' + $json_object.id_input_select).val(
                    $json_object.input_select_default
                  );
                },
              });
            }
          },
          select: function (event, ui) {
            $('#' + $json_object.id_input_text).val(ui.item.value);
            $('#' + $json_object.id_input_select).val(ui.item.id);
            $json_data_status.is_selected = true;
          },
          change: function (event, ui) {
            if ($json_data_status.is_ajax == false) {
              $.alert('Campo requerido ');
              $('#' + $json_object.id_input_text).val(
                $json_object.input_value_default
              );
              $('#' + $json_object.id_input_select).val(
                $json_object.input_select_default
              );
            } else {
              if ($json_data_status.is_selected == false) {
                $.each($json_data_status.array_items, function (key, valor) {
                  if (
                    $('#' + $json_object.id_input_text)
                      .val()
                      .toLowerCase() === valor.nombre.toLowerCase()
                  ) {
                    $('#' + $json_object.id_input_text).val(valor.nombre);
                    $('#' + $json_object.id_input_select).val(valor.id);
                    $json_data_status.is_found_item = true;
                  }
                });

                if ($json_data_status.is_found_item == false) {
                  autocomplete_insert_item_child($json_object);
                }
              }
            }
          },
        })
        .data('ui-autocomplete')._renderItem = function (ul, item) {
          let id = item.id;
          if (id == 0) {
            return $(
              '<li class="ui-state-disabled">' + item.value + '</li>'
            ).appendTo(ul);
          } else {
            return $('<li>')
              .append('<a>' + item.value + '</a>')
              .appendTo(ul);
          }
        };
    } else {
      $('#' + $json_object.input_father_text).focus();
      $.alert(
        'El campo <b>( ' +
        $json_object.input_father_name +
        ' ) </b> no debe estar vacio'
      );
      return false;
    }
  });
}
function autocomplete_insert_item_child($json_object) {
  if (
    $('#' + $json_object.id_input_text)
      .val()
      .trim().length > 0
  ) {
    $.confirm({
      title: '¡Alto ahi!',
      content:
        '<center> ' +
        'Este elemento no existe ...  <br> ' +
        '( <b>' +
        escapehtmljs(
          $('#' + $json_object.id_input_text)
            .val()
            .toUpperCase()
        ) +
        '</b> )' +
        '<br>¿Desea crearlo?' +
        '</center>',
      columnClass: 'xsmall',
      buttons: {
        button_yes: {
          text: 'Si',
          action: function () {
            $.confirm({
              title: 'Espere... ',
              content: 'Cargando, espere...',
              typeAnimated: true,
              scrollToPreviousElement: false,
              scrollToPreviousElementAnimate: false,
              content: function () {
                var self = this;
                return $.ajax({
                  url: $json_object.url_insert_ajax,
                  type: 'POST',
                  data: {
                    nombre_elemento: $('#' + $json_object.id_input_text)
                      .val()
                      .toUpperCase(),
                    id_father: $('#' + $json_object.input_father_select).val(),
                  },
                  headers: {
                    'csrf-token': $('meta[name="csrf-token"]').attr('content'),
                  },
                  dataType: 'json',
                  timeout: 5000,
                })
                  .done(function (response) {
                    if (response.status === 'bien') {
                      self.setTitle('Completado');
                      self.setContentAppend(
                        '<center><b>( ' +
                        response.nombre +
                        ' )</b><br>Fue creado correctamente </center>'
                      );

                      $('#' + $json_object.id_input_text).val(response.nombre);
                      $('#' + $json_object.id_input_select).val(response.id);
                    } else if (
                      response.status === 'csrf' ||
                      response.status === 'session'
                    ) {
                      $('#' + $json_object.id_input_text).val(
                        $json_object.input_value_default
                      );
                      $('#' + $json_object.id_input_select).val(
                        $json_object.input_select_default
                      );
                      self.close();
                      recuperar_session();
                    } else {
                      self.setTitle(response.status);
                      self.setContentAppend(response.id);

                      $('#' + $json_object.id_input_text).val(
                        $json_object.input_value_default
                      );
                      $('#' + $json_object.id_input_select).val(
                        $json_object.input_select_default
                      );
                    }
                  })
                  .fail(function (response) {
                    self.setTitle('Error fatal');
                    self.setContent(
                      response.statusText + ' // ' + response.responseText
                    );
                    console.log(response);

                    $('#' + $json_object.id_input_text).val(
                      $json_object.input_value_default
                    );
                    $('#' + $json_object.id_input_select).val(
                      $json_object.input_select_default
                    );
                  });
              },
              buttons: {
                aceptar: function () { },
              },
            });
          },
        },
        button_no: {
          text: 'No',
          action: function () {
            $('#' + $json_object.id_input_text).val(
              $json_object.input_value_default
            );
            $('#' + $json_object.id_input_select).val(
              $json_object.input_select_default
            );
          },
        },
      },
    });
  } else {
    $.alert('No puede ser vacio');
    $('#' + $json_object.id_input_text).val($json_object.input_value_default);
    $('#' + $json_object.id_input_select).val(
      $json_object.input_select_default
    );
  }
}

// ++++++++++ +++++++
// RECUPERAR SESSION CON CALLBACK
// ++++++++++ +++++++

function call_recuperar_session(_callback) {
console.log("dsadsadsadasd");
  let json_datos_usuario = {
    cedula: '',
    contrasenia: '',
  };


  let self = $.confirm({
    title: false,
    content: 'Cargando, espere...',
    typeAnimated: true,
    scrollToPreviousElement: false,
    scrollToPreviousElementAnimate: false,
    content: function () {
      return $.ajax({
        url: 'modelo/getEmpresas.php',
        type: 'POST',
        data: {
          dato: 1,
        },
        headers: {
          'csrf-token': $('meta[name="csrf-token"]').attr('content'),
        },
        dataType: 'json',
        timeout: 35000,
      })
        .done(function (response) {
          // console.log(response.message);
          if (response.status === 'bien') {

            let i = 0;
            let html_modal = `<div class="row gtr-50 gtr-uniform" style="overflow-x: hidden;overflow-y: hidden;">
            <div class="col-12 align-center">
                <i class="fas fa-address-card fa-3x"></i>
                <hr class="hr-text" data-content="Recuperación de sesión">
            </div>
            <div class="col-12">
            <label class="label-important"> Empresa </label>
                <div class="input-container">
                    <i class="fas fa-thumbs-up icon-input"></i>
                    <select id="empresa" name="empresa" required="">${$.each(response.message, function (index, value) {
              self.close();

              $('#empresa').append($('<option>', {
                value: response.message[i].id,
                text: response.message[i].nombre.toUpperCase(),
              }));
              i++;
            })}
                    </select>
                </div>
            </div>
            <div class="col-12">
                <label class="label-important"> Cedula</label>
                <div class="input-container">
                    <i class="fa fa-user icon-input"></i>
                    <input type="text" name="usuario" id="usuario_inciar_sesion" maxlength="25" required="" autocomplete="off">
                </div>
            </div>
            <div class="col-12">
                <label class="label-important"> Contraseña</label>
                <div class="input-container">
                    <i class="fa fa-lock icon-input"></i>
                    <input type="password" name="contrasenia" id="contrasenia_inciar_sesion" maxlength="25" required=""
                        autocomplete="off">
                </div>
            </div>
        
        </div>`;


            getModal(html_modal, _callback);

            // $.each(response.message, function( index, value ) {
            //   self.close();

            //   $('#empresa').append($('<option>', {
            //     value: response.message[i].id,
            //     text: response.message[i].nombre.toUpperCase(),
            //   }));
            //   i++;
            // });

            // $('select option:contains("TODO")').remove();
            // $('select option:contains("SIN EMPRESA")').remove();





          } else {
            self.setTitle(response.status);
            self.setContent(response.message);
          }
        })
        .fail(function (response) {
          self.setTitle('Error fatal');
          self.setContent(response.statusText + ' // ' + response.responseText);
          // console.log(response);
        });
    },
  });

}



function getModal(_html_modal, _callback) {
  let json_datos_usuario = {
    cedula: '',
    contrasenia: '',
  };

  $.confirm({
    title: false,
    content: _html_modal,
    boxWidth: '365px',
    useBootstrap: false,
    buttons: {
      iniciar: {
        text: 'Iniciar',
        action: function () {
          json_datos_usuario.cedula = this.$content
            .find('#usuario_inciar_sesion')
            .val();
          json_datos_usuario.contrasenia = this.$content
            .find('#contrasenia_inciar_sesion')
            .val();

          if (!json_datos_usuario.cedula || !json_datos_usuario.contrasenia) {
            $.alert('Los campos no pueden estar vacíos.');
            return false;
          }
          // aca todo va bien
          else {
            this.close('ok');
            return false;
          }
        },
      },

      cancelar: {
        text: 'Salir',
        action: function () {
          location.reload();
        },
      },
    },
    onClose: function (_task) {
      if (_task === 'ok') {
        let self = $.confirm({
          content: function () {
            return $.ajax({
              url:
                PROTOCOL_HOST + '/clientes/administrador/assets/php/hdv_restaurar_session.php',
              type: 'POST',
              data: {
                usuario: json_datos_usuario.cedula,
                contrasenia: json_datos_usuario.contrasenia,
                ip: json_ip,
              },
              dataType: 'json',
              timeout: 5000,
            })
              .done(function (response) {
                // console.log('done');
                // console.log(response);
                if (response.status === 'bien') {
                  $("meta[name='csrf-token']").attr('content', response.token);
                  self.close('ok');
                } else {
                  self.setTitle(response.status);
                  self.setContent(response.message);
                }
              })
              .fail(function (response) {
                self.setTitle('Error fatal');
                self.setContent(
                  response.statusText + ' // ' + response.responseText
                );
                console.log('fail');
                console.log(response);
              });
          },
          onClose: function (_task) {
            if (_task === 'ok') {
              _callback();
            }
          },
          buttons: {
            aceptar: function () { },
          },
        });
      }
    },
  });
}

function escapehtmljs(text) {
  var map = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#039;',
  };
  return text.toString().replace(/[&<>"']/g, function (m) {
    return map[m];
  });
}

function get_file_extension(file_name) {
  var ext = /^.+\.([^.]+)$/.exec(file_name);
  return ext == null ? '.null' : ext[1];
}

function set_file_icon(file_extension) {
  let icon_retun = '';
  if (file_extension.toLowerCase() == 'txt') {
    icon_retun = '<i class="fas fa-file-alt fa-3x"></i>';
  } else if (file_extension.toLowerCase() == 'zip') {
    icon_retun = '<i class="fas fa-file-archive fa-3x"></i>';
  } else {
    icon_retun = '<i class="fas fa-file fa-3x"></i>';
  }
  return icon_retun;
}

function slice_smart(string, maximo, corte) {
  let string_return = string;
  if (string.length >= maximo) {
    string_return = string.slice(0, corte) + '...';
  }
  return string_return;
}

function get_file_exact_size(_size) {
  const fSExt = new Array('Bytes', 'KB', 'MB', 'GB');
  let i = 0;
  while (_size > 900) {
    _size /= 1024;
    i++;
  }
  let exactSize = Math.round(_size * 100) / 100 + ' ' + fSExt[i];
  return exactSize;
}

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
    '<button class="button small btn-guardar-dropzone" disabled> Guardar </button>' +
    '<button class="button small btn-limpiar-dropzone"> Corregir </button>' +
    '<button class="button small btn-formatos-dropzone"> ? </button>' +
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
        formData.append('folder', _json_dropzone.folder);

        $.confirm({
          title: 'Error ',
          content: 'Cargando, espere...',
          typeAnimated: true,
          scrollToPreviousElement: false,
          scrollToPreviousElementAnimate: false,
          content: function () {
            var self = this;
            return $.ajax({
              url: PROTOCOL_HOST + '/clientes/administrador/assets/php/hoja_subir_archivo.php',
              dataType: 'json',
              type: 'POST',
              data: formData,
              contentType: false,
              cache: false,
              processData: false,
              headers: {
                'csrf-token': $('meta[name="csrf-token"]').attr('content'),
              },
            })
              .done(function (response) {
                hidden_input_value.status = 'con_archivos';

                hidden_input_value.file.push({
                  src: response.src,
                  name: response.name,
                  size: response.size,
                });
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
            aceptar: function () { },
          },
          onDestroy: function () { },
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
        value.src +
        '" target="_blank"> CLICK PARA VER ARCHIVO ' +
        '</a>';
    }

    html_preview += '</p>' + '</div>' + '</div>';
  });
  $('#' + _id_container + '_preview_zone').html(html_preview);
}
/*
window.addEventListener(
  'dragover',
  function (e) {
    e = e || event;
    // console.log(e);
    if (e.target.tagName != 'INPUT') {
      // check which element is our target
      e.preventDefault();
    }
  },
  false
);
window.addEventListener(
  'drop',
  function (e) {
    e = e || event;

    if (e.target.tagName != 'INPUT') {
      // check which element is our target
      e.preventDefault();
    }
  },
  false
);*/
function getTitleTable(response) {
  return (
    'Resultados : ' +
    response['total'] +
    ' ( Página ' +
    response['page'] +
    ' de ' +
    response['total_pages'] +
    ' ) '
  );
}
function getTheadTable($array, $order, $by) {
  const arrow = $by === 'asc' ? '&dArr;' : '&uArr;';
  let inner_html = '<tr>';
  $.each($array, function (key, value) {
    if (value === $order) {
      inner_html +=
        '<th id="th-data" class="th-data-active" field-id="' +
        value +
        '" data-id="' +
        ($by == 'asc' ? 'desc' : 'asc') +
        '">' +
        arrow +
        ' ' +
        value +
        '</th>';
    } else {
      inner_html +=
        '<th id="th-data" field-id="' +
        value +
        '" data-id="asc">' +
        value +
        '</th>';
    }
  });
  inner_html += '</tr> ';
  return inner_html;
}

function getTbodyTable($array, _json_botones) {
  let inner_html = '';
  $.each($array, function (key, value) {
    inner_html += '<tr id="' + key + '">';
    $.each($array[key], function (keyy, valuee) {
      if (keyy === 'opciones') {
        inner_html += '<td data-label="' + keyy + '">';
        $.each(_json_botones.botones, function (index, valueee) {
          inner_html +=
            '<button btn-id="' +
            escapehtmljs(valuee) +
            '" id="' +
            valueee.id +
            '" class="button primary small icon solid ' +
            valueee.icon +
            '"></button>';
        });
        inner_html += '</td>';
      } else {
        inner_html +=
          '<td data-label="' +
          keyy +
          '" id="table_' +
          keyy +
          '">' +
          escapehtmljs(valuee) +
          '</td>';
      }
    });
    inner_html += '</tr>';
  });
  inner_html += '';
  return inner_html;
}
function getTbodyTableOBJ($array, _json_botones, _link) {
  let inner_html = '<tbody>';
  $.each($array, function (key, value) {
    inner_html += '<tr id="' + key + '">';
    $.each($array[key], function (keyy, valuee) {
      if (keyy === 'opciones') {
        inner_html += '<td data-label="' + keyy + '">';
        $.each(_json_botones.botones, function (index, valueee) {
          inner_html +=
            '<a href="' +
            _link +
            escapehtmljs(valuee) +
            '" ><button btn-id="' +
            escapehtmljs(valuee) +
            '" id="' +
            valueee.id +
            '" class="button primary small icon solid ' +
            valueee.icon +
            '"></button></a>';
        });
        inner_html += '</td>';
      } else {
        inner_html +=
          '<td data-label="' +
          keyy +
          '" id="table_' +
          keyy +
          '">' +
          escapehtmljs(valuee) +
          '</td>';
      }
    });
    inner_html += '</tr>';
  });
  inner_html += '</tbody>';
  return inner_html;
}
function getPaginationTable($currentpage, $totalpages, $url) {
  if (!$.isNumeric($currentpage)) {
    $currentpage = 1;
  }
  if (!$.isNumeric($totalpages)) {
    $totalpages = 1;
  }
  if ($currentpage > $totalpages) {
    $currentpage = $totalpages;
  }
  if ($currentpage < 1) {
    $currentpage = 1;
  }

  let inner_html = '';
  let range = 2;
  let prevpage = 0;
  let ciclox = 0;
  let nextpage = 0;

  if ($totalpages > 1) {
    inner_html +=
      '<h4> página ( ' + $currentpage + ' de ' + $totalpages + ' )</h4>';
    inner_html += '<ul class="pagination">';
    if ($currentpage > 1) {
      inner_html +=
        '<li id="li-data" data-id="1" ><a class="page" data-id="1"> &laquo; </a></li>';
      prevpage = $currentpage - 1;
      inner_html +=
        '<li id="li-data" data-id="' +
        prevpage +
        '"><a class="page" data-id="' +
        prevpage +
        '"> &#8249; </a></li>';
    }

    for (
      ciclox = $currentpage - range;
      ciclox < $currentpage + range + 1;
      ciclox++
    ) {
      if (ciclox > 0 && ciclox <= $totalpages) {
        if (ciclox == $currentpage) {
          inner_html +=
            '<li id="li-data" data-id="' +
            ciclox +
            '"><a class="page active" > ' +
            ciclox +
            '</a></li>';
        } else {
          inner_html +=
            '<li id="li-data" data-id="' +
            ciclox +
            '"><a class="page"> ' +
            ciclox +
            ' </a></li>';
        }
      }
    }
    if ($currentpage != $totalpages) {
      nextpage = $currentpage + 1;
      inner_html +=
        '<li id="li-data" data-id="' +
        nextpage +
        '"><a class="page" data-id="' +
        nextpage +
        '"> &#8250; </a></li>';
      inner_html +=
        '<li id="li-data" data-id="' +
        $totalpages +
        '" ><a class="page" data-id="' +
        $totalpages +
        '" > &raquo; </a></li>';
    }

    inner_html += '</ul>';
  }

  return inner_html;
}

function getPaginationListNoRef($currentpage, $totalpages, $url) {
  if (!$.isNumeric($currentpage)) {
    $currentpage = 1;
  }
  if (!$.isNumeric($totalpages)) {
    $totalpages = 1;
  }
  if ($currentpage > $totalpages) {
    $currentpage = $totalpages;
  }
  if ($currentpage < 1) {
    $currentpage = 1;
  }

  var inner_html = '';
  var range = 3;
  var prevpage = 0;
  var ciclox = 0;
  var nextpage = 0;

  if ($totalpages > 1) {
    inner_html += '<h4>Paginación</h4>';
    inner_html += '<ul class="pagination">';
    if ($currentpage > 1) {
      inner_html +=
        '<li id="li-data" data-id="1" ><a class="page" data-id="1"> &laquo; </a></li>';
      prevpage = $currentpage - 1;
      inner_html +=
        '<li id="li-data" data-id="' +
        prevpage +
        '"><a class="page" data-id="' +
        prevpage +
        '"> &#8249; </a></li>';
    }

    for (
      ciclox = $currentpage - range;
      ciclox < $currentpage + range + 1;
      ciclox++
    ) {
      if (ciclox > 0 && ciclox <= $totalpages) {
        if (ciclox == $currentpage) {
          inner_html +=
            '<li id="li-data" data-id="' +
            ciclox +
            '"><a class="page active" > ' +
            ciclox +
            '</a></li>';
        } else {
          inner_html +=
            '<li id="li-data" data-id="' +
            ciclox +
            '"><a class="page"> ' +
            ciclox +
            ' </a></li>';
        }
      }
    }
    if ($currentpage != $totalpages) {
      nextpage = $currentpage + 1;
      inner_html +=
        '<li id="li-data" data-id="' +
        nextpage +
        '"><a class="page" data-id="' +
        nextpage +
        '"> &#8250; </a></li>';
      inner_html +=
        '<li id="li-data" data-id="' +
        $totalpages +
        '" ><a class="page" data-id="' +
        $totalpages +
        '" > &raquo; </a></li>';
    }

    inner_html += '</ul>';
  }

  return inner_html;
}

function formatdateui(date) {
  let fecha = date.split('-');

  if (fecha[2].charAt(0) == 0) {
    fecha[2] = fecha[2].charAt(1);
  }
  if ((fecha[1].length = 0)) {
    fecha[1] = '0' + fecha[1];
  }

  return [fecha[2], fecha[1], fecha[0]].join('/');
}

function vh_placa_css(_servicio) {
  let classe_placa = 'vh-placa';
  switch (_servicio) {
    case '1':
    case '4':
    case '7':
      classe_placa += ' vh-especial';
      break;
    case '2':
    case '8':
      classe_placa += ' vh-publico';
      break;
    case '3':
    case '5':
      classe_placa += ' vh-particular';
      break;
    default:
      classe_placa + ' vh-particular';
  }
  return classe_placa;
}

function formatMoney($input) {
  console.log("dasdasd");
  let num = $input.replace(/\./g, '');
  if (!isNaN(num)) {
    num = num
      .toString()
      .split('')
      .reverse()
      .join('')
      .replace(/(?=\d*\.?)(\d{3})/g, '$1.');
    num = num.split('').reverse().join('').replace(/^[\.]/, '');
  } else {
    // $.alert('Solo se permiten numeros');
    num = num.replace(/[^\d\.]*/g, '');
  }

  return num;
}
function habeas_data() {
  let confirm = $.confirm({
    title: 'HABEAS DATA',
    content: `<div class="habeas-data-chimbo">
    <center>
    AUTORIZACIÓN PARA EL TRATAMIENTO DE DATOS PERSONALES<br>
  </center>
  <br>
  
    De conformidad con lo definido por la Ley 1581 de 2012, el Decreto Reglamentario 1377 de 2013, la Circular Externa 002 de 2015 expedida por la Superintendencia de Industria y Comercio:
  
        Autorizo de manera libre, voluntaria, previa, explícita, informada e inequívoca al PREVENTIVA DE AUTOS SAS para que en los términos legalmente establecidos realice la recolección, almacenamiento, uso, circulación, supresión y en general, el tratamiento de los datos personales que he procedido a entregar o que entregaré, en virtud de las relaciones legales, contractuales, comerciales y/o de cualquier otra que surja, en desarrollo y ejecución de los fines descritos en el presente documento.
  
        Realice la recolección, almacenamiento, uso, circulación, supresión, y en general, tratamiento de mis datos personales, incluyendo datos sensibles, como mis huellas digitales, firmas, fotografías, videos y demás datos que puedan llegar a ser considerados como sensibles de conformidad con la Ley, para que dicho Tratamiento se realice con el fin de lograr las finalidades relativas a ejecutar el control, seguimiento, monitoreo, vigilancia y, en general, garantizar la seguridad de sus instalaciones; así como para documentar las actividades pertinentes y adecuados para la realización y el registro de la revisión preventiva, avaluó, peritaje Revisión Técnico Documental, y cualquier otro servicio ofrecido por PREVIAUTOS SAS o que ofrezca cualquier tercero dentro de las instalaciones de acuerdo con la normatividad vigente.
  
        Dicha autorización para adelantar el tratamiento de mis datos personales se extiende durante la totalidad del tiempo en el que pueda llegar consolidarse un vínculo o este persista por cualquier circunstancia con el PREVENTIVA DE AUTOS SAS y con posterioridad al finiquito del mismo, siempre que tal tratamiento se encuentre relacionado con las finalidades para las cuales los datos personales, fueron inicialmente suministrados.
  
        En ese sentido, declaro conocer que los datos personales objeto de tratamiento, serán utilizados específicamente de acuerdo con el objeto social del PREVENTIVA DE AUTOS SAS y en especial para todos aquellos fines, legales, contractuales, comerciales y personales descritos en la “Política de Tratamiento de Datos GE-DS-009” del PREVENTIVA DE AUTOS SAS.
  
        Der igual forma, declaro que me han sido informados y conozco los derechos que el ordenamiento legal y la jurisprudencia, conceden al titular de los datos personales y que incluyen entre otras prerrogativas las que a continuación se relacionan: (i) Conocer, actualizar y rectificar datos personales frente a los responsables o encargados del tratamiento. Este derecho se podrá ejercer, entre otros frente a datos parciales, inexactos, incompletos, fraccionados, que induzcan a error, o aquellos cuyo tratamiento esté expresamente prohibido o no haya sido autorizado; (ii) solicitar prueba de la autorización otorgada al responsable del tratamiento salvo cuando expresamente se exceptúe como requisito para el tratamiento; (iii) ser informado por el responsable del tratamiento o el encargado del tratamiento, previa solicitud, respecto del uso que le ha dado a mis datos personales; (iv) presentar ante la Superintendencia de Industria y Comercio quejas por infracciones al régimen de protección de datos personales; (v) revocar la autorización y/o solicitar la supresión del dato personal cuando en el tratamiento no se respeten los principios, derechos y garantías constitucionales y legales, (vi) acceder en forma gratuita a mis datos personales que hayan sido objeto de Tratamiento.
  
    Las políticas para la protección de datos adoptada por el PREVENTIVA DE AUTOS SAS, se encuentran en la sala de espera
  
    Finalmente, manifiesto conocer que en los casos en que requiera ejercer los derechos anteriormente mencionados, la solicitud respectiva podrá ser elevada a través de los mecanismos dispuestos para tal fin por el PREVENTIVA DE AUTOS SAS que corresponden a los siguientes:
  
    Correo electrónico: preventivasdeautos@gmail.com
    Correspondencia:  Dg 16 #96ª-35 Bogotá D.C., Colombia
    </div>
    <div class="canvas-container" id="canvas_firma_1">
    <label id="canvas-title">
    Firma empleado
    </label>
    <canvas id="canvas_firma_1_graficos" width="542.483" height="206.24392857142857"></canvas>
    <br>
    <button class="button primary small icon solid fa-undo" id="canvas_firma_1_borrar"> Corregir</button>
    </div>
    `,
    columnClass: 'medium',
    buttons: {
      aceptar: function () {
        // $.alert('Confirmed!');
      },
    },
  });
  return confirm;
}
