<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dataset extends Model
{
    use HasFactory, SoftDeletes;

    // Tabel yang digunakan
    protected $table = 'datasets';

    // Field yang dapat diisi
    protected $fillable = [
        'name',
        'file_path',
        'status',
        'full_text',
        'label',
        'word_cloud_path',
        'freq_chart_path',
        'confussion_matrix_path',
        'normalized_text',
        'tfidf_path',
        'model_path_nb',
        'model_path_svm',
    ];

    protected $casts = [
        'full_text' => 'array',
        'label' => 'array',
        'normalized_text' => 'array',
    ];


    // Relasi One-to-Many dengan Preprocessing
    public function preprocessings()
    {
        return $this->hasMany(Preprocessing::class, 'dataset_id');
    }

    // Relasi One-to-One dengan TfidfWeights
    public function tfidfWeights()
    {
        return $this->hasOne(TfidfWeight::class, 'dataset_id');
    }

    // Relasi One-to-One dengan AnalysisResult
    public function analysisResult()
    {
        return $this->hasOne(AnalysisResult::class, 'dataset_id');
    }
}
