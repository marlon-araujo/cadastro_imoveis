<input type="hidden" id="pagina" value="<?= $tabela ?>" />

<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-content-save"></i>
                </span> <?= $nome_pagina ?> 
            </h3>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">
                        <div class="acoes-botoes">
                            <button type="button" id="btn-novo" class="btn btn-danger waves-effect waves-light">Novo</button>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>

        <div class="page-body">
            <div class="row">
                <div class="col-12">
                    <div class="card ">
                        <div class="card-body card-body-interno">
                            <div class="table-responsive m-t-40">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Telefone</th>
                                        <th>Cidade/UF</th>
                                        <th>Ações</th>
                                    </tr>
                                    </thead>
                                    <tbody id="dados-tabela">
                                        <?php if(!empty($consulta)){
                                            foreach($consulta as $cada){ 
                                                
                                                $alterar = verificar_acao($tabela, "alterar") ? ' <button class="btn-alterar btn btn-success btn-acoes" data-toggle="tooltip" data-placement="top" title="Alterar" data-original-title="Alterar" data-codigo="' . $cada['codigo_pes'] . '" style="padding: 5px;"><i class="mdi mdi-lead-pencil"></i></button>' : '';
                                                $excluir = verificar_acao($tabela, "excluir") ? ' <button class="btn-excluir btn btn-danger btn-acoes" data-toggle="tooltip" data-placement="top" title="Excluir" data-original-title="Excluir" data-codigo="' . $cada['codigo_pes'] . '" style="padding: 5px;"><i class="mdi mdi-delete-forever"></i></button>' : '';

                                                ?>
                                                <tr>
                                                    <td class='col_nome_<?= $cada["codigo_pes"] ?>'><?= $cada["nome_pes"] . ' ' . $cada['sobrenome_pes'] ?></td>
                                                    <td><?= $cada["telefone_pes"] ?></td>
                                                    <td><?= $cada["nome_cid"] . ' - ' . $cada["uf_est"] ?></td>
                                                    <td><?= $alterar . $excluir ?></td>
                                                </tr>
                                        <?php } } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
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
                                    <?php $campo = "logradouro_pes"; ?>
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
                                    <?php $campo = "numero_pes"; ?>
                                    <label for="<?= $campo ?>" class="control-label text-left col-md-3">Nº</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="<?= $campo ?>" id="<?= $campo ?>" />
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <?php $campo = "bairro_pes"; ?>
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
                                    <?php $campo = "complemento_pes"; ?>
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