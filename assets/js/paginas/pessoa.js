var pagina = $("#pagina").val();

$(document).ready(function(){

    $("#btn-novo").click(function(){
        $("#codigo_esp").val(0);
        $("#codigo_tpi").val(0);
        $("#tipo_esp").val(0);
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
                nome_pes: {
                    validators: {
                        notEmpty: {
                            message: 'campo obrigatório'
                        }
                    }
                },
                telefone_pes: {
                    validators: {
                        notEmpty: {
                            message: 'campo obrigatório'
                        }
                    }
                },
                data_pes: {
                    validators: {
                        notEmpty: {
                            message: 'campo obrigatório'
                        }
                    }
                },
                cep_pes: {
                    validators: {
                        notEmpty: {
                            message: 'campo obrigatório'
                        }
                    }
                },
                logradouro_pes: {
                    validators: {
                        notEmpty: {
                            message: 'campo obrigatório'
                        }
                    }
                },
                numero_pes: {
                    validators: {
                        notEmpty: {
                            message: 'campo obrigatório'
                        }
                    }
                },
                bairro_pes: {
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
    $("#codigo_esp").val(codigo);
    buscar_registro(codigo);
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
                        swal("Excluído!");
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
                var alterar = verificar_acao(pagina, "alterar") ? ' <button class="btn-alterar btn btn-success btn-acoes" data-toggle="tooltip" data-placement="top" title="Alterar" data-original-title="Alterar" data-codigo="' + dados[i].codigo_pes + '" style="padding: 5px;"><i class="mdi mdi-lead-pencil"></i></button>' : '';
                var excluir = verificar_acao(pagina, "excluir") ? ' <button class="btn-excluir btn btn-danger btn-acoes" data-toggle="tooltip" data-placement="top" title="Excluir" data-original-title="Excluir" data-codigo="' + dados[i].codigo_pes + '" style="padding: 5px;"><i class="mdi mdi-delete-forever"></i></button>' : '';

                html += "<tr>" +
                            "<td class='col_nome_" + dados[i].codigo_pes + "'>" + dados[i].nome_pes + " " + dados[i].sobrenome_pes + "</td>" +
                            "<td>" + dados[i].telefone_pes + "</td>" +
                            "<td>" + dados[i].nome_cid + " - " + dados[i].uf_est + "</td>" +
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

    $("#codigo_pes").val(dados[0].codigo_pes);
    $("#nome_pes").val(dados[0].nome_pes);
    $("#sobrenome_pes").val(dados[0].sobrenome_pes);
    $("#telefone_pes").val(dados[0].telefone_pes);
    $("#email_pes").val(dados[0].email_pes);
    $("#cep_pes").val(dados[0].cep_pes);
    $("#logradouro_pes").val(dados[0].logradouro_pes);
    $("#numero_pes").val(dados[0].numero_pes);
    $("#bairro_pes").val(dados[0].bairro_pes);
    $("#complemento_pes").val(dados[0].complemento_pes);
    $("#data_pes").val(toDateBR(dados[0].data_pes));
}