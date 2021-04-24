<?php


namespace App\Tasks;


class GitCommit extends Task
{
    protected string $prompt = "Create first git commit?";
    protected string $description = "Commit to git";

    public function handle(): void
    {
        $this->runCommand('git init', $this->wd());
        $this->runCommand('git add -A', $this->wd());
        $this->runCommand('git commit -m "Initial commit"', $this->wd());
    }
}