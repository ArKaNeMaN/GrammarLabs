<?php

namespace App\Grammars\Exceptions;

use Exception;
use JetBrains\PhpStorm\Pure;

class UnsupportedGrammarTypeException extends Exception
{
    #[Pure]
    public function __construct()
    {
        parent::__construct('Unsupported grammar type.');
    }


}
