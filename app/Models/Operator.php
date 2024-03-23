<?php

namespace App\Models;

use App\Traits\HasSlug;
use App\Traits\HasScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Operator extends Model
{
    use HasFactory, HasSlug, HasScope;

    protected $fillable = [
        'tugas_id', 'name', 'email', 'avatar', 'nik',
         'phone', 'photo', 'kec', 'kel', 'hit', 'status',
     ];

    public function tugas()
    {
        return $this->hasMany(Tugas::class);
    }

    public function pendaftarans()
    {
        return $this->hasOne(Pendaftaran::class);
    }



}
