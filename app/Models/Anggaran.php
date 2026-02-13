<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Anggaran extends Model
{
    protected $table = 'anggaran';
    protected $primaryKey = 'id_anggaran';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_anggaran',
        'anggaran',
        'tahun',
        'sum_total',
        'sisa_anggaran',
        'is_active',
    ];

    protected $casts = [
        'anggaran' => 'decimal:2',
        'sum_total' => 'decimal:2',
        'sisa_anggaran' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->id_anggaran)) {
                $model->id_anggaran = 'ANG-' . Str::uuid();
            }
            
            if (empty($model->sisa_anggaran)) {
                $model->sisa_anggaran = $model->anggaran;
            }
        });
    }

    public function pum()
    {
        return $this->hasMany(Pum::class, 'id_anggaran', 'id_anggaran');
    }

  // Update sum_total dan sisa_anggaran berdasarkan realisasi
    public function updateSisaAnggaran()
    {
        // Sum_total = total dari semua realisasi
        $this->sum_total = $this->pum()->sum('realisasi');
        
        // Sisa anggaran = anggaran - sum_total
        $this->sisa_anggaran = $this->anggaran - $this->sum_total;
        
        $this->save();
    }
}
