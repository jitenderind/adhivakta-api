<?php
namespace App\helpers;

class Helper
{
    public static function subString($string,$startChr,$endChr=''){
        $string = ' ' . $string;
        $ini = strpos($string, $startChr);
        if ($ini == 0) return '';
        $ini += strlen($startChr);
        $len = strpos($string, $endChr, $ini) - $ini;
        return trim(substr($string, $ini, $len));
    }
    
    public static function searchForValue($id, $array) {
        foreach ($array as $key => $val) {
            if ($val['uid'] === $id) {
                return $array[$key];
            }
        }
        return null;
    }
}

?>