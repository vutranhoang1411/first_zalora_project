<?php
namespace MyApp\Util;

//class with static method for utility
class Util{
    public static $charArray="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    public static $numArray="0123456789";
    public static function randomName(int $len):string{
        $arrLen=strlen(Util::$charArray);
        $res="";
        for ($i=0;$i<$len;$i++){
            $res=$res.Util::$charArray[rand(0,$arrLen-1)];
        }
        return $res;
    }
    public static function randomPhoneNumber(int $len):string{
        $arrLen=strlen(Util::$numArray);
        $res="";
        for ($i=0;$i<$len;$i++){
            $res=$res.Util::$numArray[rand(0,$arrLen-1)];
        }
        return $res;
    }
    public static function randomEmail(int $len):string{
        return Util::randomName($len)."@gmail.com";
    }
    public static function randomNumber(int $min, int $max){
        return rand($min,$max);
    }
}