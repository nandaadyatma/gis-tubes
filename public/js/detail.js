// LEAFLET.JS
var map = L.map("map", {}).setView([-8.52670, 115.26718], 12);

L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
  maxZoom: 19, //max zoom
  minZoom: 10,
  attribution:
    '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
}).addTo(map);




// SideBar

var decodePaths = []

let isSideBarOpen = false
var bounds
var polyline = null
var latLngs = [];

var roadData = []

let token2 = document.getElementById('hiddenField').value;
let roadId = document.getElementById('roadId').value;



var deleteButton = document.getElementById('deleteRoadButton')




function getDetailDataById(id) {
  axios.get('https://gisapis.manpits.xyz/api/ruasjalan/' + id, {
    headers: {
      'Authorization': `Bearer ${token2}`
    }
  }).then(response => {
    console.log(response.data.ruasjalan.paths);
    console.log(decodePolyline(response.data.ruasjalan.paths));

    switch (response.data.ruasjalan.kondisi_id) {
      case 1: {
        polyline = L.polyline([], {
          color: '#1CC861',
          weight: 5
        }).addTo(map);
      }
        break;
      case 2: {
        polyline = L.polyline([], {
          color: '#FFBD13',
          weight: 5
        }).addTo(map);
      }
        break;

      case 3: {
        polyline = L.polyline([], {
          color: '#F93844',
          weight: 10
        }).addTo(map);
      }

        break;

      default:
        break;
    }



    roadData.push(response.data.ruasjalan);
    console.log(roadData);

    var keterangan = document.getElementById('additionalInformation');
    var nama = document.getElementById('roadName');
    var kode = document.getElementById('roadCode');
    var kondisi = document.getElementById('roadCondition');
    var lebar = document.getElementById('roadWidth')
    var idDesa = document.querySelector('#vilageId');

    keterangan.value = roadData[0].keterangan;
    nama.value = roadData[0].nama_ruas;
    kode.value = roadData[0].kode_ruas;
    kondisi.value = roadData[0].kondisi_id;
    lebar.value = roadData[0].lebar;
    idDesa.value = roadData[0].desa_id;

    function setDefaultVillageDistrictCity() {

      let villageId = roadData[0].desa_id;

      axios.get(`https://gisapis.manpits.xyz/api/kecamatanbydesaid/${villageId}`, {
        headers: {
          'Authorization': `Bearer ${token}`
        }
      }).then(response => {

        var data = response.data
        console.log(data)

        // const citySelect = document.getElementById('city');
        // const districtSelect = document.getElementById('district');
        // const villageSelect = document.getElementById('village');
        // citySelect.innerHTML = `<option value="${data.kabupaten.id}">${data.kabupaten.kabupaten}</option>`;
        // districtSelect.innerHTML = `<option value="${data.desa.id}">${data.desa.desa}</option>`;
        // villageSelect.innerHTML = `<option value="${data.kecamatan.id}">${data.kecamatan.kecamatan}</option>`;

        // Fetch initial city data
        axios.get(`https://gisapis.manpits.xyz/api/kabupaten/1`, {
          headers: {
            'Authorization': `Bearer ${token}`
          }
        })
          .then(response => {
            console.log(response.data.kabupaten);
            const cities = response.data;
            const citySelect = document.getElementById('city');

            citySelect.innerHTML = `<option value="${data.kabupaten.id}">${data.kabupaten.kabupaten}</option>`;

            response.data.kabupaten.forEach(city => {
              const option = document.createElement('option');
              option.value = city.id;
              option.text = city.value;
              citySelect.appendChild(option);
            });
          })
          .catch(error => console.error('Error fetching cities:', error));

        // Fetch Default Kecamatan

        const cityId = data.kabupaten.id;
        const districtId = data.kecamatan.id;
        const districtSelect = document.getElementById('district');


        districtSelect.innerHTML = `<option value="${data.kecamatan.id}">${toCapitalized(data.kecamatan.kecamatan)}</option>`;


        if (cityId) {
          axios.get(`https://gisapis.manpits.xyz/api/kecamatan/${cityId}`, {
            headers: {
              'Authorization': `Bearer ${token2}`
            }
          })
            .then(response => {
              console.log(response.data.kecamatan);
              const districts = response.data.kecamatan;
              districts.forEach(district => {
                const option = document.createElement('option');
                option.value = district.id;
                option.text = toCapitalized(district.value);
                districtSelect.appendChild(option);
              });


            })
            .catch(error => console.error('Error fetching districts:', error));
        }

        //Fetch Default village

        const villageSelect = document.getElementById('village');
        villageSelect.innerHTML = `<option value="${data.kecamatan.id}">${toCapitalized(data.kecamatan.kecamatan)}</option>`;

        if (villageId) {
          axios.get(`https://gisapis.manpits.xyz/api/desa/${districtId}`, {
            headers: {
              'Authorization': `Bearer ${token}`
            }
          })
            .then(response => {
              const villages = response.data.desa;
              villages.forEach(village => {
                const option = document.createElement('option');
                option.value = village.id;
                option.text = toCapitalized(village.value);
                villageSelect.appendChild(option);
              });
            })
            .catch(error => console.error('Error fetching villages:', error));
        }







        // Fetch districts when city changes
        document.getElementById('city').addEventListener('change', function () {
          const cityId = this.value;
          const districtSelect = document.getElementById('district');
          const villageSelect = document.getElementById('village');
          districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
          villageSelect.innerHTML = '<option value="">Pilih Desa</option>';

          if (cityId) {
            axios.get(`https://gisapis.manpits.xyz/api/kecamatan/${cityId}`, {
              headers: {
                'Authorization': `Bearer ${token2}`
              }
            })
              .then(response => {
                console.log(response.data.kecamatan);
                const districts = response.data.kecamatan;
                districts.forEach(district => {
                  const option = document.createElement('option');
                  option.value = district.id;
                  option.text = toCapitalized(district.value);
                  districtSelect.appendChild(option);
                });
              })
              .catch(error => console.error('Error fetching districts:', error));
          }
        });

        // Fetch villages when district changes
        document.getElementById('district').addEventListener('change', function () {
          const districtId = this.value;
          const villageSelect = document.getElementById('village');
          villageSelect.innerHTML = '<option value="">Pilih Desa</option>';

          if (districtId) {
            axios.get(`https://gisapis.manpits.xyz/api/desa/${districtId}`, {
              headers: {
                'Authorization': `Bearer ${token}`
              }
            })
              .then(response => {
                const villages = response.data.desa;
                villages.forEach(village => {
                  const option = document.createElement('option');
                  option.value = village.id;
                  option.text = toCapitalized(village.value);
                  villageSelect.appendChild(option);
                });
              })
              .catch(error => console.error('Error fetching villages:', error));
          }
        });

        document.getElementById('village').addEventListener('change', function () {
          console.log(this.value);
        })

      })



      // existingType
      axios.get(`https://gisapis.manpits.xyz/api/meksisting`, {
        headers: {
          'Authorization': `Bearer ${token}`
        }
      })
        .then(response => {
          console.log(response.data.eksisting);
          const existing = response.data.eksisting;
          const existingSelect = document.getElementById('existingPavement');

          existingSelect.innerHTML = `<option value="${roadData[0].eksisting_id}">${roadData[0].eksisting_id}</option>`;
          existing.forEach(existing => {
            const option = document.createElement('option');
            option.value = existing.id;
            option.text = existing.eksisting;
            existingSelect.appendChild(option);
          });
        })
        .catch(error => console.error('Error fetching cities:', error));

      // roadCondition
      axios.get(`https://gisapis.manpits.xyz/api/mkondisi`, {
        headers: {
          'Authorization': `Bearer ${token}`
        }
      })
        .then(response => {
          console.log(response.data.eksisting);
          const existing = response.data.eksisting;
          const conditionSelect = document.getElementById('roadCondition');

          var kondisiJalan = "";

          switch (roadData[0].jenisjalan_id) {
            case 1:
              kondisiJalan = "Baik";
              break;

            case 2:
              kondisiJalan = "Sedang"
              break;

            case 3:
              kondisiJalan = "Rusak"
              break;

            default:
              kondisiJalan = "-"
              break;
          }

          conditionSelect.innerHTML = `<option value="${roadData[0].kondisi_id}">${kondisiJalan}</option>`;


          existing.forEach(condition => {
            const option = document.createElement('option');
            option.value = condition.id;
            option.text = condition.kondisi;
            conditionSelect.appendChild(option);
          });
        })
        .catch(error => console.error('Error fetching cities:', error));


      // roadType
      axios.get(`https://gisapis.manpits.xyz/api/mjenisjalan`, {
        headers: {
          'Authorization': `Bearer ${token}`
        }
      })
        .then(response => {
          console.log(response.data.eksisting);
          const existing = response.data.eksisting;
          const typeSelect = document.getElementById('roadType');

          var jenisjalan = ''

          switch (roadData[0].jenisjalan_id) {
            case 1:
              jenisjalan = "Desa";
              break;

            case 2:
              jenisjalan = "Kabupaten"
              break;

            case 3:
              jenisjalan = "Provinsi"
              break;

            default:
              jenisjalan = "-"
              break;
          }

          typeSelect.innerHTML = `<option value="${roadData[0].jenisjalan_id}">${jenisjalan}</option>`;


          existing.forEach(type => {
            const option = document.createElement('option');
            option.value = type.id;
            option.text = type.jenisjalan;
            typeSelect.appendChild(option);
          });
        })
        .catch(error => console.error('Error fetching cities:', error));




    }

    setDefaultVillageDistrictCity();



    var decodedData = decodePolyline(response.data.ruasjalan.paths);
    console.log(decodedData);

    decodedData.forEach(paths => {
      // console.log(paths)

      addMarker(paths[0], paths[1])

      var latLng = new L.LatLng(paths[0], paths[1]);
      latLngs.push(latLng);

      bounds = L.latLngBounds(latLngs)
    });

    map.fitBounds(bounds, {
      padding: [30, 30],
      maxZoom: 19,
      minZoom: 4
    });

  })


  console.log(decodePaths);

}

function deleteRoadDataById(id) {
  axios.delete('https://gisapis.manpits.xyz/api/ruasjalan/' + id, {
    headers: {
      'Authorization': `Bearer ${token2}`
    }
  }).then(response => {
    var data = response.data
    // console.log(response.data)
    if (data.status == 'success') {
      console.log(`Data with Id: ${roadId} has deleted`);
      alert(`Data with Id: ${roadId} has deleted`);
      window.location.replace('/')
    }
  }
  ).catch(error => {
    console.error("Terjadi kesalahan:", error);
    alert('Gagal menghapus data');
  }
  )
}

deleteButton.addEventListener('click', function () {
  deleteRoadDataById(roadId)

})

function editRoadDataById(id) {
  let encodePath = document.getElementById('hiddenEncodePath').value;
  let desa_id = document.getElementById('village').value;
  let kode_ruas = document.getElementById('roadCode').value;
  let nama_ruas = document.getElementById('roadName').value;
  let panjang = document.getElementById('roadDistance').value;
  let lebar = document.getElementById('roadWidth').value;
  let eksisting_id = document.getElementById('existingPavement').value;
  let kondisi_id = document.getElementById('roadCondition').value;
  let jenisjalan_id = document.getElementById('roadType').value;
  let keterangan = document.getElementById('additionalInformation').value;

  if (encodePath && desa_id && kode_ruas && nama_ruas && panjang && lebar && eksisting_id && kondisi_id && jenisjalan_id && keterangan) {
    data = {
      paths: encodePath,
      desa_id: desa_id,
      kode_ruas: kode_ruas,
      nama_ruas: nama_ruas,
      panjang: panjang,
      lebar: lebar,
      eksisting_id: eksisting_id,
      kondisi_id: kondisi_id,
      jenisjalan_id: jenisjalan_id,
      keterangan: keterangan


    };

    console.log(data);
    axios.put('https://gisapis.manpits.xyz/api/ruasjalan/' + id, data, {
      headers: {
        'Authorization': `Bearer ${token2}`
      }
    }).then(response => {

      console.log(response);
      // alert("Mantap data diperbarui");

      const modalDialog = document.querySelector('#modal-dialog');
      modalDialog.style.visibility = 'visible';
      setTimeout(() => {
        modalDialog.style.visibility = 'hidden';
    }, 2000);

    }).catch(error => { console.log(error) })


  } else {

    function isEmpty(val) {
      return (val === undefined || val == null || val.length <= 0) ? true : false;
    }

    var error = []
    var message = ""

    if (isEmpty(lebar)) {
      error.push("lebar jalan")
    }
    if (isEmpty(kode_ruas)) {
      error.push("kode ruas")
    }
    if (isEmpty(jenisjalan_id)) {
      error.push("jenis jalan")
    }
    if (isEmpty(kondisi_id)) {
      error.push("kondisi jalan")
    }
    if (isEmpty(eksisting_id)) {
      error.push("perkerasan")
    }

    error.forEach(element => {
      message += `${element}, `

    });



    alert(`Pastikan data ${message}terisi`)
  }




}

document.addEventListener('DOMContentLoaded', function () {
  document.getElementById('editDataButton').addEventListener('click', function () {
    editRoadDataById(roadId)
  })
})




// map.fitBounds(bounds);

getDetailDataById(roadId);






document.getElementById('toggleSidebarBtn').onclick = function () {
  var sidebar = document.getElementById('sidebar');
  sidebar.classList.toggle('show');
  var sideBarButton = document.getElementById('toggleSidebarBtn');
  sideBarButton.classList.toggle('show');
  var polylineMenu = document.getElementById('polylineMenu');
  polylineMenu.classList.toggle('show');
  var mapSide = document.getElementById('map');
  mapSide.classList.toggle('slide');



  isSideBarOpen = !isSideBarOpen;
  if (isSideBarOpen) { sideBarButton.innerHTML = '<i class="bi bi-chevron-right"></i>'; } else {
    sideBarButton.innerHTML = '<i class="bi bi-chevron-left"></i>';
  }
};

// Map Point and Line

var currectLocationMarker = L.icon({
  iconUrl: '../img/point.png',
  iconSize: [20, 20],
  iconAnchor: [10, 10],
  popupAnchor: [0, 0]

});

var widthRoadMarker = L.icon({
  iconUrl: 'img/cross.png',
  iconSize: [20, 20],
  iconAnchor: [10, 10],
  popupAnchor: [0, 0]

});


var markers = []; //contain points
// var polyline = L.polyline([], {
//   color: '#229F4A',
//   weight: 5
// }).addTo(map);

function deletePoint(marker) {
  map.removeLayer(marker);

  markers = markers.filter(m => m !== marker);
}



// Fungsi untuk menambahkan marker baru
function addMarker(lat, lng) {
  var marker = L.marker([lat, lng], { draggable: true, icon: currectLocationMarker }).addTo(map);

  marker.on('drag', function (event) {
    updatePolyline();
    var customPopup = "<b>Total titik: " + markers.length + "</b><br>" +
      "Lat: " + marker.getLatLng().lat.toFixed(5) + "<br>" +
      "Lng: " + marker.getLatLng().lng.toFixed(5) + "<br>" +
      "Total jarak: " + getDistanceBetweenMarkers(getLatLngArrayFromMarkers(markers)).toFixed(1) + " m";

    marker.bindPopup(customPopup).openPopup();
  });

  markers.push(marker);



  if (markers.length > 1) {
    var customPopup = "<b>Total titik: " + markers.length + "</b><br>" +
      "Lat: " + marker.getLatLng().lat.toFixed(5) + "<br>" +
      "Lng: " + marker.getLatLng().lng.toFixed(5) + "<br>" +
      "Total jarak: " + getDistanceBetweenMarkers(getLatLngArrayFromMarkers(markers)).toFixed(1) + " m" + "<br><br>";



    marker.bindPopup(customPopup);





    // Open sidebar to let user save road
    var sidebar = document.getElementById('sidebar');
    // alert(rightPositionValue + " " + isSideBarOpen);
    if (isSideBarOpen == false) {
      sidebar.classList.toggle('show');
      var sideBarButton = document.getElementById('toggleSidebarBtn');
      sideBarButton.classList.toggle('show');
      isSideBarOpen = !isSideBarOpen;
      var polylineMenu = document.getElementById('polylineMenu')
      polylineMenu.classList.toggle('show')
      var mapSide = document.getElementById('map')
      mapSide.classList.toggle('slide')

      if (isSideBarOpen) { sideBarButton.innerHTML = '<i class="bi bi-chevron-right"></i>'; } else {
        sideBarButton.innerHTML = '<i class="bi bi-chevron-left"></i>';
      }
    }

  }



  updatePolyline();

  document.getElementById('polylineMenu').style.visibility = "visible";


}

document.getElementById("deletePoint").addEventListener("click",
  function () {
    if (markers.length === 0) {
      return;
    }

    if (markers.length === 1) {
      document.getElementById('polylineMenu').style.visibility = "hidden";
    }




    // Hapus marker terakhir dari peta dan dari array
    var lastMarker = markers.pop();
    map.removeLayer(lastMarker);
    updatePolyline();
  });

// update polyline
function updatePolyline() {
  var latlngs = markers.map(function (marker) {
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


}

var roadWidthInput = document.getElementById('roadWidth');

roadWidthInput.addEventListener('focus', function () {
  console.log('Input field is focused!');
  console.log(markers[0].getLatLng())
});

// Event listener untuk click event
roadWidthInput.addEventListener('click', function () {
  getRoadWidth();
  console.log(markers[markers.length])
});

function getRoadWidth() {
  console.log("clicked");
  let n = markers.length - 1

  map.closePopup();

  if (roadDistanceMarker.length > 1 || markers.length < 1) { return; }
  else {
    let latlngs1 = markers[n].getLatLng();

    var widthLine = L.polyline([], {
      color: '#FF6B3D',
      weight: 5
    }).addTo(map);

    map.setView(markers[n].getLatLng(), 19);

    roadDistanceMarker.push(L.marker([latlngs1.lat - (0.00004), latlngs1.lng - (0.00004)], { draggable: true, icon: widthRoadMarker }).addTo(map));
    roadDistanceMarker.push(L.marker([latlngs1.lat + (0.00004), latlngs1.lng + (0.00004)], { draggable: true, icon: widthRoadMarker }).addTo(map));
    var customPopup = '<h6>Geser sesuai lebar jalan</h6><img src="img/roadWidthDemo.gif" alt="Width Line Demo" style="width: 200px">';

    roadDistanceMarker[1].bindPopup(customPopup).openPopup();
    updateWidthLine();

    roadDistanceMarker[0].on('drag', function (event) {
      updateWidthLine();
      var customPopup = "<b>Total jarak: " + getDistanceBetweenMarkers(getLatLngArrayFromMarkers(roadDistanceMarker)).toFixed(1) + " meter </b><br>" +
        "Lat: " + roadDistanceMarker[0].getLatLng().lat.toFixed(5) + "<br>" +
        "Lng: " + roadDistanceMarker[0].getLatLng().lng.toFixed(5) + "<br>";

      roadDistanceMarker[0].bindPopup(customPopup).openPopup();
    });

    roadDistanceMarker[1].on('drag', function (event) {
      updateWidthLine();
      var customPopup = "<b>Total jarak: " + getDistanceBetweenMarkers(getLatLngArrayFromMarkers(roadDistanceMarker)).toFixed(1) + " meter </b><br>" +
        "Lat: " + roadDistanceMarker[1].getLatLng().lat.toFixed(5) + "<br>" +
        "Lng: " + roadDistanceMarker[1].getLatLng().lng.toFixed(5) + "<br>";

      roadDistanceMarker[1].bindPopup(customPopup).openPopup();
    });

    function updateWidthLine() {
      var latlngs = roadDistanceMarker.map(function (marker) {
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

function getLatLngArrayFromMarkers(markers) {
  let markerLatLng = []
  markers.forEach(marker => {
    let lat = marker.getLatLng().lat;
    let lng = marker.getLatLng().lng;
    markerLatLng.push([lat, lng]);

  });
  return markerLatLng

}



function getDistanceBetweenMarkers(latLngs) {
  let totalDistance = 0
  for (let index = 0; index < latLngs.length - 1; index++) {
    let PointA = L.latLng(latLngs[index][0], latLngs[index][1]);
    let PointB = L.latLng(latLngs[index + 1][0], latLngs[index + 1][1]);
    totalDistance += PointA.distanceTo(PointB);
  }
  return totalDistance
}




// Event listener untuk menambahkan marker dengan klik pada peta
map.on('click', function (event) {
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


document.addEventListener('DOMContentLoaded', function () {
  var alert = document.getElementById('alert');
  if (alert) {
    setTimeout(function () {
      alert.style.display = 'none';
    }, 2000); // 5000 milidetik = 5 detik
  }
});



