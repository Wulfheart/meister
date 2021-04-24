<?php


namespace App\Tasks;


class InstallLaravelBlueprint extends Task
{
    protected string $prompt = "Install Laravel Blueprint?";
    protected string $description = "Install Laravel Blueprint";

    protected function handle(): void
    {
        $this->runCommand('composer require --dev laravel-shift/blueprint', $this->wd());
        $this->runCommand('php artisan vendor:publish --tag=blueprint-config', $this->wd());
        $path = $this->wd() . '/config/blueprint.php';
        $config = file_get_contents($path);
        $config = preg_replace("/(\?<='models_namespace' => ).*/", "'Models',", $config);
        $config = preg_replace("/(\?<='generate_fqcn_route' => ).*/", "true,", $config);
        file_put_contents($path, $config);

//        $this->runCommand('php artisan blueprint:new', $this->wd());
    }
}