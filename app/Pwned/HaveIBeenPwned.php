<?php

declare(strict_types=1);

namespace App\Pwned;

use LaravelZero\Framework\Commands\Command;

class HaveIBeenPwned
{
    public function getHashes(string $password): HashCollection
    {
        $prefix = substr(sha1($password), 0, 5);
        $hashCollection = new HashCollection($prefix);
        $hashCollection->setFoundHashes($this->getPwnedHashes($prefix));

        return $hashCollection;
    }

    private function getPwnedHashes($prefix): array
    {
        $url = "https://api.pwnedpasswords.com/range/{$prefix}";

        $result = file_get_contents($url);

        return explode("\n", $result);
    }
}
