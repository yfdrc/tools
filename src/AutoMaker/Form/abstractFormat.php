<?php
/**
 * Created by PhpStorm.
 * User: yfred
 * Date: 2018/3/14
 * Time: 9:01
 */

declare(strict_types=1);

namespace Drc\AutoMaker\Form;

abstract class abstractFormat extends abstractFormatBase
{
    public static function ToReadOnly($class): string
    {
        if($class==""){
            $class = "['readonly'=>'ReadOnly']";
        }else{
            $class = str_before($class, "]").", 'readonly'=>'ReadOnly']";
        }
        return $class;
    }

    public static function Format_selectVar($key, $values, $hasvalue=null, $class=[]): string
    {
        if($hasvalue==null) {
            return self::Format_select($key,"\$$values", "null", $class);
        }else{
            return self::Format_select($key,"\$$values", "\$$hasvalue", $class);
        }
    }

    public static function Format_checkboxVar($key, $value, $hasvalueflag=false, $class=[]): string
    {
        if($hasvalueflag) {
            return self::Format_checkbox($key,"\$$value", "\$task->has$value", $class);
        }else{
            return self::Format_checkbox($key,"\$$value", false, $class);
        }
    }

    public static function Format_radioVar($key, $value, $hasvalueflag=false, $class=[]): string
    {
        if($hasvalueflag) {
            return self::Format_radio($key,"\$$value", "\$task->has$value", $class);
        }else{
            return self::Format_radio($key,"\$$value", false, $class);
        }
    }

    public static function Format_checkboxgroupVar($key, $values, $hasvalueflag=false, $wz="", $class="[]"): string
    {
        $s1 = "    ";
        $s2 = $s1 . $s1;
        $s3 = $s2 . $s1;
        $s4 = $s2 . $s2;

        $fhz = "<table>\n";
        $fhz = $fhz . "$wz$s1@foreach (\$$values as \$key=>\$value)\n";
        $fhz = $fhz . "$wz$s1<tr>\n";
        $fhz = $fhz . "$wz$s2<td>\n$wz$s3{{ \$value }}\n$wz$s2</td>\n";
        $fhz = $fhz . "$wz$s2<td width=\"10px\"></td>\n$wz$s2<td>\n";
        if($hasvalueflag==false){
            $fhz = $fhz . "$wz$s3{{ Form::checkbox(\"$key"."[]\", \$key, null,$class) }}\n";
        }else{
            $fhz = $fhz . "$wz$s3@if(in_array(\$key, \$has$values))\n";
            $fhz = $fhz . "$wz$s4{{ Form::checkbox(\"$key"."[]\", \$key, 1,$class) }}\n";
            $fhz = $fhz . "$wz$s3@else\n";
            $fhz = $fhz . "$wz$s4{{ Form::checkbox(\"$key"."[]\", \$key, null,$class) }}\n";
            $fhz = $fhz . "$wz$s3@endif\n";
        }
        $fhz = $fhz . "$wz$s2</td>\n$wz$s1</tr>\n";
        $fhz = $fhz . "$wz$s1@endforeach\n";
        $fhz = $fhz . "$wz</table>";
        return $fhz;
    }

    public static function Format_radiogroupVar($key,$values,$hasvalueflag=false, $wz=0,$class="[]"): string
    {
        $s1 = "    ";
        $s2 = $s1 . $s1;
        $s3 = $s2 . $s1;
        $s4 = $s2 . $s2;

        $fhz = "$wz<table>\n";
        $fhz = $fhz . "$wz$s1@foreach (\$$values as \$key=>\$value)\n";
        $fhz = $fhz . "$wz$s1<tr>\n";
        $fhz = $fhz . "$wz$s2<td>\n$wz$s3{{ \$value }}\n$wz$s2</td>\n";
        $fhz = $fhz . "$wz$s2<td width=\"10px\"></td>\n$wz$s2<td>\n";
        if($hasvalueflag==false){
            $fhz = $fhz . "$wz$s3{{ Form::radio(\"$key"."[]\", \$key, null,$class) }}\n";
        }else{
            $fhz = $fhz . "$wz$s3@if(in_array(\$key, \$has$values))\n";
            $fhz = $fhz . "$wz$s4{{ Form::radio(\"$key"."[]\", \$key, 1,$class) }}\n";
            $fhz = $fhz . "$wz$s3@else\n";
            $fhz = $fhz . "$wz$s4{{ Form::radio(\"$key"."[]\", \$key, null,$class) }}\n";
            $fhz = $fhz . "$wz$s3@endif\n";
        }
        $fhz = $fhz . "$wz$s2</td>\n$wz$s1</tr>\n";
        $fhz = $fhz . "$wz@endforeach\n";
        $fhz = $fhz . "$wz</table>";
        return $fhz;
    }

}
