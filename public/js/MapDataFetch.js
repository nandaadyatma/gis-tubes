var polylineRoadData = []

var isTootipVisible = true;
var isGoodRoadVisible = true;
var isModerateRoadVisible = true;
var isDamagedRoadVisible = true;

document.getElementById('tooltipSwitch').addEventListener('change', function(event){
    if(event.target.checked) {
        isTootipVisible = true
    } else {
        isTootipVisible = false
    }
    drawRoadData(10)
})

document.getElementById('goodRoadSwitch').addEventListener('change', function(event){
    if(event.target.checked) {
        isGoodRoadVisible = true
    } else {
        isGoodRoadVisible = false
    }
    drawRoadData(10)
})

document.getElementById('moderateRoadSwitch').addEventListener('change', function(event){
    if(event.target.checked) {
        isModerateRoadVisible = true
    } else {
        isModerateRoadVisible = false
    }
    drawRoadData(10)
})

document.getElementById('damagedRoadSwitch').addEventListener('change', function(event){
    if(event.target.checked) {
        isDamagedRoadVisible = true
    } else {
        isDamagedRoadVisible = false
    }
    drawRoadData(10)
})

function drawRoadData(lineWidth){
    // reset polyline
   

    polylineRoadData.forEach( line => {
        map.removeLayer(line);
        console.log("reseted")
    })

    console.log(polylineRoadData);

    polylineRoadData = [];

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



                switch (data.kondisi_id) {
                    case 1: { 
                        if(isGoodRoadVisible){
                            drawLine(color1 = '#1CC861', color2 = '#10691E', width = lineWidth, data = data, decodedData = decodedData )
                        }
                    }
                    break;
                    case 2:{
                        if(isModerateRoadVisible){
                            drawLine(color1 = '#FFBD13', color2 = '#7B6000', width = lineWidth, data = data, decodedData = decodedData )
                        }
                    }

                    break;

                    case 3:{
                        if (isDamagedRoadVisible) {  
                            drawLine(color1 = '#F93844', color2 = '#7B6000', width = lineWidth, data = data, decodedData = decodedData )
                        }
                    }
                        
                        break;
                
                    default:
                        break;
                }

            
        });
    })

}

function drawLine(color1, color2, width, data, decodedData){

 

    var outlinePolyline = L.polyline(decodedData, {
        color: color2,
        weight: 8 // Lebar garis outline
    }).addTo(map);

    var mainPolyline = L.polyline(decodedData, {
        color: color1,
        weight: 4 // Lebar garis utama
    }).addTo(map);

    if (isTootipVisible) {
        
        mainPolyline.bindTooltip(data.kode_ruas, {permanent: true, direction: 'center', className: 'my-tooltip'}).openTooltip();
    }


    var popupContent2 = `
    <table>
        <tr>
            <th><h6><b>Data ruas jalan</b></h6></th>
        </tr>
        <tr>
            <td>Nama ruas</td>
            <td>${data.nama_ruas}</td>
        </tr>
        <tr>
            <td>Panjang ruas</td>
            <td>${data.panjang} m</td>
        </tr>
        <tr>
            <td>lebar ruas</td>
            <td>${data.lebar} m</td>
        </tr>
        <tr>
            <td>Jenis jalan</td>
            <td>${getJenisJalanById(data.jenisjalan_id)}</td>
        </tr>
        <tr>
            <td>Eksisting jalan</td>
            <td>${getEksistingJalanById(data.eksisting_id)}</td>
        </tr>
        <tr>
            <td>Kondisi jalan</td>
            <td>${getKondisiJalanById(data.kondisi_id)}</td>
        </tr>
    </table>
    <hr>
    <div class="d-flex justify-content-center">
        <button type="submit" class="btn btn-primary flex-end" id="detailDataButton" action="">Detail & Edit</i></button>
    </div>
    `

    
    mainPolyline.bindPopup(popupContent2).on('popupopen', function(){
        document.getElementById('detailDataButton').addEventListener('click', function() {
                window.location.href = `/detail/${data.id}`;

        })
    })
    

    polylineRoadData.push(outlinePolyline)
    polylineRoadData.push(mainPolyline)
}

function getZoomLevel(){
    var zoomLevel = map.getZoom();
    console.log(`current zoom level ${zoomLevel}`);
    return zoomLevel;
}


map.on('zoomend',function(){
    var x = getZoomLevel();
    var y = 1;
    y = Math.round(1*x - 5.59);
    
    lineWidth = y;
    drawRoadData(lineWidth);
})

function getJenisJalanById(id){
    switch (id) {
        case 1: return "Desa"
            
        break;

        case 2: return "Kabupaten"

        break;

        case 3: return "Provinsi"

        break;
    
        default: return "-"
            break;
    }
}

function getKondisiJalanById(id){
    switch (id) {
        case 1: return "Baik"
            
        break;

        case 2: return "Sedang"

        break;

        case 3: return "Rusak"

        break;
    
        default: return "-"
            break;
    }
}

function getEksistingJalanById(id){
    switch (id) {
        case 1:  return "Tanah"
            
        break;

        case 2:  return "Tanah/Beton"

        break;

        case 3: return "Perkerasan"

        break;
        
        case 4:  return "Koral"
            
        break;

        case 5:  return "Lapen"

        break;

        case 6: return "Paving"

        break;
        
        case 7:  return "Hotmix"
            
        break;

        case 8:  return "Beton"

        break;

        case 9: return "Beton/Lapen"

        break;
    
        default:  return "-"
            break;
    }
}

// console.log(polylineRoadData);