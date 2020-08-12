<?php
/**
 * @author hernan ariel de luca
 * Date: 12/07/2017
 * Time: 17:32
 */

namespace Drc\DB\Exporter\Commands;

use Illuminate\Console\Command;
use Drc\DB\Exporter\ExporterManager;

class AllActionCommand extends AbstractCommand
{
    protected $signature = 'drc:dboutall {database?} {--ignore=} {--select=}';

    protected $description = 'export all structure and data in a migration and seed class';

    public function handle()
    {
        $database = $this->argument('database');

        // Display some helpfull info
        if (empty($database)) {
            $this->comment("Preparing the migrations and seed for database: {$this->expManager->getDatabaseName()}");
        } else {
            $this->comment("Preparing the migrations and seed for database {$database}");
        }

        // Grab the options
        $ignore = $this->option('ignore');

        $selected = $this->option('select');

        if (empty($ignore) and empty($selected)) {
            $this->expManager->migrateAndSeed($database);
        } else {
            if(!empty($ignore) and empty($selected)) {
               $this->makeAction(compact('ignore'),'migrateAndSeed');
            } else if(empty($ignore) and !empty($selected)) {
               $this->makeAction(compact('selected'), 'migrateAndSeed');
            }
            else {
                $this->error("it is not possible pass selected table and ignored table together");
            }
        }

        $filename = $this->getFilename();
        $this->info('Success!');
        $this->info('Database migrations generated in: ' . $this->expManager->getMigrationsFilePath());
        $this->info("Database seed class generated in: {$filename}");

        //$this->excel();
    }

    public function excel()
    {
        $this->comment("Preparing the seeder class for database {$this->expManager->getDatabaseName()}");

        // Grab the options
        $ignore = $this->option('ignore');

        $selected = $this->option('select');

        $expManager = $this->expManager;

        if (empty($ignore) and empty($selected)) {
            $expManager->seed(null,'excel');
        } else {
            if(!empty($ignore) and empty($selected)) {
                $this->makeAction(compact('ignore'),'seed',null,'excel');
            } else if (empty($ignore) and !empty($selected)) {
                $this->makeAction(compact('selected'),'seed',null,'excel');
            }
            else {
                $this->error("it is not possible pass selected table and ignored table together");
            }
        }

        $filename = config('drc.exportConfig.excel.seed').'database.xlsx';

        $this->info('Success!');
        $this->info("File excel with data generated in: {$filename}");
    }

}