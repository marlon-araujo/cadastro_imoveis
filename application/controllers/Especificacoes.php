<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Especificacoes extends CI_Controller {

    private $nome_pagina = "Especificações";
    private $tabela = "especificacoes";
    private $prefixo = "esp";

    function __construct() {
        parent::__construct();

        if(!verifica_acesso($this->tabela)) {
            redirect('dashboard');
        }
    }

	public function index(){

        $rodape['js'] = array(
            'assets/js/paginas/' . $this->tabela . '.js'
        );

        $data["tabela"] = $this->tabela;
        $data["nome_pagina"] = $this->nome_pagina;

        $data["consulta"] = $this->crud->buscar('x.*, t.descricao_tpi', $this->tabela . ' x', 'x.ativo_' . $this->prefixo . ' = 1', '', ['tabela' => 'tipo_imovel t', 'condicao' => 't.codigo_tpi = x.codigo_tpi', 'tipo' => 'inner']);
        $data["tipos_imoveis"] = $this->crud->buscar('*', 'tipo_imovel', 'ativo_tpi = 1', 'descricao_tpi ASC');

		$this->load->view('01_estrutura/cabecalho');
		$this->load->view('03_cadastros/' . $this->tabela, $data);
		$this->load->view('01_estrutura/rodape', $rodape);
    }
    
    public function salvar(){

        $dados = $this->input->post();
        //print_r($dados);exit;

        if(!empty($dados)) {
            $this->form_validation->set_rules('descricao_' . $this->prefixo, 'Descrição', 'required');

            if($this->form_validation->run() === FALSE) {
                echo json_encode(array('retorno' => false, 'mensagem' => validation_errors()));
                exit;
            } else {
                $codigo = $this->input->post('codigo_' . $this->prefixo);
                unset($dados['codigo_' . $this->prefixo]);

                if(intval($codigo) === 0) {
                    $dados["ativo_" . $this->prefixo] = 1;
                    $retorno = $this->crud->inserir($this->tabela, $dados);

                    if ($retorno) {
                        echo json_encode(array('retorno' => true));
                    } else {
                        echo json_encode(array('retorno' => false));
                    }
                } else {
                    $retorno = $this->crud->atualizar($this->tabela, $dados, 'codigo_' . $this->prefixo . ' = ' . $codigo);

                    if($retorno) {
                        echo json_encode(array('retorno' => true));
                    } else {
                        echo json_encode(array('retorno' => false));
                    }
                }
            }
        }
    }

    public function buscar() {
        $condicao = $this->input->post('condicao');
        $valor = $this->input->post('valor');

        $query  = "SELECT x.*, t.descricao_tpi FROM " . $this->tabela . " x INNER JOIN tipo_imovel t ON t.codigo_tpi = x.codigo_tpi WHERE x.ativo_" . $this->prefixo . " = 1";
        $query .= $condicao == "" ? "" : " AND " . $condicao . " like '%" . $valor . "%'";

        $dados = $this->crud->busca_livre($query);

        if($dados) {
            echo json_encode(array('retorno' => true, 'dados' => $dados));
        } else {
            echo json_encode(array('retorno' => false, 'mensagem' => 'Nenhum registro encontrado!'));
        }
    }

    public function buscar_registro() {
        $codigo = $this->input->post('codigo');
        $dados  = $this->crud->buscar("*", $this->tabela, "ativo_" . $this->prefixo . " = 1 AND codigo_" . $this->prefixo . " = " . $codigo);

        if($dados) {
            echo json_encode(array('retorno' => true, 'dados' => $dados));
        } else {
            echo json_encode(array('retorno' => false, 'mensagem' => 'Nenhum registro encontrado!'));
        }
    }

    public function excluir() {
        if($this->crud->inativar($this->tabela, $this->prefixo, $this->input->post('codigo'))) {
            echo json_encode(array('retorno' => true));
        } else {
            echo json_encode(array('retorno' => false));
        }
    }
}
