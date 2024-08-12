<style>
    .modal{
        margin-top: 2%;
        margin-left: auto;
        margin-right: auto;
    }
</style>

<!-- alerta -->
<div id="alerta"></div>

<!-- Modal de atualização de produto -->
<div class="modal fade modal-lg" id="modalEditarProduto" tabindex="-1" role="dialog">
    <div class="modal-content">
        <div class="modal-header">
            <div id="alerta-modal"></div>
            <h4 class="modal-title">Editar produto</h4>
        </div> <!-- modal-header -->
        <div class="modal-body">
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-6">
                        <div class="row">
                            <div class="col-xs-12">
                                <label for="nomeEditar"><span class = "glyphicon glyphicon-shopping-cart"></span> Nome do produto</label>
                                <input class="form-control" placeholder="Nome do produto" id="nomeEditar" value="a" maxlength="255" size="20" required autofocus>
                            </div>
                        </div> <!-- Linha [1,1] -->
                        <br>
                        <div class="row">
                            <div class="col-xs-6">
                                <label for="custoEditar"><span class = "glyphicon glyphicon-usd"></span> Custo</label>
                                <input class="form-control" placeholder="Custo" id="custoEditar" type="number" min="0" onkeydown="return false" required autofocus>
                            </div>
                            <div class="col-xs-6">
                                <label for="precoEditar"><span class = "glyphicon glyphicon-tags"></span> Preço</label>
                                <input class="form-control" placeholder="Preço" id="precoEditar" type="number" min="0" onkeydown="return false" required autofocus>
                            </div>                            
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-xs-6">
                                    <label for="estoqueEditar"><span class = "glyphicon glyphicon-inbox"></span> Estoque</label>
                                    <input class="form-control" placeholder="Estoque" id="estoqueEditar" type="number" min="0" onkeydown="return false" required autofocus>
                            </div>
                            <div class="col-xs-6">
                                <label for="cadastrarEditar"><span style="visibility:hidden" id="id_produto">A</span> </label><br>
                                <button type="button" class="btn btn-primary col-xs-12" id="cadastrarEditar" onclick="editarProduto()">Alterar</button>
                            </div>
                        </div> <!-- Linha [1,2] -->
                    </div> <!-- col 1-4 -->
                    <div class="col-xs-6">
                        <label for="descricaoEditar"><span class="glyphicon glyphicon-pencil"></span> Descrição</label>
                        <textarea class="form-control" placeholder="Descrição" rows="9" id="descricaoEditar" maxlength="255" required autofocus></textarea>
                    </div> <!-- col 5-12 -->
                </div> <!-- Linha [1] -->
            </div>
        </div> <!-- modal-body -->
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        </div> <!-- modal-footer -->
    </div> <!-- modal-content -->
</div> <!-- modal -->

<!-- Modal de inserção de produto -->
<div class="modal fade modal-lg" id="modalInserirProduto" tabindex="-1" role="dialog">
    <div class="modal-content">
        <div class="modal-header">
            <div id="alerta-modal"></div>
            <h4 class="modal-title">Cadastrar produto</h4>
        </div> <!-- modal-header -->
        <div class="modal-body">
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-6">
                        <div class="row">
                            <div class="col-xs-12">
                                <label for="nomeInserir"><span class = "glyphicon glyphicon-shopping-cart"></span> Nome do produto</label>
                                <input class="form-control" placeholder="Nome do produto" id="nomeInserir" type="text" maxlength="255" size="20" required autofocus>
                            </div>
                        </div> <!-- Linha [1,1] -->
                        <br>
                        <div class="row">
                            <div class="col-xs-6">
                                <label for="custoInserir"><span class = "glyphicon glyphicon-usd"></span> Custo</label>
                                <input class="form-control" placeholder="Custo" id="custoInserir" type="number" required autofocus>
                            </div>
                            <div class="col-xs-6">
                                <label for="precoInserir"><span class = "glyphicon glyphicon-tags"></span> Preço</label>
                                <input class="form-control" placeholder="Preço" id="precoInserir" type="number" required autofocus>
                            </div>                            
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-xs-6">
                                    <label for="estoqueInserir"><span class = "glyphicon glyphicon-inbox"></span> Estoque</label>
                                    <input class="form-control" placeholder="Estoque" id="estoqueInserir" type="number" required autofocus>
                            </div>
                            <div class="col-xs-6">
                                <label for="cadastrarInserir"><span style="visibility:hidden">A</span></label>
                                <button type="button" class="btn btn-primary col-xs-12" id="cadastrarInserir" onclick="cadastrarProduto()">Cadastrar</button>
                            </div>
                        </div> <!-- Linha [1,2] -->
                    </div> <!-- col 1-4 -->
                    <div class="col-xs-6">
                        <label for="descricaoInserir"><span class="glyphicon glyphicon-pencil"></span> Descrição</label>
                        <textarea class="form-control" placeholder="Descrição" rows="9" id="descricaoInserir" maxlength="255" required autofocus></textarea>
                    </div> <!-- col 5-12 -->
                </div> <!-- Linha [1] -->
            </div>
        </div> <!-- modal-body -->
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        </div> <!-- modal-footer -->
    </div> <!-- modal-content -->
</div> <!-- modal -->

<!-- Formulário de listagem de produtos -->
 <div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <button type="button" class="close" data-toggle="modal" data-target="#modalInserirProduto"><span class="glyphicon glyphicon-plus" data-toggle="tooltip" title="Inserir novo produto"></span></button>
            <div class="panel-title"><b>Listagem de produtos</b></div>
        </div> <!-- panel-heading -->
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12">
                    <table class="table table-hover">
                        <tr>
                            <th class="col-xs-2">
                                <span class="glyphicon glyphicon-shopping-cart"></span> Nome</th>
                            <th class="col-xs-1">
                                <span class="glyphicon glyphicon-usd"></span> Custo</th>
                            <th class="col-xs-1">
                                <span class="glyphicon glyphicon-tags"></span> Preço</th>
                            <th class="col-xs-1">
                                <span class="glyphicon glyphicon-inbox"></span> Estoque</th>
                            <th class="col-xs-6">
                                <span class="glyphicon glyphicon-pencil"></span> Descrição</th>
                            <th class="col-xs-1">
                                <span class="glyphicon glyphicon-cog"></span> Opções</th>
                        </tr>
                        <tbody id="listarProdutos">
                        <tr>
                            <td colspan="5">Não há produtos cadastrados.</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div> 
        </div> <!-- panel-body -->
    </div> <!-- panel -->
 </div> <!-- container-fluid -->


<script>
    $(document).ready(function() {
        listarProdutos();
    });

    function listarProdutos(){
        let id_usuario = "<?= $this->session->userdata('id_usuario')?>";

        $.ajax({
            url: "<?=base_url('loja/ajax_listarProdutos')?>",
            type: "GET",
            dataType: "json",
            cache: false,
            data: {
                id_usuario: id_usuario
            },
            success: function(data) {
                if(!data) return;
                let html = `
                    <tr>
                        <td colspan="12">
                            Não há produtos cadastrados
                        </td>
                    </tr>
                `;
                if (data.length > 0) {
                    html = '';
                    data.forEach(produto => {                       
                        html += `
                            <tr id="tr_produto${produto['id_produto']}">
                                <td class="col-xs-2" id="nome_${produto['id_produto']}">${produto['nome']}</td>
                                <td class="col-xs-1" id="custo_${produto['id_produto']}">${produto['custo']}</td>
                                <td class="col-xs-1" id="preco_${produto['id_produto']}">${produto['preco']}</td>
                                <td class="col-xs-1" id="estoque_${produto['id_produto']}">${produto['estoque']}</td>
                                <td class="col-xs-5" id="descricao_${produto['id_produto']}">${produto['descricao']}</td>
                                <td class="col-xs-1">
                                    <button type="button" class="btn btn-danger" onclick="deletarProduto(${produto['id_produto']})" data-toggle="tooltip" title="Excluir produto">
                                        <i class="glyphicon glyphicon-trash"></i>
                                    </button>
                                    <button type="button" class="btn btn-default" onclick="abrirModalEdicao(${produto['id_produto']})" data-toggle="tooltip" title="Editar produto">
                                        <i class="glyphicon glyphicon-pencil"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                }

                // Atualiza o conteúdo da tabela com os usuários ou a mensagem de "Não há usuários cadastrados"
                $("#listarProdutos").html(html);
            },
            error: function() {
                // Exibe uma mensagem de erro em caso de falha na comunicação com o servidor
                exibirAviso('Aconteceu um erro em nosso servidor', 'alerta');
            }
        });
    }

    function cadastrarProduto(){
        let id_usuario_loja = "<?= $this->session->userdata('id_usuario') ?>";
        let nome = $("#nomeInserir").val();
        let custo = $("#custoInserir").val();
        let preco = $("#precoInserir").val();
        let estoque = $("#estoqueInserir").val();
        let descricao = $("#descricaoInserir").val();

        if(!nome ?? false){
            exibirAviso('Nome inválido!','alerta-modal');
            return;
        }
        if(!custo ?? false){
            exibirAviso('Custo inválido!','alerta-modal');
            return;
        }
        if(!preco ?? false){
            exibirAviso('Preço inválido!','alerta-modal');
            return;
        }
        if(!estoque ?? false){
            exibirAviso('Estoque inválido!','alerta-modal');
            return;
        }
        if(!descricao ?? false){
            exibirAviso('Descrição inválido!','alerta-modal');
            return;
        }

        $.ajax({
            url: "<?=base_url('loja/ajax_cadastrarProduto')?>",
            type: "POST",
            dataType: "json",
            data: {
                id_usuario_loja: id_usuario_loja,
                nome: nome,
                custo: custo,
                preco: preco,
                estoque: estoque,
                descricao: descricao
            },
            cache: false,
            success: function(data){
                if(data.sucesso){
                    $("#nomeInserir").val('');
                    $("#custoInserir").val('');
                    $("#precoInserir").val('');
                    $("#estoqueInserir").val('');
                    $("#descricaoInserir").val('');
                    exibirAviso('Produto cadastrado com sucesso!', 'alerta-modal', 'SUCESSO');
                    listarProdutos();
                } else {
                    exibirAviso('Aconteceu um erro em nosso servidor', 'alerta-modal');
                }
            },
            error: function() {
                exibirAviso('Aconteceu um erro em nosso servidor', 'alerta-modal');
            }
        });
    }

    function editarProduto(){
        let id_produto = $('#id_produto').text();
        let nome = $('#nomeEditar').val();
        let custo = $('#custoEditar').val();
        let preco = $('#precoEditar').val();
        let estoque = $('#estoqueEditar').val();
        let descricao = $('#descricaoEditar').val();

        $.ajax({
            url: "<?= base_url('loja/ajax_editarProduto')?>",
            type: "POST",
            dataType: "json",
            data: {
                id_produto: id_produto,
                nome: nome,
                custo: custo,
                preco: preco,
                estoque: estoque,
                descricao: descricao
            },
            cache: false,
            success: function(data){
                exibirAviso('Produto atualizado com sucesso!','alerta-modal','SUCESSO');
                listarProdutos();
            },
            error: function(){
                exibirAviso('Aconteceu um erro em nosso servidor', 'alerta-modal');
            }
        });
    }

    function deletarProduto(id_produto){
        if(confirm('Tem certeza de que deseja deletar este produto?')){
            $.ajax({
                url: "<?= base_url('loja/ajax_deletarProduto')?>",
                type: "POST",
                dataType: "json",
                data: {
                    id_produto: id_produto
                },
                cache: false,
                success: function(data){
                    if(data){
                        exibirAviso('Produto excluido com sucesso!','alerta','SUCESSO');
                        listarProdutos();
                    } else {
                        exibirAviso('Esse produto não pode ser excluído porque já possui registro de compra', 'alerta');
                    }
                },
                error: function(){
                    exibirAviso('Aconteceu um erro em nosso servidor', 'alerta');
                }
            });
        }
    }

    function abrirModalEdicao(id_produto){
        $("#modalEditarProduto").modal("show").data("id_produto", id_produto);

        $('#nomeEditar').val($('#nome_' + id_produto).text());
        $('#custoEditar').val($('#custo_'+ id_produto).text());
        $('#precoEditar').val($('#preco_'+ id_produto).text());
        $('#estoqueEditar').val($('#estoque_'+ id_produto).text());
        $('#descricaoEditar').val($('#descricao_'+ id_produto).text());
        $('#id_produto').text(id_produto);
    }
</script>