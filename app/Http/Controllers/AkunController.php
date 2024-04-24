<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
// use Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class AkunController extends Controller
{
    // use PasswordValidationRules;
    use HasRoles;

    public function index()
    {
        return response()->json(['success' => true, 'message' => 'Ok !']);
    }

    public function getUser()
    {

        \App\Models\Admin::all();
    }

    public function sync(Request $request)
    {

        $email = $request->email;

        $cek = DB::table('users')
            ->where('email', $email)
            ->first();

        if ($cek) {

            return response()->json(['success' => true, 'message' => 'Berhasil, sudah pernah memiliki akun !', 'data' => $cek]);

        } else {

            $client = new \GuzzleHttp\Client(array('curl' => array(CURLOPT_SSL_VERIFYPEER => false, )));
            $res = $client->request('GET', 'https://geni.malangkota.go.id/superapps/api/siapel/user/' . $email . '', ['auth' => ['admin', 'admin']]);
            $response = $res->getBody()->getContents();
            $arr = json_decode($response);
            $user_superapps = $arr->data;

            try {

                if ($request->nik == null) {
                    return response()->json(['success' => false, 'message' => 'Harap isi NIK !']);
                }
                if ($request->phone == null) {
                    return response()->json(['success' => false, 'message' => 'Harap isi Nomor Telepon !']);
                }
                if ($request->kelurahan == null) {
                    return response()->json(['success' => false, 'message' => 'Harap isi Kelurahan !']);
                }
                if ($request->kecamatan == null) {
                    return response()->json(['success' => false, 'message' => 'Harap isi Kecamatan !']);
                }
                $kode = strtoupper(Str::random(6));

                $user = DB::table('users')
                    ->insertGetId([
                        'name' => $user_superapps->nama,
                        'nik' => $request->nik,
                        'email' => $user_superapps->email,
                        'phone' => $this->convert_hp_number($request->phone),
                        'kel' => $request->kelurahan,
                        'kec' => $request->kecamatan,
                        'status' => 'aktif',
                        'token_user' => $kode,
                        'password' => $user_superapps->password,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);


                DB::table('model_has_roles')
                    ->insert([
                        'role_id' => 9,
                        'model_type' => 'App\Models\User',
                        'model_id' => $user,
                    ]);

                $data = DB::table('users')
                    ->where('email', $user_superapps->email)
                    ->first();


                //$this->sendEmail($user_superapps->email,'Sinkronisasi Akun', $kode);



                return response()->json(['success' => true, 'message' => 'Berhasil Sinkronisasi !', 'data' => $data]);

            } catch (\Throwable $th) {
                return response()->json([
                    'error' => [
                        'description' => $th->getMessage()
                    ]
                ], 500);
            }
        }

    }

    public function convert_hp_number($no)
    {
        if (!preg_match('/[^+0-9]/', trim($no))) {
            // cek apakah no hp karakter 1-3 adalah +62
            if (substr(trim($no), 0, 3) == '+62') {
                $hp = '62' . substr(trim($no), 1);
            }
            // cek apakah no hp karakter 1 adalah 0
            elseif (substr(trim($no), 0, 1) == '0') {
                $hp = '62' . substr(trim($no), 1);
            } else {
                $hp = $no;
            }
        }
        return $hp;
    }

    public function verifikasi(Request $request)
    {

        try {

            $email = $request->email;
            $kode = $request->kode;

            $data = DB::table('users')
                ->where('email', $email)
                ->where('token_user', $kode)
                ->first();

            if ($data) {

                DB::table('users')
                    ->where('email', $email)
                    ->update([
                        'token_user' => null,
                        'status' => 'aktif',
                    ]);

                return response()->json(['success' => true, 'message' => 'Berhasil'], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'Gagal, Email / Kode tidak sesuai'], 401);
            }


        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => $th], 401);
        }
    }

    function sendEmail($email, $title, $kode)
    {

        $mail = new PHPMailer;
        $data = DB::table('users')
            ->where('email', $email)
            ->first();

        // $link = Crypt::encryptString($data->email);

        DB::table('users')
            ->where('email', $email)
            ->update(['token_user' => $kode]);

        $body = view('email', compact('data', 'kode'))->render();

        $mail->IsSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        // $mail->SMTPDebug = 1;
        $mail->SMTPAuth = true;
        $mail->Username = 'superappskotamalang@gmail.com';
        $mail->Password = 'hzeeycujdglcomyt';
        $mail->From = 'superappskotamalang@gmail.com';
        $mail->FromName = 'SuperApps Kota Malang';
        $mail->AddAddress($email);
        $mail->Subject = $title;
        $mail->Body = $body;
        $mail->IsHTML(true);

        if (!$mail->Send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
            exit;
        }

    }
}