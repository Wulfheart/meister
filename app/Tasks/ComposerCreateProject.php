<?php


namespace App\Tasks;


use App\Utility\ConfigWriter\Rewrite;
use TitasGailius\Terminal\Terminal;

class ComposerCreateProject extends Task
{
    protected string $description = "Initialize Laravel project";

    protected function handle(): void
    {
        $this->runCommand("composer create-project laravel/laravel {$this->ctx->argument('name')}", null);
    }
}