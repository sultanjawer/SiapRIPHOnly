<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pks extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'pks';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'npwp',
        'no_ijin',
        'poktan_id',
        'no_perjanjian',
        'tgl_perjanjian_start',
        'tgl_perjanjian_end',
        'jumlah_anggota',
        'luas_rencana',
        'varietas_tanam',
        'periode_tanam',
        'provinsi_id',
        'kabupaten_id',
        'kecamatan_id',
        'kelurahan_id',
        'berkas_pks',
    ];

    public function lokasi()
    {
        return $this->hasMany(Lokasi::class, 'poktan_id', 'poktan_id');
    }

    public function masterpoktan()
    {
        return $this->belongsTo(MasterPoktan::class, 'poktan_id', 'poktan_id');
    }
}
