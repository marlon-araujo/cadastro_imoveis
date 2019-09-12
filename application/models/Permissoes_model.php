<?php

class Permissoes_model extends CI_Model{

    public function buscar_paginas_grupo($codigo_gru) {

        $this->db->select("p.link_pag, pg.*");
        $this->db->from("paginas_grupo pg");
        $this->db->join("paginas p", "p.codigo_pag = pg.codigo_pag");
        $this->db->where("pg.codigo_gru", $codigo_gru);
        $query = $this->db->get();

        //print_r($this->db->last_query());exit;

        if ($query->num_rows() > 0) {
            //return $query->result();
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function buscar_paginas() {

        $this->db->select("*");

        $this->db->from("paginas");
        $this->db->where("ativo_pag", 1);

        $query = $this->db->get();

        //print_r($this->db->last_query());exit;

        if ($query->num_rows() == 1) {
            //return $query->result();
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function por_nome($grupo, $pagina) {

        $this->db->select("pg.*");

        $this->db->from("paginas_grupo pg");
        $this->db->join("paginas p", "p.codigo_pag = pg.codigo_pag");

        $this->db->where("pg.codigo_gru", $grupo);
        $this->db->where("p.nome_pag", $pagina);
        $this->db->limit(1);

        $query = $this->db->get();

        //print_r($this->db->last_query());exit;

        if ($query->num_rows() == 1) {
            //return $query->result();
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function paginas_liberadas($grupo) {

        $this->db->select("*");

        $this->db->from("paginas_grupo pg");
        $this->db->join("paginas p", "p.codigo_pag = pg.codigo_pag");
        $this->db->where("pg.codigo_gru", $grupo);

        $query = $this->db->get();

        //print_r($this->db->last_query());exit;

        if ($query->num_rows() > 0) {
            //return $query->result();
            return $query->result_array();
        } else {
            return false;
        }
    }

}
