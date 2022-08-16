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
        return $this;
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
    /**
     * Send the variable
     * @param string|float|int|bool|null|array $mixed any variavle not begin an resource
     * @param $bExit (optional) default true it will stop processing
     */
    public function sendJson($mixed, $bExit = true)
    {
        $this->setHeader('Content-type', 'application/json')->send();
        print json_encode($mixed);
        if ($bExit) {
            exit();
        }
    }
}
