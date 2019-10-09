<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pessoa extends CI_Controller {

    private $nome_pagina = "Pessoa";
    private $tabela = "pessoa";
    private $prefixo = "pes";

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

        $query = "SELECT p.*, c.nome_cid, e.uf_est
                    FROM pessoa p
                    INNER JOIN cidades c ON c.codigo_cid = p.codigo_cid
                    INNER JOIN estados e ON e.codigo_est = c.codigo_est
                    WHERE ativo_pes = 1";

        $data["consulta"] = $this->crud->busca_livre($query);
        $data["estados"] = $this->crud->buscar('*', 'estados', 'codigo_pai = 1', 'nome_est ASC');
        $data["cidades"] = $this->crud->buscar('*', 'cidades', 'codigo_est = 25', 'nome_cid ASC');
        $data["tipos_imoveis"] = $this->crud->buscar('*', 'tipo_imovel', 'ativo_tpi = 1', 'descricao_tpi ASC');

		$this->load->view('01_estrutura/cabecalho');
		$this->load->view('03_cadastros/' . $this->tabela, $data);
		$this->load->view('01_estrutura/rodape', $rodape);
    }
    
    public function salvar(){

        $dados = $this->input->post();
        //print_r($dados);exit;

        if(!empty($dados)) {
            $this->form_validation->set_rules('nome_' . $this->prefixo, 'Nome', 'required');

            if($this->form_validation->run() === FALSE) {
                echo json_encode(array('retorno' => false, 'mensagem' => validation_errors()));
                exit;
            } else {
                $codigo = $this->input->post('codigo_' . $this->prefixo);
                unset($dados['codigo_' . $this->prefixo]);
                unset($dados['codigo_est']);

                $dados['data_pes'] = data_completa($dados['data_pes'], 3);

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

        $query = "SELECT p.*, c.nome_cid, e.uf_est
                    FROM pessoa p
                    INNER JOIN cidades c ON c.codigo_cid = p.codigo_cid
                    INNER JOIN estados e ON e.codigo_est = c.codigo_est
                    WHERE ativo_pes = 1";

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

        $query = "SELECT p.*, c.nome_cid, e.uf_est
                    FROM pessoa p
                    INNER JOIN cidades c ON c.codigo_cid = p.codigo_cid
                    INNER JOIN estados e ON e.codigo_est = c.codigo_est
                    WHERE codigo_pes = {$codigo}";

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

    public function buscar_cidades(){

        $dados = $this->input->post();

        if(!empty($dados)){

            $query = "SELECT c.nome_cid, c.codigo_cid FROM cidades c INNER JOIN estados e On e.codigo_est = c.codigo_est WHERE e.uf_est = '{$dados['estado']}' ORDER BY c.nome_cid ASC";

            $r = $this->crud->busca_livre($query);

            echo json_encode(array('retorno' => true, 'dados' => $r));
        }else{
            echo json_encode(array('retorno' => false));
        }

    }
}
