<?php
/**
 * Created by PhpStorm.
 * User: yfred
 * Date: 2018/9/26
 * Time: 9:00
 */

declare(strict_types=1);

namespace Drc\AutoMaker\Configration;

class ConfigDB
{
    public static function getPzModel()
    {
        $pz["name"] = "Cangku";
        $pz["col"] = ["name"=>"name" ,"address"=>"address","gly"=>"text"];
        $pz["farr"] = ["name" ,"address","gly"];
        $pz["harr"] = [];
        $pz["cs"] = 5;

        return $pz;
    }

}
