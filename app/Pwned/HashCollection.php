<?php

declare(strict_types=1);

namespace App\Pwned;

use Illuminate\Support\Collection;

class HashCollection
{
    private $hashPrefix;
    private $hashSuffixes;

    public function __construct(string $hashPrefix)
    {
        $this->hashPrefix = $hashPrefix;
        $this->hashSuffixes = new Collection();
    }

    public function setFoundHashes(array $hashes)
    {
        $foundHashSuffixes = array_map(function (string $foundHash) {
            list($suffix, $count) = explode(':', $foundHash);
            return new FoundHashSuffix($suffix, (int)$count);
        }, $hashes);

        $this->hashSuffixes = new Collection($foundHashSuffixes);
    }

    public function getPwnCountForPassword(string $password): int
    {
        $hashedPassword = sha1($password);
        $prefix = $this->hashPrefix;

        /**
         * @var FoundHashSuffix $foundHash
         */
        $foundHash = $this->hashSuffixes->first(function (FoundHashSuffix $suffix) use ($hashedPassword, $prefix) {
            return $suffix->matches($prefix, $hashedPassword);
        });

        if ($foundHash !== null) {
            return $foundHash->getCount();
        }

        return 0;
    }
}
