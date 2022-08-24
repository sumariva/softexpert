<?php
namespace Emercado\Model;

class Produto extends Base {
    const ESTA_DISPONIVEL = 1;
    /**
     * {@inheritDoc}
     */
    public function __construct()
    {
        parent::__construct('produto');
    }
}
