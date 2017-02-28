<?php
/**
 * @company MTE Telecom, Ltd.
 * @author Aleksandr Yulin(alexander.ulin@mte-telecom.ru)
 */

namespace Application\Utils;

/**
 * Class UuidGenerator
 * @package MteBase\Utils
 * @author Aleksandr Yulin(alexander.ulin@mte-telecom.ru)
 */
class UuidGenerator
{
    public static $pattern = '/^[a-f\d]{8}(-[a-f\d]{4}){4}[a-f\d]{8}$/i';
    /**
     * A guid function that works in all php versions
     * @param bool $opt
     * @return string
     * @see http://php.net/manual/en/function.com-create-guid.php#52354
     */
    public static function generateUuid($opt = false)
    {
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $left_curly = $opt ? chr(123) : "";     //  "{"
        $right_curly = $opt ? chr(125) : "";    //  "}"
        $hyphen = chr(45);// "-"
        $uuid = $left_curly
            . substr( $charid, 0, 8 ) . $hyphen
            . substr( $charid, 8, 4 ) . $hyphen
            . substr( $charid, 12, 4 ) . $hyphen
            . substr( $charid, 16, 4 ) . $hyphen
            . substr( $charid, 20, 12 )
            . $right_curly;
        return $uuid;
    }

    /**
     * Validate uuid format
     * @param string $uuid
     * @param bool $opt
     * @return bool
     */
    public static function validateUuid($uuid, $opt = false)
    {
        $left_curly = $opt ? chr(123) : "";     //  "{"
        $right_curly = $opt ? chr(125) : "";    //  "}"
        return !empty($uuid) && is_string($uuid) && preg_match($left_curly . self::$pattern . $right_curly, $uuid);
    }
}