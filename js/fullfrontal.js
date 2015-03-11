/*! matchMedia() polyfill - Test a CSS media type/query in JS. Authors & copyright (c) 2012: Scott Jehl, Paul Irish, Nicholas Zakas. Dual MIT/BSD license */

window.matchMedia = window.matchMedia || (function(doc, undefined){

  var bool,
      docElem  = doc.documentElement,
      refNode  = docElem.firstElementChild || docElem.firstChild,
      // fakeBody required for <FF4 when executed in <head>
      fakeBody = doc.createElement('body'),
      div      = doc.createElement('div');

  div.id = 'mq-test-1';
  div.style.cssText = "position:absolute;top:-100em";
  fakeBody.style.background = "none";
  fakeBody.appendChild(div);

  return function(q){

    div.innerHTML = '&shy;<style media="'+q+'"> #mq-test-1 { width: 42px; }</style>';

    docElem.insertBefore(fakeBody, refNode);
    bool = div.offsetWidth === 42;
    docElem.removeChild(fakeBody);

    return { matches: bool, media: q };
  };

}(document));


function displayPullout(e) {
  // This function could be a lot smarter, caching pullouts instead of throwing them away for example
  if (window.innerWidth < 640 || e.metaKey || e.ctrlKey || e.shiftKey) {
    return true;
  } else {
    if (this.hash) {
      window.location.hash = this.hash;  
    } else {
      if (e.target.nodeName == "A") return true;
      window.location.hash = $(this).data('hash');
    }
    
    return false;
  }
}

var $tint = $('<div>').css({
      position: 'fixed',
      top: '0',
      bottom: '0',
      left: '0',
      right: '0',
      'background-color': 'rgba(0,0,0,0.75)',
      'z-index': 50
    }).click(function () { window.location.hash = ''; return false; }),
    $body = $('body'),
    re = /<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi,
    // globals for the map
    iconURL, smallIcon, largeIcon, map, pV, sV, bounds, zIndex;

// router
window.onhashchange = function () {
  // make sure this is a pullout
  $('#pullout-wrapper').remove();
  $tint.remove();
  var $link = $('[href$="' + window.location.hash + '"]');
  if ($link.length == 0) {
    $link = $('[data-href$="' + window.location.hash + '"]');
  }

  if ($link.hasClass('pullout')) {
    // Remove one if it's already open

    $.get($link.attr('href') || $link.data('href'), function(data){
      //gown.addClass('blur');
      var $div = $('<div>').append(data.replace(re, '')),
          $pullout = $div.find('#pullout').wrapAll('<div id="pullout-wrapper">').parent();
      $body.append($tint);
      $body.append($pullout);

      $pullout.css({
        top: $(window).scrollTop() + 50
      });
    });
  }
};

$(document).delegate('.pullout', 'click', displayPullout);
$(document).delegate('[data-href]', 'click', displayPullout);


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

var dirty,
    pageYOffset = window.pageYOffset === undefined ? document.body.scrollTop : window.pageYOffset;

var updateSchedule = function (now) {
  if(now >= new Date('2012-11-09T17:35') && dirty) {
    $('.finished').removeClass('finished');
    $('.current').removeClass('current');
    $('.time').show();
    $('.done').hide();
    return;
  }
  if(now < new Date('2012-11-06T08:00') || now >= new Date('2012-11-09T17:35')) {
    return;
  }

  dirty = true;

  var $allTalks = $('#schedule').find('.vevent').each(function () {
    var $this = $(this),
        start = $this.find('.dtstart').attr('datetime'),
        end = $this.find('.dtend').attr('datetime'),
        stime = new Date(start),
        etime = new Date(end);
    
    if (stime == 'NaN') {
      stime = noIsoDateParse(start);
    }
    if (etime == 'NaN') {
      etime = noIsoDateParse(end);
    }

    if (etime < now) {
      $this.addClass('finished').find('.time').hide();
      $this.addClass('finished').find('.done').show();
    }
    if (stime < now && etime > now) {
      $this.addClass('now');      
    }
    if ( (etime - now) < (1000 * 60 * 15) ) {
      $this.removeClass('talk current');
    }
  }).filter('.talk');

  $allTalks.removeClass('current');
  var $next = $allTalks.eq($('.talk').filter('.finished').length).addClass('current');

  $('.next').hide();
  if (!$next.hasClass('now')) {
    $next.find('.time').find('.next').show();
  }

  if (!pageYOffset && (!location.hash || location.hash === '#?')) {
      $(document).scrollTop($next.position().top - 7);
  }

  setTimeout(function () {
    updateSchedule(+new Date);
  }, 1000 * 60);
};

updateSchedule(+new Date);

var debugSchedule = function () {
  var i = new Date('2012-11-09T08:00'), j = (1000 * 60 * 8);
  setInterval(function () {
    updateSchedule(i);
    console.log(i);
    i = new Date(i.getTime() + j);
  }, 500);
};


/* Map Stuff */
(function () {

function genMarkers(venues, icon) {
  var len = venues.length,
      el,
      latlng,
      venueLocation,
      standardIcon,
      hoverIcon,
      marker,
      hoverIconAction,
      i;

  for (i = 0; i < len; i++) {
    el = venues[i];
    latlng = el.getAttribute('data-latlng').split(',');
    venueLocation = new google.maps.LatLng(latlng[0], latlng[1]);
    standardIcon = new google.maps.MarkerImage(
      iconURL,
      new google.maps.Size(icon.width, icon.height, 'px', 'px'),
      new google.maps.Point(i * icon.width, icon.origin),
      icon.point
    );
    hoverIcon = new google.maps.MarkerImage(
      iconURL,
      new google.maps.Size(icon.width, icon.height, 'px', 'px'),
      new google.maps.Point(i * icon.width, icon.origin + icon.height),
      icon.point
    );
    marker = new google.maps.Marker({
      position: venueLocation,
      flat: true,
      icon: standardIcon
    });

    hoverIconAction = newHoverIconAction(el, venueLocation, marker, standardIcon, hoverIcon);
    bounds.extend(venueLocation);

    // event handlers - sweeeeeeet HAWT ::rasp::
    google.maps.event.addListener(marker, 'mouseover', function () {
      hoverIconAction({ type: 'mouseover' });
    });
    google.maps.event.addListener(marker, 'mouseout', function () {
      hoverIconAction({ type: 'mouseout' });
    });

    el.onmouseover = hoverIconAction;
    el.onmouseout = hoverIconAction;

    marker.setMap(map);
  }
}

function newHoverIconAction(el, latlng, marker, standardIcon, hoverIcon) {
  var $el = $(el);
  return function (event) {
    event = event || window.event;
    if (event.type === 'mouseover') {
      marker.setZIndex(++zIndex);
      marker.setIcon(hoverIcon);
      $el.addClass('selected');
      // don't use the pageX - just using it to determine that we hovered from the li, not a google hover
      if (event.clientX) map.panTo(latlng);
    } else {
      marker.setIcon(standardIcon);
      $el.removeClass('selected');
    }
  };
}

// do the map after the page has loaded
$(window).load(function () {
  // allow the window to scroll before loading the popup
  if (location.hash) window.onhashchange();

  iconURL = '/images/map-markers.png';
  smallIcon = {
    point: new google.maps.Point(11, 43),
    width: 29,
    height: 45,
    origin: 0
  };
  largeIcon = {
    point: new google.maps.Point(21, 83),
    width: 55,
    height: 85,
    origin: 90
  };
  map = new google.maps.Map(document.getElementById('map'), {
    center: new google.maps.LatLng(50.8339238, -0.1385427),
    zoom: 14,
    mapTypeId: 'Toner',
    disableDefaultUI: true,
    zoomControl: true,
    scrollwheel: false
  });
  pV = document.querySelectorAll('.primary-venue');
  sV = document.querySelectorAll('.secondary-venue');
  bounds = new google.maps.LatLngBounds();
  zIndex = google.maps.Marker.MAX_ZINDEX;


  map.mapTypes.set('Toner', new google.maps.StamenMapType('toner'));

  genMarkers(sV, smallIcon);
  genMarkers(pV, largeIcon);

  map.fitBounds(bounds);
});

}()); // because crockford prefers his balls on the inside: http://www.youtube.com/watch?v=eGArABpLy0k#t=1m10s
