<?php
namespace Emercado\Controller;

use Emercado\Http\Cors;
use Emercado\Http\Request;
use Emercado\Http\Response;
use Emercado\Service\SessionManager;

class Base {
    /**
     * @var Response
     */
    private $oResponse;
    public function __construct($bRunMiddleware = true)
    {
        if ($bRunMiddleware) {
            $this->runMiddleware();
        }
    }

    protected function runMiddleware()
    {
        SessionManager::start();
        Cors::reply($this->getRequest(), $this->getResponse());
    }

    protected function getRequest()
    {
        return new Request();
    }

    protected function getResponse()
    {
        if (! $this->oResponse) {
            $this->oResponse = new Response();
        }
        return $this->oResponse;
    }
}
