<?php

namespace App\Models;

use App\Traits\HasSlug;
use App\Traits\HasScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ref extends Model
{
    use HasFactory, HasSlug, HasScope;

    protected $fillable = [
       'code', 'sect', 'name', 'ket'
    ];
}
