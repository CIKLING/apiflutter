<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Models\Pendaftaran;
use App\Models\Persyaratan;
use App\Models\Statustracking;
use App\Models\Layanan;
use App\Traits\HasImage;
use App\Traits\HasTiket;
use App\Traits\HasPenanggung;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Operator;
use Illuminate\Support\Facades\Storage;

class DisabilitasController extends Controller
{
    use HasImage;
    use HasTiket;
    use HasPenanggung;

    public $path = 'public/pendudukrentans/';
    public $pathselfie = 'public/selfie/';
    public $layanan = 'PENDUDUK RENTAN';

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

           //
        $tiketcode = $this->ambilTiket(Layanan::all()->where('id','=',$request->layanan_id)->last()->code);
        $tiket = $tiketcode;
        /* :::::::::Insert kia ::::::::: */
            $penanggungJawab = $this->penanggungJawab('17'); // OPERATOR KIA 11
            $lastid = Persyaratan::create([
                'fm1' => $request->fm1, // nik pelapor
                'fm2' => $request->fm2, // nama pelapor
                'fm3' => $request->fm3, // nik anak
                'fm4' => $request->fm4, // nama anak
                'fm5' => $request->fm5,
                'img1' => $this->uploadImage2($request->file('img1'), $this->path), // foto anak
                'img2' => $this->uploadImage2($request->file('img2'), $this->path), // akta anak
                'img3' => $this->uploadImage2($request->file('img3'), $this->path), // foto anak
                'img4' => $this->uploadImage2($request->file('img4'), $this->path), // akta anak
                'img5' => $this->uploadImage2($request->file('img5'), $this->path),
            ])->id;

            if($lastid){

                if($request->selfie == null || $request->selfie == ''){

                    return response()->json(['success' => false, 'message' => 'Gagal, Belum selfie !']);
                
                }
                else{
                    DB::table('pendaftarans')
                        ->insert([
                            'user_id' => $request->user_id,
                            'persyaratan_id' => $lastid,
                            'layanan_id' => $request->layanan_id, // layanan penduduk rentan
                            'layanankategori_id' => 1, // layanankategori 1 Kelurahan
                            // 'status_id' => $request->layanan_id,
                            // 'traking_id' => $request->layanan_id,
                            'operator_id' => $penanggungJawab,
                            'tiket' => $tiket,
                            'pelapor_nik' => $request->fm1,
                            'pelapor_name' => $request->fm3,
                            'pelapor_email' => $request->pelapor_email,
                            'pelapor_phone' => $request->pelapor_phone,
                            'kec' => $request->kecamatan,
                            'kel' => $request->kelurahan,
                            'statustracking_id' => 802, // 1. registrasi KIA
                            'status_tracking' => 'Teregristasi Malang Mbois',
                            'status_pesan' => '1',//SEDANG DIKIRIM SEBELUMNYA
                            'ket' => $request->ket,
                            'selfie' => $this->uploadImage2($request->file('imgselfie'), $this->pathselfie),
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