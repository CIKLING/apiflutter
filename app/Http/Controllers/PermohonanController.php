<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class PermohonanController extends Controller
{
    public function index()
    {
        return response()->json(['success' => true, 'message' => 'Ok !']);
    }

    function tgl_indo($tanggal)
    {
        $bulan = array(
            1 => 'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode('-', $tanggal);

        return $pecahkan[2] . ' ' . $bulan[(int) $pecahkan[1]] . ' ' . $pecahkan[0];

    }

    public function list($email)
    {

        // $email = 'achmadprayogi1@gmail.com';
        // dd($email);
        try {
            $get_id = DB::table('users')
                ->where('email', $email)
                ->first();

            $data = DB::table('pendaftarans')
                ->leftJoin('statustrackings', 'pendaftarans.statustracking_id', 'statustrackings.id')
                ->where('user_id', $get_id->id)
                ->select('pendaftarans.*', 'statustrackings.name as nama_tracking')
                ->orderBy('created_at', 'DESC')
                ->get();

            $arr = [];
            foreach ($data as $key => $value) {

                $layanan = DB::table('layanans')
                    ->where('id', $value->layanan_id)
                    ->first();

                $format_tanggal = date("Y-m-d", strtotime($value->created_at));
                $tanggal = $this->tgl_indo($format_tanggal);
                // $format_jam = date('H:i:s', strtotime($value->created_at));

                // $jam =  strtotime("+7 hours", ($format_jam));

                $track = "";
                if ($value->nama_tracking != 'Reg. Online' && $value->nama_tracking != 'Dokumen Ditolak' && $value->nama_tracking != 'Dokumen Dibatalkan' && $value->nama_tracking != 'Dokumen Diarsipkan' && $value->nama_tracking != 'Dokumen Lengkap dan Telah di Ambil' && $value->nama_tracking != 'Dokumen Siap Diambil') {
                    $track = "Reg. Online";
                } else {
                    $track = $value->nama_tracking;
                }

                $arr[] = [
                    'id' => $value->id,
                    'tiket' => $value->tiket,
                    'nama_pelapor' => $value->pelapor_name,
                    'nik_pelapor' => $value->pelapor_nik,
                    'layanan' => $layanan->detail,
                    'status_tracking' => $value->nama_tracking,
                    'tanggal' => $tanggal,
                    'keterangan' => $value->ket
                ];
            }

            return response()->json(['success' => true, 'data' => $arr]);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => [
                    'description' => $th->getMessage()
                ]
            ], 500);
        }

    }

}