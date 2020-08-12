<?php
/**
 * @author hernan ariel de luca
 * Date: 12/07/2017
 * Time: 12:31
 */

namespace Drc\DB\Exporter;

use Drc\DB\Exporter\DriverExporter\MySqlExporterAbstract;
use Drc\DB\Exporter\DriverExporter\PostgresExporterAbstract;
use Drc\DB\Exporter\DriverExporter\SQLiteExporterAbstract;
use Drc\DB\Exporter\DriverExporter\SqlServerExporterAbstract;
use Illuminate\Container\Container;
use Closure;

class ExporterFactory{

    /**
     * @var \Illuminate\Contracts\Container\Container
     */
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }


    /**
     * @param $driver
     * @param Closure $callback
     * @return MySqlExporterAbstract|PostgresExporterAbstract|SQLiteExporterAbstract|SqlServerExporterAbstract
     */
    public function make($driver,Closure $callback = null)
    {
        $exporter = null;
        switch ($driver)
        {
            case 'mysql':
                 $exporter = new MySqlExporterAbstract($this->container['exp.mysql.migrator'],$this->container['exp.mysql.seeder']);
                 break;
            case 'pgsql':
                $exporter =  new PostgresExporterAbstract($this->container['exp.pgsql.migrator'],$this->container['exp.pgsql.seeder']);
                break;
            case 'sqlite':
                $exporter =  new SQLiteExporterAbstract($this->container['exp.sqlite.migrator'],$this->container['exp.sqlite.seeder']);
                break;
            case 'sqlsrv':
                $exporter = new SqlServerExporterAbstract($this->container['exp.sqlsrv.migrator'],$this->container['exp.sqlsrv.seeder']);
                break;
        }

        if($callback != null)
            $exporter = $callback($exporter);

        return $exporter;
    }

}