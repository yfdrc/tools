<?php

namespace Drc\DB\Import\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class DBInmigrationcommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'drc:dbinmigration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'import your table structur from database to a migration';

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
        echo "Now import migrate database ...\n";
        Schema::disableForeignKeyConstraints();
        $this->call('migrate');
        Schema::enableForeignKeyConstraints();
        echo "import migrate database finish ...\n";
    }
}
