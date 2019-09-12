<input type="hidden" id="pagina" value="<?= $tabela ?>" />

<div class="row page-titles">
    <!--<div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Dashboard</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </div>
    <div class="col-md-7 col-4 align-self-center">
        <div class="d-flex m-t-10 justify-content-end">
            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                <div class="chart-text m-r-10">
                    <h6 class="m-b-0"><small>THIS MONTH</small></h6>
                    <h4 class="m-t-0 text-info">$58,356</h4>
                </div>
            </div>
        </div>
    </div>-->
</div>


<div class="row">
    <div class="col-12">
        <div class="card ">
            <div class="card-body card-body-interno">
                <div class="ribbon ribbon-default ribbon-titulo-interno"><?= $nome_pagina ?></div>
                <div class="acoes-botoes">
                    <button type="button" id="btn-novo" class="btn btn-danger waves-effect waves-light"><span class="btn-label"><i class="fa fa-save"></i></span>Novo</button>
                </div>
                <div class="table-responsive m-t-40">
                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Telefone</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody id="dados-tabela">
                            <?php if(!empty($consulta)){
                                foreach($consulta as $cada){ 
                                    
                                    $detalhar = verificar_acao($tabela, "detalhar") ? ' <button class="btn-historico btn btn-info btn-acoes" data-toggle="tooltip" data-placement="top" title="Histórico" data-original-title="Histórico" data-codigo="' . $cada['codigo_pes'] . '" data-nome="' . $cada['nome_pes'] . '"><i class="mdi mdi-all-inclusive"></i></button>' : '';
                                    $alterar = verificar_acao($tabela, "alterar") ? ' <button class="btn-alterar btn btn-success btn-acoes" data-toggle="tooltip" data-placement="top" title="Alterar" data-original-title="Alterar" data-codigo="' . $cada['codigo_pes'] . '"><i class="mdi mdi-lead-pencil"></i></button>' : '';
                                    $excluir = verificar_acao($tabela, "excluir") ? ' <button class="btn-excluir btn btn-danger btn-acoes" data-toggle="tooltip" data-placement="top" title="Excluir" data-original-title="Excluir" data-codigo="' . $cada['codigo_pes'] . '"><i class="mdi mdi-delete-forever"></i></button>' : '';

                                    ?>
                                    <tr>
                                        <td class='col_nome_<?= $cada["codigo_pes"] ?>'><?= $cada["nome_pes"] ?></td>
                                        <td><?= $cada["telefone_pes"] ?></td>
                                        <td><?= $detalhar . $alterar . $excluir ?></td>
                                    </tr>
                            <?php } } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modal-cadastro" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Adicionar <?= $nome_pagina ?></h4>
            </div>
            <form id="form-modal-cadastro" action="<?= base_url($tabela . '/salvar') ?>" method="post" novalidate="novalidate" enctype="multipart/form-data">
                <div class="modal-body">

                    <input type="hidden" name="codigo_pes" id="codigo_pes" value="0" />

                    <div class="form-body">
                        <h3 class="box-title">Informações Pessoais</h3>
                        <hr class="m-t-0 m-b-40">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <?php $campo = "nome_pes"; ?>
                                    <label for="<?= $campo ?>" class="control-label text-left col-md-3">Nome</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="<?= $campo ?>" id="<?= $campo ?>" />
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <?php $campo = "telefone_pes"; ?>
                                    <label for="<?= $campo ?>" class="control-label text-left col-md-3">Telefone</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control celular" name="<?= $campo ?>" id="<?= $campo ?>" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <?php $campo = "responsavel_pes"; ?>
                                    <label for="<?= $campo ?>" class="control-label text-left col-md-3">Responsável</label>
                                    <div class="col-md-9">
                                        <select id="<?= $campo ?>" name="<?= $campo ?>" class="form-control" data-live-search="true">
                                            <?php if(!empty($consulta)){ ?>
                                                <option value="0">Selecione</option>
                                                <?php foreach($consulta as $cada){ ?>
                                            <option value="<?= $cada['codigo_pes'] ?>"><?= $cada['nome_pes'] ?></option>
                                            <?php } }else{ ?>
                                                <option value="0">Nenhum Cliente Cadastrado!</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <?php $campo = "email_pes"; ?>
                                    <label for="<?= $campo ?>" class="control-label text-left col-md-3">E-mail</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="<?= $campo ?>" id="<?= $campo ?>" />
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <?php $campo = "data_pes"; ?>
                                    <label for="<?= $campo ?>" class="control-label text-left col-md-6">Data Nascimento</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control data" name="<?= $campo ?>" id="<?= $campo ?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <h3 class="box-title">Endereço</h3>
                        <hr class="m-t-0 m-b-40">
                        
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group row">
                                    <?php $campo = "cep_pes"; ?>
                                    <label for="<?= $campo ?>" class="control-label text-left col-md-3">Cep</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control cep" name="<?= $campo ?>" id="<?= $campo ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group row">
                                    <?php $campo = "cep_pes"; ?>
                                    <label for="<?= $campo ?>" class="control-label text-left col-md-3">Logradouro</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="<?= $campo ?>" id="<?= $campo ?>" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <?php $campo = "cep_pes"; ?>
                                    <label for="<?= $campo ?>" class="control-label text-left col-md-3">Nº</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="<?= $campo ?>" id="<?= $campo ?>" />
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <?php $campo = "cep_pes"; ?>
                                    <label for="<?= $campo ?>" class="control-label text-left col-md-3">Bairro</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="<?= $campo ?>" id="<?= $campo ?>" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <?php $campo = "cep_pes"; ?>
                                    <label for="<?= $campo ?>" class="control-label text-left col-md-3">Complemento</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="<?= $campo ?>" id="<?= $campo ?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <?php $campo = "codigo_est"; ?>
                                    <label for="<?= $campo ?>" class="control-label text-left col-md-3">Estado</label>
                                    <div class="col-md-9">
                                        <select class="form-control custom-select" name="<?= $campo ?>" id="<?= $campo ?>">
                                            <option value="0">Selecione</option>
                                            <?php foreach($estados as $estado){ ?>
                                                <option value="<?= $estado["uf_est"] ?>" <?= ($estado["uf_est"] == "SP" ? 'selected' : '') ?>><?= $estado["nome_est"] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <?php $campo = "codigo_cid"; ?>
                                    <label for="<?= $campo ?>" class="control-label text-left col-md-3">Cidade</label>
                                    <div class="col-md-9">
                                        <select class="form-control custom-select" name="<?= $campo ?>" id="<?= $campo ?>">
                                            <option value="0">Selecione</option>
                                            <?php foreach($cidades as $cidade){ ?>
                                                <option value="<?= $cidade["codigo_cid"] ?>" <?= ($cidade["codigo_cid"] == 5148 ? 'selected' : '') ?>><?= $cidade["nome_cid"] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger waves-effect waves-light">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modal-historico" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="nome-modal-historico">Carregando...</h4>
            </div>
            
            <div class="modal-body">
                <table class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Hora</th>
                            <th>Profissional</th>
                            <th>Forma de Pgto</th>
                            <th>Serviço</th>
                            <th>Detalhe</th>
                        </tr>
                    </thead>
                    <tbody id="dados-tabela-historico">
                            
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>