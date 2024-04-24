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

class AktaKelahiranController extends Controller
{
    use HasImage;
    use HasTiket;
    use HasPenanggung;

    public $path = 'public/kelahirans/';
    public $pathselfie = 'public/selfie/';
    public $layanan = 'PAKET KELAHIRAN';

    public function index()
    {
        return response()->json(['success' => true, 'message' => 'Ok !']);
    }

    public function layanan()
    {
        $layanans = Layanan::all()->where('name', '=', $this->layanan);
        $layanans->forget('29');
        $layanans->forget('30');
        // $status = auth()->user()->status;
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
            $tiket = $tiketcode;
            // $nama = auth()->user()->name;
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
            $keterangan = $request->ket;
            /* :::::::::Insert akta::::::::: */
            $penanggungJawab = $this->penanggungJawab('7'); // // OPERATOR KELAHIRAN KK 7
            $lastid = DB::table('persyaratans')->insertGetId([
                'fm1' => $request->fm1, // nik pelapor
                'fm2' => $request->fm2, // nama pelapor
                'fm3' => $request->fm3, // nik bayi
                'fm4' => $request->fm4, // nama bayi
                'fm5' => $request->fm5, // nik ibu
                'fm6' => $request->fm6, // nama ibu
                'fm7' => $request->fm7, // no kk
                'fm8' => $request->fm8,
                'fm9' => $request->fm9,
                'fm10' => $request->fm10,
                'fm11' => $request->fm11,
                'fm12' => $request->fm12,
                'fm13' => $request->fm13,
                'img1' => $this->uploadImage2($request->file('img1'), $this->path), // kk
                'img2' => $this->uploadImage2($request->file('img2'), $this->path), // ktp ibu
                'img3' => $this->uploadImage2($request->file('img3'), $this->path), // ktp bapak
                'img4' => $this->uploadImage2($request->file('img4'), $this->path), // bukunikah
                'img5' => $this->uploadImage2($request->file('img5'), $this->path), // surat kelahiran
                'img6' => $this->uploadImage2($request->file('img6'), $this->path), // f2-01
                'img7' => $this->uploadImage2($request->file('img7'), $this->path), // foto KIA
                'img8' => $this->uploadImage2($request->file('img8'), $this->path),
                'img9' => $this->uploadImage2($request->file('img9'), $this->path),
            ]);

            if ($lastid) {
                $post['user_id'] = $request->user_id;
                $post['persyaratan_id'] = $lastid;
                $post['layanan_id'] = $request->layanan_id;
                $post['layanankategori_id'] = 1; // layanankategori 1 Kelurahan
                // $post['status_id'] = $request->layanan_id;
                // $post['traking_id'] = $request->layanan_id;
                $post['operator_id'] = $penanggungJawab;
                $post['tiket'] = $tiket;
                $post['pelapor_nik'] = $request->fm1;
                $post['pelapor_name'] = $request->fm2;
                $post['pelapor_email'] = $request->pelapor_email;
                $post['pelapor_phone'] = $request->pelapor_phone;
                // 'kec' = Auth::user()->kec;
                // 'kel' = Auth::user()->kel;
                $post['kec'] = $kecamatanya;
                $post['kel'] = $request->kel;
                $post['statustracking_id'] = 512; // 1. registrasi
                $post['status_tracking'] = 'Teregristasi Malang Mbois';
                $post['status_pesan'] = '1';
                $post['ket'] = $keterangan;
                $post['created_at'] = Carbon::now();
                $post['updated_at'] = Carbon::now();
                $post['selfie'] = $this->uploadImage2($request->file('selfie'), $this->pathselfie);

                DB::table('pendaftarans')->insert($post);
            }
            /* :::::::::Insert akta end::::::::: */

            /* :::::::::Insert kk ::::::::: */
            $lastid = DB::table('persyaratans')->insertGetId([
                'fm1' => $request->fm1, // nik pelapor
                'fm2' => $request->fm2, // nama pelapor
                'fm3' => $request->fm3, // nik bayi
                'fm4' => $request->fm4, // nama bayi
                'fm5' => $request->fm7, // no KK
                'img1' => $this->uploadImage2($request->file('img1'), $this->path), // kk
                'img2' => $this->uploadImage2($request->file('img2'), $this->path), // f1 01
                'img3' => $this->uploadImage2($request->file('img3'), $this->path), // f1 06
                'img4' => $this->uploadImage2($request->file('img4'), $this->path), // sptjm pendaftaran penduduk
                'img5' => $this->uploadImage2($request->file('img5'), $this->path), // dok pendukung
                'img6' => $this->uploadImage2($request->file('img6'), $this->path), // dok pendukung
                'img7' => $this->uploadImage2($request->file('img7'), $this->path), // dok pendukung
                'img8' => $this->uploadImage2($request->file('img8'), $this->path), // dok pendukung
                'img9' => $this->uploadImage2($request->file('img9'), $this->path),
            ]);

            if ($lastid) {
                $post['user_id'] = $request->user_id;
                $post['persyaratan_id'] = $lastid;
                $post['layanan_id'] = '421'; // kk paket kelahiran
                $post['layanankategori_id'] = 1; // layanankategori 1 Kelurahan
                // $post['status_id'] = $request->layanan_id;
                // $post['traking_id'] = $request->layanan_id;
                $post['operator_id'] = $penanggungJawab;
                $post['tiket'] = $tiket;
                $post['pelapor_nik'] = $request->fm1;
                $post['pelapor_name'] = $request->fm2;
                $post['pelapor_email'] = $request->pelapor_email;
                $post['pelapor_phone'] = $request->pelapor_phone;
                // 'kec' = Auth::user()->kec;
                // 'kel' = Auth::user()->kel;
                $post['kec'] = $kecamatanya;
                $post['kel'] = $request->kel;
                $post['statustracking_id'] = 412; // 411 KK REGISTRASI
                $post['status_tracking'] = 'Teregristasi Malang Mbois';
                $post['status_pesan'] = '1';
                $post['ket'] = $keterangan;
                $post['created_at'] = Carbon::now();
                $post['updated_at'] = Carbon::now();
                $post['selfie'] = $this->uploadImage2($request->file('selfie'), $this->pathselfie);

                DB::table('pendaftarans')->insert($post);
            }
            /* :::::::::Insert kk end::::::::: */

            /* :::::::::Insert kia ::::::::: */
            $penanggungJawab = $this->penanggungJawab('11'); // OPERATOR KIA 11
            $lastid = DB::table('persyaratans')->insertGetId([
                'fm1' => $request->fm1, // nik pelapor
                'fm2' => $request->fm2, // nama pelapor
                'fm3' => $request->fm3, // nik anak
                'fm4' => $request->fm4, // nama anak
                'img1' => $this->uploadImage2($request->file('img1'), $this->path), // foto anak
                'img2' => $this->uploadImage2($request->file('img2'), $this->path), // akta anak
            ]);

            if ($lastid) {
                $post['user_id'] = $request->user_id;
                $post['persyaratan_id'] = $lastid;
                $post['layanan_id'] = '155'; // kia baru
                $post['layanankategori_id'] = 1; // layanankategori 1 Kelurahan
                // $post['status_id'] = $request->layanan_id;
                // $post['traking_id'] = $request->layanan_id;
                $post['operator_id'] = $penanggungJawab;
                $post['tiket'] = $tiket;
                $post['pelapor_nik'] = $request->fm1;
                $post['pelapor_name'] = $request->fm2;
                $post['pelapor_email'] = $request->pelapor_email;
                $post['pelapor_phone'] = $request->pelapor_phone;
                // 'kec' => Auth::user()->kec;
                // 'kel' => Auth::user()->kel;
                $post['kec'] = $kecamatanya;
                $post['kel'] = $request->kel;
                $post['statustracking_id'] = 152; // Registrasi Kelahiran
                $post['status_tracking'] = 'Teregristasi Malang Mbois';
                $post['status_pesan'] = '1';
                $post['ket'] = $request->ket;
                $post['created_at'] = Carbon::now();
                $post['updated_at'] = Carbon::now();
                $post['selfie'] = $this->uploadImage2($request->file('selfie'), $this->pathselfie);

                DB::table('pendaftarans')->insert($post);
            }
            /* :::::::::Insert kia end::::::::: */
            return response()->json(['success' => true, 'message' => 'Berhasil !']);

        } catch (\Throwable $e) {

            return response()->json([
                'error' => [
                    'description' => $e->getMessage()
                ]
            ], 500);
        }
    }
}
