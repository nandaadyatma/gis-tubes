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
                        <div class="col-sm">
                            <div class="card mb-3">
                                <div class="card-header"><i class="bi bi-0-circle"></i> Total ruas jalan</div>
                                <div class="card-body">
                                    <h1 class="card-title">{{ count($roadData) }}</h1>
                                </div>
                            </div>
                            
                        </div>
                        <div class="col-sm">
                            <div class="card text-white bg-danger mb-3">
                                <div class="card-header"><i class="bi bi-1-circle"></i> Jalan kondisi rusak</div>
                                <div class="card-body">
                                    @php
                                        $jumlahJalanRusak = 0;
                                        foreach ($roadData as $data) {
                                            if ($data['kondisi_id'] == 3) {
                                                $jumlahJalanRusak += 1;
                                            }
                                        }
                                    @endphp
                                    <h1 class="card-title">{{ $jumlahJalanRusak }}</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="card text-white bg-warning mb-3">
                                <div class="card-header"><i class="bi bi-2-circle"></i> Jalan kondisi sedang</div>
                                <div class="card-body">
                                    @php
                                        $jumlahJalanSedang = 0;
                                        foreach ($roadData as $data) {
                                            if ($data['kondisi_id'] == 2) {
                                                $jumlahJalanSedang += 1;
                                            }
                                        }
                                    @endphp
                                    <h1 class="card-title">{{ $jumlahJalanSedang }}</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="card text-white bg-success mb-3">
                                <div class="card-header"><i class="bi bi-3-circle"></i> Jalan kondisi baik</div>
                                <div class="card-body">
                                    @php
                                        $jumlahJalanBaik = 0;
                                        foreach ($roadData as $data) {
                                            if ($data['kondisi_id'] == 1) {
                                                $jumlahJalanBaik += 1;
                                            }
                                        }
                                    @endphp
                                    <h1 class="card-title">{{ $jumlahJalanBaik }}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <br>
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
                                <td>{{ $item['kode_ruas'] }}</td>
                                <td>{{ $item['nama_ruas'] }}</td>
                                <td>{{ $item['panjang'] }}</td>
                                <td>{{ $item['lebar'] }}</td>
                                @php
                                    $eksisting = '';
                                    switch ($item['eksisting_id']) {
                                        case 1:
                                            $eksisting = 'Tanah';
                                            break;

                                        case 2:
                                            $eksisting = 'Tanah/beton';
                                            break;

                                        case 3:
                                            $eksisting = 'Perkerasan';
                                            break;

                                        case 4:
                                            $eksisting = 'Koral';
                                            break;

                                        case 5:
                                            $eksisting = 'Lapen';
                                            break;

                                        case 6:
                                            $eksisting = 'Paving';
                                            break;

                                        case 7:
                                            $eksisting = 'Hotmix';
                                            break;

                                        case 8:
                                            $eksisting = 'Beton';
                                            break;

                                        case 9:
                                            $eksisting = 'Beton/Lapen';
                                            break;

                                        default:
                                            $eksisting = '-';
                                            break;
                                    }

                                    $kondisi = '';
                                    switch ($item['kondisi_id']) {
                                        case 1:
                                            $kondisi = 'Baik';
                                            break;

                                        case 2:
                                            $kondisi = 'Sedang';
                                            break;

                                        case 3:
                                            $kondisi = 'Rusak';
                                            break;

                                        default:
                                            $kondisi = '-';
                                            break;
                                    }

                                    $jenisJalan = '';
                                    switch ($item['jenisjalan_id']) {
                                        case 1:
                                            $jenisJalan = 'Desa';
                                            break;

                                        case 2:
                                            $jenisJalan = 'Kabupaten';
                                            break;

                                        case 3:
                                            $jenisJalan = 'Provinsi';
                                            break;

                                        default:
                                            $jenisJalan = '-';
                                            break;
                                    }
                                @endphp
                                <td>{{ $eksisting }}</td>
                                <td>{{ $kondisi }}</td>
                                <td>{{ $jenisJalan }}</td>
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
        


    </div>
@endsection


@section('js')
    {{-- for fetch api  --}}
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="js/app.js"></script>
    <script src="js/MapDataFetch.js"></script>
    <script src="js/data.js"></script>
    <script src="js/modal.js"></script>
@endsection
