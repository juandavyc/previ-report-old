class canvas_firma {
  constructor(_json_canvas) {
    $('#' + _json_canvas.id_container).prepend(`
    <label id="canvas-title">
    ${escapehtmljs(_json_canvas.title_label)}
    </label>
    <canvas id="${_json_canvas.id_container}_graficos"></canvas>
    <br>
    <button class="button primary small icon solid fa-undo" 
    id="${_json_canvas.id_container}_borrar"> Corregir</button>   
    `);

    this.canvas = document.getElementById(
      _json_canvas.id_container + '_graficos'
    );
    this.ctx = this.canvas.getContext('2d');
    this.is_drawing = true;
    this.is_used = false;

    this.responsive = _json_canvas.responsive;

    this.canvas.setAttribute('width', $(this.responsive).width() - 35);
    this.canvas.setAttribute('height', $(this.responsive).width() / 2.8);

    this.ctx.lineWidth = 3;
    this.ctx.lineJoin = 'round';
    this.ctx.strokeStyle = '#FFF';

    this.image = new Image();

    this.fun_listener(_json_canvas.id_container, this);
  }

  fun_listener(_container, _this) {
    $('#' + _container + '_borrar').on('click', function (e) {
      _this.set_default();
      return false;
    });
    $(window).on('resize', function () {
      _this.set_resize();
    });

    $('#' + _container + '_graficos').on('touchstart', function (e) {
      _this.drawstart(e.touches[0], _this);
    });
    $('#' + _container + '_graficos').on('touchmove', function (e) {
      _this.drawmove(e.touches[0], _this);
      e.preventDefault();
    });
    $('#' + _container + '_graficos').on('touchend', function (e) {
      _this.dragend(e.changedTouches[0], _this);
    });

    $('#' + _container + '_graficos').mousedown(function (e) {
      _this.drawstart(e, _this);
    });
    $('#' + _container + '_graficos').mousemove(function (e) {
      _this.drawmove(e, _this);
    });
    $('#' + _container + '_graficos').mouseup(function (e) {
      _this.dragend(e, _this);
    });
  }

  set_default() {
    this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
    this.ctx.beginPath();
    this.is_drawing = true;
    this.is_used = false;
  }
  set_resize() {
    this.canvas.setAttribute('width', $(this.responsive).width() - 35);
    this.canvas.setAttribute('height', $(this.responsive).width() / 2.8);
  }

  drawstart(_event, _class) {
    let pos = _class.getMousePos(_event, _class.canvas);
    _class.ctx.lineWidth = 4;
    _class.ctx.lineJoin = 'bevel';
    _class.ctx.strokeStyle = '#000';
    _class.ctx.beginPath();
    _class.ctx.moveTo(pos.x, pos.y);
    _class.is_drawing = false;
    _class.is_used = true;
  }
  drawmove(_event, _class) {
    let pos = _class.getMousePos(_event, _class.canvas);
    if (_class.is_drawing) return;
    else {
      _class.ctx.lineTo(pos.x, pos.y);
      _class.ctx.stroke();
    }
  }

  dragend(_event, _class) {
    if (_class.is_drawing) return;
    _class.drawmove(_event, _class);
    _class.is_drawing = true;
  }
  getMousePos(_event, _canvas) {
    var rect = _canvas.getBoundingClientRect();
    return {
      x: _event.clientX - rect.left,
      y: _event.clientY - rect.top,
    };
  }

  get get_blob() {
    return this.canvas.toDataURL();
  }

  get get_status() {
    return this.is_used;
  }
  set_status(_status) {
    this.is_used = _status;
  }

  set_blob(_blob) {
    let _ctx = this.ctx;
    this.image.onload = function (e) {
      _ctx.drawImage(this, 0, 0);
    };
    this.image.src = _blob;
  }

  set_image(_image) {
    let _ctx = this.ctx;
    let _canvas = this.canvas;

    this.set_default();

    this.image.onload = function (e) {
      _ctx.drawImage(
        this,
        0,
        0,
        this.width,
        this.height,
        0,
        0,
        _canvas.width,
        _canvas.height
      );
    };

    this.image.src = _image;
  }
}

// html
// <div class="canvas-container" id="canvas_firma_1"></div>

// js
//const json_firma_1 = {
//  id_container: 'canvas_firma_1',
//  title_label: 'firma 1 test',
//  responsive: '#canvas_firma_1',
// };

// let firma_1 = new canvas_firma(json_firma_1);

//$('#suboton').on('click', function (e) {
// console.log(firma_1.get_status);
// limpia el canvas y pone estatus = false
// firma_1.canvas_default();
// pone una imagen en el canvas
// firma_1.set_image('http://192.168.1.50/images/sin_imagen.png');
// obtiene el blob
// firma_1.get_blob;
// return false;
//});
