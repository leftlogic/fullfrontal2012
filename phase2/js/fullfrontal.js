$('html').removeClass('noJS');

var $tabContent = $('.tab-content .wrapper').addClass('tab-hidden'),
    $tabs = $('.tab');

window.onhashchange = function () {
    var $match = $tabs.filter('[href$="' + location.hash + '"]');
    if ($match.length) {
      $tabs.removeClass('tab-selected');
      $match.addClass('tab-selected');
      $tabContent.addClass('tab-hidden').filter(location.hash).removeClass('tab-hidden');
    }
};

if (location.hash) window.onhashchange();

(function () { 
  var countdown = document.getElementById('countdown'),
      d = countdown.querySelector('.days .value'),
      h = countdown.querySelector('.hour .value'),
      m = countdown.querySelector('.mins .value'),
      s = countdown.querySelector('.secs .value'),
      time = new Date(countdown.getAttribute('datetime')),
      cutoff = 5,
      thefinalcountdown,
      r, // remaining time
      _s = 1000,
      _m = _s * 60,
      _h = _m * 60,
      _d = _h * 24;

  var pad = function (number) {
    if (number < 10) {
      return "0" + number;
    }
    return number;
  };

  var theEnd = function () {
    clearInterval(thefinalcountdown);
    d.innerHTML = "ON";
    h.innerHTML = "SA";
    m.innerHTML = "LE";
    s.innerHTML = "!!";
  }
  
  setTimeout(function () {
    r = (time - new Date()) | 0;
    if (r > cutoff) {  
      thefinalcountdown = setInterval(function () {
        r = (time - new Date()) | 0;
        var rd = Math.floor(r / _d),
            rh = Math.floor((r % _d) / _h),
            rm = Math.floor((r % _h) / _m),
            rs = Math.floor((r % _m) / _s);

        d.innerHTML = pad(rd);
        h.innerHTML = pad(rh);
        m.innerHTML = pad(rm);
        s.innerHTML = pad(rs);

        if (r < 0) {
          theEnd();
        }
      }, 1000);
    } else {
      d.innerHTML = "00";
      h.innerHTML = "00";
      m.innerHTML = "00";
      s.innerHTML = pad(cutoff--);

      thefinalcountdown = setInterval(function () {
        s.innerHTML = pad(cutoff--);
        if (cutoff < 0) {
          theEnd();
        }
      }, 1000);
    }
  }, 3000);
})();