<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trip Buddy | {{ $title }}</title>

    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="shortcut icon" href="img/Trip Buddy.png" type="image/x-icon">

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light shadow-sm fixed-top">
        <div class="container-fluid ">
            <a class="navbar-brand" href="#">
                {{-- <img src="img/Trip Buddy.png" alt="Trip Buddy" style="height: 30px; margin-right: 5px;"> --}}
                <h5 style="display: inline">MyMap</h5>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ ($title === "Home") ? 'active' : '' }}" aria-current="page" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ ($title === "About") ? 'active' : '' }}" href="/about">About</a>
                    </li>
                </ul>

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="img/profile-img.jpg" alt="Profile" class="rounded-circle">
                    <span class="d-none d-md-block ps-2">{{ session('name') }}</span>
                </a>

                    <a href="/logout"><button class="btn btn-outline-primary ms-3">Logout</button></a>

                    <img src="" alt="">
            </div>
        </div>
    </nav>
    <div class="main-container">
        @yield('main-content')
    </div>


    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script> -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.9.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.9.0/firebase-database.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    
    @yield('js')
    


</body>

</html>
