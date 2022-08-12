<?php
namespace Emercado\Service;

class Env {
    static $aEnv = ['development' => false];
    /**
     * Verificar ambiente da aplicação.
     * @return bool true caso modo desenvolvimento
     */
    public static function isDevelopment()
    {
        self::parseEnvFile();
        return self::$aEnv['development'];
    }

    private static function parseEnvFile()
    {
        foreach(
            file(dirname(__FILE__, 3).DIRECTORY_SEPARATOR.'.env', FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES)
            as $sLine
        ) {
            list($sVar, $sValue) = explode('=', $sLine);
            $sValue = trim($sValue, " '");
            if ($sVar == 'APP_ENV') {
                self::$aEnv['development'] = $sValue == 'development';
            }
        }
    }
}
