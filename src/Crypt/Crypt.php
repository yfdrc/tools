<?php

namespace Drc\Crypt;

use Illuminate\Encryption\Encrypter;
use Exception;

class Crypt
{
    public static function getPassword($string)
    {
        if (is_null($string)){
            try {
                $string = session("pz");
            } catch (Exception $exception) {
            }
        }
        if (is_null($string)) $string = "ABCghi123!@#";
        while (strlen($string) < 32) $string .= $string;

        return substr($string, 0, 32);
    }

    public static function encrypt($nr ,$password=null)
    {
        $fhz = "";
        try {
            $obj = new Encrypter(self::getPassword($password), 'AES-256-CBC');
            $fhz = $obj->encrypt($nr);
        } catch (Exception $exception) {
            //dump($exception);
        }
        return $fhz;
    }

    public static function decrypt($nr ,$password=null)
    {
        $fhz = "";
        try {
            $obj = new Encrypter(self::getPassword($password), 'AES-256-CBC');
            $fhz = $obj->decrypt($nr);
        } catch (Exception $exception) {
            //dump($exception);
        }
        return $fhz;
    }

}
