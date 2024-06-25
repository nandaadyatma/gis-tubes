<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class RoadController extends Controller
{
    public function createNewRoad(Request $request)
    {
        // $data = [
        //     "paths" => "`pcs@uqr~T4}BJ}@",
        //     "desa_id"=> 473,
        //     "kode_ruas"=> "R1",
        //     "nama_ruas"=> "10-12",
        //     "panjang"=> "1093",
        //     "lebar" => "3",
        //     "eksisting_id"=> 2,
        //     "kondisi_id"=> 2,
        //     "jenisjalan_id"=> 1,
        //     "keterangan"=> "keterangan Jalan"
        // ];

        if(session('token')){
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . session('token'),
                'Content-Type' => 'application/json'
            ])->post('https://gisapis.manpits.xyz/api/ruasjalan', [
                "paths" => $request->encodedPath,
                "desa_id"=> $request->village,
                "kode_ruas"=> $request->roadCode,
                "nama_ruas"=> $request->roadName,
                "panjang"=> $request->roadDistance,
                "lebar" => $request->roadWidth,
                "eksisting_id"=> $request->existingPavement,
                "kondisi_id"=> $request->roadCondition,
                "jenisjalan_id"=> $request->roadType,
                "keterangan"=> $request->additionalInformation
            ]);
    
            if ($response->successful()) {
                return back()->with('success-add-road',"Success Create Data"); //flash session
            //    return response()->json(['data' => $response->json()]);
            } else {
                // return response()->json(['data' => $response->json()]);
            }
        }
        
    }

    public function detail(){
        return view('detail', [
            "title" => "Road Detail "
        ]);

    }

    public function getRoadData(Request $request)
    {
        if (session('token')) {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . session('token'),
                'Content-Type' => 'application/json'
            ])->get('https://gisapis.manpits.xyz/api/ruasjalan');

            if ($response->successful()) {
                $data = $response->json()["ruasjalan"];
                // dd($data);
                // dd($request->input('search'));
                
                //tambah atribut kondisi, eksisting, dan jenis jalan
                foreach ($data as &$item) {
                    switch ($item['eksisting_id']) {
                        case 1:
                            $item['nama_eksisting'] = 'Tanah';
                            break;
                        case 2:
                            $item['nama_eksisting'] = 'Tanah/beton';
                            break;
                        case 3:
                            $item['nama_eksisting'] = 'Perkerasan';
                            break;
                        case 4:
                            $item['nama_eksisting'] = 'Koral';
                            break;
                        case 5:
                            $item['nama_eksisting'] = 'Lapen';
                            break;
                        case 6:
                            $item['nama_eksisting'] = 'Paving';
                            break;
                        case 7:
                            $item['nama_eksisting'] = 'Hotmix';
                            break;
                        case 8:
                            $item['nama_eksisting'] = 'Beton';
                            break;
                        case 9:
                            $item['nama_eksisting'] = 'Beton/Lapen';
                            break;
                        default:
                            $item['nama_eksisting'] = '-';
                            break;
                    }

                    switch ($item['kondisi_id']) {
                        case 1:
                            $item['nama_kondisi'] = 'Baik';
                            break;
                        case 2:
                            $item['nama_kondisi'] = 'Sedang';
                            break;
                        case 3:
                            $item['nama_kondisi'] = 'Rusak';
                            break;
                        default:
                            $item['nama_kondisi'] = '-';
                            break;
                    }

                    switch ($item['jenisjalan_id']) {
                        case 1:
                            $item['nama_jenis_jalan'] = 'Desa';
                            break;
                        case 2:
                            $item['nama_jenis_jalan'] = 'Kabupaten';
                            break;
                        case 3:
                            $item['nama_jenis_jalan'] = 'Provinsi';
                            break;
                        default:
                            $item['nama_jenis_jalan'] = '-';
                            break;
                    }
                }

                // Filter data jika ada parameter pencarian
                if ($request->has('search') && $request->input('search') != '') {
                    $search = $request->input('search');
                    // dd($request->input('search'));
                    $data = array_filter($data, function ($item) use ($search) {
                        return (
                            stripos($item['nama_ruas'], $search) !== false ||
                            stripos($item['kode_ruas'], $search) !== false ||
                            stripos($item['nama_eksisting'], $search) !== false

                        );
                    });
                }

                // Menghitung jumlah jalan berdasarkan kondisi
                $jumlahJalanRusak = count(array_filter($data, fn($item) => $item['kondisi_id'] == 3));
                $jumlahJalanSedang = count(array_filter($data, fn($item) => $item['kondisi_id'] == 2));
                $jumlahJalanBaik = count(array_filter($data, fn($item) => $item['kondisi_id'] == 1));

                $jumlahJalanDesa = count(array_filter($data, fn($item) => $item['jenisjalan_id'] == 1));
                $jumlahJalanKabupaten = count(array_filter($data, fn($item) => $item['jenisjalan_id'] == 2));
                $jumlahJalanProvinsi = count(array_filter($data, fn($item) => $item['jenisjalan_id'] == 3));


                $jumlahEksistingTanah = count(array_filter($data, fn($item) => $item['eksisting_id'] == 1));
                $jumlahEksistingTanahBeton = count(array_filter($data, fn($item) => $item['eksisting_id'] == 2));
                $jumlahEksistingPerkerasan = count(array_filter($data, fn($item) => $item['eksisting_id'] == 3));
                $jumlahEksistingKoral = count(array_filter($data, fn($item) => $item['eksisting_id'] == 4));
                $jumlahEksistingLapen = count(array_filter($data, fn($item) => $item['eksisting_id'] == 5));
                $jumlahEksistingPaving = count(array_filter($data, fn($item) => $item['eksisting_id'] == 6));
                $jumlahEksistingHotmix = count(array_filter($data, fn($item) => $item['eksisting_id'] == 7));
                $jumlahEksistingBeton = count(array_filter($data, fn($item) => $item['eksisting_id'] == 8));
                $jumlahEksistingBetonLapen = count(array_filter($data, fn($item) => $item['eksisting_id'] == 9));



                

                return view('data', [
                    'roadData' => $data,
                    'resultCount' => count($data),
                    'title' => "Data",
                    'jumlahJalanRusak' => $jumlahJalanRusak,
                    'jumlahJalanSedang' => $jumlahJalanSedang,
                    'jumlahJalanBaik' => $jumlahJalanBaik,
                    'jumlahJalanDesa' => $jumlahJalanDesa,
                    'jumlahJalanKabupaten' => $jumlahJalanKabupaten,
                    'jumlahJalanProvinsi' => $jumlahJalanProvinsi,
                    'jumlahEksistingTanah' => $jumlahEksistingTanah,
                    'jumlahEksistingTanahBeton' => $jumlahEksistingTanahBeton,
                    'jumlahEksistingPerkerasan' => $jumlahEksistingPerkerasan,
                    'jumlahEksistingKoral' => $jumlahEksistingKoral,
                    'jumlahEksistingLapen' => $jumlahEksistingLapen,
                    'jumlahEksistingPaving' => $jumlahEksistingPaving,
                    'jumlahEksistingHotmix' => $jumlahEksistingHotmix,
                    'jumlahEksistingBeton' => $jumlahEksistingBeton,
                    'jumlahEksistingBetonLapen' => $jumlahEksistingBetonLapen,
                ]);
            }
        }

        // Jika tidak ada token atau permintaan gagal
        return redirect()->route('login'); // Sesuaikan dengan rute login Anda
    }

    public function deleteData($id) {
        if(session('token')){
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . session('token'),
                'Content-Type' => 'application/json'
            ])->delete('https://gisapis.manpits.xyz/api/ruasjalan/' .$id);

            if($response->successful()){
                // dd($response->json());
                // $data = $response->json()["ruasjalan"];
                // // dd($data);

                return back()->with('success-delete-road',"Success Delete Data");
            }
        }
    }
}
