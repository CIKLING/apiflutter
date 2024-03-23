<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasTiket
{
    public function ambilTiket($jenis)
    {
         // nomor tiket
         $length = 6;
         $random = '';
         for($i = 0; $i < $length; $i++){
             $random .= rand(0,1) ? rand(0,9) : chr(rand(ord('A'), ord('Z')));
         }
         //$tiket = $jenis.'-'.Str::upper($random);
         $tiket = $jenis.'-'.$random;
         return $tiket;
    }
}
