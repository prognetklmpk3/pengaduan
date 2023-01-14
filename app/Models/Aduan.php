<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Aduan extends Model
{
    use HasFactory;
    protected $table='t_help_aduan';
    protected $primaryKey= 'id';
    protected $keyType = 'string';
    protected $guarded = [];
    public $timestamps = false;
    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            // date_default_timezone_set('Asia/Ujung_Pandang');
            $model->id = time();
            // $model->id = IdGenerator::generate(['table' => 't_help_aduan', 'length' => 6, 'prefix' =>time()]);
        });
    }

    public function respon()
    {
        return $this->hasMany(AduanRespon::class, 'aduan_id');
    }

    public function pengadu()
    {
        return $this->belongsTo(Pengadu::class, 'pengadu_id');
    }
}
