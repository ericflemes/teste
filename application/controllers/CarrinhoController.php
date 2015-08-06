<?php

class CarrinhoController extends Zend_Controller_Action {

    public function init() {
        session_start();
    }

    public function indexAction() {
        $carrinho = new Application_Model_Carrinho();
        $this->view->carrinho = $carrinho->listaCarrinho();       
        $this->view->totalCarrinho = 'R$ '.number_format($carrinho->TotalCarrinho(), 2, ",", ".");
    }

}
