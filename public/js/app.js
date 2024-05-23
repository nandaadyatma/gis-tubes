// LEAFLET.JS
var map = L.map("map", {}).setView([-8.621213, 115.086804], 11);

let currentSelectedLocation = null

let listLocation = [];
let listMarker = [];

L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
  maxZoom: 19, //max zoom
  attribution:
    '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>', //copyright
}).addTo(map);

L.marker([-8.621213, 115.086804]).addTo(map);

var currectLocationMarker = L.icon({
  iconUrl: 'img/point.png',
  iconSize:     [20, 20], 
  iconAnchor:   [10, 10], 
  popupAnchor:  [0, 0]

});

navigator.geolocation.getCurrentPosition(position => {
  const { coords: { latitude, longitude }} = position;
  
  var marker = new L.marker([latitude, longitude], {
  draggable: false,
  autoPan: true
  }).addTo(map);

  var path = [];

  map.setView([latitude, longitude], 10);

  marker.bindPopup("Posisi kamu").openPopup();
  console.log(marker);
})


        var markers = []; //contain points
        var polyline = L.polyline([], {
          color: '#1A65BD',
          weight: 5
        }).addTo(map);

        // Fungsi untuk menambahkan marker baru
        function addMarker(lat, lng) {
            var marker = L.marker([lat, lng], {draggable: true, icon: currectLocationMarker}).addTo(map);

            marker.on('drag', function(event) {
                updatePolyline();
            });

            markers.push(marker);
            updatePolyline();
        }

        // Fungsi untuk mengupdate polyline
        function updatePolyline() {
            var latlngs = markers.map(function(marker) {
                return marker.getLatLng();
            });
            polyline.setLatLngs(latlngs);
            console.log(markers);
        }

    
        

        // Event listener untuk menambahkan marker dengan klik pada peta
        map.on('click', function(event) {
            addMarker(event.latlng.lat, event.latlng.lng);
        });


    

        
     
       

