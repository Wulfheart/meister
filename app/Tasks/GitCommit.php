<?php


namespace App\Tasks;


class GitCommit extends Task
{
    protected string $prompt = "Create first git commit?";
    protected string $description = "Commit to git";
}