var map = L.map('map').setView([-8.409518, 115.188919], 10);

// Tambahkan lapisan peta dasar
L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);