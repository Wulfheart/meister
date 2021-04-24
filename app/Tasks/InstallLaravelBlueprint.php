<?php


namespace App\Tasks;


class InstallLaravelBlueprint extends Task
{
    protected string $prompt = "Install Laravel Blueprint?";
    protected string $description = "Install Laravel Blueprint";

    protected function handle(): void
    {
        $this->runCommand('composer require --dev laravel-shift/blueprint');
    }
}