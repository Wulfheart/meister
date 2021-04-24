<?php


namespace App\Tasks;


use TitasGailius\Terminal\Terminal;

class LaravelJetstreamLivewire extends Task
{
    protected string $prompt = "Install Laravel Jetstream Livewire?";
    protected string $description = "Installing Laravel Jetstream Livewire";

    protected function handle(): void
    {
        $this->runCommand("composer require laravel/jetstream", $this->wd());
        $this->runCommand("php artisan jetstream:install livewire", $this->wd());
    }
}