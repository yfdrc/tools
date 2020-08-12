<?php
/**
 * Created by PhpStorm.
 * User: yfred
 * Date: 2018/9/26
 * Time: 9:00
 */

declare(strict_types=1);

namespace Drc\AutoMaker\Configration;

class ConfigControl extends abstractConfigBase
{
    public static function getPzDepartment()
    {
        $pz = parent::getPzDepartment();

        $pz["usearray"] = ["Illuminate\Support\Facades\Cache"];

        $pz["vaildcreate"] = "[\"name\" => \"required|unique:departments\"]";
        $pz["vaildedit"] = "[\"name\" => \"required\"]";

        $pz["selectcreate"] = ["tasks" => "auth()->user()->getSubDepartments();"];
        $pz["ignoreupdate"] = "";

        $pz["OverrideClassname"] = "";
        $pz["Overrideindex"] = ["tasks" => "Department::orderby(\"parent_id\")->get();"];
        $pz["Overrideedit"] = [];
        $pz["Overrideupdate"] = [];

        return $pz;
    }

    public static function getPzRolePerm()
    {
        $pz = parent::getPzRolePerm();

        $pz["usearray"] = ["Illuminate\Support\Facades\Cache"];

        $pz["vaildcreate"] = "";
        $pz["vaildedit"] = "";

        $pz["selectcreate"] = [];
        $pz["ignoreupdate"] = "";

        $pz["OverrideClassname"] = "Role";
        $pz["Overrideindex"] = ["roleid" => "auth()->user()->getRolesRight()", "tasks" => "Role::where(\"Right\", \"<=\", \$roleid)->get()"];
        $pz["Overrideedit"] = ["permissions" => "drc_selectAll(\"permissions\", \"label\")", "haspermissions" => "drc_selectAll(\"permission_role\", \"permission_id\", \"role_id\", \$id,\"=\",\"permission_id\")"];
        $pz["Overrideupdate"] = ["\$inputs = \$request->get(\"permission_id\");","\$model = Role::findOrFail(\$id);" ,"\$model->permissions()->detach();" ,"\$model->permissions()->attach(\$inputs);"];

        return $pz;
    }

    public static function getPzUserRole()
    {
        $pz = parent::getPzUserRole();

        $pz["usearray"] = ["App\Models\User", "Illuminate\Support\Facades\Cache"];

        $pz["vaildcreate"] = "";
        $pz["vaildedit"] = "";

        $pz["selectcreate"] = [];
        $pz["ignoreupdate"] = "";

        $pz["OverrideClassname"] = "User";
        $pz["Overrideindex"] = ["tasks" => "User::getUsersAll()"];
        $pz["Overrideedit"] = ["roles" => "drc_selectAll(\"roles\", \"label\",\"right\", auth()->user()->getRolesRight(),\"<=\")", "hasroles" => "drc_selectAll(\"role_user\", \"role_id\", \"user_id\", \$id,\"=\",\"role_id\")"];
        $pz["Overrideupdate"] = ["\$inputs = \$request->get(\"role_id\");","\$model = User::findOrFail(\$id);" ,"\$model->roles()->detach();" ,"\$model->roles()->attach(\$inputs);"];

        return $pz;
    }

    public static function getPzPermission()
    {
        $pz = parent::getPzPermission();

        $pz["usearray"] = ["Illuminate\Support\Facades\Cache"];

        $pz["vaildcreate"] = "[\"name\" => \"required|unique:permissions\",\"label\" => \"required|unique:permissions\"]";
        $pz["vaildedit"] = "[\"name\" => \"required\",\"label\" => \"required\"]";

        $pz["selectcreate"] = [];
        $pz["ignoreupdate"] = "";

        $pz["OverrideClassname"] = "";
        $pz["Overrideindex"] = [];
        $pz["Overrideedit"] = [];
        $pz["Overrideupdate"] = [];

        return $pz;
    }

    public static function getPzRole()
    {
        $pz = parent::getPzRole();

        $pz["usearray"] = ["Illuminate\Support\Facades\Cache"];

        $pz["vaildcreate"] = "[\"name\" => \"required|unique:roles\",\"label\" => \"required|unique:roles\"]";
        $pz["vaildedit"] = "[\"name\" => \"required\",\"label\" => \"required\"]";

        $pz["selectcreate"] = [];
        $pz["ignoreupdate"] = "";

        $pz["OverrideClassname"] = "";
        $pz["Overrideindex"] = [];
        $pz["Overrideedit"] = [];
        $pz["Overrideupdate"] = [];

        return $pz;
    }

    public static function getPzUser()
    {
        $pz = parent::getPzUser();

        $pz["usearray"] = ["Illuminate\Support\Facades\Cache"];

        $pz["vaildcreate"] = "[\"name\" => \"required|unique:users\",\"email\" => \"required|unique:users\",\"department_id\" => \"required\",\"password\" => \"required\"]";
        $pz["vaildedit"] = "[\"name\" => \"required\",\"email\" => \"required\"]";

        $pz["selectcreate"] = [];
        $pz["ignoreupdate"] = "password";

        $pz["OverrideClassname"] = "";
        $pz["Overrideindex"] = ["tasks" => "User::getUsersAll()"];
        $pz["Overrideedit"] = [];
        $pz["Overrideupdate"] = [];

        return $pz;
    }

}