<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Preprocessing extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'dataset_id',
        'cleaned_sentence',
        'tokenized_sentence',
        'stopword_sentence',
        'stemmed_sentence',
    ];

    public function dataset()
    {
        return $this->belongsTo(Dataset::class, 'dataset_id');
    }
}
