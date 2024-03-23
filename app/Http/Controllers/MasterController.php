<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;


class MasterController extends Controller
{
    
    public function index()
    {
        return response()->json(['success' => true, 'message' => 'Ok !']);
    }

    public function kecamatan(){

        $kecamatan[] = ['id' => 1, 'nama' => 'BLIMBING'];
        $kecamatan[] = ['id' => 2, 'nama' => 'KLOJEN'];
        $kecamatan[] = ['id' => 3, 'nama' => 'KEDUNGKANDANG'];
        $kecamatan[] = ['id' => 4, 'nama' => 'SUKUN'];
        $kecamatan[] = ['id' => 5, 'nama' => 'LOWOKWARU'];
        $kecamatan[] = ['id' => 6, 'nama' => 'KTP Luar Daerah'];

        return (['success'=> true,'data'=>$kecamatan]);
    }

    public function kelurahan(Request $request){

        $kecamatan_id = $request->kecamatan_id;
         
        $kelurahan = [];
        if($kecamatan_id == 1){
            
            $kelurahan[] = ['id' => 1001,'kec' => "1",'kel'=>'1001', 'nama' => 'BALEARJOSARI'];
            $kelurahan[] = ['id' => 1002,'kec' => "1",'kel'=>'1002', 'nama' => 'ARJOSARI'];
            $kelurahan[] = ['id' => 1003,'kec' => "1",'kel'=>'1003', 'nama' => 'POLOWIJEN'];
            $kelurahan[] = ['id' => 1004,'kec' => "1",'kel'=>'1004', 'nama' => 'PURWODADI'];
            $kelurahan[] = ['id' => 1005,'kec' => "1",'kel'=>'1005', 'nama' => 'BLIMBING'];
            $kelurahan[] = ['id' => 1006,'kec' => "1",'kel'=>'1006', 'nama' => 'PANDANWANGI'];
            $kelurahan[] = ['id' => 1007,'kec' => "1",'kel'=>'1007', 'nama' => 'PURWANTORO'];
            $kelurahan[] = ['id' => 1008,'kec' => "1",'kel'=>'1008', 'nama' => 'BUNULREJO'];
            $kelurahan[] = ['id' => 1009,'kec' => "1",'kel'=>'1009', 'nama' => 'KESATRIAN'];
            $kelurahan[] = ['id' => 10010,'kec' => "1",'kel'=>'10010', 'nama' => 'POLEHAN'];
            $kelurahan[] = ['id' => 10011,'kec' => "1",'kel'=>'10011', 'nama' => 'JODIPAN'];
            
        }

        if($kecamatan_id == 2){

            $kelurahan[] = ['id' => 1001,'kec' => "2",'kel'=>'1001', 'nama' => 'KLOJEN'];
            $kelurahan[] = ['id' => 1002,'kec' => "2",'kel'=>'1002', 'nama' => 'RAMPAL CELAKET'];
            $kelurahan[] = ['id' => 1003,'kec' => "2",'kel'=>'1003', 'nama' => 'SAMAAN'];
            $kelurahan[] = ['id' => 1004,'kec' => "2",'kel'=>'1004', 'nama' => 'KIDUL DALEM'];
            $kelurahan[] = ['id' => 1005,'kec' => "2",'kel'=>'1005', 'nama' => 'SUKOHARJO'];
            $kelurahan[] = ['id' => 1006,'kec' => "2",'kel'=>'1006', 'nama' => 'KASIN'];
            $kelurahan[] = ['id' => 1007,'kec' => "2",'kel'=>'1007', 'nama' => 'KAUMAN'];
            $kelurahan[] = ['id' => 1008,'kec' => "2",'kel'=>'1008', 'nama' => 'ORO ORO DOWO'];
            $kelurahan[] = ['id' => 1009,'kec' => "2",'kel'=>'1009', 'nama' => 'BARENG'];
            $kelurahan[] = ['id' => 10010,'kec' => "2",'kel'=>'10010', 'nama' => 'GADINGKASRI'];
            $kelurahan[] = ['id' => 10011,'kec' => "2",'kel'=>'10011', 'nama' => 'PENANGGUNGAN'];

        }

        if($kecamatan_id == 3){

            $kelurahan[] = ['id' => 1001,'kec' => "3",'kel'=>'1001', 'nama' => 'KOTALAMA'];
            $kelurahan[] = ['id' => 1002,'kec' => "3",'kel'=>'1002', 'nama' => 'MERGOSONO'];
            $kelurahan[] = ['id' => 1003,'kec' => "3",'kel'=>'1003', 'nama' => 'BUMIAYU'];
            $kelurahan[] = ['id' => 1004,'kec' => "3",'kel'=>'1004', 'nama' => 'WONOKOYO'];
            $kelurahan[] = ['id' => 1005,'kec' => "3",'kel'=>'1005', 'nama' => 'BURING'];
            $kelurahan[] = ['id' => 1006,'kec' => "3",'kel'=>'1006', 'nama' => 'KEDUNGKANDANG'];
            $kelurahan[] = ['id' => 1007,'kec' => "3",'kel'=>'1007', 'nama' => 'LESANPURO'];
            $kelurahan[] = ['id' => 1008,'kec' => "3",'kel'=>'1008', 'nama' => 'SAWOJAJAR'];
            $kelurahan[] = ['id' => 1009,'kec' => "3",'kel'=>'1009', 'nama' => 'MADYOPURO'];
            $kelurahan[] = ['id' => 10010,'kec' => "3",'kel'=>'10010', 'nama' => 'CEMOROKANDANG'];
            $kelurahan[] = ['id' => 10011,'kec' => "3",'kel'=>'10011', 'nama' => 'ARJOWINANGUN'];
            $kelurahan[] = ['id' => 10012,'kec' => "3",'kel'=>'10012', 'nama' => 'TLOGOWARU'];

        }

        if($kecamatan_id == 4){

            $kelurahan[] = ['id' => 1001,'kec' => "4",'kel'=>'1001', 'nama' => 'CIPTOMULYO'];
            $kelurahan[] = ['id' => 1002,'kec' => "4",'kel'=>'1002', 'nama' => 'GADANG'];
            $kelurahan[] = ['id' => 1003,'kec' => "4",'kel'=>'1003', 'nama' => 'KEBONSARI'];
            $kelurahan[] = ['id' => 1004,'kec' => "4",'kel'=>'1004', 'nama' => 'BANDUNGREJOSARI'];
            $kelurahan[] = ['id' => 1005,'kec' => "4",'kel'=>'1005', 'nama' => 'SUKUN'];
            $kelurahan[] = ['id' => 1006,'kec' => "4",'kel'=>'1006', 'nama' => 'TANJUNGREJO'];
            $kelurahan[] = ['id' => 1007,'kec' => "4",'kel'=>'1007', 'nama' => 'PISANG CANDI'];
            $kelurahan[] = ['id' => 1008,'kec' => "4",'kel'=>'1008', 'nama' => 'BANDULAN'];
            $kelurahan[] = ['id' => 1009,'kec' => "4",'kel'=>'1009', 'nama' => 'KARANG BESUKI'];
            $kelurahan[] = ['id' => 10010,'kec' => "4",'kel'=>'10010', 'nama' => 'MULYOREJO'];
            $kelurahan[] = ['id' => 10011,'kec' => "4",'kel'=>'10011', 'nama' => 'BAKALAN KRAJAN'];

        }

        if($kecamatan_id == 5){

            $kelurahan[] = ['id' => 1001,'kec' => "5",'kel'=>'1001', 'nama' => 'TUNGGULWULUNG'];
            $kelurahan[] = ['id' => 1002,'kec' => "5",'kel'=>'1002', 'nama' => 'MERJOSARI'];
            $kelurahan[] = ['id' => 1003,'kec' => "5",'kel'=>'1003', 'nama' => 'TLOGOMAS'];
            $kelurahan[] = ['id' => 1004,'kec' => "5",'kel'=>'1004', 'nama' => 'DINOYO'];
            $kelurahan[] = ['id' => 1005,'kec' => "5",'kel'=>'1005', 'nama' => 'SUMBERSARI'];
            $kelurahan[] = ['id' => 1006,'kec' => "5",'kel'=>'1006', 'nama' => 'KETAWANGGEDE'];
            $kelurahan[] = ['id' => 1007,'kec' => "5",'kel'=>'1007', 'nama' => 'JATIMULYO'];
            $kelurahan[] = ['id' => 1008,'kec' => "5",'kel'=>'1008', 'nama' => 'TUNJUNGSEKAR'];
            $kelurahan[] = ['id' => 1009,'kec' => "5",'kel'=>'1009', 'nama' => 'MOJOLANGU'];
            $kelurahan[] = ['id' => 10010,'kec' => "5",'kel'=>'10010', 'nama' => 'TULUSREJO'];
            $kelurahan[] = ['id' => 10011,'kec' => "5",'kel'=>'10011', 'nama' => 'LOWOKWARU'];
            $kelurahan[] = ['id' => 10012,'kec' => "5",'kel'=>'10012', 'nama' => 'TASIKMADU'];

        }

        if($kecamatan_id == 6){

            $kelurahan[] = ['id' => 0000,'kec' => "6",'kel'=>'0000', 'nama' => 'LUAR DAERAH'];

        }

        return response()->json         (['success'=> true,'data'=>$kelurahan]);
    }

}