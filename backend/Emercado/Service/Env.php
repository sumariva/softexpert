<?php
namespace Emercado\Service;

use RuntimeException;

class Env {
    /**
     * @var array map
     */
    static $aEnv = ['development' => false];

    static $sEnvDir = null;
    /**
     * Verificar ambiente da aplicação.
     * @return bool true caso modo desenvolvimento
     */
    public static function isDevelopment()
    {
        self::parseEnvFile();
        return self::$aEnv['development'];
    }
    /**
     * Define the dir to search for the .env file
     */
    public static function setEnvDir($sDir)
    {
        self::$sEnvDir = $sDir;
    }

    private static function parseEnvFile()
    {
        $sDir = self::$sEnvDir;
        if (! $sDir) {
            throw new RuntimeException('No env dir defined. Check application config.');
        }
        foreach(
            file($sDir.DIRECTORY_SEPARATOR.'.env', FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES)
            as $sLine
        ) {
            list($sVar, $sValue) = explode('=', $sLine);
            $sValue = trim($sValue, " '");
            if ($sVar == 'APP_ENV') {
                self::$aEnv['development'] = $sValue == 'development';
            }
        }
    }

    public static function all()
    {
        self::parseEnvFile();
        return self::$aEnv;
    }
}
