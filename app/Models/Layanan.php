<?php

namespace App\Models;

use App\Traits\HasSlug;
use App\Traits\HasScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Layanan extends Model
{
    use HasFactory, HasSlug, HasScope;

    protected $fillable = [
        'sect', 'name', 'slug', 'detail', 'image'
    ];

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn($image) => asset('storage/layanans/' . $image),
        );
    }

    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class);
    }

    //public function status()
    //{
    //    return $this->belongsTo(Status::class);
    //}

    public function status()
    {
        return $this->hasOne(Status::class);
    }
}
