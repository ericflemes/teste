<?php

class Application_Model_Produto extends Zend_Db_Table {

    protected $_name = 'tb_produto';
    protected $_primary = 'cod_produto';
    var $codigo;
    var $descricao;
    var $preco;
    var $quantidade;
    var $produto;

    public function listar($id = NULL) {
        try {
            $where = '1';
            if (!empty($id))
                $where = $this->getDefaultAdapter()->quoteInto("cod_produto IN (?)", $id);
            return $this->fetchAll($where)->toArray();
        } catch (Zend_Db_Exception $e) {
            throw new Exception($ex->getMessage());
        }
    }

    protected function colunas(Array $dados) {
        $ret = array();
        foreach ($dados as $coluna => $valor) {
            if (in_array($coluna, $this->info(Zend_Db_Table_Abstract::COLS)))
                $ret[$coluna] = $valor;
        }
        return $ret;
    }

    public function Produto($id) {
        try {
            if (!empty($id)) {
                $where = $this->getDefaultAdapter()->quoteInto("cod_produto = ?", $id);
                $this->produto = $this->fetchRow($where)->toArray();

                $this->codigo = $this->produto['cod_produto'];
                $this->quantidade = 1;
                $this->preco = $this->produto['preco'];
                $this->descricao = $this->produto['descricao'];

                return $this->produto;
            }
        } catch (Zend_Db_Exception $e) {
            throw new Exception($ex->getMessage());
        }
    }

}
