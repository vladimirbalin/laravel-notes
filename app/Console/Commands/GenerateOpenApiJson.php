<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class GenerateOpenApiJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'openapi:generate {dir=app : A directory to scan for OpenApi docs} {name=public/docs/api.json : A generated json file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate OpenApi json file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // ./vendor/bin/openapi -o api.json app/Http
        $command = './vendor/bin/openapi';

        $process = new Process([
            $command,
            '--output',
            $this->argument('name'),
            $this->argument('dir'),
        ]);
        $process->run();

        if (!$process->isSuccessful()) {
            $this->error($process->getErrorOutput());
        } else {
            $this->info('File generated at ./' . $this->argument('name'));
        }

        echo $process->getOutput();
    }
}
