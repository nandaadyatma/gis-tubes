let listLocation = [];

let currentKey = "";

// FIREBASE
const firebaseConfig = {
  apiKey: "AIzaSyCebGipg56isDCAxjEJ1-jJtUXK4wTHERI",
  authDomain: "gis-nanda035.firebaseapp.com",
  databaseURL: "https://gis-nanda035-default-rtdb.firebaseio.com",
  projectId: "gis-nanda035",
  storageBucket: "gis-nanda035.appspot.com",
  messagingSenderId: "633969420544",
  appId: "1:633969420544:web:261c024511c4b1287b2be5",
  measurementId: "G-MRTLET02ZH",
};
// Initialize Firebase
firebase.initializeApp(firebaseConfig);
let database = firebase.database();




//   Read Data from Firebase
database.ref("placeData").on("value", getData);

function deleteData(key) {
  database.ref("placeData/" + key).remove()
    .then(function() {
      alert("Data berhasil dihapus");
    })
    .catch(function(error) {
      console.error("Gagal menghapus data: ", error);
    });
}

  let currentName = "";
  let currentDesc = "";
  let currentLan = "";
  let currentLng = "";
  let currentImgUrl = "";

function getModal(inputKey, inputName, inputDesc, inputLat, inputCategory, inputLng, inputImgUrl) {
  let name = document.getElementById("editInputName");
  let desc = document.getElementById("editInputDescription");
  let lat = document.getElementById("editInputLatitude");
  let lng = document.getElementById("editInputLongitude");
  let imgUrl = document.getElementById("editInputImgUrl");

  currentKey = inputKey;

  name.value = inputName;
  desc.value = inputDesc;
  lat.value = inputLat;
  lng.value = inputLng;
  imgUrl.value = inputImgUrl;

  const saveButton = document.getElementById("saveData");
  const newSaveButton = saveButton.cloneNode(true);
  saveButton.parentNode.replaceChild(newSaveButton, saveButton);

  newSaveButton.addEventListener('click', function() {
    updateData(currentKey, inputCategory);
  });

}

function updateData(key, dataCategory) {
  let name = document.getElementById("editInputName");
  let desc = document.getElementById("editInputDescription");
  let lat = document.getElementById("editInputLatitude");
  let lng = document.getElementById("editInputLongitude");
  let imgUrl = document.getElementById("editInputImgUrl");

  let data = {
    placeName: name.value,
    description: desc.value,
    category: dataCategory,
    latitude: lat.value,
    longitude: lng.value,
    imgUrl: imgUrl.value,
  };
  
  database.ref("placeData/" + key).update(data)
    .then(function() {
      alert("Data berhasil diperbarui");
    })
    .catch(function(error) {
      console.error("Gagal memperbarui data: ", error);
    });
}

function getData(snapshoot) {
  let table = ``;
  let number = 1;
  let points = [];
  snapshoot.forEach((element) => {
    console.log(element.val().placeName);
    var data = element.val();
    listLocation.push(data);
    table += `
        <tr>
                <th scope="row">${number}</th>
                <td>${data.placeName}</td>
                <td>${data.description}</td>
                <td>lat: ${parseFloat(data.latitude).toFixed(4)}, lng: ${parseFloat(data.longitude).toFixed(4)}</td>
                <td>
                <button type="button" class="btn btn-primary" id="editData" data-bs-toggle="modal" data-bs-target="#editModal" onClick="getModal('${element.key}', '${data.placeName}', '${data.description}', '${data.latitude}', '${data.category}', '${data.longitude}', '${data.imgUrl}')">Edit</button>

                <button type="button" class="btn btn-danger" id="deleteData" onclick="deleteData('${element.key}')">Delete</button></td>
              </tr>
        `;
  


    number++;
    points.push([data.latitude, data.longitude]);
    console.log(element.key);

    contentPlaceTable.innerHTML = table;



 
}
  )
}










