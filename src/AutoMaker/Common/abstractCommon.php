<?php
/**
 * Created by PhpStorm.
 * User: yfred
 * Date: 2018/9/27
 * Time: 14:40
 */

declare(strict_types=1);

namespace Drc\AutoMaker\Common;

abstract class abstractCommon
{
    protected static function CreateDir($path, $basePath = "app\\Http\\Controllers")
    {
        $pathtmp = base_path($basePath);
        $patharr = str_getcsv(str_replace("/", "\\", $path), "\\");
        foreach ($patharr as $item) {
            $pathtmp = self::tranPath($pathtmp) . $item;
            if (!file_exists($pathtmp)) {
                mkdir($pathtmp);
            }
        }
    }

    protected static function WritetoFile($fpath, $fname, $nr, $bpath="app\\Http\\Controllers")
    {
        $pathtmp = base_path($bpath);
        $pathtmp = self::tranPath($pathtmp);
        $pathtmp = $pathtmp . $fpath;
        $pathtmp = self::tranPath($pathtmp);

        $file = fopen($pathtmp . $fname, "w");
        fwrite($file, $nr);
        fclose($file);
    }

    protected static function tranPath($path)
    {
        if($path=="") return "";
        $path = str_replace("/","\\",$path);
        if(stripos($path,"\\",-1) != strlen($path)-1){
            $path = $path . "\\";
        }
        return $path;
    }

    protected static function ends_with($haystack, $needle)
    {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }

}
