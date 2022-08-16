<?php
namespace Emercado\Service;

class SessionManager {
    static public function start()
    {
        @session_start();
    }

    static public function get($sName)
    {
        return $_SESSION[$sName];
    }

    static public function set($sName, $mValue)
    {
        $_SESSION[$sName] = $mValue;
        return $this;
    }
}
