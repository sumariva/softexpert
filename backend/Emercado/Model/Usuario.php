<?php
namespace Emercado\Model;

class Usuario extends Base {
    const ADMIN = 1;
    const CLIENT = 0;
    const GRANTED = 0;
    /**
     * {@inheritDoc}
     */
    public function __construct()
    {
        parent::__construct('usuario');
    }
}
