<?php
class StringUtil
{

    public static function dateFormat($value, $offset = 0, $length = 16)
    {

        return str_replace('-', '/', substr($value, $offset, $length));

    }// end function dateFormat

    public static function encode($string)
    {

        return htmlspecialchars($string, ENT_QUOTES);

    }// end function encode

}// end class StringUtil