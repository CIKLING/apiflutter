<?php

namespace App\Models;

use App\Traits\HasSlug;
use App\Traits\HasScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Pendaftaran extends Model implements Auditable
{
    use HasFactory, HasSlug, HasScope,AuditableTrait;

    protected $fillable = ['user_id', 'persyaratan_id','layanan_id','operator_id','layanankategori_id',
    'tiket', 'pelapor_nik', 'pelapor_name','pelapor_email', 'pelapor_phone', 'kec', 'kel', 'statustracking_id', 'status_tracking', 'status_pesan', 'ket'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function persyaratan()
    {
        return $this->belongsTo(Persyaratan::class);
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    public function layanankategori()
    {
        return $this->belongsTo(Layanankategori::class);
    }


    public function operator()
    {
        return $this->belongsTo(Operator::class);
    }

    public function statustracking()
    {
        return $this->belongsTo(Statustracking::class);
    }

    public function status()
    {
        return $this->hasMany(Status::class);
    }




}
