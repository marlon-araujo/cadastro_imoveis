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
                                        <th>Tipo Imóvel</th>
                                        <th>Descrição</th>
                                        <th>Tipo Campo</th>
                                        <th>Ações</th>
                                    </tr>
                                    </thead>
                                    <tbody id="dados-tabela">
                                        <?php if(!empty($consulta)){
                                            foreach($consulta as $cada){ 
                                                
                                                $alterar = verificar_acao($tabela, "alterar") ? ' <button class="btn-alterar btn btn-success btn-acoes" data-toggle="tooltip" data-placement="top" title="Alterar" data-original-title="Alterar" data-codigo="' . $cada['codigo_esp'] . '" style="padding: 5px;"><i class="mdi mdi-lead-pencil"></i></button>' : '';
                                                $excluir = verificar_acao($tabela, "excluir") ? ' <button class="btn-excluir btn btn-danger btn-acoes" data-toggle="tooltip" data-placement="top" title="Excluir" data-original-title="Excluir" data-codigo="' . $cada['codigo_esp'] . '" style="padding: 5px;"><i class="mdi mdi-delete-forever"></i></button>' : '';

                                                $tipo = $cada['tipo_esp'] == 0 ? 'Sim/Não' : 'Campo Livre';
                                                ?>
                                                <tr>
                                                    <td><?= $cada['descricao_tpi'] ?></td>
                                                    <td class='col_nome_<?= $cada["codigo_esp"] ?>'><?= $cada["descricao_esp"] ?></td>
                                                    <td><?= $tipo ?></td>
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Adicionar <?= $nome_pagina ?></h4>
            </div>
            <form id="form-modal-cadastro" action="<?= base_url($tabela . '/salvar') ?>" method="post" novalidate="novalidate" enctype="multipart/form-data">
                <div class="modal-body">

                    <input type="hidden" name="codigo_esp" id="codigo_esp" value="0" />
                
                    <div class="form-group">
                        <?php $campo = "codigo_tpi"; ?>
                        <label for="<?= $campo ?>" class="control-label">Tipo Imóvel:</label>
                        <select class="form-control" name="<?= $campo ?>" id="<?= $campo ?>">
                        <?php if(!empty($tipos_imoveis)){ ?>
                            <option value="0">Selecione</option>
                            <?php foreach($tipos_imoveis as $cada){ ?>
                                <option value="<?= $cada[$campo] ?>"><?= $cada['descricao_tpi'] ?></option>
                        <?php } }else{ ?>
                            <option value="0">Cadastre um tipo</option>
                        <?php } ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <?php $campo = "descricao_esp"; ?>
                        <label for="<?= $campo ?>" class="control-label">Descrição:</label>
                        <input type="text" class="form-control" name="<?= $campo ?>" id="<?= $campo ?>" />
                    </div>
                    
                    <div class="form-group">
                        <?php $campo = "tipo_esp"; ?>
                        <label for="<?= $campo ?>" class="control-label">Tipo Campo:</label>
                        <select class="form-control" name="<?= $campo ?>" id="<?= $campo ?>">
                            <option value="0">Sim/Não</option>
                            <option value="1">Campo Livre</option>
                        </select>
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