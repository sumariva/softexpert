<?php
namespace Emercado\Model;

class TipoProduto extends Base {
    /**
     * {@inheritDoc}
     */
    public function __construct()
    {
        parent::__construct('tipo_produto');
    }
    /**
     * Retornar o valor do imposto
     * @param int $iId identidade do tipo
     * @return float
     * @throws RuntimeException
     */
    public function getImposto($iId)
    {
        $aSelf = $this->fetchRow(['id' => $iId]);
        if (! $aSelf) {
            throw new RuntimeException('Tipo não localizado.');
        }
        return (float) $aSelf['imposto'] ;
    }
}
