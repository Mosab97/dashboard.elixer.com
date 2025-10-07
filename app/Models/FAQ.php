<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class FAQ extends Model
{
    use HasFactory, HasTranslations, SoftDeletes;

    protected $table = 'faqs';
    protected $fillable = ['question', 'answer', 'active', 'order'];

    protected $translatable = ['question', 'answer'];

    protected $casts = [
        'question' => 'array',
        'answer' => 'array',
        'active' => 'boolean',
        'order' => 'integer',
    ];
}
