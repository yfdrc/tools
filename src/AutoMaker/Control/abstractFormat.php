<?php
/**
 * Created by PhpStorm.
 * User: yfred
 * Date: 2018/3/14
 * Time: 9:01
 */

declare(strict_types=1);

namespace Drc\AutoMaker\Control;

use Drc\AutoMaker\Common\abstractCommon;

abstract class abstractFormat extends abstractCommon
{
    public static function checkQx($qx, $flag = true, $space = "")
    {
        if ($flag) {
            return $space . "if (auth()->check() and auth()->user()->can(\"" . $qx . "\", new Role)) {\n";
        } else {
            return "";
        }
    }

    public static function checkQxend($flag = true, $space = "")
    {
        if ($flag) {
            return $space . "}\n";
        } else {
            return "";
        }
    }

    public static function reParent()
    {
        return "return redirect(\$this->urltoparent);\n";
    }

    public static function reParentErr($errStr)
    {
        return "return redirect(\$this->urltoparent)->withErrors([\".$errStr.\"]);\n";
    }

    public static function reView($viewname)
    {
        return "return view(\$this->urltoview . \".$viewname\");\n";
    }

    public static function reViewArr($viewname, $arr)
    {
        $strtem = "[";
        foreach ($arr as $key => $value) {
            $strtem = $strtem . "\"$key\" => \$$key ,";
        }
        $strtem = mb_strcut($strtem, 0, strlen($strtem) - 1) . "]";
        return "return view(\$this->urltoview . \".$viewname\", $strtem);\n";
    }

    public static function reViewArrmodel($viewname, $arr)
    {
        $strtem = "[\"task\" => \$model, ";
        foreach ($arr as $key => $value) {
            $strtem = $strtem . "\"$key\" => \$$key ,";
        }
        $strtem = mb_strcut($strtem, 0, strlen($strtem) - 1) . "]";
        return "return view(\$this->urltoview . \".$viewname\", $strtem);\n";
    }

    public static function reViewModel($viewname, $model, $task = "task")
    {
        return "return view(\$this->urltoview . \".$viewname\", [\"$task\" => \$$model]);\n";
    }

}
