<?php

namespace Emercado\Model;

use Emercado\Service\ConnectionFactory;

class Base {
    protected $oConnection;
    protected $sTable;
    /**
     * @param string $sTable nome da tabela sem o esquema
     * @return $this
     * @throws RuntimeException
     */
    public function __construct($sTable)
    {
        $this->sTable = $sTable;
        $this->oConnection = ConnectionFactory::getConnection();
    }

    public function insert($aValues)
    {
        ;
    }

    public function update($aValues, $aWhere)
    {
        ;
    }

    public function delete($aWhere)
    {
        ;
    }
}
