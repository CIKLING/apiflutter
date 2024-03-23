<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statustracking extends Model
{
    use HasFactory;

    //protected $table = "statustrackings";

    protected $fillable = [
        'code', 'sect', 'name', 'ket'
     ];
}
