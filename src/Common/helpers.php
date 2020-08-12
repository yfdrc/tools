<?php
/**
 * Created by PhpStorm.
 * User: yfred
 * Date: 2017/3/2
 * Time: 8:51
 */


if (!function_exists('drc_selectAll')) {
    function drc_selectAll($tblname = 'departments', $fhvalue = 'name', $cxcol = '', $cxvalue = '', $cxysf = '=', $fhkey = 'id')
    {
        $fhz = [];
        if ($cxcol == '') {
            $temps = DB::table($tblname)->orderBy($fhkey, 'asc')->get([$fhkey, $fhvalue]);
        } else {
            $temps = DB::table($tblname)->orderBy($fhkey, 'asc')->where($cxcol, $cxysf, $cxvalue)->get([$fhkey, $fhvalue]);
        }
        foreach ($temps as $item) {
            $fhz = array_add($fhz, $item->$fhkey, $item->$fhvalue);
        }
        return $fhz;
    }
}
