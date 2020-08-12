<?php

namespace Drc\DB\Import\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class DBInseedcommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'drc:dbinseed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'import your data from database to a seed class';

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
        echo "Now import seed database(0/3) ...\n";
        echo "   Copy file DrcTableSeeder.php(1/3) ...\n";
        $filename1 = config('drc.exportConfig.seeds') . "DatabaseSeeder.php";
        $filename2 = base_path() . '/database/seeds/' . "DatabaseSeeder.php";
        if (File::exists($filename1)) {
            File::copy($filename1, $filename2);
            Schema::disableForeignKeyConstraints();
            echo "   dump-autoload(2/3) ...\n";

            $filename1 = base_path() . "composer.phar";
            $filename2 = base_path() . "../composer.phar";
            if (File::exists($filename1)) {
                $this->call('@php ' . $filename1 . ' dump-autoload');
            } else if (File::exists($filename2)) {
                $this->call('@php ' . $filename2 . ' dump-autoload');
            }
            echo "   Import DrcTableSeeder(3/3) ...\n";
            $this->call('db:seed');
            Schema::enableForeignKeyConstraints();
        }
        echo "import seed database finish ...\n";
    }
}
