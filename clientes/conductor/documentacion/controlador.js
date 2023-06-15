const array_videos = {
  0: {
    title: 'inicio',
    introduccion: {
      title: 'Sin video',
    },
  },
  6: {
    title: 'Siniestros',
    buscador: {
      title: 'Buscador',
      0: {
        src: 'siniestro/agregar.mp4',
        title: 'Agregar',
      },
    },
    detalles: {
      title: 'Detalles',
      0: {
        src: 'siniestro/datos.mp4',
        title: 'Datos',
      },
    },
  },
  8: {
    title: 'Preoperacional',
    buscador: {
      title: 'Buscador',
      0: {
        src: 'preoperacional/agregar.mp4',
        title: 'Agregar',
      },
    },
    detalles: {
      title: 'Detalles',
      0: {
        src: 'preoperacional/datos.mp4',
        title: 'Datos',
      },
    },
  },
};

$('#tipo-video-select').change(function (e) {
  let temp_html = '';
  let temp_id_selected = $('#tipo-video-select option:selected').val();
  $('#listado-videos').empty();
  $.each(array_videos[temp_id_selected], function (i, item) {
    if (typeof item === 'object') {
      temp_html += '<ul>';
      temp_html += '<li>' + item.title + '</li>';
      temp_html += '<ol>';
      $.each(item, function (i_sub, item_sub) {
        if (typeof item_sub === 'object') {
          temp_html += `<li class="li-video" data-src="${item_sub.src}">${item_sub.title}</li>`;
        }
      });
      temp_html += '</ol>';
      temp_html += '</ul>';
    } else {
      temp_html += '<label class="icon solid fa-video"> ' + item + '</label>';
    }
  });

  $('#listado-videos').html(temp_html);
  e.preventDefault();
  return false;
});

$('#listado-videos').on('click', '.li-video', function (e) {
  let temp_src = 'documentacion/sources/' + $(this).attr('data-src');

  $('#video-title').html('-- ' + $(this).html() + ' --');
  $('#video-player source').attr('src', temp_src);
  $('#video-player')[0].load();

  e.preventDefault();
  return false;
});
