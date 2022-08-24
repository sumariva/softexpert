<?php
namespace Emercado\Service;

use RuntimeException;

class SessionManager {
    static public function start()
    {
        $bStatus = @session_start();
        if (! $bStatus) {
            throw new RuntimeException('Falha ao registrar sessão.');
        }
    }
    /**
     * Read a session variable
     * @param string $sname a session variable
     */
    static public function get($sName)
    {
        return @$_SESSION[$sName];
    }
    /**
     * Store a session variable
     * @param string $sName the variable name
     * @param array|float|int|string|null the variable value
     */
    static public function set($sName, $mValue)
    {
        $_SESSION[$sName] = $mValue;
    }

    static public function clear()
    {
        $_SESSION = [];
    }
}
