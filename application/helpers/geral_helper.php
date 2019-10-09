<?php
/**
 * Created by PhpStorm.
 * User: Marlon Araújo
 * Date: 04/04/2019
 * Time: 16:10
 */

if(!defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('formata_string')){
    function formata_string($value, $tipo)
    {
        $CI =& get_instance();
        $CI->load->library('sanitizer');

        switch ($tipo){
            case 'email':
                $retorno = $CI->sanitizer->email($value);
                $retorno = mb_strtolower($retorno);
                break;
            case 'nome':
                $retorno = $CI->sanitizer->alfabetico($value, true, true);
                $retorno = mb_strtolower($retorno);
                $retorno = ucwords($retorno);
                break;
            case 'string':
                $retorno = $CI->sanitizer->alfanumerico($value, true, true);
                $retorno = mb_strtolower($retorno);
                $retorno = ucwords($retorno);
                break;
            case 'sanitize':
                $retorno = $CI->sanitizer->alfanumerico($value, true, true);
                break;
            case 'string_semacento':
                $retorno = $CI->sanitizer->alfanumerico($value, false, true);
                break;
            case 'integer':
                $retorno = $CI->sanitizer->integer($value);
                break;
            case 'numeric':
                $retorno = $CI->sanitizer->numerico($value);
                break;
            case 'float':
                $retorno = $CI->sanitizer->float($value);
                break;
            case 'money':
                $retorno = $CI->sanitizer->money($value);
                break;
            case 'url':
                $retorno = $CI->sanitizer->url($value);
                break;
            case 'protect':
                $retorno = $CI->sanitizer->protect($value);
                break;
        }

        return $retorno;
    }
}

if(!function_exists('envia_email')) {
    function envia_email($assunto, $mensagem, $para, $nome_reply = "", $email_reply = "", $cc = "", $bcc = "", $anexo = "") {

        $CI =& get_instance();
        $CI->load->library('email');

        $config = array();
        $config['protocol'] = "smtp";
        $config['smtp_host'] = "smtp.seusite.com.br";
        $config['smtp_user'] = "no-reply@seusite.com.br";
        $config['smtp_pass'] = "senha";
        $config['smtp_port'] = 587;
        $config['charset'] = "utf-8";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";

        $CI->email->initialize($config);

        $CI->email->from($config_email['email'], $nome_reply);

        if(!empty($email_reply) && !empty($nome_reply)){
            $CI->email->reply_to($email_reply, $nome_reply);
        }

        $CI->email->to($para);

        $CI->email->subject($assunto);
        $CI->email->message($mensagem);

        if(!empty($cc)) $CI->email->cc($cc);
        if(!empty($bcc)) $CI->email->bcc($bcc);
        if(!empty($anexo)) $CI->email->attach($anexo);

        if ($CI->email->send()) {
            return array('retorno' => true);
        } else {
            return array('retorno' => false, 'erro' => 'Erro ao enviar o e-mail.' . $CI->email->print_debugger());
        }
    }
}

if(!function_exists('verifica_acesso')){
    function verifica_acesso($pagina = "", $menu = false)
    {
        $CI =& get_instance();

        if((empty($CI->session->userdata('usuario')) || $CI->session->userdata('usuario') != true) && (empty($CI->session->userdata('permissoes')) || $CI->session->userdata('permissoes') != true)){
            return false;
        }else{
            if(!empty($pagina)){
                $CI->load->model('permissoes_model', 'permissoes');
                $paginas = $CI->permissoes->paginas_liberadas($CI->session->userdata['usuario']['codigo_gru']);

                if(!empty($paginas)){
                    foreach ($paginas as $cada_pagina){
                        if(($cada_pagina["link_pag"] == $pagina) && intval($cada_pagina["acesso"]) == 1){
                            return true;
                        }
                    }
                }

                if(!$menu){
                    redirect("dashboard");
                }

                return false;
            }
            return true;
        }
    }
}

if(!function_exists('verificar_acao')){
    function verificar_acao($pagina = "", $acao = "")
    {
        $CI =& get_instance();

        if(!empty($pagina) && !empty($acao)){ 
            $permissoes = $CI->session->userdata('permissoes');

            foreach ($permissoes as $cada){
                if(($cada["link_pag"] == $pagina) && intval($cada[$acao]) == 1){
                    return true;
                }
            }
            return false;
        }else{
            return false;
        }
    }
}

if(!function_exists('data_completa')) {

    /**
     * @data: recebe data em timestamp
     * @tipo_mes: completo ou abreviado
     * @tipo_ano: 2 ou 4 digitos
     * @retorno:
     *          1 - ex.: 16 DE ABRIL DE 2018
     *          2 - ex.: 16/04/2018
     *          3 - ex.: 2018-04-16
     *          4 - ex.: 16 ABR 2018
     *          5 - ex.: 01
     *          6 - ex.: ABR ou ABRIL
     *          7 - ex.: 18 ou 2018
     *          8 - ex.: SEG ou SEGUNDA
     */
    function data_completa($data, $retorno, $tipo_mes = "", $tipo_dia = "") {
        $mes_nome_completo = array('', 'JANEIRO', 'FEVEREIRO', 'MARÇO', 'ABRIL', 'MAIO', 'JUNHO', 'JULHO', 'AGOSTO', 'SETEMBRO', 'OUTUBRO', 'NOVEMBRO', 'DEZEMBRO');
        $mes_nome_abreviado = array('', 'JAN', 'FEV', 'MAR', 'ABR', 'MAI', 'JUN', 'JUL', 'AGO', 'SET', 'OUT', 'NOV', 'DEZ');

        $dia_semana_completo = array('DOMINGO', 'SEGUNDA', 'TERÇA', 'QUARTA', 'QUINTA', 'SEXTA', 'SÁBADO');
        $dia_semana_abreviado = array('DOM', 'SEG', 'TER', 'QUA', 'QUI', 'SEX', 'SÁB');

        if(strpos($data, '-')){
            $data = explode("-", $data);
        }else{
            $data = explode("/", $data);
        }
        

        $mes_numero = intval($data[1]);
        $mes = !empty($tipo_mes) ? $tipo_mes == 1 ? $mes_nome_abreviado[$mes_numero] : $mes_nome_completo[$mes_numero] : "";

        switch ($retorno){
            case 1:
                if(empty($tipo_mes)){
                    $mes = $mes_nome_completo[$mes_numero];
                }

                return $data[2] . " DE " . $mes . " DE " . $data[0];
                break;

            case 2:
                return $data[2] . "/" . $data[1] . "/" . $data[0];
                break;

            case 3:
                return $data[2] . "-" . $data[1] . "-" . $data[0];
                break;

            case 4:
                if(empty($tipo_mes)){
                    $mes = $mes_nome_abreviado[$mes_numero];
                }

                return $data[2] . " " . $mes . " " . $data[0];
                break;

            case 5:
                return $data[2];
                break;

            case 6:
                if(empty($tipo_mes)){
                    $mes = $mes_nome_completo[$mes_numero];
                }

                return $mes;
                break;

            case 7:
                return $data[0];
                break;

            case 8:

                $dia_semana = date('w', strtotime($data));
                return $tipo_dia == 1 ? $dia_semana_abreviado[$dia_semana] : $dia_semana_completo[$dia_semana];
                break;

            default:
                if(empty($tipo_mes)){
                    $mes = $mes_nome_completo[$mes_numero];
                }

                return $data[2] . " DE " . $mes . " DE " . $data[0];
                break;
        }

    }
}

if(!function_exists('letras_iniciais')) {
    function letras_iniciais($nome){
        $iniciais = "";
        $array_nomes = explode(' ', $nome);
        $tam = count($array_nomes) == 2 ? 2 : 1;

        for($i = 0; $i < $tam; $i++){
            $iniciais .= substr($array_nomes[$i], 0, 1);
        }

        return $iniciais;
    }
}
	
if(!function_exists('base64_url_encode')){
    function base64_url_encode($input)
    {
        return strtr(base64_encode($input), '+/=', '._-');
    }
}

if(!function_exists('base64_url_decode')){
    function base64_url_decode($input)
    {
        return base64_decode(strtr($input, '._-', '+/='));
    }
}

if(!function_exists('limitar_texto')){
    function limitar_texto($string, $tamanho){
        return substr($string, 0, $tamanho);
    }
}

if(!function_exists('url_encode')) {
    function url_encode($encode)
    {
        return rawurlencode(base64_encode(str_replace(array('+', '=', '/'), array('_', '-', '~'), $encode)));
    }
}

if(!function_exists('url_decode')) {
    function url_decode($decode)
    {
        return base64_decode(rawurldecode($decode));
    }
}

if(!function_exists('data_para_banco')) {
    function data_para_banco($data) {
        $arr = explode('/', $data);
        return $arr[2] . '-' . $arr[1] . '-' . $arr[0];
    }
}