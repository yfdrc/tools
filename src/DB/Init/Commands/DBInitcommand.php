<?php

namespace Drc\DB\Init\Commands;

use Illuminate\Console\Command;

class DBInitcommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'drc:dbinit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'init database';

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
     * @return mixed
     */
    public function handle()
    {
        echo "Now init database ...\n";
        $this->call('migrate:reset');
        echo "init database finish ...\n";
    }
}
