<?php
/**
 * Created by PhpStorm.
 * User: yfred
 * Date: 2018/3/14
 * Time: 9:01
 */

declare(strict_types=1);

namespace Drc\AutoMaker\Form;

use Drc\AutoMaker\Common\abstractCommon;

abstract class abstractFormatBase extends abstractCommon
{
    //$key都是字符串内容，需要""括起来；$value和$checked是语句、$class是数组，不需要""括起来。
    public static function Format_checkbox($key, $value, $checked=false, $class="[]"): string
    {
        return "{{ Form::checkbox(\"$key\",$value, $checked, $class) }}";
    }

    //$key都是字符串内容，需要""括起来；$value和$checked是语句、$class是数组，不需要""括起来。
    public static function Format_radio($key, $value, $checked=false, $class="[]"): string
    {
        return "{{ Form::radio(\"$key\",$value, $checked, $class) }}";
    }

    //$key都是字符串内容，需要""括起来；$values和$hasvalue是语句、$class是数组，不需要""括起来。
    public static function Format_select($key, $values, $hasvalue="null", $class="[]"): string
    {
        return "{{ Form::select(\"$key\",$values, $hasvalue, $class) }}";
    }

    //$key和$value都是字符串内容，需要""括起来；$class是数组，不需要""括起来。
    public static function Format_label($key, $value="null", $class="[]"): string
    {
        return "{{ Form::label(\"$key\", \"$value\", $class) }}";
    }

    //$key都是字符串内容，需要""括起来；$value是语句、$class是数组，不需要""括起来。
    public static function Format_password($key, $value="null", $class="[]"): string
    {
        return "{{ Form::password(\"$key\", $value, $class) }}";
    }

    //$key都是字符串内容，需要""括起来；$value是语句、$class是数组，不需要""括起来。
    public static function Format_text($key, $value="null", $class="[]"): string
    {
        return "{{ Form::text(\"$key\", $value, $class) }}";
    }

    //$key都是字符串内容，需要""括起来；$value是语句、$class是数组，不需要""括起来。
    public static function Format_textarea($key, $value="null", $class="[]"): string
    {
        return "{{ Form::textarea(\"$key\", $value, $class) }}";
    }

    public static function Format_date($key, $value="null", $class="[]"): string
    {
        return "{{ Form::date(\"$key\", $value, $class) }}";
    }

    public static function Format_time($key, $value="null", $class="[]"): string
    {
        return "{{ Form::time(\"$key\", $value, $class) }}";
    }

    public static function Format_datetime($key, $value="null", $class="[]"): string
    {
        return "{{ Form::datetime(\"$key\", $value, $class) }}";
    }

    public static function toDate($value): string
    {
        return "date(\"Y-m-d\",strtotime($value))";
    }

    public static function toDatetime($value): string
    {
        return "date(\"Y-m-d h:i:sa\",strtotime($value))";
    }

    public static function toTime($value): string
    {
        return "date(\"h:i:sa\",strtotime($value))";
    }

    public static function Format_email($key, $value="null", $class="[]"): string
    {
        return "{{ Form::email(\"$key\", $value, $class) }}";
    }

}
