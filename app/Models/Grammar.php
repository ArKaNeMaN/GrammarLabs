<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grammar extends Model
{
    protected $table = 'grammars';

    protected $fillable = [
        'chars',
        'root_char',
        'non_terms',
        'terms',
    ];
}
