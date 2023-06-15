const array_videos = {
  0: {
    title: 'inicio',
    introduccion: {
      title: 'Sin video',
    },
  },
  2: {
    title: 'vehículos',
    buscador: {
      title: 'Buscador',
      0: {
        src: 'vehiculo/agregar.mp4',
        title: 'Agregar vehículo',
      },
      1: {
        src: 'vehiculo/buscador.mp4',
        title: 'Usar el buscador',
      },
      2: {
        src: 'vehiculo/fotografias.mp4',
        title: 'Fotos',
      },
    },
  },
  3: {
    title: 'Conductores',
    buscador: {
      title: 'Buscador',
      0: {
        src: 'conductor/agregar.mp4',
        title: 'Agregar conductor',
      },
      1: {
        src: 'conductor/buscador.mp4',
        title: 'Usar el buscador',
      },
    },
    detalles: {
      title: 'Detalles',
      0: {
        src: 'conductor/asignar.mp4',
        title: 'Asignar vehiculo',
      },
    },
  },
  4: {
    title: 'Talleres',
    buscador: {
      title: 'Buscador',
      0: {
        src: 'taller/agregar.mp4',
        title: 'Agregar taller',
      },
      1: {
        src: 'taller/buscador.mp4',
        title: 'Usar el buscador',
      },
    },
  },
  5: {
    title: 'Usuarios',
    buscador: {
      title: 'Buscador',
      0: {
        src: 'usuario/agregar.mp4',
        title: 'Agregar usuario',
      },
      1: {
        src: 'usuario/buscador.mp4',
        title: 'Usar el buscador',
      },
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
      1: {
        src: 'siniestro/buscador.mp4',
        title: 'Usar el buscador',
      },
    },
  },
  7: {
    title: 'Mantenimientos',
    buscador: {
      title: 'Buscador',
      0: {
        src: 'mantenimiento/agregar.mp4',
        title: 'Agregar',
      },
      1: {
        src: 'mantenimiento/buscador.mp4',
        title: 'Usar el buscador',
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
      1: {
        src: 'preoperacional/buscador.mp4',
        title: 'Usar el buscador',
      },
    },
    detalles: {
      title: 'Detalles',
      1: {
        src: 'preoperacional/listado.mp4',
        title: 'Check list',
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
