var mobile = (!matchMedia('@media screen and (min-width: 820px)'));

if (document.querySelector && !mobile) (function () { 
  //https://github.com/csnover/js-iso8601/blob/master/iso8601.js
  var noIsoDateParse = function (date) {
    var timestamp, struct, minutesOffset = 0, numericKeys = [ 1, 4, 5, 6, 7, 10, 11 ];
    if ((struct = /^(\d{4}|[+\-]\d{6})(?:-(\d{2})(?:-(\d{2}))?)?(?:T(\d{2}):(\d{2})(?::(\d{2})(?:\.(\d{3}))?)?(?:(Z)|([+\-])(\d{2})(?::(\d{2}))?)?)?$/.exec(date))) {
        for (var i = 0, k; (k = numericKeys[i]); ++i) {
            struct[k] = +struct[k] || 0;
        }
        struct[2] = (+struct[2] || 1) - 1;
        struct[3] = +struct[3] || 1;
        if (struct[8] !== 'Z' && struct[9] !== undefined) {
            minutesOffset = struct[10] * 60 + struct[11];
            if (struct[9] === '+') {
                minutesOffset = 0 - minutesOffset;
            }
        }
        timestamp = Date.UTC(struct[1], struct[2], struct[3], struct[4], struct[5] + minutesOffset, struct[6], struct[7]);
    }
    else {
        timestamp = origParse ? origParse(date) : NaN;
    }
    return timestamp;
  };

  var countdown = document.getElementById('countdown'),
      d = countdown.querySelector('div.days span.value'),
      h = countdown.querySelector('div.hour span.value'),
      m = countdown.querySelector('div.mins span.value'),
      s = countdown.querySelector('div.secs span.value'),
      timeString = countdown.getAttribute('datetime'),
      cutoff = 2,
      thefinalcountdown, // performed by europe
      r, // remaining time
      _s = 1000,
      _m = _s * 60,
      _h = _m * 60,
      _d = _h * 24;

  var time = new Date(timeString);
  if(time == 'NaN'){
    time = noIsoDateParse(timeString);
  }

  // TODO remove
  // time = new Date();

  var pad = function (number) {
    if (number < 10) {
      return "0" + number;
    }
    return number;
  };

  var theEndCallback = function () {};

  var theEnd = function () {
    clearInterval(thefinalcountdown);
    d.innerHTML = "ON";
    h.innerHTML = "SA";
    m.innerHTML = "LE";
    s.innerHTML = "!!";

    theEndCallback();
  };

  var timeRemaining = function () {
    return time - new Date;
  }

  function run() {
    r = timeRemaining();

    if (r > cutoff) {
      thefinalcountdown = setInterval(function () {
        r = timeRemaining();
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
  }

  $.extend($.easing, {
    easeOutQuad: function (x, t, b, c, d) {
      return -c *(t/=d)*(t-2) + b;
    }
  });

  function cleanup() {
    // console.log('cleaning up');
    document.documentElement.className = '';
    $('#dummy').hide();
    window.onscroll = null;
    localStorage.seenit = 1;
  }

  // if (localStorage.seenit) {
    // cleanup();
  // }


  $(window).load(function () {
    setTimeout(function () {
      var scroll = $('body').scrollTop();
      $(document.body).addClass('ready');
      // if (document.body.scrollIntoView) {
        // console.log(scroll, document.body.scrollTop);
        // console.log('preparing scroll effect');
        run();
        theEndCallback = function () {
          document.documentElement.className = '';
          window.onscroll = null;
          setTimeout(function () {
            // SLEDGEHAMMER => nail
            $('html,body').animate({
              scrollTop: 0
            }, 1500, 'easeOutQuad', function () {
              cleanup();
            });
          }, 500);
        };
        document.getElementById('dummy').scrollIntoView();
        // setTimeout(function () {
        //   window.onscroll = function () {
        //     theEndCallback = function () {};
        //     // console.log('killing effect');
        //     cleanup();
        //   };
        // }, 10);
      // } else {
        // console.log('not scrolling');
        // cleanup();
      // }
    }, 100);
  });
}()); // because crockford prefers his balls on the inside: http://www.youtube.com/watch?v=eGArABpLy0k#t=1m10s