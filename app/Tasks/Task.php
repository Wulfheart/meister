<?php


namespace App\Tasks;


use App\Commands\MakeCommand;
use Exception;
use LaravelZero\Framework\Commands\Command;
use TitasGailius\Terminal\Terminal;

class Task
{
    protected MakeCommand $ctx;
    protected bool $required = false;
    protected string $prompt = "";
    protected string $description = "";
    protected bool $execute = false;

    public function __construct(MakeCommand $ctx, bool $required)
    {
        $this->ctx = $ctx;
        $this->required = $required;
    }

    public function required(): bool {
        return $this->required;
    }

    public function prompt(): string {
        return $this->prompt;
    }

    public function register(): void {
        $this->execute = true;
    }

    public function execute(): bool{
        return $this->execute;
    }

    public function description(): string{
        return $this->description;
    }

    public function work(): bool {
        try {
            $this->handle();

        }catch (\Exception $e){
            $this->ctx->error($e);
            return false;
        }
        return true;
    }

    protected function handle(): void{
        throw new Exception("NotImplemented");
    }

    protected function wd(): string {
        return getcwd() . "/{$this->ctx->argument('name')}";
    }

    protected function runCommand(string $command ,?string $wd):void {
        $terminal = Terminal::builder();
        if($wd){
            $terminal = $terminal->in($wd);
        }
        $result = $terminal->run($command);
        var_dump($result->output());
        if(!$result->successful()){
            var_dump($result->lines());
            throw new Exception();
        }
    }

}