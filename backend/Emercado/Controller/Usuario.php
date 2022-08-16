<?php

namespace Emercado\Controller;

use Emercado\Model\Usuario as UsuarioModel;

class Usuario extends Base {
    /**
     * @action
     */
    public function salvar()
    {
        $oUsuario = new UsuarioModel();
        $this->getResponse()->sendJson($this->getRequest()->post());
    }
}
