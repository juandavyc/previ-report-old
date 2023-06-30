
const containerEmpresas = document.getElementById('container-empresas');
const containerEmpresasItems = document.getElementById('container-empresas-items');
const containerIniciarSesion = document.getElementById('container-iniciar-sesion');
const formulario = document.getElementById('form_iniciar_sesion');

const empresaNombre = document.getElementById('iniciar-empresa-nombre');
const btnContainerEmpresas = document.getElementById('iniciar-empresa-volver');
const input_empresa = document.getElementById('iniciar-empresa');

const getEmpresas = () => {
  let self = $.confirm({
    title: false,
    content: 'Cargando, espere...',
    typeAnimated: true,
    scrollToPreviousElement: false,
    scrollToPreviousElementAnimate: false,
    content: function () {
      return $.ajax({
        url: 'modelo/empresas.php',
        type: 'POST',
        data: { dato: 1 },
        headers: {
          'csrf-token': $('meta[name="csrf-token"]').attr('content'),
        },
        dataType: 'json',
        timeout: 35000,
      }).done(function (response) {
        if (response.status === 'bien') {
          innerEmpresas(response.message);
          self.close();
        } else {
          self.setTitle(response.status);
          self.setContent(response.message);
        }
      }).fail(function (response) {
        self.setTitle('Error fatal');
        self.setContent(response.statusText + ' // ' + response.responseText);
      });
    },
    buttons: {
      aceptar: function () { },
    },
  });
}
const iniciarSesion = () => {
  let self = $.confirm({
    content: function () {
      return $.ajax({
        url: 'modelo/iniciar.php',
        type: 'POST',
        data: new FormData(formulario),
        processData: false,
        contentType: false,
        headers: {
          'csrf-token': $('meta[name="csrf-token"]').attr('content'),
        },
        dataType: 'json',
        timeout: 5000,
      })
        .done(function (response) {
          if (response.status === "bien") {
            self.setTitle('Inicio de sesion correcto');
            self.setContent('Redireccionando, espere...');
            setTimeout(function () {
              $(location).attr('href', response.message);
              self.close();
            }, 1000);
          } else {
            self.setTitle(response.status);
            self.setContent(response.message);
          }
        })
        .fail(function (response) {
          self.setTitle('Error fatal');
          self.setContent(JSON.stringify(response));
          console.log(response);
        });
    },
    buttons: {
      aceptar: function () { },
    },
  });
}

const innerEmpresas = (_empresas) => {
  const rowElement = document.createElement('div');
  rowElement.classList.add('row', 'gtr-25', 'gtr-uniform');
  Object.entries(_empresas).forEach(([key, value]) => {

    const colElement = document.createElement('div');
    const cardElement = document.createElement('div');
    const cardBodyElement = document.createElement('div');
    const cardTitleElement = document.createElement('h4');
    const cardTextElement = document.createElement('p');
    const cardButtonElement = document.createElement('button');

    colElement.classList.add('col-6', 'col-12-small');
    cardElement.classList.add('card');
    cardBodyElement.classList.add('card-body');
    cardTitleElement.classList.add('card-title');
    cardTextElement.classList.add('card-text');
    cardButtonElement.classList.add('button', 'primary', 'small', 'icon', 'solid', 'fa-arrow-right', 'btn-empresa');

    // values
    cardTitleElement.textContent = `${value.nombre}`;
    cardTextElement.textContent = `Nit: ${value.nit}`;
    cardButtonElement.setAttribute('data-id', value.id);
    cardButtonElement.setAttribute('data-name', value.nombre);
    cardButtonElement.textContent = " Seleccionar";

    cardBodyElement.appendChild(cardTitleElement);
    cardBodyElement.appendChild(cardTextElement);
    cardBodyElement.appendChild(cardButtonElement);
    cardElement.appendChild(cardBodyElement);
    colElement.appendChild(cardElement);
    rowElement.appendChild(colElement);

    cardButtonElement.addEventListener('click', (e) => {
      input_empresa.value = e.target.getAttribute('data-id');
      empresaNombre.textContent = e.target.getAttribute('data-name');
      containerEmpresas.style.display = 'none';
      containerIniciarSesion.style.display = 'block';
      containerIniciarSesion.scrollIntoView({ behavior: "smooth" });
      e.preventDefault();
    });
  });

  containerEmpresasItems.appendChild(rowElement);
}

btnContainerEmpresas.addEventListener('click', (e) => {
  e.preventDefault();
  containerIniciarSesion.style.display = 'none';
  containerEmpresas.style.display = 'block';
  containerEmpresas.scrollIntoView({ behavior: "smooth" });
});

formulario.addEventListener('submit', (e) => {
  e.preventDefault();
  iniciarSesion();
});


getEmpresas();