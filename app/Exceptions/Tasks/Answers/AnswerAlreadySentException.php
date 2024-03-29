<?php

namespace App\Exceptions\Tasks\Answers;

use Exception;
use JetBrains\PhpStorm\Pure;

class AnswerAlreadySentException extends Exception
{
    #[Pure]
    public function __construct()
    {
        parent::__construct('Это задание уже было отправлено');
    }
}
