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
    //pz["index"]   0=>名称 1=>输入方式 2=>宽度
    //pz["create"]  0=>名称 1=>输入方式 2=>公式value
    //pz["edit"]    0=>名称 1=>输入方式 2=>公式value
    //pz["show"]    0=>名称 1=>输入方式
    //pz["bixu"]    0=>名称 1=>输入方式
    //pz["qita"]    0=>名称 1=>输入方式
    public static function getPzDepartment()
    {
        $pz = parent::getPzDepartment();

        $pz["layout"] = "layouts.app";
        $pz["section"] = "content";

        $pz["title"] = "部门";

        $pz["shortcutflag"] = true;
        $pz["shortcut"] = "shortcut01";

        $pz["index"] = ["getParentName()" => ["上级部门",InputCs::Text,"10%"],"name" => ["名称",InputCs::Text,"10%"],"description" => ["描述",InputCs::Text,"10%"], "telephone" => ["电话",InputCs::Text,"10%"], "email" => ["邮件",InputCs::Text,"10%"], "address" => ["地址",InputCs::Text,"10%"]];
        $pz["create"] = ["parent_id" => ["上级部门", InputCs::Select, "tasks"]];
        $pz["edit"] = ["parent_id" => ["上级部门", InputCs::Text, "\$task->getParentName()"]];

        $pz["show"] = ["getParentName()" => ["上级部门",InputCs::Text]];
        $pz["bixu"] = ["name" => "名称","description" => "描述", "telephone" => "电话", "email" => "邮件", "address" => "地址"];
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

        $pz["index"] = ["name" => ["名称",InputCs::Text,"20%"], "email" => ["邮件",InputCs::Text,"20%"]];
        $pz["create"] = [];
        $pz["edit"] = [];

        $pz["show"] = [];
        $pz["bixu"] = ["name" => "名称", "email" => "邮件", "password" => ["密码",InputCs::Password]];
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

        $pz["index"] = ["label" => ["角色名称",InputCs::Text,"20%"], "getPermissionsLabel()" => ["拥有权限",InputCs::Text,"20%"]];
        $pz["create"] = [];
        $pz["edit"] = ["label" => ["角色名称", InputCs::Text, "\$task->label"], "permission_id" => ["拥有权限",InputCs::Checkboxgroup,"permissions"]];

        $pz["show"] = ["label" => ["角色名称",InputCs::Text], "getPermissionsLabel()" => ["拥有权限",InputCs::Text]];
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

        $pz["index"] = ["name" => ["权限名称",InputCs::Text,"20%"], "label" => ["权限标签",InputCs::Text,"20%"], "description" => ["权限描述",InputCs::Text,"20%"]];
        $pz["create"] = [];
        $pz["edit"] = [];

        $pz["show"] = [];
        $pz["bixu"] = ["name" => ["权限名称",InputCs::Text], "label" => ["权限标签",InputCs::Text], "description" => ["权限描述",InputCs::Text]];
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

        $pz["index"] = ["name" => ["角色名称",InputCs::Text,"10%"], "label" => ["角色标签",InputCs::Text,"10%"], "right" => ["角色权重",InputCs::Text,"10%"],"description" => ["角色描述",InputCs::Text,"20%"]];
        $pz["create"] = [];
        $pz["edit"] = [];

        $pz["show"] = [];
        $pz["bixu"] = ["name" => ["角色名称",InputCs::Text], "label" => ["角色标签",InputCs::Text], "right" => ["角色权重",InputCs::Text]];
        $pz["qita"] = ["description" => ["角色描述",InputCs::Text]];
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

        $pz["index"] = ["name" => ["用户名称",InputCs::Text,"20%"], "getRolesLabel()" => ["拥有角色",InputCs::Text,"20%"]];
        $pz["create"] = [];
        $pz["edit"] = ["name" => ["用户名称",InputCs::Text,"\$task->name"], "role_id" => ["拥有角色",InputCs::Checkboxgroup,"roles"]];

        $pz["show"] = ["name" => ["用户名称",InputCs::Text], "getRolesLabel()" => ["拥有角色",InputCs::Text]];
        $pz["bixu"] = [];
        $pz["qita"] = [];
        return $pz;
    }

}
