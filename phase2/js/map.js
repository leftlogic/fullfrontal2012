var map = document.getElementById('map');

map = new google.maps.Map(map, {
  center: new google.maps.LatLng(50.833, -0.139),
  zoom: 14,
  mapTypeId: 'Toner',
  disableDefaultUI: true
});
map.mapTypes.set('Toner', new google.maps.StamenMapType('toner')); 