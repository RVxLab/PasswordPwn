<?php

declare(strict_types=1);

namespace App\Commands;

use LaravelZero\Framework\Commands\Command;

class PasswordPwnCommand extends Command
{
    protected $signature = 'pwned {password*}';

    protected $description = 'Check if a password has been pwned';

    public function handle(): void
    {
        $password = join(' ', $this->argument('password'));

        $this->info($password);
    }
}
