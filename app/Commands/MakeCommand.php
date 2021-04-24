<?php

namespace App\Commands;

use App\Tasks\ComposerCreateProject;
use App\Tasks\GitCommit;
use App\Tasks\InstallLaravelBlueprint;
use App\Tasks\InstallLaravelDebugbar;
use App\Tasks\InstallNpmDependencies;
use App\Tasks\LaravelIdeHelpers;
use App\Tasks\LaravelJetstreamLivewire;
use App\Tasks\RunNpmDevelopment;
use App\Tasks\Task;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Collection;
use LaravelZero\Framework\Commands\Command;

class MakeCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'make {name} {--a|all}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected array $required = [
        ComposerCreateProject::class,
    ];

    protected array $optional = [
        LaravelIdeHelpers::class,
        InstallLaravelDebugbar::class,
        LaravelJetstreamLivewire::class,
        InstallLaravelBlueprint::class,
        InstallNpmDependencies::class,
        RunNpmDevelopment::class,
        GitCommit::class,
    ];

    protected Collection $queue;

    /**
     * Execute the console command.
     *
     *
     */
    public function handle()
    {
        $this->queue = new Collection();

        // Initialize all tasks
        /** @var Task $item */
        foreach ($this->required as $item) {
            $i = new $item($this, true);
            $i->register();
            $this->queue->push($i);
        }

        /** @var Task $item */
        foreach ($this->optional as $item) {
            $this->queue->push(new $item($this, false));
        }


        // Iterate the queue for asking
        /** @var Task $item */
        $this->queue->map(function (Task $item) {
            if($this->option('all')){
                $item->register();
            } else if (!$item->required() && $this->confirm($item->prompt())) {
                $item->register();
            }

        });


        $this->queue->each(function (Task $item) {
            if ($item->execute()) {
                return $this->task($item->description(), [$item, 'work']) || !$item->required();
            }
            return true;
        });

        $this->notify('meister', 'Laravel application bootstrapped.');



    }

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
