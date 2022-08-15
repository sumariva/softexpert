<?php
namespace Emercado\Http;

class Response {
    private $aHeaders = [];
    /**
     * @param string $sName
     * @param string $sValue
     */
    public function setHeader($sName, $sValue)
    {
        $this->aHeaders[$sName] = $sValue;
    }
    /**
     * Serialize the response
     */
    public function toString()
    {
        ;
    }

    public function send()
    {
        foreach ($this->aHeaders as $sName => $sValue) {
            header($sName.': '.$sValue);
        };
    }
}
