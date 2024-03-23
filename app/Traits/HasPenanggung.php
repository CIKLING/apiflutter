<?php

namespace App\Traits;

use App\Models\Operator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

trait HasPenanggung
{
    public function penanggungJawab($tugas)
    {
        $penanggung = DB::table('operators')
            ->where('tugas_id', '=', $tugas)
            ->where('status', '=', 'aktif')
            ->orderBy('hit', 'asc')
            ->first();

        Operator::where('id', $penanggung->id)
            ->update(['hit' => $penanggung->hit+1]);

        return $penanggung->id;
    }
}
