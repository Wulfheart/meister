<?php


namespace App\Tasks;


class InstallLaravelDebugbar extends Task
{
    protected string $prompt = "Install Laravel Debugbar?";
    protected string $description = "Install Laravel Debugbar";

    protected function handle(): void
    {
        $this->runCommand("composer require barryvdh/laravel-debugbar --dev ", $this->wd());
    }

}