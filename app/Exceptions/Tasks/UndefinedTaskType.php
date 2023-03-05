<?php

namespace App\Exceptions\Tasks;

use JetBrains\PhpStorm\Pure;

class UndefinedTaskType extends \Exception
{
    #[Pure]
    public function __construct(?string $type = null)
    {
        if ($type !== null) {
            parent::__construct("Undefined task type '$type'.");
        } else {
            parent::__construct('Undefined task type.');
        }
    }

}
