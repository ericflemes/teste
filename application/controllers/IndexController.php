<?php

class IndexController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        // action body
    }

    public function principalAction() {
        $modelProduto = new Application_Model_Produto();
        $this->view->produtos = $modelProduto->listar();
    }

}
