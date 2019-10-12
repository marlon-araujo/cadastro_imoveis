var pagina = $("#pagina").val();

$(document).ready(function(){

    $("#btn-novo").click(function(){
        $("#codigo_imo").val(0);
        $("#codigo_tpi").val(0);
        $('#form-modal-cadastro').formValidation('resetForm', true);
        $("#modal-cadastro").modal('show');
    });

    $('#form-modal-cadastro').formValidation({
            framework: 'bootstrap',
            excluded: [':disabled', ':hidden', ':not(:visible)'],
            icon: {
                valid: 'fa fa-check',
                invalid: 'fa fa-remove',
                validating: 'fa fa-trash-o'
            },
            fields: {
                codigo_tpi: {
                    validators: {
                        notEmpty: {
                            message: 'campo obrigatório'
                        }
                    }
                },
                codigo_pes: {
                    validators: {
                        notEmpty: {
                            message: 'campo obrigatório'
                        }
                    }
                },
                valor_imo: {
                    validators: {
                        notEmpty: {
                            message: 'campo obrigatório'
                        }
                    }
                },
                cep_imo: {
                    validators: {
                        notEmpty: {
                            message: 'campo obrigatório'
                        }
                    }
                },
                logradouro_imo: {
                    validators: {
                        notEmpty: {
                            message: 'campo obrigatório'
                        }
                    }
                },
                numero_imo: {
                    validators: {
                        notEmpty: {
                            message: 'campo obrigatório'
                        }
                    }
                },
                bairro_imo: {
                    validators: {
                        notEmpty: {
                            message: 'campo obrigatório'
                        }
                    }
                },
                codigo_est: {
                    validators: {
                        notEmpty: {
                            message: 'campo obrigatório'
                        }
                    }
                },
                codigo_cid: {
                    validators: {
                        notEmpty: {
                            message: 'campo obrigatório'
                        }
                    }
                }
            }
        }).on('success.form.fv', function(e) {
        e.preventDefault();

        var $form    = $(e.target),
            params   = $form.serializeArray(),
            formData = new FormData();

        $.each(params, function(i, val) {
            formData.append(val.name, val.value);
        });

        $.ajax({
            url: $form.attr('action'),
            type: 'POST',
            data: formData,
            dataType : 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                if(data.retorno){
                    buscar();
                    $("#modal-cadastro").modal('hide');
                    $('#form-modal-cadastro').formValidation('resetForm', true);
                    retorno_mensagem('Salvo');
                }else{
                    retorno_mensagem(data.mensagem, 'aviso');
                }
            },
            error: function(){
                $("#modal-cadastro").modal('hide');
                retorno_mensagem("Houve um erro com a conexão, tente novamente!", 'erro');
            }
        });
    });

    $(".numero").blur(function(){
        $('#form-modal-cadastro').formValidation('revalidateField', 'logradouro_pes')
                                 .formValidation('revalidateField', 'bairro_pes')
                                 .formValidation('revalidateField', 'codigo_cid')
                                 .formValidation('revalidateField', 'codigo_est');
    });
});

$(document).on('click', '.btn-alterar', function(){
    mostrar_carregando();
    var codigo = $(this).data('codigo');
    $("#codigo_imo").val(codigo);
    buscar_registro(codigo);
});

$(document).on('click', '.btn-detalhes', function(){
    mostrar_carregando();
    var codigo = $(this).data('codigo');
    var codigo_tpi = $(this).data('codigo_tpi');

    $("#codigo_imovel_especificacoes").val(codigo);

    //buscar as especificações
    $.ajax({
        url: base_url + 'imovel/buscar_especificacoes',
        type: 'POST',
        data: {codigo_tpi: codigo_tpi},
        dataType : 'json',
        success: function(data) {
            if(data.retorno){
                //montar campos
                var html = '';

                for(var i = 0, tam = data.dados.length; i < tam; i++){

                    html += '<div class="row">' +
                                '<div class="col-md-12">' +
                                    '<div class="form-group row">' +
                                        '<label for="campo_' + i + '" class="control-label text-left col-md-12">' + data.dados[i].descricao_esp + '</label>' +
                                        '<div class="col-md-12">';

                                        if(parseInt(data.dados[i].tipo_esp) === 1){
                                            html += '<input type="text" class="form-control" name="esp[]" id="campo_' + i + '" />';
                                        }else{
                                            html += '<select class="form-control" name="esp[]" id="campo_' + i + '">' +
                                                        '<option value="0">Não</option>' +
                                                        '<option value="1">Sim</option>' +
                                                    '</select>';
                                        }
                                            
                                    html += '</div>' +
                                    '</div>' +
                                '</div>' +
                            '</div>';
                }

                $("#div-campos-dinamicos").html(html);

                


                //buscar especificações salvas

                
                $("#modal-detalhes").modal('show');
                fechar_carregando();
            }
        }
    });

    
});

$(document).on('click', '.btn-excluir', function(){
    var codigo = $(this).data('codigo');
    var nome = $(".col_nome_" + codigo).text();
    var texto = 'Você está prestes a excluir <b>' + nome + '</b>';

    swal({
            title: "Excluir?",
            text: texto,
            html: true,
            type: "info",
            showCancelButton: true,
            //confirmButtonColor: "#18a689",
            confirmButtonText: "Excluir",
            cancelButtonText: "Cancelar",
            closeOnConfirm: true,
            allowOutsideClick: true
        },
        function() {
            $.ajax({
                url: base_url + pagina + "/excluir",
                type: 'POST',
                data: {codigo: codigo},
                dataType : 'json',
                success: function(data) {

                    if(data.retorno){
                        buscar();
                        swal("Excluido!", "success");
                    }else{
                        retorno_mensagem("Houve algum erro!", 'Erro');
                    }
                },
                error: function(){
                    retorno_mensagem("Houve um erro com a conexão, tente novamente!", 'Erro');
                }
            });
        });
});

function buscar(data){
    mostrar_carregando();

    $.ajax({
        url: base_url + pagina + "/buscar",
        type: 'POST',
        data: data,
        dataType : 'json',
        success: function(data) {
            if(data.retorno){
                monta_tabela(data.dados);
            }else{
                $("#dados-tabela").html("<tr><td colspan='3' style='text-align: center'>Nenhum registro Encontrado!</td></tr>");
                monta_tabela();
                retorno_mensagem(data.mensagem, 'Aviso');
            }
            fechar_carregando();
        },
        error: function(){
            fechar_carregando();
            $("#txt-pesquisar").focus();
            retorno_mensagem("Houve um erro com a conexão, tente novamente!", 'Erro');
        }
    });
}

function buscar_registro(codigo){
    $.ajax({
        url: base_url + pagina + "/buscar_registro",
        type: 'POST',
        data: {codigo: codigo},
        dataType : 'json',
        success: function(data) {

            if(data.retorno){
                preenche_campos(data.dados);
                $("#modal-cadastro").modal('show');
            }else{
                retorno_mensagem(data.mensagem, 'Aviso');
            }
            fechar_carregando();
        },
        error: function(){
            fechar_carregando();
            retorno_mensagem("Houve um erro com a conexão, tente novamente!", 'Erro');
        }
    });
}

function monta_tabela(dados){
    var html = "<tr><td colspan='6' style='text-align: center'>Nenhum registro Encontrado!</td></tr>";
    var tipo = "";

    if(dados !== undefined) {
        var tam  = dados.length;

        if (tam > 0) {
            html = "";

            for (var i = 0; i < tam; i++) {
                var fotos    = verificar_acao(pagina, "alterar") ? ' <button class="btn-fotos btn btn-success btn-acoes" data-toggle="tooltip" data-placement="top" title="Fotos" data-original-title="Fotos" data-codigo="' + dados[i].codigo_imo + '" style="padding: 5px;"><i class="mdi mdi-lead-camera"></i></button>' : '';
                var detalhes = verificar_acao(pagina, "alterar") ? ' <button class="btn-detalhes btn btn-success btn-acoes" data-toggle="tooltip" data-placement="top" title="Detalhes" data-original-title="Detalhes" data-codigo="' + dados[i].codigo_imo + '" data-codigo_tpi="' + dados[i].codigo_tpi + '" style="padding: 5px;"><i class="mdi mdi-bulletin-board"></i></button>' : '';
                var alterar  = verificar_acao(pagina, "alterar") ? ' <button class="btn-alterar btn btn-success btn-acoes" data-toggle="tooltip" data-placement="top" title="Alterar" data-original-title="Alterar" data-codigo="' + dados[i].codigo_imo + '" style="padding: 5px;"><i class="mdi mdi-lead-pencil"></i></button>' : '';
                var excluir  = verificar_acao(pagina, "excluir") ? ' <button class="btn-excluir btn btn-danger btn-acoes" data-toggle="tooltip" data-placement="top" title="Excluir" data-original-title="Excluir" data-codigo="' + dados[i].codigo_imo + '" style="padding: 5px;"><i class="mdi mdi-delete-forever"></i></button>' : '';

                html += "<tr>" +
                            "<td class='col_nome_" + dados[i].codigo_imo + "'>" + dados[i].nome_pes + "</td>" +
                            "<td>" + dados[i].descricao_tpi + "</td>" +
                            "<td>R$ " + accBr(dados[i].valor_imo) + "</td>" +
                            "<td>" + alterar + excluir + "</td>" +
                        "</tr>";
            }
        }
    }
    $("#dados-tabela").html(html);
}

function preenche_campos(dados){
    var codigo_est = dados[0].uf_est;
    $("#codigo_est").val(codigo_est);
    buscar_cidade(dados[0].nome_cid, codigo_est);

    $("#codigo_imo").val(dados[0].codigo_imo);
    $("#cep_imo").val(dados[0].cep_imo);
    $("#logradouro_imo").val(dados[0].logradouro_imo);
    $("#numero_imo").val(dados[0].numero_imo);
    $("#bairro_imo").val(dados[0].bairro_imo);
    $("#complemento_imo").val(dados[0].complemento_imo);

    $("#valor_imo").val(moeda(dados[0].valor_imo));
    $("#codigo_pes").val(dados[0].codigo_pes);
    $("#codigo_tpi").val(dados[0].codigo_tpi);
    $("#numeromatricula_imo").val(dados[0].numeromatricula_imo);
    $("#cadastromunicipal_imo").val(dados[0].cadastromunicipal_imo);
}