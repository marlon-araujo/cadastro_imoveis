<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Imovel extends CI_Controller {

    private $nome_pagina = "Imóvel";
    private $tabela = "imovel";
    private $prefixo = "imo";

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

        $query = "SELECT i.*, p.*, c.nome_cid, e.uf_est, ti.descricao_tpi
                    FROM imovel i
                    INNER JOIN pessoa p ON p.codigo_pes = i.codigo_pes
                    INNER JOIN tipo_imovel ti ON ti.codigo_tpi = i.codigo_tpi
                    INNER JOIN cidades c ON c.codigo_cid = p.codigo_cid
                    INNER JOIN estados e ON e.codigo_est = c.codigo_est
                    WHERE i.ativo_imo = 1";
        $data["consulta"] = $this->crud->busca_livre($query);

        $data["estados"] = $this->crud->buscar('*', 'estados', 'codigo_pai = 1', 'nome_est ASC');
        $data["tipos_imoveis"] = $this->crud->buscar('*', 'tipo_imovel', 'ativo_tpi = 1', 'descricao_tpi ASC');
        $data["pessoas"] = $this->crud->buscar('*', 'pessoa', 'ativo_pes = 1', 'nome_pes ASC');

		$this->load->view('01_estrutura/cabecalho');
		$this->load->view('03_cadastros/' . $this->tabela, $data);
		$this->load->view('01_estrutura/rodape', $rodape);
    }
    
    public function salvar(){

        $dados = $this->input->post();
        //print_r($dados);exit;

        if(!empty($dados)) {
            $this->form_validation->set_rules('codigo_pes', 'Proprietário', 'required');

            if($this->form_validation->run() === FALSE) {
                echo json_encode(array('retorno' => false, 'mensagem' => validation_errors()));
                exit;
            } else {
                $codigo = $this->input->post('codigo_' . $this->prefixo);
                unset($dados['codigo_' . $this->prefixo]);
                unset($dados['codigo_est']);

                $dados['valor_imo'] = str_replace(',', '.', str_replace('.', '', $dados['valor_imo']));

                if(intval($codigo) === 0) {
                    $dados["datacadastro_" . $this->prefixo] = date('Y-m-d H:i:s');
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

        $query = "SELECT i.*, p.*, c.nome_cid, e.uf_est, ti.descricao_tpi
                    FROM imovel i
                    INNER JOIN pessoa p ON p.codigo_pes = i.codigo_pes
                    INNER JOIN tipo_imovel ti ON ti.codigo_tpi = i.codigo_tpi
                    INNER JOIN cidades c ON c.codigo_cid = p.codigo_cid
                    INNER JOIN estados e ON e.codigo_est = c.codigo_est
                    WHERE i.ativo_imo = 1";
        $query .= $condicao == "" ? "" : " AND " . $condicao . " like '%" . $valor . "%'";

        $dados = $this->crud->busca_livre($query);

        if($dados) {
            echo json_encode(array('retorno' => true, 'dados' => $dados));
        } else {
            echo json_encode(array('retorno' => false, 'mensagem' => 'Nenhum registro encontrado!'));
        }
    }

    public function buscar_especificacoes() {
        $codigo = $this->input->post('codigo_tpi');
        $dados = $this->crud->buscar('tipo_esp, descricao_esp', 'especificacoes', 'ativo_esp = 1 AND codigo_tpi = ' . $codigo);

        if($dados) {
            echo json_encode(array('retorno' => true, 'dados' => $dados));
        } else {
            echo json_encode(array('retorno' => false, 'mensagem' => 'Nenhum registro encontrado!'));
        }
    }

    public function buscar_registro() {
        $codigo = $this->input->post('codigo');
        $query = "SELECT i.*, p.*, c.nome_cid, e.uf_est, ti.descricao_tpi
                    FROM imovel i
                    INNER JOIN pessoa p ON p.codigo_pes = i.codigo_pes
                    INNER JOIN tipo_imovel ti ON ti.codigo_tpi = i.codigo_tpi
                    INNER JOIN cidades c ON c.codigo_cid = p.codigo_cid
                    INNER JOIN estados e ON e.codigo_est = c.codigo_est
                    WHERE i.codigo_imo = {$codigo}";
        $dados = $this->crud->busca_livre($query);

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
