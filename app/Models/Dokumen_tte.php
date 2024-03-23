<?php

namespace App\Models;

use App\Traits\HasSlug;
use App\Traits\HasScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dokumen_tte extends Model
{
    use HasFactory, HasSlug, HasScope;

    protected $fillable = [
       'token', 'judul', 'user_tte', 'no_surat','tgl_tte','dokumen','dokumen_tte'
    ];
}
