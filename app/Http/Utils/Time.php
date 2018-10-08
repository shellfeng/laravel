<?php
namespace App\Http\Utils;

/**
 * Class Time
 * @package App\Http\Utils\Integral
 */
class Time
{
    /**
     * @var int
     */
    protected static $time;


    /**
     * @return int
     */
    public static function current()
    {
        if (is_null(self::$time)) {
            self::$time = time();
        }
        return self::$time;
    }
}