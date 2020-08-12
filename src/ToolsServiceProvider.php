<?php
/**
 * @author hernan ariel de luca
 * Date: 12/07/2017
 * Time: 12:12
 */

namespace Drc;

use Drc\DB\Exporter\ExporterFactory;
use Drc\DB\Exporter\ExporterManager;
use Drc\DB\Init\Commands\DBInitcommand;
use Drc\DB\Import\Commands\DBInmigrationcommand;
use Drc\DB\Import\Commands\DBInseedcommand;
use Drc\DB\Exporter\Commands\AllActionCommand;
use Drc\DB\Exporter\Commands\ExportExcelDataCommand;
use Drc\DB\Exporter\Commands\MigrationsCommand;
use Drc\DB\Exporter\Commands\SeedCommand;
use Drc\DB\Exporter\Migrator\MySqlMigrator;
use Drc\DB\Exporter\Migrator\PostgresMigrator;
use Drc\DB\Exporter\Migrator\SQLiteMigrator;
use Drc\DB\Exporter\Migrator\SqlServerMigrator;
use Drc\DB\Exporter\Seeder\MySqlSeeder;
use Drc\DB\Exporter\Seeder\PostgresSeeder;
use Drc\DB\Exporter\Seeder\SQLiteSeeder;
use Drc\DB\Exporter\Seeder\SqlServerSeeder;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;

class ToolsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $fs =new Filesystem();
        if(!$fs->exists(app_path('Http/Controllers/Install'))) $fs->makeDirectory(app_path('Http/Controllers/Install'));
        $pstr = __DIR__ . '/Common/stubs/';
        $this->publishes([
            $pstr . 'DB/factories' => database_path('factories'),
            $pstr . 'DB/migrations' => database_path('migrations'),
            $pstr . 'DB/Models' => app_path('Models'),
            $pstr . 'DB/seeds' => database_path('seeds'),
            $pstr . 'DB/config.php' => config_path('drc.php'),
            $pstr . 'AutoMaker/Models' => app_path('Models'),
            $pstr . 'AutoMaker/migrations' => database_path('migrations'),
            $pstr . 'AutoMaker/seeds' => database_path('seeds'),
            $pstr . 'AutoMaker/Controllers/Install' => app_path('Http/Controllers/Install')
        ]);

        $this->mergeConfigFrom($pstr . 'DB/config.php','drc');
        $this->loadRoutesFrom($pstr . 'AutoMaker/routes/web.php');
    }

    public function register()
    {
        $this->registerAction();
        $this->registerCommand();
    }

    private function registerAction()
    {
        // exporter
        $this->app->bind('exp.factory',function($app){
            return new ExporterFactory($app);
        });

        $this->app->singleton('exp',function($app){
            return new ExporterManager($app,$app['exp.factory']);
        });

        $this->app->singleton('tools',function($app){
            return new ToolsManager($app->exp);
        });

        // Migrator
        $this->app->bind('exp.mysql.migrator',function($app){
            return new MySqlMigrator($this->getDatabaseName());
        });

        $this->app->bind('exp.pgsql.migrator',function($app){
            return new PostgresMigrator($this->getDatabaseName());
        });

        $this->app->bind('exp.sqlite.migrator',function ($app){
            return new SQLiteMigrator($this->getDatabaseName());
        });

        $this->app->bind('exp.sqlsrv.migrator',function ($app){
            return new SqlServerMigrator($this->getDatabaseName());
        });

        // Seeder
        $this->app->bind('exp.mysql.seeder',function($app){
            return new MySqlSeeder($this->getDatabaseName());
        });

        $this->app->bind('exp.pgsql.seeder',function($app){
            return new PostgresSeeder($this->getDatabaseName());
        });

        $this->app->bind('exp.sqlite.seeder',function ($app){
            return new SQLiteSeeder($this->getDatabaseName());
        });

        $this->app->bind('exp.sqlsrv.seeder',function ($app){
            return new SqlServerSeeder($this->getDatabaseName());
        });

        // command
        $this->app->bind('drc::dbinit',function(){
            return new DBInitcommand();
        });
        $this->app->bind('drc::dbinmigration',function(){
            return new DBInmigrationcommand();
        });
        $this->app->bind('drc::dbinseed',function(){
            return new DBInseedcommand();
        });
        $this->app->bind('drc::dboutseed',function($app){
            return new SeedCommand($app['exp']);
        });
        $this->app->bind('drc::dboutmigration',function($app){
            return new MigrationsCommand($app['exp']);
        });
        $this->app->bind('drc::dboutall',function($app){
            return new AllActionCommand($app['exp']);
        });
        $this->app->bind('drc::dboutexcel',function($app){
            return new ExportExcelDataCommand($app['exp']);
        });

    }

    private function registerCommand()
    {
        $this->commands([
            'drc::dbinit',
            'drc::dbinmigration',
            'drc::dbinseed',
            'drc::dboutseed',
            'drc::dboutmigration',
            'drc::dboutall',
            'drc::dboutexcel'
        ]);
    }

    private function getDatabaseName()
    {
        $connType = config('database.default');
        $database = config('database.connections.' .$connType );

        return $database['database'];
    }
}
