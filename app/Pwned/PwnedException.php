<?php

declare(strict_types=1);

namespace App\Pwned;

class PwnedException extends \Exception
{
    public function __constructor(string $message)
    {
        parent::__construct($message);
    }
}
