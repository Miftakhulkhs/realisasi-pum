<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pum extends Model
{
    protected $table = 'pum';
    protected $primaryKey = 'id_pum';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_pum',
        'nopum',
        'nama_kegiatan',
        'jenis',
        'total_pum_spp',
        'realisasi',
        'total_biaya',
        'tanggal_pum',
        'tanggal_lpj',
        'id_anggaran',
        'id_user',
    ];

    protected $casts = [
        'total_pum_spp' => 'decimal:2',
        'realisasi' => 'decimal:2',
        'total_biaya' => 'decimal:2',
        'tanggal_pum' => 'date',
        'tanggal_lpj' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->id_pum)) {
                $model->id_pum = 'PUM-' . Str::uuid();
            }
        });

        static::saved(function ($model) {
            $model->anggaran->updateSisaAnggaran();
        });

        static::deleted(function ($model) {
            $model->anggaran->updateSisaAnggaran();
        });
    }

    public function anggaran()
    {
        return $this->belongsTo(Anggaran::class, 'id_anggaran', 'id_anggaran');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
