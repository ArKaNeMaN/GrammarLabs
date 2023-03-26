<?php

namespace App\Exceptions\Tasks\Answers;

use Exception;
use JetBrains\PhpStorm\Pure;

class AnswerNotSent extends Exception
{
    #[Pure]
    public function __construct()
    {
        parent::__construct('Это задание ещё не отправлено на проверку');
    }
}
