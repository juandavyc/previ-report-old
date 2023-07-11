// style="overflow-x: hidden;overflow-y: hidden;"
/* AUTOCOMPLETE V2 */
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
          aceptar: function () {},
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
                aceptar: function () {},
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
  let html_modal = '';
  let status_empresa = false;

  let self = $.confirm({
    title: false,
    content: 'Cargando, espere...',
    typeAnimated: true,
    scrollToPreviousElement: false,
    scrollToPreviousElementAnimate: false,
    content: function () {
      return $.ajax({
        url: PROTOCOL_HOST + '/clientes/assets/php/getEmpresa.php',
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

            status_empresa = true;
            let i = 0;
            html_modal = `<div class="row gtr-50 gtr-uniform" style="overflow-x: hidden;overflow-y: hidden;">
            <div class="col-12 align-center">
                <i class="fas fa-address-card fa-3x"></i>
                <hr class="hr-text" data-content="Recuperación de sesión">
            </div>
            <div class="col-12">
            <label class="label-important"> Empresa </label>
                <div class="input-container">
                    <i class="fas fa-thumbs-up icon-input"></i>
                    <select id="empresa" name="empresa" required="">`;
            Object.entries(response.message).forEach(entry => {
              const [key, value] = entry; 
            html_modal+='<option value = ' + value.id + '>' + value.nombre + '</option>';
            });
            html_modal += `</select>
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
            self.close();
          } else {
            self.setTitle(response.status);
            self.setContent(response.message);
            console.log("PASO 1");
          }
        })
        .fail(function (response) {
          self.setTitle('Error fatal');
          self.setContent(response.statusText + ' // ' + response.responseText);
          // console.log(response);
        });
    },
    onClose: function () {
      // console.log(html_modal);
      if (status_empresa == true) {
        getModal(html_modal, _callback);
      }
    }
  });

}



function getModal(_html_modal, _callback) {

  let json_datos_usuario = {
    cedula: '',
    contrasenia: '',
    empresa: '',
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
          json_datos_usuario.empresa = this.$content
            .find('#empresa')
            .val();

          if (!json_datos_usuario.cedula || !json_datos_usuario.contrasenia || !json_datos_usuario.empresa) {
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
                empresa: json_datos_usuario.empresa,
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
