<?php


namespace App\Tasks;


class InstallNpmDependencies extends Task
{
    protected string $prompt = "Install npm dependencies?";
    protected string $description = "Install npm dependencies";

    public function handle(): void
    {
        $this->runCommand("npm install", $this->wd());
    }
}