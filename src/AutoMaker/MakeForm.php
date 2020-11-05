<?php
/**
 * Created by PhpStorm.
 * User: yfred
 * Date: 2018/3/14
 * Time: 9:01
 */

declare(strict_types=1);

namespace Drc\AutoMaker;

use Drc\AutoMaker\Configration\ConfigForm;
use Drc\AutoMaker\Form\abstractFormat;
use Drc\AutoMaker\Form\InputCs;
use Illuminate\Support\Str;

class MakeForm extends abstractFormat
{
    const Version = "V1.0.0";

    public static function CreateAll()
    {
        self::Create(ConfigForm::getPzDepartment());
        self::Create(ConfigForm::getPzUser());
        self::Create(ConfigForm::getPzRole());
        self::Create(ConfigForm::getPzPermission());
        self::Create(ConfigForm::getPzRolePerm());
        self::Create(ConfigForm::getPzUserRole());
    }

    public static function Create($pz = null)
    {
        if (is_null($pz)) $pz = ConfigForm:: getPzDepartment();
        $pathclass = $pz["namespace"] . "\\" . $pz["classname"];
        static::CreateDir($pathclass, "resources\\views");

        self::initbl($pz);
        if ($pz["showcreate"]) static::WritetoFile($pathclass, "create.blade.php", static::getCreate($pz), "resources\\views");
        static::WritetoFile($pathclass, "edit.blade.php", static::getEdit($pz), "resources\\views");
        static::WritetoFile($pathclass, "index.blade.php", static::getIndex($pz), "resources\\views");
        static::WritetoFile($pathclass, "show.blade.php", static::getShow($pz), "resources\\views");

        return true;
    }

    public static function getCreate($pz = null)
    {
        if (!$pz["showcreate"]) return "";

        global $s1, $s2, $s3, $s4, $s5, $s6, $s7, $s8, $s9, $s10;
        global $ps, $pd, $pi, $pp, $ph, $pb, $pg, $c3, $cc, $d9, $d36, $dd,$pathclass,$ext,$fo,$fp,$fd,$fc;

        $shortcutcrea = "";

        if ($pz["shortcutflag"]) {
            if ($pz["showcreate"]) {
                $shortcutcrea = "$s3" . "快捷方式：@include(\"layouts." . $pz["shortcut"] . "\")\n";
            } else {
                $shortcutcrea = "";
            }
        }

        $tmcrea = "";
        if ($pz["showcreate"]) {
            if ($pz["create"] == []) {
                foreach ($pz["belongto"] as $key => $value) {
                    $tmcrea .= "$s7$pg$s8" . self::Format_label($key . "_id", $value, $c3) . "\n";
                    $tmcrea .= "$s8$d9$s9" . self::Format_selectVar($key . "_id", $key, null, $cc) . "\n$s8$dd$s7$dd";
                }
            } else {
                foreach ($pz["create"] as $key => $value) {
                    $tmcrea .= "$s7$pg$s8" . self::Format_label($key, $value[0], $c3) . "\n";
                    $tmcrea .= self::tranInputCreate("$key",$value[2],"$value[1]","$s8$d9$s9","\n$s8$dd$s7$dd","",$cc);
                }
            }
        }

        $nrbixu = "";
        foreach ($pz["bixu"] as $key => $value) {
            if (is_array($value)) {
                $nrbixu .= "$s7$pg$s8" . self::Format_label($key, $value[0], $c3) . "\n";
                $nrbixu .= self::tranInputCreate("$key","\$task->$key","$value[1]","$s8$d9$s9","\n$s8$dd$s7$dd","",$cc);
            } else {
                $nrbixu .= "$s7$pg$s8" . self::Format_label($key, $value, $c3) . "\n";
                $nrbixu .= "$s8$d9$s9" . self::Format_text($key, "null", $cc) . "\n$s8$dd$s7$dd";
            }
        }

        $nrqita = "";
        foreach ($pz["qita"] as $key => $value) {
            if (is_array($value)) {
                $nrqita .= "$s5$pg$s6" . self::Format_label($key, $value[0], $c3) . "\n";
                $nrqita .= self::tranInputCreate("$key","\$task->$key","$value[1]","$s8$d9$s9","\n$s8$dd$s7$dd","",$cc);
            } else {
                $nrqita .= "$s5$pg$s6" . self::Format_label($key, $value, $c3) . "\n";
                $nrqita .= "$s6$d9$s7" . self::Format_text($key, "null", $cc) . "\n$s6$dd$s5$dd";
            }
        }

        $nrbxts = "$s5$pp$s6$ph$s7" . "必填项目" . "\n$s6$dd$s6$pb";
        $nrbxend = "$s6$dd$s5$dd";

        $nrcreate = "$ext$s1$ps$s2$ph$shortcutcrea$s2$dd$s2$pb$s3$ps$s4$ph$s5" . "新建" . $pz["title"] . "\n$s4$dd$s4$pb$s5$fo\n";
        $nrcreate .= $nrbxts . $tmcrea . $nrbixu . $nrbxend . $nrqita . "$s5$pg$s6$d36\n$s7<button type=\"submit\" class=\"btn btn-success\">确定增加</button>\n$s6$dd$s5$dd$s5$fc\n$s4$dd$s3$dd$s2$dd$s1$dd\n@endsection\n";

        return $nrcreate;
    }

    public static function getEdit($pz = null)
    {
        global $s1, $s2, $s3, $s4, $s5, $s6, $s7, $s8, $s9, $s10;
        global $ps, $pd, $pi, $pp, $ph, $pb, $pg, $c3, $cc, $d9, $d36, $dd,$pathclass,$ext,$fo,$fp,$fd,$fc;

        $cancrea = "";
        $end_can = "";
        $shortcutedit = "";

        if ($pz["shortcutflag"]) {
            if ($pz["showcreate"]) {
                $shortcutedit = "$s3" . "快捷方式：@include(\"layouts." . $pz["shortcut"] . "\") || $cancrea{!! link_to(\"" . $pathclass . "/create\",\"增加" . $pz["title"] . "\") !!} | $end_can {!! link_to(\"" . $pathclass . "/\$task->id\",\"" . $pz["title"] . "" . "详情\") !!}\n";
            } else {
                $shortcutedit = "$s3" . "快捷方式： @include(\"layouts." . $pz["shortcut"] . "\") || {!! link_to(\"" . $pathclass . "/\$task->id\",\"" . $pz["title"] . "" . "详情\") !!}\n";
            }
        }

        $tmedit = "";
        if ($pz["edit"] == []) {
            foreach ($pz["belongto"] as $key => $value) {
                $tmedit .= "$s7$pg$s8" . self::Format_label($key . "_id", $value, $c3) . "\n";
                $tmedit .= "$s8$d9$s9" . self::Format_selectVar($key . "_id", $key, "task->$key" . "->id", $cc) . "\n$s8$dd$s7$dd";
            }
        } else {
            foreach ($pz["edit"] as $key => $value) {
                $tmedit .= "$s7$pg$s8" . self::Format_label($key, $value[0], $c3) . "\n";
                $tmedit .= self::tranInputEdit("$key",$value[2],true,"$value[1]","$s8$d9$s9","\n$s8$dd$s7$dd",$s9,$cc);
            }
        }

        $nrbixu = "";
        foreach ($pz["bixu"] as $key => $value) {
            if (is_array($value)) {
                $nrbixu .= "$s7$pg$s8" . self::Format_label($key, $value[0], $c3) . "\n";
                $nrbixu .= self::tranInputEdit("$key","\$task->$key",true,"$value[1]","$s8$d9$s9","\n$s8$dd$s7$dd","",$cc);
            } else {
                $nrbixu .= "$s7$pg$s8" . self::Format_label($key, $value, $c3) . "\n";
                $nrbixu .= "$s8$d9$s9" . self::Format_text($key, "null", $cc) . "\n$s8$dd$s7$dd";
            }
        }

        $nrqita = "";
        foreach ($pz["qita"] as $key => $value) {
            if (is_array($value)) {
                $nrqita .= "$s5$pg$s6" . self::Format_label($key, $value[0], $c3) . "\n";
                $nrqita .= self::tranInputEdit("$key","\$task->$key",true,"$value[1]","$s6$d9$s7","\n$s6$dd$s5$dd","",$cc);
            } else {
                $nrqita .= "$s5$pg$s6" . self::Format_label($key, $value, $c3) . "\n";
                $nrqita .= "$s6$d9$s7" . self::Format_text($key, "null", $cc) . "\n$s6$dd$s5$dd";
            }
        }

        $nrbxts = "$s5$pp$s6$ph$s7" . "必填项目" . "\n$s6$dd$s6$pb";
        $nrbxend = "$s6$dd$s5$dd";

        $nredit = "$ext$s1$ps$s2$ph$shortcutedit$s2$dd$s2$pb$s3$pp$s4$ph$s5" . "编辑" . $pz["title"] . "\n$s4$dd$s4$pb$s5$fp\n";
        $nredit .= $nrbxts . $tmedit . $nrbixu . $nrbxend . $nrqita . "$s5$pg$s6$d36\n$s7<button type=\"submit\" class=\"btn btn-warning\">确定修改</button>\n$s6$dd$s5$dd$s5$fc\n$s4$dd$s3$dd$s2$dd$s1$dd\n@endsection\n";

        return $nredit;
    }

    public static function getIndex($pz = null)
    {
        global $s1, $s2, $s3, $s4, $s5, $s6, $s7, $s8, $s9, $s10;
        global $ps, $pd, $pi, $pp, $ph, $pb, $pg, $c3, $cc, $d9, $d36, $dd,$pathclass,$ext,$fo,$fp,$fd,$fc;

        $chaxun = "";
        $cancrea = "";
        $canshow = "";
        $canedit = "";
        $candele = "";
        $end_can = "";
        $shortcutinde = "";
        $fpage = "";

        if ($pz["pageflag"] && $pz["cxflag"]) {
            $chaxun = "$s3<div>\n$s4<form method=\"put\" class=\"form-inline\"]>\n$s5$pg$s6" . "每页行数：<input type=\"text\" class=\"form-control\" name=\"xshs\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"" . $pz["cxhsname"] . "\") !!}\">\n$s5$dd$s5$pg$s6" . "查询：<input type=\"text\" class=\"form-control\" name=\"cxnr\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"" . $pz["cxnrname"] . "\") !!}\" placeholder=\"" . $pz["cxholder"] . "\">\n$s5$dd$s5<button type=\"submit\" class=\"btn btn-default\">确定</button>\n$s4</form>\n$s3$dd";
        } else {
            if ($pz["cxflag"]) {
                $chaxun = "$s3<div>\n$s4<form method=\"put\" class=\"form-inline\"]>\n$s5$pg$s6" . "查询：<input type=\"text\" class=\"form-control\" name=\"cxnr\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"" . $pz["cxnrname"] . "\") !!}\" placeholder=\"" . $pz["cxholder"] . "\">\n$s5$dd$s5<button type=\"submit\" class=\"btn btn-default\">确定</button>\n$s4</form>\n$s3$dd";
            }
            if ($pz["pageflag"]) {
                $chaxun = "$s3<div>\n$s4<form method=\"put\" class=\"form-inline\"]>\n$s5$pg$s6" . "每页行数：<input type=\"text\" class=\"form-control\" name=\"xshs\" value=\"{!! Illuminate\Support\Facades\Cache::get(\"" . $pz["cxhsname"] . "\") !!}\">\n$s5$dd$s5<button type=\"submit\" class=\"btn btn-default\">确定</button>\n$s4</form>\n$s3$dd";
            }
        }
        if ($pz["qxflag"]) {
            $canshow = "@can(\"" . $pz["qxshow"] . "\", new \App\Models\Role)";
            $cancrea = "@can(\"" . $pz["qxcreate"] . "\", new \App\Models\Role)";
            $canedit = "@can(\"" . $pz["qxedit"] . "\", new \App\Models\Role)";
            $candele = "@can(\"" . $pz["qxdelete"] . "\", new \App\Models\Role)\n";
            $end_can = "@endcan";
        }
        if ($pz["shortcutflag"]) {
            if ($pz["showcreate"]) {
                $shortcutinde = "$s3" . "快捷方式：@include(\"layouts." . $pz["shortcut"] . "\")$cancrea || {!! link_to(\"" . $pathclass . "/create\",\"增加" . $pz["title"] . "\") !!}$end_can \n";
            } else {
                $shortcutinde = "$s3" . "快捷方式：@include(\"layouts." . $pz["shortcut"] . "\")\n";
            }
        }
        if ($pz["pageflag"]) {
            $fpage = "$s6{!! \$tasks->links() !!}\n";
        }

        $nrindex = "$ext$s1$pd$s2$ph$shortcutinde$s2$dd$s2$pb$chaxun$s3@if (count(\$tasks) > 0)\n$s4$pi$s5$ph$s6" . $pz["title"] . "列表\n$s5$dd$s5$pb$s6<table class=\"table table-striped task-table\">\n$s7<thead>\n";
        if ($pz["index"] == []) {
            foreach ($pz["belongto"] as $key => $value) {
                $nrindex .= "$s8<th>" . $value . "</th>\n";
            }
        } else {
            foreach ($pz["index"] as $key => $value) {
                if (is_array($value)) {
                    $nrindex .= "$s8<th>" . $value[0] . "</th>\n";
                } else {
                    $nrindex .= "$s8<th>" . $value . "</th>\n";
                }
            }
        }
//        foreach ($pz["bixu"] as $key => $value) {
//            if (is_array($value)) {
//                if($value[1]!=InputCs::Password) $nrindex .= "$s8<th>" . $value[0] . "</th>\n";
//            } else {
//                $nrindex .= "$s8<th>" . $value . "</th>\n";
//            }
//        }
        $nrindex .= "$s8<th></th>\n$s7</thead>\n$s7<tbody>\n$s8@foreach (" . "\$tasks as \$task" . ")\n$s9<tr>\n";
        if ($pz["index"] == []) {
            foreach ($pz["belongto"] as $key => $value) {
                $nrindex .= "$s10<td class=\"table-text\">\n$s10$s1<div>{{ " ."\$task->" . $key . "->name }}</div>\n$s10</td>\n";
            }
        } else {
            foreach ($pz["index"] as $key => $value) {
                if (is_array($value)) {
                    $nrindex .= "$s10<td width=\"$value[2]\">\n$s10$s1<div>{{ " . self::tranInputIndex($value[1],"\$task->" . $key) . " }}</div>\n$s10</td>\n";
                } else {
                    $nrindex .= "$s10<td class=\"table-text\">\n$s10$s1<div>{{ " . "\$task->" . $key . " }}</div>\n$s10</td>\n";
                }
            }
        }
//        foreach ($pz["bixu"] as $key => $value) {
//            if (is_array($value)) {
//                if($value[1]!=InputCs::Password) $nrindex .= "$s10<td width=\"$value[2]\">\n$s10$s1<div>{{ " . self::tranInputIndex($value[1],"\$task->" . $key) . " }}</div>\n$s10</td>\n";
//            } else {
//                $nrindex .= "$s10<td class=\"table-text\">\n$s10$s1<div>{{ " . "\$task->" . $key . " }}</div>\n$s10</td>\n";
//            }
//        }
        if ($pz["showdelete"]) {
            $nrindex .= "$s10<td>\n$s10$s1$canshow{!! link_to(\"" . $pathclass . "/\$task->id\",\"详情\") !!}$end_can $canedit | {!! link_to(\"" . $pathclass . "/\$task->id/edit\",\"编辑\") !!}$end_can $candele | {!! link_to(\"" . $pathclass . "/\$task->id\",\"删除\") !!}$end_can\n$s10</td>\n";
        } else {
            $nrindex .= "$s10<td>\n$s10$s1$canshow{!! link_to(\"" . $pathclass . "/\$task->id\",\"详情\") !!}$end_can $canedit | {!! link_to(\"" . $pathclass . "/\$task->id/edit\",\"编辑\") !!}$end_can\n$s10</td>\n";
        }
        $nrindex .= "$s9</tr>\n$s8@endforeach\n$s7</tbody>\n$s6</table>\n$fpage$s5$dd$s4$dd$s3@endif\n$s2$dd$s1$dd\n@endsection\n";

        return $nrindex;
    }

    public static function getShow($pz = null)
    {
        global $s1, $s2, $s3, $s4, $s5, $s6, $s7, $s8, $s9, $s10;
        global $ps, $pd, $pi, $pp, $ph, $pb, $pg, $c3, $cc, $d9, $d36, $dd,$pathclass,$ext,$fo,$fp,$fd,$fc;

        $cancrea = "";
        $canedit = "";
        $candele2 = "";
        $end_can = "";
        $endcan2 = "";
        $shortcutshow = "";

        if ($pz["shortcutflag"]) {
            if ($pz["showcreate"]) {
                $shortcutshow = "$s3" . "快捷方式：@include(\"layouts." . $pz["shortcut"] . "\")$cancrea || {!! link_to(\"" . $pathclass . "/create\",\"增加" . $pz["title"] . "\") !!} | $end_can $canedit{!! link_to(\"" . $pathclass . "/\$task->id/edit\",\"编辑" . $pz["title"] . "\") !!}$end_can \n";
            } else {
                $shortcutshow = "$s3" . "快捷方式： @include(\"layouts." . $pz["shortcut"] . "\")$canedit || {!! link_to(\"" . $pathclass . "/\$task->id/edit\",\"编辑" . $pz["title"] . "\") !!}$end_can \n";
            }
        }

        $nrshow = "$ext$s1$ps$s2$ph$shortcutshow$s2$dd$s2$pb$s3$pp$s4$ph$s5" . $pz["title"] . "详情\n$s4$dd$s4$pb$s5$fd\n";
        if ($pz["show"] == []) {
            foreach ($pz["belongto"] as $key => $value) {
                $nrshow .= "$s6$pg$s7" . self::Format_label($key, $value, $c3) . "\n";
                $nrshow .= "$s7$d9$s8" . self::Format_text($key, "\$task->$key" . "->name", $cc) . "\n$s7$dd$s6$dd";
            }
        } else {
            foreach ($pz["show"] as $key => $value) {
                if (is_array($value)) {
                    $nrshow .= "$s6$pg$s7" . self::Format_label($key, $value[0], $c3) . "\n";
                    $nrshow .= self::tranInputShow("$key","\$task->$key","$value[1]","$s6$d9$s8","\n$s7$dd$s6$dd","",$cc);
                } else {
                    $nrshow .= "$s6$pg$s7" . self::Format_label($key, $value, $c3) . "\n";
                    $nrshow .= "$s7$d9$s8" . self::Format_text($key, "\$task->$key", $cc) . "\n$s7$dd$s6$dd";
                }
            }
        }
        foreach ($pz["bixu"] as $key => $value) {
            if (is_array($value)) {
                $nrshow .= "$s6$pg$s7" . self::Format_label($key, $value[0], $c3) . "\n";
                $nrshow .= self::tranInputShow("$key","\$task->$key","$value[1]","$s6$d9$s8","\n$s7$dd$s6$dd","",$cc);
            } else {
                $nrshow .= "$s6$pg$s7" . self::Format_label($key, $value, $c3) . "\n";
                $nrshow .= "$s7$d9$s8" . self::Format_text($key, "\$task->$key", $cc) . "\n$s7$dd$s6$dd";
            }
        }
        foreach ($pz["qita"] as $key => $value) {
            if (is_array($value)) {
                $nrshow .= "$s6$pg$s7" . self::Format_label($key, $value[0], $c3) . "\n";
                $nrshow .= self::tranInputShow("$key","\$task->$key","$value[1]","$s6$d9$s8","\n$s7$dd$s6$dd","",$cc);
            } else {
                $nrshow .= "$s6$pg$s7" . self::Format_label($key, $value, $c3) . "\n";
                $nrshow .= "$s7$d9$s8" . self::Format_text($key, "\$task->$key", $cc) . "\n$s7$dd$s6$dd";
            }
        }

        if ($pz["showdelete"]) {
            $nrshow .= "$candele2$s7<hr width=\"90%\">\n$s7$pg$s8$d36\n$s9<button type=\"submit\" class=\"btn btn-danger\">确定删除</button>\n$s8$dd$s7$dd$endcan2$s5$fc\n$s4$dd$s3$dd$s2$dd$s1$dd\n@endsection\n";
        } else {
            $nrshow .= "$s5$fc\n$s4$dd$s3$dd$s2$dd$s1$dd\n@endsection\n";
        }

        return $nrshow;
    }

    private static function tranInputCreate($key, $value, $inputcs, $pre, $end, $wz, $class)
    {
        $tm = "";
        switch ($inputcs) {
            case InputCs::Textarea:
                $tm .= $pre . self::Format_textarea($key, "null", $class) . $end;
                break;

            case InputCs::Password:
                $tm .= $pre . self::Format_text($key,"null" , $class) . $end;
                break;

            case InputCs::Date:
                $tm .= $pre . self::Format_date($key,date("Y-m-d"), $class) . $end;
                break;

            case InputCs::DateTime:
                $tm .= $pre . self::Format_datetime($key,date("Y-m-d H:i:s"), $class) . $end;
                break;

            case InputCs::Time:
                $tm .= $pre . self::Format_time($key, date("H:i:s"), $class) . $end;
                break;

            case InputCs::Text:
                $tm .= "$pre" . self::Format_text($key, "null", $class) . $end;
                break;

            case InputCs::Select:
                $tm .= $pre . self::Format_select($key, "\$$value", "null", $class) . $end;
                break;

            case InputCs::Checkbox:
                $tm .= $pre . self::Format_checkbox($key, "\$$value", "null", $class) . $end;
                break;

            case InputCs::Radio:
                $tm .= $pre . self::Format_radio($key, "\$$value", "null", $class) . $end;
                break;

            case InputCs::Checkboxgroup:
                $tm .= $pre . self::Format_checkboxgroup($key, "\$$value", "null", $wz) . $end;
                break;

            case InputCs::Radiogroup:
                $tm .= $pre . self::Format_radiogroup($key, "\$$value", "null", $wz) . $end;
                break;

            default:
                break;
        }

        return $tm;
    }

    private static function tranInputEdit($key, $value, $hasvalueflag, $inputcs, $pre, $end, $wz, $class)
    {
        $tm = "";
        switch ($inputcs) {
            case InputCs::Textarea:
                $tm .= $pre . self::Format_textarea($key,$value,$class) . $end;
                break;

            case InputCs::Password:
                $tm .= $pre . self::Format_text($key,"\"\"",$class) . $end;
                break;

            case InputCs::Date:
                $tm .= $pre . self::Format_date($key,self::toDate($value), $class) . $end;
                break;

            case InputCs::DateTime:
                $tm .= $pre . self::Format_datetime($key, self::toDatetime($value), $class) . $end;
                break;

            case InputCs::Time:
                $tm .= $pre . self::Format_time($key, self::toTime($value), $class) . $end;
                break;

            case InputCs::Text:
                $tm .= "$pre" . self::Format_text($key, $value, $class) . $end;
                break;

            case InputCs::Select:
                $tm .= $pre . self::Format_selectVar($key, $value, $key, $class) . $end;
                break;

            case InputCs::Checkbox:
                $tm .= $pre . self::Format_checkboxVar($key, $value, $hasvalueflag, $class) . $end;
                break;

            case InputCs::Radio:
                $tm .= $pre . self::Format_radioVar($key, $value, $hasvalueflag, $class) . $end;
                break;

            case InputCs::Checkboxgroup:
                $tm .= $pre . self::Format_checkboxgroupVar($key, $value, $hasvalueflag, $wz) . $end;
                break;

            case InputCs::Radiogroup:
                $tm .= $pre . self::Format_radiogroupVar($key, $value, $hasvalueflag, $wz) . $end;
                break;

            case InputCs::TextRead:
                $tm .= "$pre" . self::Format_text($key, $value, self::ToReadOnly($class)) . $end;
                break;

            default:
                break;
        }

        return $tm;
    }

    private static function tranInputIndex($inputcs, $value)
    {
        $tm = "";
        switch ($inputcs) {
            case InputCs::Password:
                $tm .= "";
                break;

            case InputCs::Date:
                $tm .= self::toDate($value);
                break;

            case InputCs::DateTime:
                $tm .= self::toDatetime($value);
                break;

            case InputCs::Time:
                $tm .= self::toTime($value);
                break;

            default:
                $tm .=  $value;
                break;
        }

        return $tm;
    }

    private static function tranInputShow($key, $value,$inputcs, $pre, $end, $wz, $class="[]")
    {
        $tm = "";
        switch ($inputcs) {
            case InputCs::Textarea:
                $tm .= $pre . self::Format_textarea($key, $value, self::ToReadOnly($class)) . $end;
                break;

            case InputCs::Password:
                $tm .= $pre . self::Format_password($key,"null", self::ToReadOnly($class)) . $end;
                break;

            case InputCs::Date:
                $tm .= $pre . self::Format_date($key, self::toDate($value), self::ToReadOnly($class)) . $end;
                break;

            case InputCs::DateTime:
                $tm .= $pre . self::Format_datetime($key, self::toDatetime($value), self::ToReadOnly($class)) . $end;
                break;

            case InputCs::Time:
                $tm .= $pre . self::Format_time($key, self::toTime($value), self::ToReadOnly($class)) . $end;
                break;

            case InputCs::Text:
                $tm .= "$pre" . self::Format_text($key, $value, self::ToReadOnly($class)) . $end;
                break;

            case InputCs::Select:
                $tm .= $pre . self::Format_text($key, $value, self::ToReadOnly($class)) . $end;
                break;

            case InputCs::Checkbox:
                $tm .= $pre . self::Format_checkboxVar($key, $value, true, self::ToReadOnly($class)) . $end;
                break;

            case InputCs::Radio:
                $tm .= $pre . self::Format_radioVar($key, $value, true, self::ToReadOnly($class)) . $end;
                break;

            case InputCs::Checkboxgroup:
                $tm .= $pre . self::Format_checkboxgroupVar($key, $value, true, $wz,self::ToReadOnly("[]")) . $end;
                break;

            case InputCs::Radiogroup:
                $tm .= $pre . self::Format_radiogroupVar($key, $value, true, $wz,self::ToReadOnly("[]")) . $end;
                break;

            default:
                break;
        }

        return $tm;
    }

    public static function initbl($pz)
    {
        global $s1, $s2, $s3, $s4, $s5, $s6, $s7, $s8, $s9, $s10;
        global $ps, $pd, $pi, $pp, $ph, $pb, $pg, $c3, $cc, $d9, $d36, $dd,$pathclass,$ext,$fo,$fp,$fd,$fc;
        $s1 = "    ";
        $s2 = $s1 . $s1;
        $s3 = $s1 . $s2;
        $s4 = $s1 . $s3;
        $s5 = $s1 . $s4;
        $s6 = $s1 . $s5;
        $s7 = $s1 . $s6;
        $s8 = $s1 . $s7;
        $s9 = $s1 . $s8;
        $s10 = $s1 . $s9;
        $ps = "<div class=\"panel panel-success\">\n";
        $pd = "<div class=\"panel panel-default\">\n";
        $pi = "<div class=\"panel panel-info\">\n";
        $pp = "<div class=\"panel panel-primary\">\n";
        $ph = "<div class=\"panel-heading\">\n";
        $pb = "<div class=\"panel-body\">\n";
        $pg = "<div class=\"form-group\">\n";
        $c3 = "[\"class\"=>\"col-sm-3 control-label\"]";
        $cc = "[\"class\"=>\"form-control\"]";
        $d9 = "<div class=\"col-sm-6\">\n";
        $d36 = "<div class=\"col-sm-offset-3 col-sm-6\">";
        $dd = "</div>\n";

        $pathclass = $pz["namespace"] . "\\" . $pz["classname"];
        $ext = "@extends(\"" . $pz["layout"] . "\")\n\n@section(\"" . $pz["section"] . "\")\n\n";
        $fo = "{!! Form::open([\"url\"=>\"" . $pathclass . "\",\"method\"=>\"POST\",\"class\"=>\"form-horizontal\"]) !!}";
        $fp = "{{ Form::model(\$task, [\"url\"=>\"" . $pathclass . "/\$task->id\", \"method\" => \"PUT\", \"class\" => \"form-horizontal\"]) }}";
        $fd = "{{ Form::model(\$task, [\"url\"=>\"" . $pathclass . "/\$task->id\", \"method\" => \"DELETE\", \"class\" => \"form-horizontal\"]) }}";
        $fc = "{!! Form::close() !!}";
    }

}
