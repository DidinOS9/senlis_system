<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Normalization extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'kata_tidak_baku',
        'kata_baku',
    ];

    protected $casts = [
        'kata_tidak_baku' => 'array',
        'kata_baku' => 'array',
    ];
}
