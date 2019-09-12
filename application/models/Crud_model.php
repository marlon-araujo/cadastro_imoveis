<?php

class Crud_model extends CI_Model {
    
    public function inserir($tabela, $dados){
        $dados_sanitizado = [];
        foreach($dados as $key => $value){
            $dados_sanitizado[$key] = formata_string($value, 'protect');
        }

        $this->db->insert($tabela, $dados_sanitizado);

        if ($this->db->insert_id() >= 1) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function inserir_array($tabela, $dados){
        if($this->db->insert_batch($tabela, $dados)){
            return true;
        } else {
            return false;
        }
    }
    
    public function atualizar($tabela, $dados, $where){
        $where = formata_string($where, 'protect');
        $dados_sanitizado = [];
        foreach($dados as $key => $value){
            $dados_sanitizado[$key] = formata_string($value, 'protect');
        }

        $this->db->set($dados_sanitizado);
        $this->db->where($where);

        if ($this->db->update($tabela)) {
            //print_r($this->db->last_query());exit;
            return true;
        } else {
            return false;
        }
    }

    public function excluir($tabela, $prefixo, $codigo){
        $this->db->where('codigo_' . $prefixo, $codigo);

        if ($this->db->delete($tabela)) {
            return true;
        } else {
            return false;
        }
    }

    public function excluir_condicionado($tabela, $where){
        $this->db->where($where);

        if ($this->db->delete($tabela)) {
            return true;
        } else {
            return false;
        }
    }

    public function inativar($tabela, $prefixo, $codigo){

        $prefixo = formata_string($prefixo, 'protect');
        $codigo = formata_string($codigo, 'protect');

        $this->db->set("ativo_" . $prefixo, false);
        $this->db->where('codigo_' . $prefixo, $codigo);

        if ($this->db->update($tabela)) {
            return true;
        } else {
            return false;
        }
    }

    public function buscar($campos, $tabela, $where, $order = "", $join = "", $mostrar_query = false){
        $this->db->select($campos);
        $this->db->from($tabela);
        $this->db->where($where);
        if(!empty($join)) {
            $this->db->join($join['tabela'], $join['condicao'], $join['tipo']);
        }

        if(!empty($order)){
            $this->db->order_by($order);
        }

        $query = $this->db->get();

        if($mostrar_query){
            print_r($this->db->last_query());exit;
        }

        if ($query->num_rows() >= 1) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function busca_livre($select){
        //$this->db->query($select);
        $query = $this->db->query($select);
        //$query = $this->db->get();
        //print_r($this->db->last_query());exit;

        if ($query->num_rows() >= 1) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function executa_comando($query){
        $query = $this->db->query($query);
        //print_r($this->db->last_query());exit;

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function verificar($tabela, $where){
        $this->db->select("*");
        $this->db->from($tabela);
        $this->db->where($where);
        $query = $this->db->get();
        //print_r($this->db->last_query());exit;

        if ($query->num_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }


    /*public function buscar_mongo($campos, $tabela, $where = ""){
        $this->mongo_db->select($campos);
        $this->mongo_db->from($tabela);

        if(!empty($where)){
            $this->mongo_db->where($where);
        }

        $query = $this->mongo_db->get();
        //print_r($this->db->last_query());exit;

        if ($query->num_rows() >= 1) {
            return $query->result_array();
        } else {
            return false;
        }
    }*/
}
