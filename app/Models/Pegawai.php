<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Authenticatable
{
    use HasFactory;
    protected $table='m_pegawai';
    protected $primaryKey= 'id';
    protected $guarded = [];
    public $timestamps = false;
    public $incrementing = false;

    public function getAuthPassword()
    {
        return bcrypt($this->sso_user_id);
    }

    public function respon()
    {
        return $this->hasMany(AduanRespon::class, 'pegawai_id');
    }
}
