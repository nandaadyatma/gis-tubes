@extends('layouts.main')

@section('main-content')
    <div class="main-content">
        <div class="container mt-5">
            <br>
            <br>
            <div class="card-body">
                <div class="card-header">
                    <h1>Data Ruas Jalan</h1>
                </div>
                <div class="container mt-5">
                    <div class="row">
                        <div class="col-md">
                            <div class="card mb-3">
                                <div class="card-header"><i class="bi bi-0-circle"></i> Total ruas jalan</div>
                                <div class="card-body">
                                    <h1 class="card-title">{{ count($roadData) }}</h1>
                                </div>
                            </div>

                        </div>
                        {{-- <div class="col-sm" style="display: none">
                            <div class="card text-white bg-danger mb-3">
                                <div class="card-header"><i class="bi bi-1-circle"></i> Jalan kondisi rusak</div>
                                <div class="card-body">
                                    <h1 class="card-title" id="jumlahJalanRusak">{{ $jumlahJalanRusak }}</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm" style="display: none">
                            <div class="card text-white bg-warning mb-3">
                                <div class="card-header"><i class="bi bi-2-circle"></i> Jalan kondisi sedang</div>
                                <div class="card-body">
                                    <h1 class="card-title" id="jumlahJalanSedang">{{ $jumlahJalanSedang }}</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm" style="display: none">
                            <div class="card text-white bg-success mb-3">
                                <div class="card-header"><i class="bi bi-3-circle"></i> Jalan kondisi baik</div>
                                <div class="card-body">
                                    <h1 class="card-title" id="jumlahJalanBaik">{{ $jumlahJalanBaik }}</h1>
                                </div>
                            </div>
                        </div> --}}
                        <div class="col-lg">
                            <div id="chart1">
                            </div>
                        </div>
                        <div class="col-lg">
                            <div id="chart2">
                            </div>
                        </div>
                        <div class="col-lg">
                            <div id="chart3">
                            </div>
                        </div>
                        
                    </div>

                </div>


                <br>
                <form method="GET" action="{{ route('getRoadData') }}">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="search"
                            placeholder="Cari kata kunci seperti nama, kode, dan lainnya" aria-label="Cari kata kunci"
                            aria-describedby="basic-addon2" value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i> Cari data</button>
                        </div>
                    </div>
                </form>
                <table class="table table-rounded">
                    <thead>
                        
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">id</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Kode Ruas</th>
                            <th class="text-center">Panjang (m)</th>
                            <th class="text-center">Lebar (m)</th>
                            <th class="text-center">Eksisting</th>
                            <th class="text-center">Kondisi</th>
                            <th class="text-center">Jenis Jalan</th>
                            <th class="text-center">Aksi</th>
                            <!-- Add more columns as needed -->
                        </tr>
                    </thead>
                    <tbody>
                        @php $count = 1; @endphp
                        @foreach ($roadData as $item)
                            <tr>
                                <td class="text-center">{{ $count }}</td>
                                <td id="id">{{ $item['id'] }}</td>
                                <td>{{ $item['nama_ruas'] }}</td>
                                <td>{{ $item['kode_ruas'] }}</td>
                                <td>{{ $item['panjang'] }}</td>
                                <td>{{ $item['lebar'] }}</td>
                                <td>{{ $item['nama_eksisting'] }}</td>
                                <td>{{ $item['nama_kondisi'] }}</td>
                                <td>{{ $item['nama_jenis_jalan'] }}</td>
                                <td class="text-center d-flex justify-content-center">


                                    <form action="{{ route('roadData.delete', $item['id']) }}" method="POST"
                                        onsubmit="return confirm('Yakin mau hapus ini?')";>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" id="deleteRoadButton"
                                            class="btn btn-outline-danger me-2">Hapus</button>
                                    </form>


                                    <button id="detailDataButton" class="btn btn-outline-primary detailDataButton"
                                        data-id="{{ $item['id'] }}">Edit</button>

                                </td>
                                <!-- Add more columns as needed -->
                            </tr>
                            @php $count++; @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if (session('success-delete-road'))
            <div class="modal-dialog" id="modal-dialog">
                <div class="card" id="card-dialog">
                    <div class="card-body">
                        <h5 class="card-title text-center">Hapus Jalan Berhasil</h5>
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
        @endif

        <input type="hidden" id="jumlahJalanBaik" value={{ $jumlahJalanBaik }}>
        <input type="hidden" id="jumlahJalanSedang" value={{ $jumlahJalanSedang }}>
        <input type="hidden" id="jumlahJalanRusak" value={{ $jumlahJalanRusak }}>

        <input type="hidden" id="jumlahJalanProvinsi" value={{ $jumlahJalanProvinsi }}>
        <input type="hidden" id="jumlahJalanKabupaten" value={{ $jumlahJalanKabupaten }}>
        <input type="hidden" id="jumlahJalanDesa" value={{ $jumlahJalanDesa }}>

        <input type="hidden" id="jumlahEksistingTanah" value={{ $jumlahEksistingTanah }}>
        <input type="hidden" id="jumlahEksistingTanahBeton" value={{ $jumlahEksistingTanahBeton }}>
        <input type="hidden" id="jumlahEksistingPerkerasan" value={{ $jumlahEksistingPerkerasan }}>
        <input type="hidden" id="jumlahEksistingKoral" value={{ $jumlahEksistingKoral }}>
        <input type="hidden" id="jumlahEksistingLapen" value={{ $jumlahEksistingLapen }}>
        <input type="hidden" id="jumlahEksistingPaving" value={{ $jumlahEksistingPaving }}>
        <input type="hidden" id="jumlahEksistingHotmix" value={{ $jumlahEksistingHotmix }}>
        <input type="hidden" id="jumlahEksistingBeton" value={{ $jumlahEksistingBeton }}>
        <input type="hidden" id="jumlahEksistingBetonLapen" value={{ $jumlahEksistingBetonLapen }}>

        {{-- @dd($jumlahJalanBaik) --}}



    </div>
@endsection


@section('js')
    {{-- for fetch api  --}}
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        let jumlahJalanBaik = parseInt(document.getElementById("jumlahJalanBaik").value);
        let jumlahJalanSedang = parseInt(document.getElementById("jumlahJalanSedang").value);
        let jumlahJalanRusak = parseInt(document.getElementById("jumlahJalanRusak").value);

        let jumlahJalanDesa = parseInt(document.getElementById("jumlahJalanDesa").value);
        let jumlahJalanKabupaten = parseInt(document.getElementById("jumlahJalanKabupaten").value);
        let jumlahJalanProvinsi = parseInt(document.getElementById("jumlahJalanProvinsi").value);

        let jumlahJalanTanah= parseInt(document.getElementById("jumlahEksistingTanah").value);
        let jumlahJalanTanahBeton = parseInt(document.getElementById("jumlahEksistingTanahBeton").value);
        let jumlahJalanPerkerasan = parseInt(document.getElementById("jumlahEksistingPerkerasan").value);
        let jumlahJalanKoral = parseInt(document.getElementById("jumlahEksistingKoral").value);
        let jumlahJalanLapen = parseInt(document.getElementById("jumlahEksistingLapen").value);
        let jumlahJalanPaving = parseInt(document.getElementById("jumlahEksistingPaving").value);
        let jumlahJalanHotmix = parseInt(document.getElementById("jumlahEksistingHotmix").value);
        let jumlahJalanBeton = parseInt(document.getElementById("jumlahEksistingBeton").value);
        let jumlahJalanBetonLapen = parseInt(document.getElementById("jumlahEksistingBetonLapen").value);

        var jumlahJalanBerdasarkanKondisi = {
            series: [jumlahJalanBaik, jumlahJalanRusak, jumlahJalanSedang],
                    chart: {
                      height: 350,
                      type: 'donut',
                      toolbar: {
                        show: false
                      }
                    },
              
              
            
            
                    labels: ['Baik', 'Rusak', 'Sedang'],
        }

        var jumlahJalanBerdasarkanEksisting = {
            series: [jumlahJalanTanah, jumlahJalanTanahBeton, jumlahJalanPerkerasan, jumlahJalanKoral, jumlahJalanLapen, jumlahJalanPaving, jumlahJalanHotmix, jumlahJalanBeton, jumlahJalanBetonLapen],
                    chart: {
                      height: 350,
                      type: 'pie',
                      toolbar: {
                        show: false
                      }
                    },
              
              
            
            
                    labels: ['Tanah', 'Tanah/Beton', 'Perkerasan', 'Koral', 'Lapen', 'Paving', 'Hotmix', 'Beton', 'Beton/Lapen'],
        }

        var jumlahJalanBerdasarkanWilayah = {
            series: [jumlahJalanDesa, jumlahJalanKabupaten, jumlahJalanProvinsi],
                    chart: {
                      height: 350,
                      type: 'pie',
                      toolbar: {
                        show: false
                      }
                    },
              
              
            
            
                    labels: ['Desa', 'Kabupaten', 'Provinsi'],
        }

        var chart1 = new ApexCharts(document.querySelector("#chart1"), jumlahJalanBerdasarkanKondisi);
        chart1.render();
        var chart2 = new ApexCharts(document.querySelector("#chart2"), jumlahJalanBerdasarkanEksisting);
        chart2.render();
        var chart3 = new ApexCharts(document.querySelector("#chart3"), jumlahJalanBerdasarkanWilayah);
        chart3.render();
        
    </script>

    <script src="js/app.js"></script>
    <script src="js/MapDataFetch.js"></script>
    <script src="js/data.js"></script>
    <script src="js/modal.js"></script>
@endsection
