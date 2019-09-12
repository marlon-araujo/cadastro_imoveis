<?php
class Login_model extends CI_Model{

    public function login($data) {
        $this->db->select("u.*, g.*");
        $this->db->from("usuario u");
        $this->db->join("grupo g", "g.codigo_gru = u.codigo_gru", "left");
        $this->db->where("u.login_usu", $data["login_usu"]);
        $this->db->where("u.senha_usu", $data["senha_usu"]);
        $this->db->where("u.ativo_usu", 1);
        $this->db->where("g.ativo_gru", 1);
        $this->db->limit(1);
        $query = $this->db->get();

        //print_r($this->db->last_query());exit;

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

}