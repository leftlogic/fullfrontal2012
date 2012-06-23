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

function displayPullout(e) {
  // This function could be a lot smarter, caching pullouts instead of throwing them away for example
  if (window.innerWidth < 640 || e.metaKey || e.ctrlKey || e.shiftKey) {
    return true;
  } else {
    window.location.hash = this.hash;
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
  var $link = $('a[href$="' + window.location.hash + '"]');
  if ($link.hasClass('pullout')) {
    // Remove one if it's already open

    $.get($link.attr('href'), function(data){
      //gown.addClass('blur');
      var $div = $('<div>').append(data.replace(re, '')),
          $pullout = $div.find('#pullout').wrapAll('<div id="pullout-wrapper">').parent();
      $body.append($tint);
      $body.append($pullout);

      $pullout.css({
        top: document.body.scrollTop + 50
      });
    });
  }
};

$(document).delegate('.pullout', 'click', displayPullout);

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