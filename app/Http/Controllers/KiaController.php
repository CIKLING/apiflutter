<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Persyaratan;
use App\Models\Statustracking;
use App\Models\Layanan;
use App\Traits\HasImage;
use App\Traits\HasTiket;
use App\Traits\HasPenanggung;
use App\Http\Controllers\Controller;
// use App\Http\Requests\IdentitasanakRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KiaController extends Controller
{
    use HasImage;
    use HasTiket;
    use HasPenanggung;

    public $path = 'public/identitasanaks/';
    public $pathselfie = 'public/selfie/';
    public $layanan = 'KIA';

    public function index()
    {
        return response()->json(['success' => true, 'message' => 'Ok !']);
    }

    public function layanan()
    {
        $layanans = Layanan::all()->where('name','=',$this->layanan);
    
        $arr = [];
        foreach ($layanans as $key => $value) {
            $arr[] = ['id' => $value->id, 'nama' => $value->detail];
        }

        return response()->json(['success' => true, 'message' => $arr]);
    }


    public function create(Request $request)
    {
        try {
            $tiketcode = $this->ambilTiket(Layanan::all()->where('id','=',$request->layanan_id)->last()->code);
            $tiket = $tiketcode;

            $kecamatanya = "";
            $kec1 = $request->kec;
            if($kec1=="1"){
                $kecamatanya = "BLIMBING";
            }elseif($kec1=="2"){
                $kecamatanya = "KLOJEN";
            }elseif($kec1=="3"){
                $kecamatanya = "KEDUNGKANDANG";
            }elseif($kec1=="4"){
                $kecamatanya = "SUKUN";
            }elseif($kec1=="5"){
                $kecamatanya = "LOWOKWARU";
            }
            /* :::::::::Insert kia ::::::::: */
                $penanggungJawab = $this->penanggungJawab('11'); // OPERATOR KIA 11
                $lastid = DB::table('persyaratans')
                        ->insertGetId([
                    'fm1' => $request->fm1, // nik pelapor
                    'fm2' => $request->fm2, // nama pelapor
                    'fm3' => $request->fm3, // nik anak
                    'fm4' => $request->fm4, // nama anak
                    'img1' => $this->uploadImage2($request->file('img1'), $this->path), // KK
                    'img2' => $this->uploadImage2($request->file('img2'), $this->path), // akta anak
                    'img3' => $this->uploadImage2($request->file('img3'), $this->path), // foto anak
                    'img4' => $this->uploadImage2($request->file('img4'), $this->path), // akta anak
                    'img5' => $this->uploadImage2($request->file('img5'), $this->path), // foto anak
                ]);
    
                if($lastid){

                    if($request->selfie == null || $request->selfie == ''){

                        return response()->json(['success' => false, 'message' => 'Gagal, Belum selfie !']);
                    
                    }
                    else{

                        DB::table('pendaftarans')
                            ->insert([
                                'user_id' => $request->user_id,
                                'persyaratan_id' => $lastid,
                                'layanan_id' => $request->layanan_id, // layanan kia
                                'layanankategori_id' => 3, // layanankategori 3 PKS
                                // 'status_id' => $request->layanan_id,
                                // 'traking_id' => $request->layanan_id,
                                'operator_id' => $penanggungJawab,
                                'tiket' => $tiket,
                                'pelapor_nik' => $request->fm1,
                                'pelapor_name' => $request->fm2,
                                'pelapor_email' => $request->pelapor_email,
                                'pelapor_phone' => $request->pelapor_phone,
                                'kec' => $kecamatanya,
                                'kel' => $request->kelurahan,
                                'statustracking_id' => 152, // 1. registrasi KIA
                                'status_tracking' => 'Teregristasi Malang Mbois',
                                'status_pesan' => '1',
                                'ket' => $request->ket,
                                'selfie' => $this->uploadImage2($request->file('selfie'), $this->pathselfie),
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ]);
                    
                    
                        return response()->json(['success' => true, 'message' => 'Berhasil !']);
                    }

                   
                }

        } catch (\Throwable $e) {
            return response()->json([
                'error' => [
                    'description' => $e->getMessage()
                ]
            ], 500);
        }

        

    }

}