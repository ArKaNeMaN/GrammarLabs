<?php

namespace App\Grammars\Enums;

enum GrammarType: int
{
    case UNLIMITED = 0;
    case CONTEXT_SENSITIVE = 1;
    case CONTEXT_FREE = 2;
    case REGULAR = 3;
}
