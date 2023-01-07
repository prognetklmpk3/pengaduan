<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;
    protected $table='m_pegawai';
    protected $primaryKey= 'id';
    protected $guarded = [];
    public $timestamps = false;
    public $incrementing = false;

    public function respon()
    {
        return $this->hasMany(AduanRespon::class, 'pegawai_id');
    }
}
