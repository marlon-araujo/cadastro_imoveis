var base_url = $("#base_url").val();

function mostrar_carregando(){

}

function fechar_carregando(){
    
}

function retorno_mensagem(mensagem, tipo) {
    switch (tipo) {
        case 'aviso':
            $.toast({
                heading: 'Aviso',
                text: mensagem,
                icon: 'info',
                loader: true,
                loaderBg: '#9EC600'
            })
            break;

        case 'erro':
            $.toast({
                heading: 'Erro',
                text: mensagem,
                icon: 'error',
                loader: true,
                loaderBg: '#9EC600'
            })
            break;

        default:
            $.toast({
                heading: 'Sucesso',
                text: mensagem,
                icon: 'success',
                loader: true,
                loaderBg: '#9EC600'
            })
            break;
    }
}

function verificar_acao(pagina, acao) {
    var permissoes = JSON.parse($("#acoes").val());
    for (var i = 0, tam = permissoes.length; i < tam; i++) {
        if (permissoes[i].link_pag === pagina && parseInt(permissoes[i][acao]) === 1) {
            return true;
        }
    }
    return false;
}

function accBr(valor) {
    return accounting.formatMoney(valor, "", 2, ".", ",");
}