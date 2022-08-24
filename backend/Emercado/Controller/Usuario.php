<?php

namespace Emercado\Controller;

use Emercado\Model\Usuario as UsuarioModel;
use Emercado\Service\SessionManager;
Use Exception;
use RuntimeException;

class Usuario extends Base {
    /**
     * Handler for route /usuario/salvar
     * POST [email, name, token]
     * @action
     */
    public function salvar()
    {
        try {
            $sEmail = trim($this->getRequest()->post('email'));
            $oUsuarioModel = new UsuarioModel();
            if ($oUsuarioModel->existsBy('email', $sEmail)) {
                throw new RuntimeException('Email já cadastrado.');
            }
            $oUsuarioModel->insert([
                'email' => $sEmail,
                'nome' => $this->getRequest()->post('name'),
                'senha' => $this->getRequest()->post('token'),
                'perfil' => UsuarioModel::CLIENT,
                'bloqueado' => UsuarioModel::GRANTED,
            ]);
            $this->getResponse()->sendJson('');
        } catch (Exception $e) {
            $this->getResponse()->sendJson($e->getMessage());
        }
    }
    /**
     * Handler for route /usuario/entrar
     * POST [email, token]
     * @action
     */
    public function entrar()
    {
        try {
            $oUsuarioModel = new UsuarioModel();
            $aUsuario = $oUsuarioModel->fetchRow([
                'email' => trim($this->getRequest()->post('email'))
            ]);
            if (! $aUsuario) {
                throw new RuntimeException('Email sem cadastro.');
            }
            if ($aUsuario['senha'] != $this->getRequest()->post('token')) {
                throw new RuntimeException('Senha incorreta.');
            }
            unset($aUsuario['id']);
            unset($aUsuario['senha']);
            SessionManager::set('usuario', $aUsuario);
            $this->getResponse()->sendJson($aUsuario);
        } catch (Exception $e) {
            $this->getResponse()->sendJson($e->getMessage());
        }
    }
    /**
     * Handler for route /usuario/sair
     * POST []
     * @action
     */
    public function sair()
    {
        SessionManager::clear();
    }
}
