
const elementos = {
    id: 'buscador',
    autocomplete: {
        empresa: {
            text: '#empresa_input',
            hidden: '#empresa_select',
        }
    },
    filtro: '#filtro',
    contenido: '#contenido',
};


const autocomplete = (id, autocomplete) => {
    // empresa
    autocomplete_with_insert_father({
        id_input_text: `${id} ${autocomplete.empresa.text}`,
        id_input_select: `${id} ${autocomplete.empresa.hidden}`,
        url_select_ajax:
            PROTOCOL_HOST +
            '/modulos/assets/autocomplete/empresa_general/buscar_empresa.php',
        url_insert_ajax:
            PROTOCOL_HOST + '/modulos/usuarios/visor/modelo/crear_empresa.php',
        input_value_default: 'TODO',
        input_select_default: '0',
        input_childs: [],
        is_todo: true,
    });
}

const listener = (id) => {
    // filtro
    $(`#${id} ${elementos.filtro}`).change(function (e) {
        if ($(`#${id} ${elementos.filtro} option:selected`).value == 0) {
            $(`#${id} ${elementos.contenido}`).val('Todo');
            $(`#${id} ${elementos.contenido}`).prop('readonly', true);
        } else {
            $(`#${id} ${elementos.contenido}`).prop('readonly', false);
            $(`#${id} ${elementos.contenido}`).val('');
        }
        e.preventDefault();
        return false;
    });
    // submit
    $(`#${id}`).on('submit', function (e) {
        buscadorSubmit();
        e.preventDefault();
        return false;
    });


}

export const buscadorSubmit = () => {
    let self = $.confirm({
        title: false,
        content: 'Cargando, espere...',
        typeAnimated: true,
        scrollToPreviousElement: false,
        scrollToPreviousElementAnimate: false,
        content: function () {
            return $.ajax({
                url:
                    PROTOCOL_HOST +
                    '/modulos/documentos/conductores/modelo/buscador.php',
                type: 'POST',
                data: new FormData($('#' + elementos.id)[0]),
                headers: {
                    'csrf-token': $('meta[name="csrf-token"]').attr('content'),
                },
                dataType: 'json',
                processData: false,
                contentType: false,
                timeout: 35000,
            }).done(function (response) {
                if (response.status === 'bien') {
                    elementosContainer('arl', response.documents.arl);
                } else {
                    self.setTitle(response.status);
                    self.setContent(response.message);
                }
            }).fail(function (response) {
                self.setTitle('Error fatal');
                self.setContent(response.statusText + ' // ' + response.responseText);
                // console.log(response);
            });
        },
        buttons: {
            aceptar: function () { },
        },
    });
}

const elementosContainer = (id, response) => {
    let inner = '<table>';
    if (response.status === "bien") {
        inner += '<thead><tr>';
        Object.entries(response.head).forEach(([key, value]) => {
            inner += '<th>' + value.replaceAll("_", " ") + '</th>';
        });
        inner += '</tr></thead>';
        inner += '<tbody>';
        Object.entries(response.results).forEach(([key, value]) => {
            inner += '<tr>';
            inner += '<td>' + (parseInt(key) + 1) + '</td>';
            Object.entries(value).forEach(([subkey, subvalue]) => {
                inner += '<td>' + subvalue + '</td>';
            });
            inner += '</tr>';
        });
        inner += '</tbody>';
    }
    inner += '</table>';
    $('#container-' + id).empty().html(inner);
}


const buscadorInit = () => {
    autocomplete(elementos.id, elementos.autocomplete);
    listener(elementos.id);
}

buscadorInit();