<?php

namespace App\Models;

use App\Traits\HasSlug;
use App\Traits\HasScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Model
{
    use HasFactory, HasSlug, HasScope;

    protected $fillable = [
       'name', 'email', 'email_verified_at', 'password', 'avatar', 'nik',
        'phone', 'photo', 'kec', 'kel', 'tugas', 'hit', 'status',
    ];

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn($image) => asset('storage/admins/' . $image),
        );
    }
}
