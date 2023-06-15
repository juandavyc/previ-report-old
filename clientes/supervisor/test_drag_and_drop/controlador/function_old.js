//Guardar datos
var fileList = [];

$('#form_save_file').on('submit', function (e) {
  fileList.forEach(function (file) {
    sendfile(file);
  });

  e.preventDefault();
  return false;
});

function sendfile(file) {
  var formdata = new FormData();

  formdata.set('file', file);

  $.confirm({
    title: 'Error ',
    content: 'Cargando, espere...',
    typeAnimated: true,
    scrollToPreviousElement: false,
    scrollToPreviousElementAnimate: false,

    content: function () {
      var self = this;
      return $.ajax({
        url: PROTOCOL_HOST + '/modulos/test_drag_and_drop/modelo/save_file.php',
        dataType: 'json',
        type: 'POST',
        data: formdata,
        contentType: false,
        cache: false,
        processData: false,
        headers: {
          'csrf-token': $('meta[name="csrf-token"]').attr('content'),
        },
      })
        .done(function (response) {
          console.log(response);
          if (response.status === 'bien') {
            self.setTitle(response.status);
            self.setContent(response.message);
          } else {
            console.log(response);
            self.setTitle(response.status);
            self.setContent(response.message);
          }
        })
        .fail(function (response) {
          console.log(response);
          self.setTitle('Error -> ');
          self.setContent(response.responseText);
        });
    },
    buttons: {
      aceptar: function () {},
    },
    onDestroy: function () {},
  });
}

function readFile(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      var htmlPreview =
        '<img width="200" src="' +
        e.target.result +
        '" />' +
        '<p>' +
        input.files[0].name +
        '</p>';

      var wrapperZone = $(input).parent();
      var previewZone = $(input).parent().parent().find('.preview-zone');
      var boxZone = $(input)
        .parent()
        .parent()
        .find('.preview-zone')
        .find('.box')
        .find('#boxxx');
      var i = 0;
      while (i < input.files.length) {
        var htmlPreview =
          '<img width="100" src="' +
          e.target.result +
          '" />' +
          '<p>' +
          input.files[i].name +
          '</p>';

        boxZone.append(htmlPreview);

        wrapperZone.removeClass('dragover');
        previewZone.removeClass('hidden');

        i++;
      }
    };

    reader.readAsDataURL(input.files[0]);
  }
}

function reset(e) {
  e.wrap('<form>').closest('form').get(0).reset();
  e.unwrap();
}

$('.dropzone').change(function () {
  fileList = [];
  for (var i = 0; i < $('.dropzone').prop('files').length; i++) {
    fileList.push($('#form_dropzone').prop('files')[i]);
  }
  // readFile(this);
});

$('.dropzone-wrapper').on('dragover', function (e) {
  e.preventDefault();
  e.stopPropagation();

  $(this).addClass('dragover');
});

$('.dropzone-wrapper').on('dragleave', function (e) {
  e.preventDefault();
  e.stopPropagation();
  $(this).removeClass('dragover');
});

$('.remove-preview').on('click', function () {
  var boxZone = $(this).parents('.preview-zone').find('#boxxx');
  var previewZone = $(this).parents('.preview-zone');
  var dropzone = $(this).parents('.form-group').find('.dropzone');
  boxZone.empty();
  previewZone.addClass('hidden');
  reset(dropzone);
});

/*//Guardar datos
var fileList = [];

$('#form_save_file').on('submit', function (e) {
  fileList.forEach(function (file) {
    sendfile(file);
  });
  e.preventDefault();
  return false;
});

function sendfile(file) {
  var formdata = new FormData();

  formdata.set('file', file);

  $.confirm({
    title: 'Error ',
    content: 'Cargando, espere...',
    typeAnimated: true,
    scrollToPreviousElement: false,
    scrollToPreviousElementAnimate: false,

    content: function () {
      var self = this;
      return $.ajax({
        url: PROTOCOL_HOST + '/modulos/test_drag_and_drop/modelo/save_file.php',
        dataType: 'json',
        type: 'POST',
        data: formdata,
        contentType: false,
        cache: false,
        processData: false,
        headers: {
          'csrf-token': $('meta[name="csrf-token"]').attr('content'),
        },
      })
        .done(function (response) {
          console.log(response);
          if (response.status === 'bien') {
            self.setTitle(response.status);
            self.setContent(response.message);
          } else {
            console.log(response);
            self.setTitle(response.status);
            self.setContent(response.message);
          }
        })
        .fail(function (response) {
          console.log(response);
          self.setTitle('Error -> ');
          self.setContent(response.responseText);
        });
    },
    buttons: {
      aceptar: function () {},
    },
    onDestroy: function () {},
  });
}

function readFile(input, preview_zone) {
  if (input.files && input.files[0]) {
    let reader = new FileReader();
    let html_preview =
      '<div class="col-12"><hr class="hr-text" data-content="Vista previa"></div>';
    reader.onload = function (e) {
      let contador_ficheros = 0;
      while (contador_ficheros < input.files.length) {
        html_preview +=
          '<div class="col-3 col-12-small">' +
          '<label class="preview-zone-temp-file icon solid ' +
          set_file_icon(
            get_file_extension(input.files[contador_ficheros].name)
          ) +
          '"> ' +
          escapehtmljs(
            slice_smart(input.files[contador_ficheros].name, 20, 17)
          ) +
          '</label>' +
          '</div>';
        contador_ficheros++;
      }
      $('#' + preview_zone).html(html_preview);
    };
    reader.readAsDataURL(input.files[0]);
  }
}

function dropzone_reset(temp_preview_div, temp_input_file) {
  $('#' + temp_preview_div).html('');
  $('#' + temp_input_file).val('');
}

$('.dropzone').change(function () {
  let temp_preview_div = $(this).attr('data-preview');
  fileList = [];
  for (var i = 0; i < $('.dropzone').prop('files').length; i++) {
    fileList.push($('#form_dropzone').prop('files')[i]);
  }
  readFile(this, temp_preview_div);
});

$('.dropzone-wrapper').on('dragover', function (e) {
  e.preventDefault();
  e.stopPropagation();

  $(this).addClass('dragover');
});

$('.dropzone-wrapper').on('dragleave', function (e) {
  e.preventDefault();
  e.stopPropagation();
  $(this).removeClass('dragover');
});

$('.remove-preview').on('click', function () {
  dropzone_reset($(this).attr('data-preview'), $(this).attr('data-input'));
});
*/
