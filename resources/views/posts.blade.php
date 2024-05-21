<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GIS 2105551035</title>

    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="shortcut icon" href="img/Trip Buddy.png" type="image/x-icon">

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="img/Trip Buddy.png" alt="Trip Buddy" style="height: 30px; margin-right: 10px;">
                Trip Buddy
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/data">Data</a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-warning" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>
    <div class="main-container">
        <div class="main-content">
            <div id="map">
                <button class="close-btn" id="closeSidebar">X</button>
                <div></div>
            </div>
        
            <div class="sidebar" id="sidebar">
                <div class="col">
                    <div id="tempo"></div>
                    <form>
                        <div class="mb-3">
                            <label for="inputPlaceName" class="form-label">Nama tempat</label>
                            <input type="text" class="form-control" id="inputPlaceName" required>
                        </div>
                        <div class="mb-3">
                            <label for="inputDescription" class="form-label">Deskripsi tempat</label>
                            <input type="text" class="form-control" id="inputDescription" required>
                        </div>
                        <div class="mb-3">
                            <label for="kategoriTempat" style="margin-bottom: 6px;">Kategori Tempat</label>
                            <select class="form-control" id="inputCategory">
                                <option value="wisata">Wisata</option>
                                <option value="pura">Pura</option>
                                <option value="kuliner">Kuliner</option>
                                <option value="belanja">Belanja</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="inputLatitude" class="form-label">Latitude</label>
                                    <input type="text" class="form-control" id="inputLatitude" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="inputLongitude" class="form-label">Longitude</label>
                                    <input type="text" class="form-control" id="inputLongitude" required>
                                </div>
                            </div>
                        </div>
        
        
                        <div class="mb-3">
                            <label for="inputImgUrl" class="form-label">Image URL</label>
                            <input type="text" class="form-control" id="inputImgUrl" required>
                        </div>
                        <button type="submit" class="btn btn-primary" onclick="createData()">Tambah ke Peta</button>
                    </form>
        
        
                </div>
        
            </div>
        </div>
    </div>


    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script> -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.9.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.9.0/firebase-database.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="js/app.js"></script>


</body>

</html>
