<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Services\LanguageService;

class ImportantParameter extends Model
{
    use HasFactory;

    protected $table = 'important_parameters';

    protected $fillable = [
        'key',
        'slug',
        'label_si',
        'label_ta',
        'label_en',
    ];



}
