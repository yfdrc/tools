<?php
/**
 * Created by PhpStorm.
 * User: yfred
 * Date: 2018/9/27
 * Time: 14:40
 */

declare(strict_types=1);

namespace Drc\AutoMaker\Configration;

abstract class abstractConfigBase
{
    public static function getPzDepartment()
    {
        $pz["pageflag"] = false;

        $pz["cxflag"] = false;
        $pz["cxholder"] = "部门名称";
        $pz["cxkeyname"] = "name";
        $pz["cxnrname"] = "bmcx";
        $pz["cxhsname"] = "bmhs";

        $pz["namespace"] = "User";
        $pz["classname"] = "Department";

        $pz["showcreate"] = true;
        $pz["showdelete"] = true;

        $pz["qxflag"] = true;
        $pz["qxindex"] = "index";
        $pz["qxcreate"] = "manage";
        $pz["qxshow"] = "show";
        $pz["qxedit"] = "manage";
        $pz["qxdelete"] = "admin";

        $pz["belongto"] = ["department"=>"部门"];

        return $pz;
    }

    public static function getPzRolePerm()
    {
        $pz["pageflag"] = false;

        $pz["cxflag"] = false;
        $pz["cxholder"] = "角色名称";
        $pz["cxkeyname"] = "name";
        $pz["cxnrname"] = "jsqxcx";
        $pz["cxhsname"] = "jsqxhs";

        $pz["namespace"] = "User";
        $pz["classname"] = "RolePerm";

        $pz["showcreate"] = false;
        $pz["showdelete"] = false;

        $pz["qxflag"] = true;
        $pz["qxindex"] = "index";
        $pz["qxcreate"] = "admin";
        $pz["qxshow"] = "show";
        $pz["qxedit"] = "admin";
        $pz["qxdelete"] = "admin";

        $pz["belongto"] = [];

        return $pz;
    }

    public static function getPzPermission()
    {
        $pz["pageflag"] = false;

        $pz["cxflag"] = false;
        $pz["cxholder"] = "权限名称";
        $pz["cxkeyname"] = "name";
        $pz["cxnrname"] = "qxcx";
        $pz["cxhsname"] = "qxhs";

        $pz["namespace"] = "User";
        $pz["classname"] = "Permission";

        $pz["showcreate"] = true;
        $pz["showdelete"] = true;

        $pz["qxflag"] = true;
        $pz["qxindex"] = "index";
        $pz["qxcreate"] = "admin";
        $pz["qxshow"] = "show";
        $pz["qxedit"] = "admin";
        $pz["qxdelete"] = "admin";

        $pz["belongto"] = [];

        return $pz;
    }

    public static function getPzRole()
    {
        $pz["pageflag"] = false;

        $pz["cxflag"] = false;
        $pz["cxholder"] = "角色名称";
        $pz["cxkeyname"] = "name";
        $pz["cxnrname"] = "jscx";
        $pz["cxhsname"] = "jshs";

        $pz["namespace"] = "User";
        $pz["classname"] = "Role";

        $pz["showcreate"] = true;
        $pz["showdelete"] = true;

        $pz["qxflag"] = true;
        $pz["qxindex"] = "index";
        $pz["qxcreate"] = "admin";
        $pz["qxshow"] = "show";
        $pz["qxedit"] = "admin";
        $pz["qxdelete"] = "admin";

        $pz["belongto"] = [];

        return $pz;
    }

    public static function getPzUserRole()
    {
        $pz["pageflag"] = false;

        $pz["cxflag"] = false;
        $pz["cxholder"] = "名称";
        $pz["cxkeyname"] = "name";
        $pz["cxnrname"] = "yhjscx";
        $pz["cxhsname"] = "yhjshs";

        $pz["namespace"] = "User";
        $pz["classname"] = "UserRole";


        $pz["showcreate"] = false;
        $pz["showdelete"] = false;

        $pz["qxflag"] = true;
        $pz["qxindex"] = "index";
        $pz["qxcreate"] = "department";
        $pz["qxshow"] = "show";
        $pz["qxedit"] = "department";
        $pz["qxdelete"] = "admin";

        $pz["belongto"] = [];

        return $pz;
    }

    public static function getPzUser()
    {
        $pz["pageflag"] = false;

        $pz["cxflag"] = false;
        $pz["cxholder"] = "用户名称";
        $pz["cxkeyname"] = "name";
        $pz["cxnrname"] = "yhcx";
        $pz["cxhsname"] = "yhhs";

        $pz["namespace"] = "User";
        $pz["classname"] = "User";

        $pz["showcreate"] = true;
        $pz["showdelete"] = true;

        $pz["qxflag"] = true;
        $pz["qxindex"] = "index";
        $pz["qxcreate"] = "department";
        $pz["qxshow"] = "show";
        $pz["qxedit"] = "department";
        $pz["qxdelete"] = "admin";

        $pz["belongto"] = ["department"=>"部门"];

        return $pz;
    }

}
