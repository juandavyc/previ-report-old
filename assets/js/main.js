(function ($) {
  var $window = $(window),
    $body = $('body'),
    $header = $('#header'),
    $banner = $('#banner');

  // Breakpoints.
  breakpoints({
    wide: ['1281px', '1680px'],
    normal: ['981px', '1280px'],
    narrow: ['841px', '980px'],
    narrower: ['737px', '840px'],
    mobile: [null, '736px'],
  });

  // Play initial animations on page load.
  // $window.on('load', function () {
  //   $('.container-loader')
  //     .delay(500)
  //     .fadeOut(500)
  //     .promise()
  //     .then(function () {
  //       $(this).remove();
  //       // Nav Panel.
  //       $(
  //         '<div id="navButton">' +
  //         '<a href="#navPanel" class="toggle"></a>' +
  //         '<span class="title">' +
  //         $('#logo').html() +
  //         '</span>' +
  //         '</div>'
  //       ).appendTo($body);
  //     });
  // });

  // Scrolly.
  $('.scrolly').scrolly({
    speed: 1000,
    offset: function () {
      return $header.height() + 10;
    },
  });

  // Dropdowns.
  $('#nav > ul').dropotron({
    mode: 'fade',
    noOpenerFade: true,
    expandMode: browser.mobile ? 'click' : 'hover',
  });

  // Panel.
  $('<div id="navPanel">' + '<nav>' + $('#nav').navList() + '</nav>' + '</div>')
    .appendTo($body)
    .panel({
      delay: 500,
      hideOnClick: true,
      hideOnSwipe: true,
      resetScroll: true,
      resetForms: true,
      side: 'left',
      target: $body,
      visibleClass: 'navPanel-visible',
    });

  // Fix: Remove navPanel transitions on WP<10 (poor/buggy performance).
  if (browser.os == 'wp' && browser.osVersion < 10)
    $('#navButton, #navPanel, #page-wrapper').css('transition', 'none');

  // Header.
  if (!browser.mobile && $header.hasClass('alt') && $banner.length > 0) {
    $window.on('load', function () {
      $banner.scrollex({
        bottom: $header.outerHeight(),
        terminate: function () {
          $header.removeClass('alt');
        },
        enter: function () {
          $header.addClass('alt reveal');
        },
        leave: function () {
          $header.removeClass('alt');
        },
      });
    });
  }
  $window.on('load', function () {
    $(
      '<div id="navButton">' +
      '<a href="#navPanel" class="toggle"></a>' +
      '<span class="title">' +
      $('#logo').html() +
      '</span>' +
      '</div>'
    ).appendTo($body);
    $body.removeClass('is-preload');
    window.setTimeout(function () {
      $body.removeClass("landing");

    }, 500);
  })
})(jQuery);

$('#menu-' + $('body').attr('data-id')).addClass('current');

function isValidDate(s) {
  let bits = s.split('/');
  let d = new Date(bits[2] + '/' + bits[1] + '/' + bits[0]);
  return !!(d && d.getMonth() + 1 == bits[1] && d.getDate() == Number(bits[0]));
}

const PROTOCOL_HOST =
  $(location).attr('protocol') + '//' + $(location).attr('host');

let json_ip = 'SIN_DIRECCION_IP';
/*
$.getJSON('https://api.ipify.org?format=jsonp&callback=?', function (data) {
  json_ip = data.ip;
});
*/
let json_dispositivo = navigator.userAgent;
