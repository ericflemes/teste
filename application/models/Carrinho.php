<?php

class Application_Model_Carrinho extends Application_Model_Produto {

    var $id;
    var $preco;
    var $quantidade;
    var $total;

    public function __construct() {
        session_start();
    }

    // Gets e Sets classe carrinho
    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function getValor() {
        if (empty($this->quantidade)):
            $this->quantidade = 1;
        endif;

        return $this->preco * $this->quantidade;
    }

    public function getTotalCarrinho() {
        // Total de produtos
        $this->total = count($_SESSION['carrinho']);
        return $this->total;
    }

    public function getTotalItens() {
        //Total de itens
        foreach ($_SESSION['carrinho'] as $item) {
            $total_itens = $total_itens + $item['qtd'];
        }
        return $total_itens;
    }

    public function getTotalPg() {
        // Total a pagar
        foreach ($_SESSION['carrinho'] as $pg) {
            $total_pg = $total_pg + $pg['preco_total'];
        }

        return $total_pg;
    }

    // Fim gets e sets
    public function carrinho($id, $qtd = NULL, $remove = NULL, $all = NULL) {
        try {
            // Pega dasos do produto
            $produto = new Application_Model_Produto();
            $dados = $produto->Produto($id);

            // Vefifica se encontrou o produto
            if (!empty($dados)):

                $this->preco = $dados['preco'];
                $this->setId($id);

                // verifica a ação solicitada
                if ($remove == TRUE):
                    $this->remover($all);
                else:
                    $this->adicionar($qtd);
                endif;

                // retrona valores para o controller
                $retorno = array('total' => $this->getTotalCarrinho(), 'retorno' => true, 'subTotal' => $this->getValor(), 'msg' => 'Adicionado com sucesso!');
                return $retorno;

            else:
                throw new Exception('Erro: Produto não encontrado!');
            endif;
        } catch (Exception $ex) {
            // retrona valores para o controller
            $retorno = array('total' => 0, 'retorno' => FALSE, 'msg' => $ex->getMessage());
            return $retorno;
        }
    }

    public function adicionar($qtd) {

        // Vefifica array
        if (!isset($_SESSION['carrinho'])):
            $_SESSION['carrinho'] = array();
        endif;

        //  Adiciona produto no carrinho.
        //  Adiciona quantidade do produto no carrinho
        if (!empty($qtd)):
            $this->quantidade = $_SESSION['carrinho'][$this->id]['qtd'] = $qtd;
        else:

            if (empty($_SESSION['carrinho'][$this->id])):
                $_SESSION['carrinho'][$this->id]['qtd'] = 1;
                $_SESSION['carrinho'][$this->id]['preco_total'] = $this->getValor();
            else:
                $this->quantidade = $_SESSION['carrinho'][$this->id]['qtd']+=1;
                $_SESSION['carrinho'][$this->id]['preco_total'] = $this->getValor();
            endif;
        endif;
    }

    public function remover($all) {

        // Remove uma unidade do item do darrinho 
        if ((!empty($_SESSION['carrinho'][$this->id])) && ($all == false)):
            $this->quantidade = $_SESSION['carrinho'][$this->id]['qtd']-=1;
            $_SESSION['carrinho'][$this->id]['preco_total'] = $this->getValor();

            // Verifica se não há mais unidades desse item e remove o produto do
            // Carrinho
            if ($this->getValor() <= 0):
                unset($_SESSION['carrinho'][$this->id]);
            endif;

        else:
            // Remove o produto do carrinho
            if ((!empty($_SESSION['carrinho'][$this->id])) && ($all == TRUE)):
                unset($_SESSION['carrinho'][$this->id]);
            endif;

        endif;
    }

    public function listaCarrinho() {
        try {
            // Pega id dos produtos na sessão
            foreach ($_SESSION['carrinho'] as $key => $value) :
                $where.=$key . ',';
            endforeach;
            $where = explode(',', $where);

            // seleciona dados do produto
            $produto = new Application_Model_Produto();
            $dados = $produto->listar($where);

            // Completo array de produtos com quanidade de itens e preço total por item
            foreach ($dados as $key => $prod) :
                foreach ($_SESSION['carrinho'] as $key2 => $value):
                    if ($key2 == $prod['cod_produto']):
                        $dados[$key]['quantidade'] = $value['qtd'];
                        $dados[$key]['preco_total'] = $prod['preco'] * $value['qtd'];
                    endif;
                endforeach;
            endforeach;

            return $dados;
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage());
        }
    }

    public function TotalCarrinho() {
        $produto = new Application_Model_Carrinho();
        $dados = $produto->listaCarrinho();
        foreach ($dados as $value) {
            $totalCompra = $totalCompra + $value['preco_total'];
        }
        return $totalCompra;
    }

}
