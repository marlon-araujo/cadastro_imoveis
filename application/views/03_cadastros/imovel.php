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
                                        <th>Proprietário</th>
                                        <th>Tipo Imóvel</th>
                                        <th>Valor</th>
                                        <th>Ações</th>
                                    </tr>
                                    </thead>
                                    <tbody id="dados-tabela">
                                        <?php if(!empty($consulta)){
                                            foreach($consulta as $cada){ 
                                                $fotos          = verificar_acao($tabela, "alterar") ? ' <button class="btn-fotos btn btn-info btn-acoes" data-toggle="tooltip" data-placement="top" title="Fotos" data-original-title="Fotos" data-codigo="' . $cada['codigo_imo'] . '" style="padding: 5px;"><i class="mdi mdi-camera"></i></button>' : '';
                                                $especificacoes = verificar_acao($tabela, "alterar") ? ' <button class="btn-detalhes btn btn-warning btn-acoes" data-toggle="tooltip" data-placement="top" title="Detalhes" data-original-title="Detalhes" data-codigo="' . $cada['codigo_imo'] . '"  data-codigo_tpi="' . $cada['codigo_tpi'] . '" style="padding: 5px;"><i class="mdi mdi-bulletin-board"></i></button>' : '';
                                                $alterar        = verificar_acao($tabela, "alterar") ? ' <button class="btn-alterar btn btn-success btn-acoes" data-toggle="tooltip" data-placement="top" title="Alterar" data-original-title="Alterar" data-codigo="' . $cada['codigo_imo'] . '" style="padding: 5px;"><i class="mdi mdi-lead-pencil"></i></button>' : '';
                                                $excluir        = verificar_acao($tabela, "excluir") ? ' <button class="btn-excluir btn btn-danger btn-acoes" data-toggle="tooltip" data-placement="top" title="Excluir" data-original-title="Excluir" data-codigo="' . $cada['codigo_imo'] . '" style="padding: 5px;"><i class="mdi mdi-delete-forever"></i></button>' : '';
                                                ?>
                                                <tr>
                                                    <td class='col_nome_<?= $cada["codigo_imo"] ?>'><?= $cada["nome_pes"] . ' ' . $cada["sobrenome_pes"] ?></td>
                                                    <td><?= $cada['descricao_tpi'] ?></td>
                                                    <td>R$ <?= number_format($cada['valor_imo'], 2, ',', '.') ?></td>
                                                    <td><?= $fotos . $especificacoes . $alterar . $excluir ?></td>
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

                    <input type="hidden" name="codigo_imo" id="codigo_imo" value="0" />

                    <div class="form-body">
                        <h3 class="box-title">Informações Gerais</h3>
                        <hr class="m-t-0 m-b-40">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php $campo = "codigo_tpi"; ?>
                                    <label for="<?= $campo ?>" class="control-label">Tipo Imóvel:</label>
                                    <select class="form-control" name="<?= $campo ?>" id="<?= $campo ?>">
                                    <?php if(!empty($tipos_imoveis)){ ?>
                                        <option value="">Selecione</option>
                                        <?php foreach($tipos_imoveis as $cada){ ?>
                                            <option value="<?= $cada[$campo] ?>"><?= $cada['descricao_tpi'] ?></option>
                                    <?php } }else{ ?>
                                        <option value="0">Cadastre um tipo</option>
                                    <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php $campo = "codigo_pes"; ?>
                                    <label for="<?= $campo ?>" class="control-label">Proprietário:</label>
                                    <select class="form-control" name="<?= $campo ?>" id="<?= $campo ?>">
                                    <?php if(!empty($pessoas)){ ?>
                                        <option value="">Selecione</option>
                                        <?php foreach($pessoas as $cada){ ?>
                                            <option value="<?= $cada[$campo] ?>"><?= $cada['nome_pes'] . ' ' . $cada['sobrenome_pes'] ?></option>
                                    <?php } }else{ ?>
                                        <option value="0">Cadastre um Proprietário</option>
                                    <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <?php $campo = "numeromatricula_imo"; ?>
                                    <label for="<?= $campo ?>" class="control-label text-left col-md-12">Nº Matrícula</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" name="<?= $campo ?>" id="<?= $campo ?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group row">
                                    <?php $campo = "cadastromunicipal_imo"; ?>
                                    <label for="<?= $campo ?>" class="control-label text-left col-md-12">Cadastro Municipal</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" name="<?= $campo ?>" id="<?= $campo ?>" />
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <?php $campo = "valor_imo"; ?>
                                    <label for="<?= $campo ?>" class="control-label text-left col-md-12">Valor</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" name="<?= $campo ?>" maxlength="18" id="<?= $campo ?>" onkeypress="mascara(this, moeda)" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <h3 class="box-title">Endereço</h3>
                        <hr class="m-t-0 m-b-40">
                        
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group row">
                                    <?php $campo = "cep_imo"; ?>
                                    <label for="<?= $campo ?>" class="control-label text-left col-md-3">Cep</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control cep" name="<?= $campo ?>" id="<?= $campo ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group row">
                                    <?php $campo = "logradouro_imo"; ?>
                                    <label for="<?= $campo ?>" class="control-label text-left col-md-3">Logradouro</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control logradouro" name="<?= $campo ?>" id="<?= $campo ?>" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <?php $campo = "numero_imo"; ?>
                                    <label for="<?= $campo ?>" class="control-label text-left col-md-3">Nº</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control numero" name="<?= $campo ?>" id="<?= $campo ?>" />
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <?php $campo = "bairro_imo"; ?>
                                    <label for="<?= $campo ?>" class="control-label text-left col-md-3">Bairro</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control bairro" name="<?= $campo ?>" id="<?= $campo ?>" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <?php $campo = "complemento_imo"; ?>
                                    <label for="<?= $campo ?>" class="control-label text-left col-md-3">Complemento</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control complemento" name="<?= $campo ?>" id="<?= $campo ?>" />
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
                                        <select class="form-control custom-select estado" name="<?= $campo ?>" id="<?= $campo ?>">
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
                                        <select class="form-control custom-select cidade" name="<?= $campo ?>" id="<?= $campo ?>">
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

<div id="modal-detalhes" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Detalhes - <span id="spn-nome-modal"></span></h4>
            </div>
            <form id="form-modal-cadastro" action="<?= base_url($tabela . '/salvar') ?>" method="post" novalidate="novalidate" enctype="multipart/form-data">
                <div class="modal-body">

                    <input type="hidden" name="codigo_imo" id="codigo_imovel_especificacoes" value="0" />

                    <div id="div-campos-dinamicos">
                        
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