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

function formata_moeda(i) {
	var v = i.value.replace(/\D/g,'');
	v = (v/100).toFixed(2) + '';
	v = v.replace(".", ",");
	v = v.replace(/(\d)(\d{3})(\d{3}),/g, "$1.$2.$3,");
	v = v.replace(/(\d)(\d{3}),/g, "$1.$2,");
	i.value = v;
}

function formata_taxa(i) {
	var v = i.value.replace(/\D/g,'');
	v = (v/100).toFixed(2) + '';
	//v = v.replace(".", ".");
	v = v.replace(/(\d)(\d{3})(\d{3}),/g, "$1.$2.$3,");
	v = v.replace(/(\d)(\d{3}),/g, "$1.$2,");
	i.value = v;
}

function toDateBR(data){
    if(data !== "" && data !== null && data !== undefined){
        var arr = data.split('-');
        return arr[2] + '/' + arr[1] + '/' + arr[0];
    }
    return '---';
}

$(document).ready(function(){

    //$("#example23").DataTable();
    
    $(".moeda").keyup(function(){
        var valor = formata_moeda($(this).val());
        $(this).val(valor);
    });
    
    $(".cep").mask("99999-999"); 
    $(".cpf").mask("999.999.999-99");
    $(".data").mask("99/99/9999");
    $(".celular").mask("(99)99999-9999");
    $(".telefone").mask("(99) 9999-9999");
    $(".data_hora").mask("99/99/9999 99:99:99");
    $(".hora").mask("99:99");
    $(".cnpj").mask("99.999.999/9999-99");
});