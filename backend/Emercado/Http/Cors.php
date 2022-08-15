<?php
namespace Emercado\Http;

class Cors {
    const HEADER_ORIGIN = 'HTTP_ORIGIN';
    const HEADER_CORS_CLIENT_HEADER = 'HTTP_ACCESS_CONTROL_REQUEST_HEADERS';
    const CORS_ALLOW_HEADER = 'Access-Control-Allow-Headers';
    const CORS_ALLOW_ORIGIN = 'Access-Control-Allow-Origin';
    /**
     * @param Request $oRequest
     * @param Response $oResponse
     */
    public static function reply($oRequest, $oResponse)
    {
        if ($oRequest->isOption()) {
            if (
                !$oRequest->hasHeader(self::HEADER_CORS_CLIENT_HEADER)
                || !$oRequest->hasHeader(self::HEADER_ORIGIN)
            ) {
                return;
            }
            $oResponse->setHeader(self::CORS_ALLOW_ORIGIN, $oRequest->getHeader(self::HEADER_ORIGIN));
            $oResponse->setHeader(self::CORS_ALLOW_HEADER, $oRequest->getHeader(self::HEADER_CORS_CLIENT_HEADER));
            $oResponse->send();
            exit(0);
        }
        if ($oRequest->isGet() || $oRequest->isPost()) {
            if ($oRequest->hasHeader(self::HEADER_ORIGIN)) {
                $oResponse->setHeader(self::CORS_ALLOW_ORIGIN, $oRequest->getHeader(self::HEADER_ORIGIN));
                $oResponse->send();
            }
        }
    }
}
