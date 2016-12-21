<?php

class Session
{


    /**
     * @param bool $remember
     */
    public static function init($remember = false)
    {
        if ($remember) {
            @session_start([
                'cookie_lifetime' => 31536000,
            ]);
        } else {
            @session_start();
        }
    }

    /**
     * @param $key
     * @param $value
     */
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * @param $key
     * @return mixed
     */
    public static function get($key)
    {
        if (isset($_SESSION[$key]))
            return $_SESSION[$key];
    }

    public static function destroy()
    {
        session_destroy();
    }

}