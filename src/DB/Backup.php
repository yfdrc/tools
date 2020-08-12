<?php

namespace Drc\DB;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Backup
{
    public static function getTablesColumns()
    {
        $fhz = "";
        $tables = self::getTables();
        foreach ($tables as $table) {
            $fhz .= $table . ":" . self::getColumns($table) . ";";
        }
        return $fhz;
    }

    public static function getColumns($table)
    {
        $cols = Schema::getColumnListing($table);
        $fhz = implode(",", $cols);
        return $fhz;
    }

    public static function ReadAllfromJson()
    {
        $tables = self::getTables();
        foreach ($tables as $table) {
            self::ReadfromJson($table);
        }
    }

    public static function ReadfromJson($table, $publicpath = "\\Data\\")
    {
        $fn = public_path($publicpath) . $table . ".php";
        $flag = str_contains("," . self::getColumns($table) . ",",",id,");
        if (file_exists($fn)) {
            $nr = file_get_contents($fn);
            $rows = json_decode($nr);
            foreach ($rows as $key => $value) {
                $arrs = (array)($value);
                if($flag){
                    DB::table($table)->updateOrInsert(["id" => $arrs["id"]], $arrs);
                }else{
                    DB::table($table)->updateOrInsert($arrs, $arrs);
                }
            }
        }
    }

    public static function WriteAlltoJson()
    {
        $tables = self::getTables();
        foreach ($tables as $table) {
            self::writetoJson($table);
        }
    }

    public static function WritetoJson($table, $publicpath = "\\Data\\")
    {
        $nr = DB::table($table)->get()->toJson();
        $fn = public_path($publicpath) . $table . ".php";
        file_put_contents($fn, $nr);
    }

    public static function getTables($except = "cache,failed_jobs,jobs,migrations,notifications,sessions")
    {
        $tblstmp = DB::select('show tables');
        $tables = [];
        $tables2 = [];
        foreach ($tblstmp as $key => $value) {
            foreach ((collect($value)) as $k => $v) {
                if (!str_contains($except, $v)) {
                    if (str_contains($v, "_")) {
                        $tables2[] = $v;
                    } else {
                        $tables[] = $v;
                    }
                }
            }
        }
        foreach ($tables2 as $item) {
            $tables[] = $item;
        }
        return $tables;
    }

}
