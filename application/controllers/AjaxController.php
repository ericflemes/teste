<?php

class AjaxController extends Zend_Controller_Action {

    public function init() {
        session_start();
    }

    public function addCartAction() {

        $this->getHelper('viewRenderer')->setNoRender();

        $request = $this->getRequest()->getParams();
        $id = $request['id'];

        $carrinho = new Application_Model_Carrinho();
        $retorno = $carrinho->carrinho($request['id']);

        echo json_encode($retorno);
    }

    public function totalCarrinhoAction() {
        $this->getHelper('viewRenderer')->setNoRender();

        $carrinho = new Application_Model_Carrinho();
        echo json_encode(array('total' => $carrinho->getTotalCarrinho(), 'total_pg' => $carrinho->getTotalPg()));
    }

    public function listarCarrinhoAction() {
        $this->getHelper('viewRenderer')->setNoRender();
        $produto = new Application_Model_Carrinho();
        $dados = $produto->listaCarrinho();
        echo json_encode($dados);
    }

    public function calcularItemAction() {
        $this->getHelper('viewRenderer')->setNoRender();
        $request = $this->getRequest()->getParams();
        
        $id = $request['id'];
        $qtd = $request["qtd"];

        $carrinho = new Application_Model_Carrinho();
        $retorno = $carrinho->carrinho($id, $qtd);
        $totalCompra = $carrinho->TotalCarrinho();
        // print_r($retorno);
        echo json_encode(array('qtd' => $qtd, 'id' => $id, 'subTotal' => 'R$ ' . number_format($retorno['subTotal'], 2, ",", "."), 'precoTotal' => 'R$ ' . number_format($totalCompra, 2, ",", "."), 'retorno' => true));
    }

    public function removerItemAction() {
        $this->getHelper('viewRenderer')->setNoRender();
        $request = $this->getRequest()->getParams();
        $id = $request['id'];

        $carrinho = new Application_Model_Carrinho();
        $retorno = $carrinho->carrinho($request['id'], NULL, TRUE, TRUE);
        echo json_encode($retorno);
    }

}
