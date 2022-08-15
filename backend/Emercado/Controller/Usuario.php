<?php

namespace Emercado\Controller;


class Usuario extends Base {
    /**
     * @action
     */
    public function salvar()
    {
        print_r($this->getRequest()->get());
        print_r($this->getRequest()->post());
        print 'salvar ok';
    }
}
