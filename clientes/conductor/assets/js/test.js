// callback funcion con parametros
/*call_recuperar_session(function (k) {
  agregar_vehiculo(_placa);
});*/
/* callback con ajax, onclose con parametros y recursividad */
/*
let message = '';
function score(_callback) {
  let self = $.confirm({
    content: function () {
      self.setContent('Checking callback flow');
      return $.ajax({
        url: PROTOCOL_HOST + '/assets/legal/json.php',
        dataType: 'json',
        // method: 'get'
      })
        .done(function (response) {
          //console.log('done');
          console.log(response);

          self.close(response.message);
          // message += response.message + '<br>';
        })
        .fail(function (response) {
          // console.log('fail');
          // console.log(response);
        });
    },
    onClose: function (_status) {
      if (_status === 'callback') {
        console.log(_status);
      } else {
        console.log('!' + _status);
      }
      _callback(_status);
    },
  });
}

let i = 0;

function next_score(_score) {
  if (i < 3) {
    message += _score + '';
    score(next_score);
    i++;
  } else {
    console.log(message);
  }
}

score(next_score);
*/
