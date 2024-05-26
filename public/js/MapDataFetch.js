

function drawRoadData(lineWidth){

    axios.get('https://gisapis.manpits.xyz/api/ruasjalan', {headers: {
    'Authorization': `Bearer ${token}`
    }
    }).then(response => {
        // console.log(response.data.ruasjalan);
        let data = response.data.ruasjalan;
        data.forEach(data => {
            // console.log(data.paths);
            var decodedData = decodePolyline(data.paths);
            console.log(decodedData);

            L.polyline(decodedData, {
                color: '#f726a1',
                weight: lineWidth
            }).addTo(map).bindPopup(`${data.nama_ruas}`)
            .on('click', function(e){ openPopUp()
            });
        });
    })

}

function getZoomLevel(){
    var zoomLevel = map.getZoom();
    console.log(`current zoom level ${zoomLevel}`);
    return zoomLevel;
}


map.on('zoomend',function(){
    var x = getZoomLevel();
    var y = 1;
    y = Math.round(0.865*x - 9.59);
    
    lineWidth = y;
    drawRoadData(lineWidth);
})