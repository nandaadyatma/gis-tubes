


async function getDesaDataByDesaId(desaId) {

    try {
        let token3 = document.getElementById('hiddenField').value;

        const response = await
            axios.get(`https://gisapis.manpits.xyz/api/mregion`, {
                headers: {
                    'Authorization': `Bearer ${token3}`
                }
            });

        const data = response.data.desa;
        const resultData = data.filter(obj => obj.id === desaId)
        const villageData = resultData[0]

        console.log(villageData)

        const village = {
            id: villageData.id,
            name: villageData.desa,
            id_kec: villageData.kec_id
        }

        console.log(village.id)

        return village

    } catch (error) {
        error => console.error('Error fetching villages:', error);

    }
}

getDesaDataByDesaId(322).then(village => {
    console.log(village);
});

