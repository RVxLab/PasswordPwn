<?php

declare(strict_types=1);

namespace App\Pwned;

class FoundHashSuffix
{
    private $hashSuffix;
    private $count;

    public function __construct(string $hashSuffix, int $count)
    {
        $this->hashSuffix = $hashSuffix;
        $this->count = $count;
    }

    public function matches(string $prefix, string $hashedPassword): bool
    {
        return mb_strtolower("{$prefix}{$this->hashSuffix}") === mb_strtolower($hashedPassword);
    }

    public function getHashSuffix(): string
    {
        return $this->hashSuffix;
    }

    public function getCount(): int
    {
        return $this->count;
    }
}
