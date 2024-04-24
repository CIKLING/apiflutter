<?php

namespace App\Http\Controllers;

use Firebase\JWT\JWT;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{

    public function signUp(Request $request)
    {
        $name = $request->input('name');
        $nik = $request->input('nik');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $kec = $request->input('kec');
        $kel = $request->input('kel');
        $password = $request->input('password');



        // Buat hash dari password
        $hashedPassword = Hash::make($password);

        // Buat user baru
        $user = new User();
        $user->name = $name;
        $user->nik = $nik;
        $user->email = $email;
        $user->phone = $phone;
        $user->kec = $kec;
        $user->kel = $kel;
        $user->password = $hashedPassword;
        $user->save();

        // Berikan respons berhasil
        return response()->json([
            'success' => true,
            'message' => 'Akun berhasil dibuat',
        ]);
    }
    public function sign_in(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        // Cari user berdasarkan email
        $user = User::where('email', $email)->first();

        // Pastikan user ditemukan
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Email tidak ditemukan',
            ], 404);
        }

        // Verifikasi password
        if (Hash::check($password, $user->password)) {
            // Password cocok, proses login berhasil
            return response()->json([
                'success' => true,
                'message' => 'Login Sukses',
            ]);
        } else {
            // Password tidak cocok, proses login gagal
            return response()->json([
                'success' => false,
                'message' => 'Password salah',
            ], 401);
        }
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Attempt to authenticate
        if (Auth::attempt($credentials)) {
            $user = $request->user();
            $token = $user->createToken('authToken')->plainTextToken;
            return response()->json(['token' => $token]);
        }
    }
}