<?php
/**
 * Created by PhpStorm.
 * User: yfred
 * Date: 2018/3/14
 * Time: 9:01
 */

declare(strict_types=1);

namespace Drc\AutoMaker\Configration;

use Drc\AutoMaker\Form\InputCs;

class ConfigForm extends abstractConfigBase
{
    public static function getPzDepartment()
    {
        $pz = parent::getPzDepartment();

        $pz["layout"] = "layouts.app";
        $pz["section"] = "content";

        $pz["title"] = "部门";

        $pz["shortcutflag"] = true;
        $pz["shortcut"] = "shortcut01";

        $pz["create"] = ["parent_id" => ["上级部门", InputCs::Select, "tasks"]];
        $pz["edit"] = ["parent_id" => ["上级部门", InputCs::Text, "\$task->getParentName()"]];

        $pz["index"] = ["getParentName()" => ["上级部门",InputCs::Text,"10%"]];
        $pz["show"] = ["getParentName()" => ["上级部门",InputCs::Text,"10%"]];
        $pz["bixu"] = ["name" => ["名称",InputCs::Text,"10%"],"description" => ["描述",InputCs::Text,"10%"], "telephone" => ["电话",InputCs::Text,"10%"], "email" => ["邮件",InputCs::Text,"10%"], "address" => ["地址",InputCs::Text,"10%"]];
        $pz["qita"] = [];
        return $pz;
    }

    public static function getPzUser()
    {
        $pz = parent::getPzUser();

        $pz["layout"] = "layouts.app";
        $pz["section"] = "content";

        $pz["title"] = "用户";

        $pz["shortcutflag"] = true;
        $pz["shortcut"] = "shortcut01";

        $pz["create"] = [];
        $pz["edit"] = [];

        $pz["index"] = [];
        $pz["show"] = [];
        $pz["bixu"] = ["name" => ["名称",InputCs::Text,"20%"], "email" => ["邮件",InputCs::Text,"20%"], "password" => ["密码",InputCs::Password,"20%"]];
        $pz["qita"] = [];
        return $pz;
    }

    public static function getPzRolePerm()
    {
        $pz = parent::getPzRolePerm();

        $pz["layout"] = "layouts.app";
        $pz["section"] = "content";

        $pz["title"] = "角色权限";

        $pz["shortcutflag"] = true;
        $pz["shortcut"] = "shortcut01";

        $pz["create"] = [];
        $pz["edit"] = ["role_id" => ["角色名称", InputCs::Text, "\$task->label"], "permission_id[]" => ["拥有权限",InputCs::Checkboxgroup,"permissions"]];

        $pz["index"] = ["label" => ["角色名称",InputCs::Text,""], "getPermissionsLabel()" => ["拥有权限",InputCs::Text,""]];
        $pz["show"] = ["label" => ["角色名称",InputCs::Text,""], "getPermissionsLabel()" => ["拥有权限",InputCs::Text,""]];
        $pz["bixu"] = [];
        $pz["qita"] = [];
        return $pz;
    }

    public static function getPzPermission()
    {
        $pz = parent::getPzPermission();

        $pz["layout"] = "layouts.app";
        $pz["section"] = "content";

        $pz["title"] = "权限";

        $pz["shortcutflag"] = true;
        $pz["shortcut"] = "shortcut01";

        $pz["create"] = [];
        $pz["edit"] = [];

        $pz["index"] = [];
        $pz["show"] = [];
        $pz["bixu"] = ["name" => ["权限名称",InputCs::Text,""], "label" => "权限标签", "description" => ["权限描述",InputCs::Text,""]];
        $pz["qita"] = [];
        return $pz;
    }

    public static function getPzRole()
    {
        $pz = parent::getPzRole();

        $pz["layout"] = "layouts.app";
        $pz["section"] = "content";

        $pz["title"] = "角色";

        $pz["shortcutflag"] = true;
        $pz["shortcut"] = "shortcut01";

        $pz["create"] = [];
        $pz["edit"] = [];

        $pz["index"] = [];
        $pz["show"] = [];
        $pz["bixu"] = ["name" => ["角色名称",InputCs::Text,""], "label" => ["角色标签",InputCs::Text,""], "right" => ["角色权重",InputCs::Text,""]];
        $pz["qita"] = ["description" => ["角色描述",InputCs::Text,""]];
        return $pz;
    }

    public static function getPzUserRole()
    {
        $pz = parent::getPzUserRole();

        $pz["layout"] = "layouts.app";
        $pz["section"] = "content";

        $pz["title"] = "用户角色";

        $pz["shortcutflag"] = true;
        $pz["shortcut"] = "shortcut01";

        $pz["create"] = [];
        $pz["edit"] = ["user_id" => ["用户名称",InputCs::Text,"\$task->name"], "role_id" => ["拥有角色",InputCs::Checkboxgroup,"roles"]];

        $pz["index"] = ["name" => ["用户名称",InputCs::Text,""], "getRolesLabel()" => ["拥有角色",InputCs::Text,""]];
        $pz["show"] = ["name" => ["用户名称",InputCs::Text,""], "getRolesLabel()" => ["拥有角色",InputCs::Text,""]];
        $pz["bixu"] = [];
        $pz["qita"] = [];
        return $pz;
    }

}
