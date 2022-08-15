<?php
namespace Emercado\Http;

class Request
{
    /**
     * Read a get value or all values as an map.
     * @return array|string|null
     */
    public function get($sName = null, $sDefault = null)
    {
        if (! $sName) { return $_GET; }
        return array_key_exists($sName, $_GET) ? $_GET[$sName] : $sDefault;
    }
    /**
     * Read a post value or all values as an map.
     * @return array|string|null
     */
    public function post($sName = null, $sDefault = null)
    {
        if (! $sName) { return $_POST; }
        return array_key_exists($sName, $_POST) ? $_POST[$sName] : $sDefault;
    }

    public function isGet()
    {
        return strcasecmp($_SERVER['REQUEST_METHOD'], 'GET') == 0;
    }
    public function isOption()
    {
        return strcasecmp($_SERVER['REQUEST_METHOD'], 'OPTIONS') == 0;
    }
    public function isPost()
    {
        return strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') == 0;
    }
    /**
     * .
     * @param string the header name
     */
    public function hasHeader($sName)
    {
        return array_key_exists($sName, $_SERVER);
        // error_log(print_r($_SERVER, true), 3, PROJECT_ROOT.DIRECTORY_SEPARATOR.'app.log');
    }
    /**
     * Read the header value
     * @return string empty string if header not found or empty
     */
    public function getHeader($sName)
    {
        return $this->hasHeader($sName) ? $_SERVER[$sName] : '';
    }
}
