<?php


namespace App\Tasks;


class RunNpmDevelopment extends Task
{
    protected string $prompt = "Create mix assets?";
    protected string $description = "Create mix assets";

    public function handle(): void
    {
        $this->runCommand("npm run dev", $this->wd());
    }
}