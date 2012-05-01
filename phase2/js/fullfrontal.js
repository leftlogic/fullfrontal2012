(function () { 
  var countdown = document.getElementById('countdown'),
      d = countdown.getElementsByClassName('days')[0].getElementsByClassName('value')[0],
      h = countdown.getElementsByClassName('hour')[0].getElementsByClassName('value')[0],
      m = countdown.getElementsByClassName('mins')[0].getElementsByClassName('value')[0],
      s = countdown.getElementsByClassName('secs')[0].getElementsByClassName('value')[0],
      time = new Date(countdown.getAttribute('datetime')),
      r = Math.floor(time - new Date()),
      cutoff = 3,
      thefinalcountdown;

  var pad = function (number) {
    if (number < 10) {
      return "0" + number;
    }
    return number;
  };
  
  if (r > 5) {  
    setInterval(function () {  
      var _s = 1000,
          _m = _s * 60,
          _h = _m * 60,
          _d = _h * 24,
          rd = Math.floor(r / _d),
          rh = Math.floor((r % _d) / _h),
          rm = Math.floor((r % _h) / _m),
          rs = Math.floor((r % _m) / _s);

      d.innerHTML = pad(rd);
      h.innerHTML = pad(rh);
      m.innerHTML = pad(rm);
      s.innerHTML = pad(rs);
    }, 1000);
  } else {
    d.innerHTML = "00";
    h.innerHTML = "00";
    m.innerHTML = "00";
    s.innerHTML = pad(cutoff--);

    thefinalcountdown = setInterval(function () {
      s.innerHTML = pad(cutoff--);
      if (cutoff < 0) {
        clearInterval (thefinalcountdown);

        d.innerHTML = "ON";
        h.innerHTML = "SA";
        m.innerHTML = "LE";
        s.innerHTML = "!!";
      }
    }, 1000)
  }
})();