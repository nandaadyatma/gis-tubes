<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>RoadWatch | Welcome</title>
	{{-- <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> --}}
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
	<link rel="stylesheet" href='{{ asset('css/welcome.css') }}'>
	<link rel="stylesheet" href='{{ asset('css/style.css') }}'>
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
	<link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
	
    <script src="https://d3js.org/topojson.v1.min.js"></script>

	<link rel="icon" type="image/jpg" href="{{ asset('/img/favicon.png') }}">
</head>
<body>
	<header>
		<nav class="navbar navbar-expand-lg navbar-light shadow-sm fixed-top">
            <div class="container-fluid" style="margin-left: 20px; margin-right: 20px">
                <a class="navbar-brand" href="/">
                    <img src="{{ asset('img/RoadWatch.png') }}" alt="RoadWatch logo" style="height: 25px; margin-bottom: 5px;">
                </a>
    
                <div class="d-flex">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    </a>
                    <a href="/register"><button class="btn btn-outline-primary ms-3">Register</button></a>
                    <a href="/login"><button class="btn btn-primary ms-3">Login</button></a>
                </div>
    
    
            </div>
        </nav>
	</header>
	<main>
		<section class="hero container">
			<div class="hero-blue" data-aos="fade-up" data-aos-duration="1500">
				<div>
					<h1>
						<span>Pantau</span> dan <span>Bagikan</span> Kondisi Jalan Terkini!
					</h1>
					<p>
						Roadwatch menyajikan informasi kondisi jalan yang tersebar di 9 kabupaten kota di Bali. Kamu juga dapat menambahkan sendiri kondisi jalan secara langsung disini.
					</p>
					<div class="social-links">
						<a href="/login"><button class="btn btn-primary" style="font-size: 20px">Masuk sekarang !</button></a>
					</div>
				</div>
			</div>
			<div class="hero-yellow" data-aos="fade-left" data-aos-duration="1500">
				<img src="{{ asset('img/hero.png') }}" alt="Adrian Twarog" width="100%" />
			</div>
		</section>
		<section class="logos container" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
			<div class="marquee">
				<div class="track">
					<img src="{{ asset('img/kab-kota-bali/badung.png') }}" alt="Badung"/>
					<img src="{{ asset('img/kab-kota-bali/bangli.png') }}" alt="Bangli"/>
					<img src="{{ asset('img/kab-kota-bali/denpasar.png') }}" alt="Denpasar"/>
					<img src="{{ asset('img/kab-kota-bali/gianyar.png') }}" alt="Gianyar"/>
					<img src="{{ asset('img/kab-kota-bali/jembrana.png') }}" alt="Jembrana"/>
					<img src="{{ asset('img/kab-kota-bali/karangasem.png') }}" alt="Karangasem"/>
					<img src="{{ asset('img/kab-kota-bali/klungkung.png') }}" alt="Klungkung"/>
					<img src="{{ asset('img/kab-kota-bali/singaraja.png') }}" alt="Singaraja"/>
					<img src="{{ asset('img/kab-kota-bali/tabanan.png') }}" alt="Tabanan"/>
					<img src="{{ asset('img/kab-kota-bali/badung.png') }}" alt="Badung"/>
					<img src="{{ asset('img/kab-kota-bali/bangli.png') }}" alt="Bangli"/>
					<img src="{{ asset('img/kab-kota-bali/denpasar.png') }}" alt="Denpasar"/>
					<img src="{{ asset('img/kab-kota-bali/gianyar.png') }}" alt="Gianyar"/>
					<img src="{{ asset('img/kab-kota-bali/jembrana.png') }}" alt="Jembrana"/>
					<img src="{{ asset('img/kab-kota-bali/karangasem.png') }}" alt="Karangasem"/>
					<img src="{{ asset('img/kab-kota-bali/klungkung.png') }}" alt="Klungkung"/>
					<img src="{{ asset('img/kab-kota-bali/singaraja.png') }}" alt="Singaraja"/>
					<img src="{{ asset('img/kab-kota-bali/tabanan.png') }}" alt="Tabanan"/>
				</div>
			</div>
		</section>
	</main>
</body>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
	integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
	crossorigin=""></script>
<script src="{{ asset('js/welcome.js') }}"></script>
<script>
	AOS.init();
  </script>
</html>




