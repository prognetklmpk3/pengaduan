<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AduanRespon extends Model
{
    use HasFactory;
    protected $table='t_help_aduan_respon';
    protected $primaryKey= 'id';
    protected $keyType = 'string';
    protected $guarded = [];
    public $timestamps = false;
    public $incrementing = false;

    public function aduan()
    {
        return $this->belongsTo(Aduan::class, 'aduan_id');
    }

    public function pengadu()
    {
        return $this->belongsTo(Pengadu::class, 'pengadu_id');
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }
}
