@extends('layouts.main')

@section('main-content')
<div class="main-content">
    <div class="container mt-5">
        <br>
        <br>
        <div class="card-body">
                <div class="card-header">
                    <h4>Data Ruas Jalan</h4>
                </div>
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
                        @foreach($roadData as $item)
                            <tr>
                                <td class="text-center">{{ $count }}</td>
                                <td>{{ $item['id'] }}</td>
                                <td>{{ $item['kode_ruas'] }}</td>
                                <td>{{ $item['nama_ruas'] }}</td>
                                <td>{{ $item['panjang'] }}</td>
                                <td>{{ $item['lebar'] }}</td>
                                <td>{{ $item['eksisting_id'] }}</td>
                                <td>{{ $item['kondisi_id'] }}</td>
                                <td>{{ $item['jenisjalan_id'] }}</td>
                                <td  class="text-center">
                                    <form action="{{ route('roadData.delete', $item['id']) }}" method="POST" onsubmit="return confirm('Yakin mau hapus ini?')";>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" id="deleteRoadButton" class="btn btn-outline-danger">Delete</button>
                                    <button id="editRoadButton" class="btn btn-outline-primary">Edit</button>
                                    </form>
                                </td>
                                <!-- Add more columns as needed -->
                            </tr>
                        @php $count++; @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
    </div>
 
   
</div>


@endsection


@section('js')
{{-- for fetch api  --}}
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="js/app.js"></script>
<script src="js/MapDataFetch.js"></script>
@endsection
