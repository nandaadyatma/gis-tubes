<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roadwatch | {{ $title }} - {{ $id }}</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('/img/favicon.png') }}">

    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-editable@1.2.0/dist/leaflet-editable.css" />
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light shadow-sm fixed-top">
        <div class="container-fluid ">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('img/RoadWatch.png') }}" alt="RoadWatch logo" style="height: 25px; margin-bottom: 5px;">
            </a>

            <div class="d-flex">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="{{ asset('img/profile-img.jpg') }}" alt="Profile" class="rounded-circle">
                    <span class="d-none d-md-block ps-2">{{ session('name') }}</span>
                    <input type="hidden" id="hiddenField" value={{ session('token') }}>
                    <input type="hidden" id="roadId" value={{ $id }}>
                    <input type="hidden" id="vilageId" value="">
                    <script>
                        var hiddenValue = document.getElementById('hiddenField').value;
                        // console.log(hiddenValue);
                    </script>
                </a>
                <a href="/logout"><button class="btn btn-outline-primary ms-3">Logout</button></a>
            </div>


        </div>
    </nav>
    <div class="alert-container">
        @if(session('info'))
            <div id="alert" class="alert alert-success" role="alert">
                {{ session('info') }}
            </div>
        @endif

    </div>
    <div class="main-container">
        <div class="main-content">
            
            
        
            
            <div id="map">
            </div>
            <div class="sidebar-container">
                <div class="sidebar" id="sidebar">
                    <div class="p-3">
                        <h4>Data Ruas Jalan</h4>
                   
                        <form>
                            @csrf
                            <div class="row">
                                <div class="col-sm">
                                    <div class="form-group">
                                        <label for="city">Kota:</label>
                                        <select class="form-control" id="city">
                                            <option value="">Pilih Kota</option>
                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm">
                                    <div class="form-group">
                                        <label for="district">Kecamatan:</label>
                                        <select class="form-control" id="district">
                                            <option value="">Pilih Kecamatan</option>
                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm">
                                    <div class="form-group">
                                        <label for="village">Desa:</label>
                                        <select name="village" class="form-control" id="village">
                                            <option value="">Pilih Desa</option>
                                          
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="roadName">Nama ruas</label>
                                <input type="text" name="roadName" class="form-control" id="roadName" placeholder="Nama jalan">
                            </div>
                            <input type="hidden" id="hiddenEncodePath" name="encodedPath">
                            <div class="row">
                                <div class="col-sm">
                                    <div class="form-group">
                                        <label for="roadCode">kode ruas</label>
                                        <input type="text" name="roadCode" class="form-control" id="roadCode" placeholder="Tipe jalan">
                                    </div>
                                </div>
                                <div class="col-sm">
                                    <div class="form-group">
                                        <label for="roadDistance">Panjang jalan (m)</label>
                                        <input type="text" name="roadDistance" class="form-control" id="roadDistance" placeholder="panjang jalan">
                                    </div> 
                                </div>
                                <div class="col-sm">
                                    <div class="form-group">
                                        <label for="roadWidth">Lebar jalan (m)</label>
                                        <input type="text" name="roadWidth" class="form-control" id="roadWidth" placeholder="lebar jalan">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm">
                                    <div class="form-group">
                                        <label for="roadType">Jenis jalan</label>
                                        <select class="form-control" id="roadType" name="roadType">
                                            <option value="">Pilih jenis jalan</option>
                                          
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm">
                                    <div class="form-group">
                                        <label for="roadCondition">Kondisi jalan</label>
                                        <select class="form-control" id="roadCondition" name="roadCondition">
                                            <option value="">Pilih kondisi jalan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm">
                                    <div class="form-group">
                                        <label for="existingPavement">Perkerasan eksisting</label>
                                        <select class="form-control" id="existingPavement" name="existingPavement">
                                            <option value="">Pilih perkerasan eksisting</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="additionalInformation">Keterangan</label>
                                <input type="text" name="additionalInformation" class="form-control" id="additionalInformation" placeholder="Keterangan">
                            </div>
                            
                        </form>
                        <div class="d-flex justify-content-end">
                            <button id="deleteRoadButton" class="btn btn-outline-danger mx-3"><i class="bi bi-trash"></i> Hapus Data</button>
                            
                            <button class="btn btn-primary flex-end" id="editDataButton">Perbarui Data</button>
                        </div>

                        <br>

                        <div class="modal-dialog" id="modal-dialog" style="visibility: hidden">
                            <div class="card" id="card-dialog">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Update Jalan Berhasil</h5>
                                    <p class="card-text text-center">Silahkan cek kembali datamu!</p>
                    
                                    <div class="lottie text-center">
                                        <img src="{{ asset('img/success.gif') }}" alt="">
                    
                                    </div>
                                    <div class="text-center">
                                        <button class="btn btn-outline-primary" style="width: 18rem">
                                            Oke
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        
                </div>
                
                <button id="toggleSidebarBtn" class="btn btn-primary"><i class="bi bi-chevron-left"></i></button>
        
                <div class="card" id="polylineMenu">
                      <button id="deletePoint" class="btn btn-outline-danger "><i class="bi bi-backspace"> Delete point</i> </button>
                </div>
                
            </div>
        </div>

    
    </div>



    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://www.gstatic.com/firebasejs/8.9.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.9.0/firebase-database.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-editable@1.2.0/dist/leaflet-editable.js"></script>

    {{-- encode--}}
    <script src="https://cdn.jsdelivr.net/npm/polyline-encoded@1.0.1/dist/polyline-encoded.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> 
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    
    <script src="{{ asset('js/formDataFetchDetail.js') }}"></script>
    <script src="{{ asset('js/detail.js') }}"></script>
    <script src="{{ asset('js/modal.js') }}"></script>
    


</body>

</html>
