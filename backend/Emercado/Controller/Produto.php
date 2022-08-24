<?php

namespace Emercado\Controller;

use Emercado\Model\Item;
use Emercado\Model\Pedido;
use Emercado\Model\Produto as ProdutoModel;
use Emercado\Model\TipoProduto;
use Emercado\Service\SessionManager;
Use PDOException;
use RuntimeException;

/**
 * acoes gerais da aplicacao
 */
class Produto extends Base {
    /**
     * @action
     */
    public function tipos()
    {
        $oTiposModel = new TipoProduto();
        $this->getResponse()->sendJson($oTiposModel->all());
    }
    /**
     * @action
     */
    public function listar()
    {
        $oProdutoModel = new ProdutoModel();
        $this->getResponse()->sendJson($oProdutoModel->all());
    }
    /**
     * @action
     */
    public function adicionarTipo()
    {
        try {
            $sTipo = trim($this->getRequest()->post('tipo'));
            $oTipoProdutoModel = new TipoProduto();
            if ($oTipoProdutoModel->existsBy('tipo', $sTipo)) {
                throw new RuntimeException('Tipo já cadastrado.');
            }
            $oTipoProdutoModel->insert([
                'tipo' => $sTipo,
                'imposto' => $this->getRequest()->post('imposto'),
            ]);
            $this->getResponse()->sendJson('');
        } catch (RuntimeException $e) {
            switch ($e->getCode()) {
                case '23514':
                    $this->getResponse()->sendJson('Valor do imposto fora do intervalo, deve ficar entre 0 e 100%.');
                    break;
            }
            $this->getResponse()->sendJson($e->getMessage());
        }
    }
    /**
     * @action
     */
    public function apagarTipo()
    {
        try {
            $iId = (int) $this->getRequest()->post('id', 0);
            $oTipoProdutoModel = new TipoProduto();
            if (! $oTipoProdutoModel->existsBy('id', $iId)) {
                throw new RuntimeException('Tipo de produto não localizado.');
            }
            if (! $oTipoProdutoModel->delete(['id' => $iId])) {
                $this->getResponse()->sendJson('Erro ao remover.');
            }
            $this->getResponse()->sendJson('');
        } catch (RuntimeException $e) {
            $this->getResponse()->sendJson($e->getMessage());
        }
    }
    /**
     * @action
     */
    public function adicionar()
    {
        try {
            $sTipo = trim($this->getRequest()->post('tipo'));
            $oTipoProdutoModel = new TipoProduto();
            if (! $oTipoProdutoModel->existsBy('id', $sTipo)) {
                throw new RuntimeException('Tipo de produto desconhecido.');
            }

            $oProdutoModel = new ProdutoModel();
            $oProdutoModel->insert([
                'tipo' => $sTipo,
                'nome' => $this->getRequest()->post('nome'),
                'preco' => $this->getRequest()->post('preco'),
                'esta_disponivel' => $this->getRequest()->post('esta_disponivel'),
            ]);
            $this->getResponse()->sendJson('');
        } catch (RuntimeException $e) {
            switch ($e->getCode()) {
                case '23502':
                    $this->getResponse()->sendJson('Campo obrigatório ausente.');
                case '23514':
                    $this->getResponse()->sendJson('Valor do imposto fora do intervalo, deve ficar entre 0 e 100%.');
                    break;
            }
            $this->getResponse()->sendJson($e->getMessage());
        }
    }
    /**
     * @action
     */
    public function apagar()
    {
        try {
            $iId = (int) $this->getRequest()->post('id', 0);
            $oProdutoModel = new ProdutoModel();
            if (! $oProdutoModel->existsBy('id', $iId)) {
                throw new RuntimeException('Produto não localizado.');
            }
            if (! $oProdutoModel->delete(['id' => $iId])) {
                $this->getResponse()->sendJson('Erro ao remover.');
            }
            $this->getResponse()->sendJson('');
        } catch (RuntimeException $e) {
            $this->getResponse()->sendJson($e->getMessage());
        }
    }
    /**
     * @action
     */
    public function listarCategoria()
    {
        try {
            $oTipoProdutoModel = new TipoProduto();
            if (! $oTipoProdutoModel->existsBy('tipo', $this->getRequest()->post('tipo', ''))) {
                throw new RuntimeException('Tipo de produto desconhecido.' . $this->getRequest()->post('tipo', ''));
            }
            $aTipoProduto = $oTipoProdutoModel->fetchRow(['tipo' => $this->getRequest()->post('tipo', '')]);

            $oProdutoModel = new ProdutoModel();
            $this->getResponse()->sendJson($oProdutoModel
                ->fetchAll([
                    'esta_disponivel' => ProdutoModel::ESTA_DISPONIVEL,
                    'tipo' => $aTipoProduto['id']
                ])
            );
        } catch (RuntimeException $e) {
            $this->getResponse()->sendJson($e->getMessage());
        }
    }
    /**
     * Finalizar a venda
     * @action
     */
    public function finalizar()
    {
        try {
            $aProduto = $this->getRequest()->post('id');
            $aQuantidade = $this->getRequest()->post('quantidade');
            if (count($aProduto) != count($aQuantidade)) {
                throw new RuntimeException('Erro de parâmetro.');
            }
            $aUsuario = SessionManager::get('usuario');
            // bug here on session
            // var_dump($aUsuario);
            if (! $aUsuario) {
                throw new RuntimeException('Cliente não autenticado.');
            }

            $fTotal = 0.0;
            $fImposto = 0.0;
            $oProdutoModel = new ProdutoModel();
            $oTipoProdutoModel = new TipoProduto();
            foreach ($aProduto as $iPos => $iProduto) {
                if (! $oProdutoModel->existsBy('id', $iProduto)) {
                    throw new RuntimeException('Produto desconhecido no carrinho.');
                }
                $aProduto = $oProdutoModel->fetchRow(['id' => $iProduto]);
                $fTotal += ((float) $aProduto['preco']) * $aQuantidade[$iPos];
                $fImposto += $oTipoProdutoModel->getImposto($aProduto['tipo']) * $aQuantidade[$iPos];
            }

            $oPedido = new Pedido();
            $oPedido->begin();
            $iPedido = $oPedido->insert([
                'usuario' => ['id'],
                'qtd_item' => array_sum($aQuantidade),
                'total_imposto' => $fImposto,
                'total' => $fTotal
            ]);

            $oItemModel = new Item();
            foreach ($aProduto as $iPos => $iProduto) {
                $aProduto = $oProdutoModel->fetchRow(['id' => $iProduto]);
                $oItemModel->insert([
                    'produto' => $iProduto,
                    'quantidade' =>  $aQuantidade[$iPos],
                    'valor_imposto' => $oTipoProdutoModel->getImposto($aProduto['tipo']) * $aQuantidade[$iPos],
                    'valor_produto' => $aProduto['preco'] * $aQuantidade[$iPos],
                    'pedido' => $iPedido
                ]);
            }
            $oPedido->commit();
            $this->getResponse()->sendJson('');
        } catch (RuntimeException $e) {
            $this->getResponse()->sendJson($e->getMessage());
        }
    }
}
