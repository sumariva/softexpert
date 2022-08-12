<?php
namespace Emercado\Controller;

use Emercado\Service\SessionManager;

class Base {
    public function __construct($bRunMiddleware = true)
    {
        if ($bRunMiddleware) {
            $this->runMiddleware();
        }
    }

    protected function runMiddleware()
    {
        SessionManager::start();
    }
}
