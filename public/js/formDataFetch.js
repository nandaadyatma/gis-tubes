let token = document.getElementById('hiddenField').value;
        
document.addEventListener('DOMContentLoaded', function() {
            // Fetch initial city data
            axios.get(`https://gisapis.manpits.xyz/api/kabupaten/1`, {headers: {
                        'Authorization': `Bearer ${token}`
                    }
                  })
                .then(response => {
                  console.log(response.data.kabupaten);
                    const cities = response.data;
                    const citySelect = document.getElementById('city');
                    response.data.kabupaten.forEach(city => {
                        const option = document.createElement('option');
                        option.value = city.id;
                        option.text = city.value;
                        citySelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching cities:', error));

            // Fetch districts when city changes
            document.getElementById('city').addEventListener('change', function() {
                const cityId = this.value;
                const districtSelect = document.getElementById('district');
                const villageSelect = document.getElementById('village');
                districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
                villageSelect.innerHTML = '<option value="">Pilih Desa</option>';

                if (cityId) {
                    axios.get(`https://gisapis.manpits.xyz/api/kecamatan/${cityId}`, {headers: {
                        'Authorization': `Bearer ${token}`
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
            document.getElementById('district').addEventListener('change', function() {
                const districtId = this.value;
                const villageSelect = document.getElementById('village');
                villageSelect.innerHTML = '<option value="">Pilih Desa</option>';

                if (districtId) {
                  axios.get(`https://gisapis.manpits.xyz/api/desa/${districtId}`, {headers: {
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

            document.getElementById('village').addEventListener('change', function(){
              console.log(this.value);
            })
            
            // existingType
            axios.get(`https://gisapis.manpits.xyz/api/meksisting`, {headers: {
                        'Authorization': `Bearer ${token}`
                    }
                  })
                .then(response => {
                  console.log(response.data.eksisting);
                    const existing = response.data.eksisting;
                    const existingSelect = document.getElementById('existingPavement');
                    existing.forEach(existing => {
                        const option = document.createElement('option');
                        option.value = existing.id;
                        option.text = existing.eksisting;
                        existingSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching cities:', error));

            // roadCondition
            axios.get(`https://gisapis.manpits.xyz/api/mkondisi`, {headers: {
                        'Authorization': `Bearer ${token}`
                    }
                  })
                .then(response => {
                  console.log(response.data.eksisting);
                    const existing = response.data.eksisting;
                    const conditionSelect = document.getElementById('roadCondition');
                    existing.forEach(condition => {
                        const option = document.createElement('option');
                        option.value = condition.id;
                        option.text = condition.kondisi;
                        conditionSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching cities:', error));


                // roadType
            axios.get(`https://gisapis.manpits.xyz/api/mjenisjalan`, {headers: {
                        'Authorization': `Bearer ${token}`
                    }
                  })
                .then(response => {
                  console.log(response.data.eksisting);
                    const existing = response.data.eksisting;
                    const typeSelect = document.getElementById('roadType');
                    existing.forEach(type => {
                        const option = document.createElement('option');
                        option.value = type.id;
                        option.text = type.jenisjalan;
                        typeSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching cities:', error));
                
        });

        function toCapitalized(str){
          str = str.toLowerCase();

          return str.replace(/\b[a-z]/g, function(letter) {
          return letter.toUpperCase();
          });
        }

  