<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu
{
    private $CI;

    public function __construct(){
        $this->CI =& get_instance();
    }

    public function buscar_menu($codigo_gru){
        $this->CI->db->select("
            (
                SELECT count(*) 
                FROM paginas p
                INNER JOIN paginas_grupo pg ON pg.codigo_pag = p.codigo_pag
                WHERE pg.acesso = 1 AND codigo_men = m.codigo_men AND p.ativo_pag = 1 AND pg.codigo_gru = {$codigo_gru}
            ) as paginas, m.*
        ");
        $this->CI->db->from('menu m');
        $this->CI->db->order_by('ordem_men', 'ASC');
        $query = $this->CI->db->get();
        return $query->result_array();
    }

    public function buscar_paginas(){
        $this->CI->db->select("*");
        $this->CI->db->from("paginas");
        $this->CI->db->where("ativo_pag", 1);
        $query = $this->CI->db->get();
        return $query->result_array();
    }

}