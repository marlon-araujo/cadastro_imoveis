var f = {

    funcao_ajax: function(url, type, param, dtype){
        return $.ajax({
            url: url,
            type: type,
            data: param,
            dataType : dtype
        });
    }

};

$(document).ready(function(){

    /** LOGAR */
    $('#form_logar').formValidation({
            framework: 'bootstrap',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                login: {
                    validators: {
                        notEmpty: {
                            message: 'login obrigatorio'
                        }
                    }
                },
                senha: {
                    validators: {
                        notEmpty: {
                            message: 'senha obrigatoria'
                        }
                    }
                }
            }
        }).on('success.field.fv', function(e, data) {
        data.fv.disableSubmitButtons(false);
    }).on('success.form.fv', function(e) {
        e.preventDefault();

        $('#btnEntrar').button('loading');

        var $form = $(e.target);

        $.when(f.funcao_ajax($form.attr('action'), "POST", $form.serialize(), "json")).then(function(data){
            if(data.retorno){
                location.href = data.redirect;
            }else{
                msgErro(data.msg);
                $('#btnEntrar').button('reset');
            }
        });
    });

});