<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    private $view_login = "00_login/login";

    function __construct(){
        parent::__construct();
        $this->load->model('login_model', 'login');
        $this->load->model('permissoes_model', 'permissoes');
    }

	public function index(){
        //adm@barber.com.br
        //echo hash_hmac("md5", "senha", KEY);exit;
		$this->load->view($this->view_login);
	}

    public function entrar(){
        // Validação
        $this->form_validation->set_rules('login', 'Login', 'trim|required');
        $this->form_validation->set_rules('senha', 'Senha', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view($this->view_login);
        } else {

            $post = $this->input->post();

            $data = array(
                'login_usu' => formata_string($post['login'], 'protect'),
                'senha_usu' => hash_hmac("md5", formata_string($post['senha'], 'protect'), KEY)
            );

            //print_r($data);exit;

            $retorno = $this->login->login($data);
            //print_r($retorno);exit;

            if ($retorno) {
                if ($retorno != false) {

                    $session_data = array(
                        'codigo_usu'        => $retorno[0]['codigo_usu'],
                        'login_usu'         => $retorno[0]['login_usu'],
                        'codigo_gru'        => $retorno[0]['codigo_gru']
                    );

                    $grupo_permissoes = $this->permissoes->buscar_paginas_grupo($retorno[0]['codigo_gru']);

                    $this->session->set_userdata(SS_USUARIO, $session_data);
                    $this->session->set_userdata(SS_PERMISSOES, $grupo_permissoes);

                    if (isset($post['cbx_manter'])) {
                        /*$tempo = 7 * 24 * 3600;
                        setcookie('login_usu', $retorno[0]["login_usu"], (time() + $tempo));
                        setcookie('senha_usu', $post['senha_usu'], (time() + $tempo));*/
                        $this->session->sess_expire_on_close = false;
                    }

                    //$this->log_acesso();

                    echo json_encode(array('retorno' => true, 'redirect' => base_url('dashboard')));
                }else{
                    echo json_encode(array('retorno' => false, 'msg' => 'Email ou senha inválidos.'));
                }
            } else {
                echo json_encode(array('retorno' => false, 'msg' => 'Email ou senha inválidos.'));
            }
        }
    }

    public function sair(){
        //$this->session->sess_destroy();
        $this->session->set_userdata(SS_USUARIO, null);
        $this->session->set_userdata(SS_PERMISSOES, null);
        $this->session->sess_expire_on_close = true;
        $this->load->view($this->view_login);
    }

}
