<?php
/**
 * @author hernan ariel de luca
 * Date: 12/07/2017
 * Time: 12:21
 */

namespace Drc;

use Drc\AutoMaker\MakeControl;
use Drc\AutoMaker\MakeDB;
use Drc\AutoMaker\MakeForm;
use Drc\Crypt\Crypt;
use Drc\DB\Backup;
use Drc\DB\Exporter\ExporterManager;
use Illuminate\Support\Facades\Artisan;

class ToolsManager
{
    protected $exp;

    public function __construct(ExporterManager $exp)
    {
        $this->exp = $exp;
    }

    public function cryptde($nr,$pw=null){
        return Crypt::decrypt($nr,$pw);
    }

    public function crypten($nr,$pw=null){
        return Crypt::encrypt($nr,$pw);
    }

    public function backupread(){
        Backup::ReadAllfromJson();
    }

    public function backupwrite(){
        Backup::WriteAlltoJson();
    }

    public function makecontrol(){
        MakeControl::CreateAll();
    }

    public function makeDB(){
        MakeDB::CreateAll();
    }

    public function makeform(){
        MakeForm::CreateAll();
    }

    public function exportmigrate(){
        $this->exp->migrate();
    }

    public function exportmigrateseed(){
        $this->exp->migrateAndSeed();
    }

    public function exportseed(){
        $this->exp->seed();
    }

    public function importseed(){
        Artisan::call('db:seed');
    }

    public function importmigrate(){
        Artisan::call('migrate');
    }

    public function dbinit(){
        Artisan::call('migrate:reset');
    }

}