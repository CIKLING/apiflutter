<?php

namespace App\Models;

use App\Traits\HasSlug;
use App\Traits\HasScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Persyaratan extends Model implements Auditable
{
    use HasFactory, HasSlug, HasScope,AuditableTrait;

    protected $fillable = [
        'fm1','fm2','fm3','fm4','fm5','fm6','fm7','fm8','fm9','fm10','fm11','fm12',
        'img1','img2','img3','img4','img5','img6','img7','img8','img9','img10','img11','img12',
    ];

    //protected function image(): Attribute
    //{
    //    return Attribute::make(
    //        get: fn($image) => asset('storage/persyaratans/' . $image),
    //    );
    //}

    protected function img11(): Attribute
    {
        return Attribute::make(
            get: fn($img1) => asset('storage/kelahirans/' . $img1),
        );
    }
    protected function img22(): Attribute
    {
        return Attribute::make(
            get: fn($img2) => asset('storage/persyaratans/' . $img2),
        );
    }
    protected function img33(): Attribute
    {
        return Attribute::make(
            get: fn($img3) => asset('storage/persyaratans/' . $img3),
        );
    }
    protected function img43(): Attribute
    {
        return Attribute::make(
            get: fn($img4) => asset('storage/persyaratans/' . $img4),
        );
    }
    protected function img53(): Attribute
    {
        return Attribute::make(
            get: fn($img5) => asset('storage/persyaratans/' . $img5),
        );
    }
    protected function img63(): Attribute
    {
        return Attribute::make(
            get: fn($img6) => asset('storage/persyaratans/' . $img6),
        );
    }
    protected function img73(): Attribute
    {
        return Attribute::make(
            get: fn($img7) => asset('storage/persyaratans/' . $img7),
        );
    }
    protected function img83(): Attribute
    {
        return Attribute::make(
            get: fn($img8) => asset('storage/persyaratans/' . $img8),
        );
    }

    public function pendaftarans()
    {
        return $this->hasOne(Pendaftaran::class);
    }

}
