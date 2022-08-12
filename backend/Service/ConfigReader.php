<?php
namespace Emercado\Service;

class ConfigReader {
    /**
     * @param string $sName nome do parametro para ler
     * @return string|array|float|int|null valor do
     */
    public static function getConfig($sName)
    {
        $aConfig = self::all();
        return array_key_exists($sName, $aConfig) ? $aConfig[$sName] : null;
    }
    /**
     * Ler todas as configuracoes da aplicação.
     * @return array
     */
    public static function all()
    {
        $aConfig = include dirname(__FILE__, 3)
            .DIRECTORY_SEPARATOR.'config'
            .DIRECTORY_SEPARATOR.'app'.(Env::isDevelopment() ?: '-local').'php';
        return $aConfig;
    }
}
