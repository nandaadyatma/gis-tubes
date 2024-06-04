// LEAFLET.JS
var map = L.map("map", {})

let currentSelectedLocation = null

let listLocation = [];
let listMarker = [];
let roadDistanceMarker = [];

L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
  maxZoom: 19, //max zoom
  minZoom: 10,
  attribution:
    '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>', 
}).addTo(map);




// SideBar

let isSideBarOpen = false

var pointNumberElement = document.getElementById('pointNumber');



document.getElementById('toggleSidebarBtn').onclick = function() {
  var sidebar = document.getElementById('sidebar');
  sidebar.classList.toggle('show');
  var sideBarButton = document.getElementById('toggleSidebarBtn');
  sideBarButton.classList.toggle('show');
  var polylineMenu = document.getElementById('polylineMenu');
  polylineMenu.classList.toggle('show');
  var mapSide = document.getElementById('map');
  mapSide.classList.toggle('slide');

  

  isSideBarOpen = !isSideBarOpen;
  if(isSideBarOpen){sideBarButton.innerHTML = '<i class="bi bi-chevron-right"></i>';} else {
    sideBarButton.innerHTML = '<i class="bi bi-chevron-left"></i>';
  }
};

// Map Point and Line

var currectLocationMarker = L.icon({
  iconUrl: 'img/point.png',
  iconSize:     [20, 20], 
  iconAnchor:   [10, 10], 
  popupAnchor:  [0, 0]

});

var widthRoadMarker = L.icon({
  iconUrl: 'img/cross.png',
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

  if(!latitude || !longitude){
    map.setView([ -8.52670, 115.26718], 12);
  } else {
    map.setView([latitude, longitude], 12);
  }


  marker.bindPopup("Posisi kamu").openPopup();
  console.log(marker);
})


        var markers = []; //contain points
        var polyline = L.polyline([], {
          color: '#229F4A',
          weight: 5
        }).addTo(map);

        function deletePoint(marker) {
          map.removeLayer(marker);

          markers = markers.filter(m => m !== marker);
      }

     

        // Fungsi untuk menambahkan marker baru
        function addMarker(lat, lng) {
            var marker = L.marker([lat, lng], {draggable: true, icon: currectLocationMarker}).addTo(map);

            marker.on('drag', function(event) {
                updatePolyline();
                var customPopup = "<b>Total titik: " + markers.length + "</b><br>"  +
                  "Lat: " + marker.getLatLng().lat.toFixed(5) + "<br>" +
                  "Lng: " + marker.getLatLng().lng.toFixed(5) + "<br>"  +
                  "Total jarak: " + getDistanceBetweenMarkers(getLatLngArrayFromMarkers(markers)).toFixed(1) + " m";

              marker.bindPopup(customPopup).openPopup();
            });

            markers.push(marker);

          

            if(markers.length > 1){
              var customPopup = "<b>Total titik: " + markers.length + "</b><br>" +
                  "Lat: " + marker.getLatLng().lat.toFixed(5) + "<br>" +
                  "Lng: " + marker.getLatLng().lng.toFixed(5) + "<br>"  +
                  "Total jarak: " + getDistanceBetweenMarkers(getLatLngArrayFromMarkers(markers)).toFixed(1) + " m" + "<br><br>";
              
                    

              marker.bindPopup(customPopup);

              

              

              // Open sidebar to let user save road
                  var sidebar = document.getElementById('sidebar');
                  // alert(rightPositionValue + " " + isSideBarOpen);
                  if(isSideBarOpen == false){
                    sidebar.classList.toggle('show');
                    var sideBarButton = document.getElementById('toggleSidebarBtn');
                    sideBarButton.classList.toggle('show');
                    isSideBarOpen = !isSideBarOpen;
                    var polylineMenu = document.getElementById('polylineMenu')
                    polylineMenu.classList.toggle('show')
                    var mapSide = document.getElementById('map')
                    mapSide.classList.toggle('slide')
                    
                    if(isSideBarOpen){sideBarButton.innerHTML = '<i class="bi bi-chevron-right"></i>';} else {
                      sideBarButton.innerHTML = '<i class="bi bi-chevron-left"></i>';
                    }
                  }
                
            }

            

            updatePolyline();

            document.getElementById('polylineMenu').style.visibility = "visible";

            

            
        }

        document.getElementById("deletePoint").addEventListener("click", 
        function(){
            if (markers.length === 0){
              return;
            }

            if (markers.length === 1){
              document.getElementById('polylineMenu').style.visibility = "hidden";
            }
            

            

            // Hapus marker terakhir dari peta dan dari array
            var lastMarker = markers.pop();
            map.removeLayer(lastMarker);
            updatePolyline();
          });

        // update polyline
        function updatePolyline() {
            var latlngs = markers.map(function(marker) {
                return marker.getLatLng();
            });
            polyline.setLatLngs(latlngs);
            console.log(markers);

            console.log(getLatLngArrayFromMarkers(markers));
            console.log(encodePolyline(getLatLngArrayFromMarkers(markers)));
            console.log(decodePolyline(encodePolyline(getLatLngArrayFromMarkers(markers))));
            console.log(getDistanceBetweenMarkers(getLatLngArrayFromMarkers(markers)));

            //insert encode data to hiddenValue 
            let encodePath = document.getElementById('hiddenEncodePath');
            encodePath.value = encodePolyline(getLatLngArrayFromMarkers(markers));

            console.log(encodePath.value);

            // insert realtime selected distance road data
            let roadDistanceData = getDistanceBetweenMarkers(getLatLngArrayFromMarkers(markers)).toFixed(1)
            document.getElementById('roadDistance').value = roadDistanceData;

            pointNumberElement.innerHTML = `Total point: ${markers.length}`
        }

        var roadWidthInput = document.getElementById('roadWidth');

        roadWidthInput.addEventListener('focus', function() {
          console.log('Input field is focused!');
          console.log(markers[0].getLatLng())
      });

      // Event listener untuk click event
      roadWidthInput.addEventListener('click', function() {
          getRoadWidth();
          console.log(markers[markers.length])
      });

        function getRoadWidth(){
          console.log("clicked");
          let n = markers.length - 1
          
          map.closePopup();

          if(roadDistanceMarker.length > 1 || markers.length < 1){ return; }
          else {
            let latlngs1 = markers[n].getLatLng();

                  var widthLine = L.polyline([], {
                    color: '#FF6B3D',
                    weight: 5
                  }).addTo(map);

                  map.setView(markers[n].getLatLng(), 19);

                  roadDistanceMarker.push(L.marker([latlngs1.lat - (0.00004), latlngs1.lng - (0.00004)], {draggable: true, icon: widthRoadMarker}).addTo(map));
                  roadDistanceMarker.push(L.marker([latlngs1.lat + (0.00004), latlngs1.lng + (0.00004)], {draggable: true, icon: widthRoadMarker}).addTo(map));
                  var customPopup = '<h6>Geser sesuai lebar jalan</h6><img src="img/roadWidthDemo.gif" alt="Width Line Demo" style="width: 200px">' ;

                    roadDistanceMarker[1].bindPopup(customPopup).openPopup();
                  updateWidthLine();

                  roadDistanceMarker[0].on('drag', function(event) {
                    updateWidthLine();
                      var customPopup = "<b>Total jarak: " + getDistanceBetweenMarkers(getLatLngArrayFromMarkers(roadDistanceMarker)).toFixed(1) + " meter </b><br>"  +
                        "Lat: " + roadDistanceMarker[0].getLatLng().lat.toFixed(5) + "<br>" +
                        "Lng: " + roadDistanceMarker[0].getLatLng().lng.toFixed(5) + "<br>" ;

                    roadDistanceMarker[0].bindPopup(customPopup).openPopup();
                  });

                  roadDistanceMarker[1].on('drag', function(event) {
                    updateWidthLine();
                      var customPopup = "<b>Total jarak: " + getDistanceBetweenMarkers(getLatLngArrayFromMarkers(roadDistanceMarker)).toFixed(1) + " meter </b><br>"  +
                        "Lat: " + roadDistanceMarker[1].getLatLng().lat.toFixed(5) + "<br>" +
                        "Lng: " + roadDistanceMarker[1].getLatLng().lng.toFixed(5) + "<br>" ;

                    roadDistanceMarker[1].bindPopup(customPopup).openPopup();
                  });

                    function updateWidthLine() {
                      var latlngs = roadDistanceMarker.map(function(marker) {
                          return marker.getLatLng();
                      });
                      widthLine.setLatLngs(latlngs);

                      let roadWidth = getDistanceBetweenMarkers(getLatLngArrayFromMarkers(roadDistanceMarker));
                      console.log(roadWidth.toFixed(1));

                      document.getElementById('roadWidth').value = roadWidth.toFixed(1);
                  }

                  return getDistanceBetweenMarkers(getLatLngArrayFromMarkers(roadDistanceMarker));



          }
          
        }

        function getLatLngArrayFromMarkers(markers){
          let markerLatLng = []
          markers.forEach(marker => {
            let lat = marker.getLatLng().lat;
            let lng = marker.getLatLng().lng;
            markerLatLng.push([lat, lng]);

          });
          return markerLatLng

        }

        

        function getDistanceBetweenMarkers(latLngs){
          let totalDistance = 0
          for (let index = 0; index < latLngs.length - 1; index++) {
            let PointA = L.latLng(latLngs[index][0], latLngs[index][1]);
            let PointB = L.latLng(latLngs[index + 1][0], latLngs[index + 1][1]);
            totalDistance += PointA.distanceTo(PointB);
          }
          return totalDistance
        }

    
        

        // Event listener untuk menambahkan marker dengan klik pada peta
        map.on('click', function(event) {
            addMarker(event.latlng.lat, event.latlng.lng);
        });


    
        function encodePolyline(coordinates) {
          let factor = 1e5; // More typical precision
          let encodedString = '';
          let prevLat = 0;
          let prevLng = 0;
      
          coordinates.forEach(([lat, lng]) => {
              let latCode = Math.round(lat * factor);
              let lngCode = Math.round(lng * factor);
      
              let dLat = latCode - prevLat;
              let dLng = lngCode - prevLng;
      
              [dLat, dLng].forEach(num => {
                  num = num << 1;
                  if (num < 0) {
                      num = ~num;
                  }
                  while (num >= 0x20) {
                      encodedString += String.fromCharCode((0x20 | (num & 0x1f)) + 63);
                      num >>= 5;
                  }
                  encodedString += String.fromCharCode(num + 63);
              });
      
              prevLat = latCode;
              prevLng = lngCode;
          });
      
          return encodedString;
      }
      
      function decodePolyline(encoded) {
          let points = [];
          let index = 0, len = encoded.length;
          let lat = 0, lng = 0;
          let factor = 1e5;  // Match the more typical precision
      
          while (index < len) {
              let b, shift = 0, result = 0;
              do {
                  b = encoded.charCodeAt(index++) - 63;
                  result |= (b & 0x1f) << shift;
                  shift += 5;
              } while (b >= 0x20);
              let dlat = ((result & 1) ? ~(result >> 1) : (result >> 1));
              lat += dlat;
      
              shift = 0;
              result = 0;
              do {
                  b = encoded.charCodeAt(index++) - 63;
                  result |= (b & 0x1f) << shift;
                  shift += 5;
              } while (b >= 0x20);
              let dlng = ((result & 1) ? ~(result >> 1) : (result >> 1));
              lng += dlng;
      
              points.push([lat / factor, lng / factor]);
          }
      
          return points;
      }
      
        
      document.addEventListener('DOMContentLoaded', function() {
        var alert = document.getElementById('alert');
        if(alert) {
            setTimeout(function(){
                alert.style.display = 'none';
            }, 2000); // 5000 milidetik = 5 detik
        }
    });
       

