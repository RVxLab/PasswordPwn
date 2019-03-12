<?php

declare(strict_types=1);

namespace App\Commands;

use LaravelZero\Framework\Commands\Command;
use App\Pwned\HaveIBeenPwned;
use App\Pwned\PwnedException;

class PasswordPwnCommand extends Command
{
    private $haveIBeenPwned;

    public function __construct(HaveIBeenPwned $haveIBeenPwned)
    {
        parent::__construct();

        $this->haveIBeenPwned = $haveIBeenPwned;
    }

    protected $signature = 'pwned {password*}';

    protected $description = 'Check if a password has been pwned';

    public function handle(): void
    {
        $password = join(' ', $this->argument('password'));

        try {
            $hashCollection = $this->haveIBeenPwned->getHashes($password);

            $pwnCount = $hashCollection->getPwnCountForPassword($password);

            if ($pwnCount > 0) {
                $this->info("Oh no! Pwned! {$password} has been found {$pwnCount} times!");
            } else {
                $this->info("You can rest easy! {$password} hasn't been pwned. Stay vigilant!");
            }
        } catch (PwnedException $pe) {
            $this->error($pe->getMessage());
        }
    }
}
