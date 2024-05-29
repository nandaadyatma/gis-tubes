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
        $data = [
            "paths" => "`pcs@uqr~T4}BJ}@",
            "desa_id"=> 473,
            "kode_ruas"=> "R1",
            "nama_ruas"=> "10-12",
            "panjang"=> "1093",
            "lebar" => "3",
            "eksisting_id"=> 2,
            "kondisi_id"=> 2,
            "jenisjalan_id"=> 1,
            "keterangan"=> "keterangan Jalan"
        ];

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
                return back()->with('info',"Success Create Data"); //flash session
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
}
