<?php
/**
 * @author hernan arie de luca
 * Date: 12/07/2017
 * Time: 16:37
 */

namespace Drc\DB\Exporter\Commands;


use Drc\DB\Exporter\Action\AbstractAction;

class SeedCommand extends AbstractCommand
{
    protected $signature = 'drc:dboutseed {database?} {--ignore=} {--select=}';

    protected $description = 'export your data from database to a seed class';

    public function handle()
    {
        $database = $this->argument('database');

        // Display some helpfull info
        if (empty($database)) {
            $this->comment("Preparing the migrations and seed for database: {$this->expManager->getDatabaseName()}");
        } else {
            $this->comment("Preparing the migrations and seed for database {$database}");
        }

        $ignore = $this->option('ignore');

        $selected = $this->option('select');

        if (empty($ignore) and empty($selected)) {
            $this->expManager->seed($database);
        } else {
            if(!empty($ignore) and empty($selected)) {
                $this->makeAction(compact('ignore'),"seed",$this->argument('database'));
            }
            else if(empty($ignore) and !empty($selected)) {
                $this->makeAction(compact('selected'),'seed',$this->argument('database'));
            }
            else {
                $this->error("it is not possible pass selected table and ignored table together");
            }
        }

        $filename = $this->getFilename();

        $this->info('Success!');
        $this->info("Database seed class generated in: {$filename}");
    }
}