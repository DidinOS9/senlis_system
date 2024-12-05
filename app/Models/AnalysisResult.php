<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnalysisResult extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'dataset_id',
        'method_nb',
        'method_svm',
        'confussion_matrix_nb',
        'confussion_matrix_svm',
    ];

    public function dataset()
    {
        return $this->belongsTo(Dataset::class, 'dataset_id');
    }
}
