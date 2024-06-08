@extends('layouts.main')

@section('main-content')
    <div class="main-content">

        <div id="map">
        </div>
        <div class="sidebar-container">
            <div class="sidebar" id="sidebar">
                <div class="p-3">
                    <h4>Data Ruas Jalan</h4>

                    <form method="POST" action="{{ route('createNewRoad') }}">
                        @csrf
                        <div class="form-group">
                            <label for="city">Kota:</label>
                            <select class="form-control" id="city">
                                <option value="">Pilih Kota</option>

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="district">Kecamatan:</label>
                            <select class="form-control" id="district">
                                <option value="">Pilih Kecamatan</option>

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="village">Desa:</label>
                            <select name="village" class="form-control" id="village">
                                <option value="">Pilih Desa</option>

                            </select>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="roadName">Nama ruas</label>
                            <input type="text" name="roadName" class="form-control" id="roadName"
                                placeholder="Jalan Ngurah Rai">
                        </div>
                        <input type="hidden" id="hiddenEncodePath" name="encodedPath">
                        <div class="form-group">
                            <label for="roadCode">kode ruas</label>
                            <input type="text" name="roadCode" class="form-control" id="roadCode"
                                placeholder="Enter road type">
                        </div>
                        <div class="form-group">
                            <label for="roadDistance">Panjang jalan (meter)</label>
                            <input type="text" name="roadDistance" class="form-control" id="roadDistance"
                                placeholder="panjang jalan">
                        </div>
                        <div class="form-group">
                            <label for="roadWidth">Lebar jalan (meter)</label>
                            <input type="text" name="roadWidth" class="form-control" id="roadWidth"
                                placeholder="lebar jalan">
                        </div>
                        <div class="form-group">
                            <label for="roadType">Jenis jalan</label>
                            <select class="form-control" id="roadType" name="roadType">
                                <option value="">Pilih jenis jalan</option>

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="roadCondition">Kondisi jalan</label>
                            <select class="form-control" id="roadCondition" name="roadCondition">
                                <option value="">Pilih kondisi jalan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="existingPavement">Perkerasan eksisting</label>
                            <select class="form-control" id="existingPavement" name="existingPavement">
                                <option value="">Pilih perkerasan eksisting</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="additionalInformation">Keterangan</label>
                            <input type="text" name="additionalInformation" class="form-control"
                                id="additionalInformation" placeholder="Keterangan">
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary flex-end" id="addDataButton">Save</button>
                        </div>
                    </form>
                </div>

            </div>
            <button id="toggleSidebarBtn" class="btn btn-primary"><i class="bi bi-chevron-left"></i></button>

            <div class="card" id="polylineMenu">
                <h6 id="pointNumber"></h6>
                <button id="deletePoint" class="btn btn-outline-danger "><i class="bi bi-backspace"> Delete point</i>
                </button>
            </div>

        </div>
        @if(session('success-login'))
        <div class="modal-dialog" id="modal-dialog">
            <div class="card" id="card-dialog">
                <div class="card-body">
                    <h5 class="card-title text-center">Login Berhasil</h5>
                    <p class="card-text text-center">Semoga harimu menyenangkan!</p>

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
        @endif

        @if(session('success-add-road'))
        <div class="modal-dialog" id="modal-dialog">
            <div class="card" id="card-dialog">
                <div class="card-body">
                    <h5 class="card-title text-center">Tambah Jalan Berhasil</h5>
                    <p class="card-text text-center">Silahkan cek data terbarumu!</p>

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
        @endif
        
    </div>
@endsection


@section('js')
    {{-- for fetch api  --}}
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
    <script src="js/app.js"></script>
    <script src="js/formDataFetch.js"></script>
    <script src="js/MapDataFetch.js"></script>
    <script src="js/modal.js"></script>
@endsection
