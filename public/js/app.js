// LEAFLET.JS
var map = L.map("map").setView([-8.621213, 115.086804], 11);

let currentSelectedLocation = null

let listLocation = [];
let listMarker = [];

L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
  maxZoom: 19, //max zoom
  attribution:
    '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>', //copyright
}).addTo(map);

L.marker([51.5, -0.09], {icon: currectLocationMarker}).addTo(map);

navigator.geolocation.getCurrentPosition(position => {
  const { coords: { latitude, longitude }} = position;
  
  var marker = new L.marker([latitude, longitude], {
  draggable: false,
  icon: currectLocationMarker,
  autoPan: true
  }).addTo(map);

  map.setView([latitude, longitude], 20);

  marker.bindPopup("<b>Hello, you're here!").openPopup();
  console.log(marker);
})