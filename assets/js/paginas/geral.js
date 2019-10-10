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

    $(".cep").blur(function() {
        var cep = $(this).val().replace(/\D/g, '');

        if (cep != "") {
            var validacep = /^[0-9]{8}$/;

            if(validacep.test(cep)) {
                $(".logradouro").val("...");
                $(".bairro").val("...");

                $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function(dados) {

                    if (!("erro" in dados)) {
                        $(".logradouro").val(dados.logradouro);
                        $(".bairro").val(dados.bairro);
                        $(".estado").val(dados.uf);
                        $(".numero").focus();

                        buscar_cidade(dados.localidade, dados.uf);

                        $('#form-modal-cadastro').formValidation('revalidateField', 'logradouro_pes')
                                                    .formValidation('revalidateField', 'bairro_pes')
                                                    .formValidation('revalidateField', 'codigo_cid')
                                                    .formValidation('revalidateField', 'codigo_est');
                    } else {
                        limpa_formulario_cep();
                    }
                });
            } else {
                limpa_formulario_cep();
            }
        } else {
            limpa_formulario_cep();
        }
    });

    $(".estado").change(function(){
        buscar_cidade('', $(this).val());
    });
});

function buscar_cidade(localidade, uf){
    $.ajax({
        url: base_url + 'pessoa/buscar_cidades',
        type: 'POST',
        data: {cidade: localidade, estado: uf},
        dataType : 'json',
        success: function(data) {
            if(data.retorno){
                var dados = data.dados;
                var html = "";
                for(var i = 0, tam = dados.length; i < tam; i++){
                    var select = dados[i].nome_cid === localidade ? 'selected' : '';
                    html += "<option value='" + dados[i].codigo_cid + "' " + select + ">" + dados[i].nome_cid + "</option>";
                }
                $(".cidade").html(html);
            }else{

            }
        }
    });
}

function limpa_formulario_cep() {
    $(".logradouro").val("");
    $(".bairro").val("");
    $(".numero").val("");
    $(".cep").val("");
    $(".complemento").val("");
    $(".estado").val(0);
    $(".cidade").html('<option value="0">Selecione um Estado</option>');
}

function mascara(o, f){
    v_obj = o;
    v_fun = f;
    setTimeout("execmascara()", 1);
}
    
function execmascara(){
    v_obj.value=v_fun(v_obj.value);
}
    
function leech(v){
    v = v.replace(/o/gi,"0");
    v = v.replace(/i/gi,"1");
    v = v.replace(/z/gi,"2");
    v = v.replace(/e/gi,"3");
    v = v.replace(/a/gi,"4");
    v = v.replace(/s/gi,"5");
    v = v.replace(/t/gi,"7");
    return v;
}
    
function soNumeros(v){
    return v.replace(/\D/g,"");
}
    
function telefone(v){
    v = v.replace(/\D/g,"");
    v = v.replace(/^(\d\d)(\d)/g,"($1) $2");
    v = v.replace(/(\d{4})(\d)/,"$1 - $2");
    return v;
}
    
function cpf(v){
    v = v.replace(/\D/g,"");
    v = v.replace(/(\d{3})(\d)/,"$1.$2");
    v = v.replace(/(\d{3})(\d)/,"$1.$2");
    v = v.replace(/(\d{3})(\d{1,2})$/,"$1-$2");
    return v;
}
    
function cep(v){
    v = v.replace(/\D/g,"");
    v = v.replace(/(\d{2})(\d)/,"$1.$2");
    v = v.replace(/(\d{3})(\d{1,3})$/,"$1-$2");
    return v;
}
    
function cnpj(v){
    v = v.replace(/\D/g,"");
    v = v.replace(/^(\d{2})(\d)/,"$1.$2");
    v = v.replace(/^(\d{2}).(\d{3})(\d)/,"$1.$2.$3");
    v = v.replace(/.(\d{3})(\d)/,".$1/$2");
    v = v.replace(/(\d{4})(\d)/,"$1-$2");
    return v;
}
    
function romanos(v){
    v = v.toUpperCase();
    v = v.replace(/[^IVXLCDM]/g,"");
    while(v.replace(/^M{0,4}(CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3})$/,"")!="");
    v = v.replace(/.$/,"");
    return v;
}
    
function data(v){
    v = v.replace(/\D/g,"");
    v = v.replace(/^(\d{2})(\d)/,"$1/$2");
    v = v.replace(/.(\d{2})(\d)/,".$1/$2");
    v = v.replace(/(\d{2})(\d)/,"$1/$2");
    return v;
}
    
function moeda(v){
    v = v.replace(/\D/g,"");
    v = v.replace(/(\d{1})(\d{15})$/,"$1.$2");
    v = v.replace(/(\d{1})(\d{11})$/,"$1.$2");
    v = v.replace(/(\d{1})(\d{8})$/,"$1.$2");
    v = v.replace(/(\d{1})(\d{5})$/,"$1.$2");
    v = v.replace(/(\d{1})(\d{1,2})$/,"$1,$2");
    return v;
}
    
