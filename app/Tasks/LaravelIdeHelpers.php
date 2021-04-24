<?php


namespace App\Tasks;


class LaravelIdeHelpers extends Task
{
    protected string $prompt = "Install Laravel IDE Helpers?";
    protected string $description = "Install Laravel IDE Helpers";

    public function handle(): void
    {
        $this->runCommand("composer require --dev barryvdh/laravel-ide-helper", $this->wd());
        $path = $this->wd() . '/composer.json';
        $composer = json_decode(file_get_contents($path), true);
        $composer['scripts']['ide'] = [
            "@php artisan ide-helper:generate -n",
            "@php artisan ide-helper:models -n",
            "@php artisan ide-helper:meta -n"
        ];
        file_put_contents($path, json_encode($composer, JSON_PRETTY_PRINT));
        $this->runCommand("composer run-script ide", $this->wd());
    }
}