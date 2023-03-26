<?php

namespace App\Exceptions\Tasks\Answers;

use Exception;
use JetBrains\PhpStorm\Pure;

class AnswerAlreadyChecked extends Exception
{
    #[Pure]
    public function __construct()
    {
        parent::__construct("Это задание уже принято или отклонено");
    }
}
