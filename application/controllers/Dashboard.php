<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    function __construct() {
        parent::__construct();

        if((empty($this->session->userdata(SS_USUARIO)) || $this->session->userdata(SS_USUARIO) != true)){
            redirect("login/sair");
        }

    }

	public function index(){

        $topo['css'] = array(
            
        );

        $rodape['js'] = array(
            /*'assets/plugins/moment/moment.js',*/
            'assets/js/cliente/dashboard.js' . V
        );

        $data['controller'] = "";


		$this->load->view('01_estrutura/cabecalho', $topo);
		$this->load->view('02_dashboard/dashboard', $data);
		$this->load->view('01_estrutura/rodape', $rodape);
    }

    public function agendar_horario(){
        $dados = $this->input->post();

        if(!empty($dados)) {
            $this->form_validation->set_rules('hora_age', 'Nome', 'required');

            if($this->form_validation->run() === FALSE) {
                echo json_encode(array('retorno' => false, 'mensagem' => validation_errors()));
                exit;
            } else {
                $dados["data_age"] = data_para_banco($dados['data_age']);
                $dados["ativo_age"] = 1;
                $retorno = $this->crud->inserir("agenda", $dados);

                if ($retorno) {
                    echo json_encode(array('retorno' => true));
                } else {
                    echo json_encode(array('retorno' => false));
                }
            }
        }
    }

    public function cadastro_cliente(){
        $dados = $this->input->post();

        if(!empty($dados)) {
            $this->form_validation->set_rules('nome_pes', 'Nome', 'required');
            $this->form_validation->set_rules('telefone_pes', 'Telefone', 'required');

            if($this->form_validation->run() === FALSE) {
                echo json_encode(array('retorno' => false, 'mensagem' => validation_errors()));
                exit;
            } else {
                $dados["datacadastro_pes"] = date('Y-m-d H:i:s');
                $dados["ativo_pes"] = 1;
                $retorno = $this->crud->inserir("pessoa", $dados);

                if ($retorno) {
                    echo json_encode(array('retorno' => true));
                } else {
                    echo json_encode(array('retorno' => false));
                }
            }
        }
    }
    
    public function buscar_agenda(){
        $dados = $this->input->post();

        if(!empty($dados)){

            $data = data_para_banco($dados['data_age']);

            $query = "SELECT * FROM agenda a 
                        INNER JOIN pessoa p ON p.codigo_pes = a.codigo_pes 
                        INNER JOIN tipo_servico tp ON tp.codigo_tps = a.codigo_tps 
                        WHERE ativo_age = 1 AND data_age = '" . $data . "'
                        ORDER BY a.hora_age ASC";

            $retorno = $this->crud->busca_livre($query);

            if($retorno){
                echo json_encode(array('retorno' => true, 'dados' => $retorno));
            }else{
                echo json_encode(array('retorno' => false));
            }
        }
    }
    
    public function buscar_clientes(){
        $busca = $this->input->post('q');

        if(!empty($busca)){

            $retorno = $this->crud->buscar("*", "pessoa", "nome_pes LIKE '%" . $busca . "%' AND ativo_pes = 1", "nome_pes ASC");

            if($retorno){
                echo json_encode(array('retorno' => true, 'dados' => $retorno));
            }else{
                echo json_encode(array('retorno' => false));
            }
        }
    }

    public function alterar_agendamento(){
        $dados = $this->input->post();

        if(!empty($dados)){

            $codigo = $dados['codigo_age'];
            unset($dados['codigo_age']);

            if($this->crud->atualizar('agenda', $dados, 'codigo_age = ' . $codigo)){
                echo json_encode(array('retorno' => true));
            }else{
                echo json_encode(array('retorno' => false));
            }
        }
    }

    public function marcar_pago(){
        $dados = $this->input->post();

        if(!empty($dados)){

            $r = $this->crud->atualizar('agenda', ['pago_age' => 1, 'codigo_for' => $dados['codigo_for']], 'codigo_age = ' . $dados['codigo_age']);

            if($r){

                //$agenda = $this->crud->buscar('*', 'agenda', 'codigo_age = ' . $dados['codigo_age']);
                //$tipo_servico = $this->crud->buscar('*', 'tipo_servico', 'codigo_tps = ' . $agenda[0]['codigo_tps']);
                $forma_pgto = $this->crud->buscar('*', 'forma_pagamento', 'codigo_for = ' . $dados['codigo_for']);

                $valor = floatval($dados['valor_pago']);
                $taxa = floatval($forma_pgto[0]['taxa_for']);

                $valor_liquido = $valor;
                if($taxa > 0){
                    $valor_liquido = $valor - (($valor * $taxa) / 100);
                }

                $obj_caixa = array(
                    'datalancamento_cai' => date('Y-m-d H:i:s'),
                    'tipo_cai' => 0,
                    'valorbruto_cai' => $valor,
                    'taxa_cai' => $taxa,
                    'valorliquido_cai' => $valor_liquido,
                    'codigo_age' => $dados['codigo_age']
                );

                $ret = $this->crud->inserir('caixa', $obj_caixa);

                if($ret){
                    echo json_encode(array('retorno' => true));
                }else{
                    echo json_encode(array('retorno' => false));
                }
                
            }else{
                echo json_encode(array('retorno' => false));
            }
        }
    }

    public function excluir() {
        if($this->crud->inativar('agenda', 'age', $this->input->post('codigo'))) {
            echo json_encode(array('retorno' => true));
        } else {
            echo json_encode(array('retorno' => false));
        }
    }
}
