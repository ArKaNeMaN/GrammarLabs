<?php

namespace App\Models;

use App\DTO\GrammarRule;
use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelData\DataCollection;

class Grammar extends Model
{
    protected $table = 'grammars';

    protected $fillable = [
        'name',
        'terms',
        'non_terms',
        'rules',
        'root_term',
    ];

    protected $casts = [
        'rules' => DataCollection::class.':'.GrammarRule::class,
    ];
}
