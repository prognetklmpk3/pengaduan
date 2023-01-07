<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengadu extends Model
{
    use HasFactory;
    protected $table='m_help_pengadu';
    protected $primaryKey= 'id';
    protected $keyType = 'string';
    protected $guarded = [];
    public $timestamps = false;
    public $incrementing = false;

    public function aduan()
    {
        return $this->hasMany(Aduan::class, 'pengadu_id');
    }

    public function respon()
    {
        return $this->hasMany(AduanRespon::class, 'pengadu_id');
    }
}
