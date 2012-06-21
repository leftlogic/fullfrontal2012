$gown = $('#dressing-gown');
$tint = $('<div>').css({
  position: 'fixed',
  top: '0',
  bottom: '0',
  left: '0',
  right: '0',
  'background-color': 'rgba(0,0,0,0.75)',
  'z-index': 50
})

$('.schedule a.summary').add('.workshop .title').click(function (e) {

  if(window.innerWidth < 640) {
    return true;
  }

  e.preventDefault();

  $.get($(this)[0], function(data){

    console.log(data);
    
    //$gown.addClass('blur');

    $('body').append($("<div>").append(data.replace(/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi, "")).find('#pullout'));
    $('body').append($tint);

    $pullout = $('#pullout');
    $pullout.position({
        my: 'top',
        at: 'top',
        collision: 'none',
        offset: '0 50px',
        of: window
    });
    $('.pullout-close').click(function () {
      $pullout.remove();
      $tint.remove();
      //$gown.removeClass('blur');
      return false;
    });
  });
  return false;
})




function addClass(el, c) {
  var className = el.className;
  
  if ((' ' + className + ' ').indexOf(' ' + c + ' ') !== false) {
    // add
    el.className = className + ' ' + c;
  }
}

// thank you jQuery...
var triml = /^\s+/,
    trimr = /\s+$/;

function removeClass(el, c) {
  el.className = (' ' + el.className + ' ').replace(' ' + c + ' ', '').replace(triml, '').replace(trimr, '');
}

function genMarkers(venues, icon) {
  var len = venues.length;

  for (var i = 0; i < len; i++) {
    !function (i) {
      var el = venues[i],
          latlng = el.getAttribute('data-latlng').split(','),
          venueLocation = new google.maps.LatLng(latlng[0], latlng[1]),
          standardIcon = new google.maps.MarkerImage(
            iconURL,
            new google.maps.Size(icon.width, icon.height, 'px', 'px'),
            new google.maps.Point(i * icon.width, icon.origin),
            icon.point
          ),
          hoverIcon = new google.maps.MarkerImage(
            iconURL,
            new google.maps.Size(icon.width, icon.height, 'px', 'px'),
            new google.maps.Point(i * icon.width, icon.origin + icon.height),
            icon.point
          ),
          marker = new google.maps.Marker({
            position: venueLocation,
            flat: true,
            icon: standardIcon
          }),
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
    }(i);
  }
}

function newHoverIconAction(el, latlng, marker, standardIcon, hoverIcon) {
  return function (event) {
    event = event || window.event;
    if (event.type === 'mouseover') {
      marker.setZIndex(++zIndex);
      marker.setIcon(hoverIcon);
      addClass(el, 'selected');
      // don't use the pageX - just using it to determine that we hovered from the li, not a google hover
      //if (event.clientX) map.panTo(latlng);
    } else {
      marker.setIcon(standardIcon);
      removeClass(el, 'selected');
    }
  };
}

var iconURL = '/images/map-markers.png',
    smallIcon = {
      point: new google.maps.Point(11, 43),
      width: 29,
      height: 45,
      origin: 0
    },
    largeIcon = {
      point: new google.maps.Point(21, 83),
      width: 55,
      height: 85,
      origin: 90
    },   
    map = new google.maps.Map(document.getElementById('map'), {
      center: new google.maps.LatLng(50.8339238, -0.1385427),
      zoom: 14,
      mapTypeId: 'Toner',
      disableDefaultUI: true,
      zoomControl: true,
      scrollwheel: false
    }),
    pV = document.querySelectorAll('.primary-venue'),
    sV = document.querySelectorAll('.secondary-venue'),
    bounds = new google.maps.LatLngBounds(),
    zIndex = google.maps.Marker.MAX_ZINDEX;

map.mapTypes.set('Toner', new google.maps.StamenMapType('toner'));

genMarkers(sV, smallIcon);
genMarkers(pV, largeIcon);

map.fitBounds(bounds);
