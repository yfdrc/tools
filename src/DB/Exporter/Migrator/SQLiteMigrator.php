<?php
/**
 * @author hernan ariel de luca
 * Date: 12/07/2017
 * Time: 15:58
 */

namespace Drc\DB\Exporter\Migrator;


use Drc\DB\Exporter\Action\AbstractAction;
use Drc\DB\Exporter\Exception\NonMethodDefinedException;

class SQLiteMigrator extends AbstractAction

{
    public function convert($database = null)
    {
        throw new NonMethodDefinedException('SQLiteMigrator->convert() is not implemented');
    }

    protected function compile()
    {
        throw new NonMethodDefinedException('SQLiteMigrator->compile() is not implemented');
    }

    public function write()
    {
        throw new NonMethodDefinedException('SQLiteMigrator->write() is not implemented');
    }
}