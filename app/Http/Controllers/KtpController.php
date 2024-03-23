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

class KtpController extends Controller
{
    use HasImage;
    use HasTiket;
    use HasPenanggung;

    public $path = 'public/ktps/';
    public $pathselfie = 'public/selfie/';
    public $layanan = 'KTP';

    public function index()
    {
        return response()->json(['success' => true, 'message' => 'Ok !']);
    }

    public function layanan()
    {
        $layanans = Layanan::all()->where('name', '=', $this->layanan);

        unset($layanans[0]);
        unset($layanans[5]);
        unset($layanans[6]);
        unset($layanans[7]);


        $arr = [];
        foreach ($layanans as $key => $value) {
            $arr[] = ['id' => $value->id, 'nama' => $value->detail];
        }

        return response()->json(['success' => true, 'message' => $arr]);
    }

    public function create(Request $request)
    {

        try {

            $tiketcode = $this->ambilTiket(Layanan::all()->where('id', '=', $request->layanan_id)->last()->code);
            $penanggungJawab = $this->penanggungJawab('10');
            $tiket = $tiketcode;

            $kecamatanya = "";
            $kec1 = $request->kec;
            if ($kec1 == "1") {
                $kecamatanya = "BLIMBING";
            } elseif ($kec1 == "2") {
                $kecamatanya = "KLOJEN";
            } elseif ($kec1 == "3") {
                $kecamatanya = "KEDUNGKANDANG";
            } elseif ($kec1 == "4") {
                $kecamatanya = "SUKUN";
            } elseif ($kec1 == "5") {
                $kecamatanya = "LOWOKWARU";
            }

            // $lastid = Persyaratan::create([
            //     'fm1' => $request->fm1, // nik pelapor
            //     'fm2' => $request->fm2, // nama pelapor
            //     'fm3' => $request->fm3, // NIK
            //     'fm4' => $request->fm4, // nama
            //     'fm5' => $request->fm5, // NO KK

            // 'img1' => $this->uploadImage2($request->file('img1'), $this->path), // Kartu Keluarga (KK)
            // 'img2' => $this->uploadImage2($request->file('img2'), $this->path), // Formulir f1-01 (Perubahan Elemen KK / Pisah KK)
            // 'img3' => $this->uploadImage2($request->file('img3'), $this->path), // Formulir f1-06 (Perubahan Elemen KK Barcode)
            // 'img4' => $this->uploadImage2($request->file('img4'), $this->path), // F1-03 (Perubahan Alamat / Pindah Dalam Kota / Pisah KK)
            // 'img5' => $this->uploadImage2($request->file('img5'), $this->path), // SPTJM Pendaftaran Penduduk
            // 'img6' => $this->uploadImage2($request->file('img6'), $this->path), // Surat Pernyataan Tempat Tinggal (Untuk Pindah)
            // 'img7' => $this->uploadImage2($request->file('img7'), $this->path), // Surat Keterangan Hilang / KK Rusak
            // 'img8' => $this->uploadImage2($request->file('img8'), $this->path), // KTP (Hilang / Rusak)
            // 'img9' => $this->uploadImage2($request->file('img9'), $this->path), // Dokumen Pendujung Lain
            // 'img10' => $this->uploadImage2($request->file('img10'), $this->path), // Dokumen Pendujung Lain
            // ])->id;
            $lastid = DB::table('persyaratans')
                ->insertGetId([
                    'fm1' => $request->fm1, // nik pelapor
                    'fm2' => $request->fm2, // nama pelapor
                    'fm3' => $request->fm3, // NIK
                    'fm4' => $request->fm4, // nama
                    'fm5' => $request->fm5, // NO KK

                    'img1' => $this->uploadImage2($request->file('img1'), $this->path), // Kartu Keluarga (KK)
                    'img2' => $this->uploadImage2($request->file('img2'), $this->path), // Formulir f1-01 (Perubahan Elemen KK / Pisah KK)
                    'img3' => $this->uploadImage2($request->file('img3'), $this->path), // Formulir f1-06 (Perubahan Elemen KK Barcode)
                    'img4' => $this->uploadImage2($request->file('img4'), $this->path), // F1-03 (Perubahan Alamat / Pindah Dalam Kota / Pisah KK)
                    'img5' => $this->uploadImage2($request->file('img5'), $this->path), // SPTJM Pendaftaran Penduduk
                    'img6' => $this->uploadImage2($request->file('img6'), $this->path), // Surat Pernyataan Tempat Tinggal (Untuk Pindah)
                    'img7' => $this->uploadImage2($request->file('img7'), $this->path), // Surat Keterangan Hilang / KK Rusak
                    'img8' => $this->uploadImage2($request->file('img8'), $this->path), // KTP (Hilang / Rusak)
                    'img9' => $this->uploadImage2($request->file('img9'), $this->path), // Dokumen Pendujung Lain
                    'img10' => $this->uploadImage2($request->file('img10'), $this->path), // Dokumen Pendujung Lain
                ]);


            if ($lastid) {
                $post['user_id'] = $request->user_id;
                $post['layanan_id'] = $request->layanan_id;
                $post['persyaratan_id'] = $lastid;
                $post['layanankategori_id'] = 1;
                // $post['status_id'] => $request->layanan_id,
                // $post['traking_id'] => $request->layanan_id,
                // $post['operator_id'] = $user->hasRole('MPP') ? $post['user_id'] : $penanggungJawab;
                $post['operator_id'] = $penanggungJawab;
                $post['statustracking_id'] = 112;
                $post['tiket'] = $tiket;
                $post['pelapor_nik'] = $request->fm1;
                $post['pelapor_name'] = $request->fm2;
                $post['pelapor_email'] = $request->pelapor_email;
                $post['pelapor_phone'] = $request->pelapor_phone;
                $post['kec'] = $kecamatanya;
                $post['kel'] = $request->kel;
                $post['status_tracking'] = 'Teregristasi Malang Mbois';
                $post['status_pesan'] = '1';
                $post['ket'] = $request->ket;
                $post['selfie'] = $this->uploadImage2($request->file('selfie'), $this->pathselfie);
                $post['created_at'] = Carbon::now();
                $post['updated_at'] = Carbon::now();

                if ($post['selfie'] == null || $post['selfie'] == '') {

                    return response()->json(['success' => false, 'message' => 'Gagal, Belum selfie !']);

                } else {

                    $data = DB::table('pendaftarans')
                        ->insert($post);


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