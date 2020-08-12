<?php
/**
 * @author hernan ariel de luca
 * Date: 12/07/2017
 * Time: 16:13
 */

namespace Drc\DB\Exporter\Migrator;


use Drc\DB\Exporter\Action\AbstractAction;
use Drc\DB\Exporter\Exception\NonMethodDefinedException;

class SqlServerMigrator extends AbstractAction
{
    public function convert($database = null)
    {
        throw new NonMethodDefinedException('SqlServerMigrator->convert() is not implemented');
    }

    protected function compile()
    {
        throw new NonMethodDefinedException('SqlServerMigrator->compile() is not implemented');
    }

    public function write()
    {
        throw new NonMethodDefinedException('SqlServerMigrator->write() is not implemented');
    }
}