<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TfidfWeight extends Model
{
    use HasFactory, SoftDeletes;

    // Tentukan nama tabel (opsional, jika namanya tidak jamak otomatis)
    protected $table = 'tfidf_weights';

    // Tentukan kolom yang bisa diisi
    protected $fillable = [
        'dataset_id',
        'dynamic_column',
        'batch_index'
    ];

    // Tentukan tipe data untuk kolom json
    protected $casts = [
        'dynamic_column' => 'json',
    ];

    // Relasi dengan tabel datasets
    public function dataset()
    {
        return $this->belongsTo(Dataset::class);
    }
}
