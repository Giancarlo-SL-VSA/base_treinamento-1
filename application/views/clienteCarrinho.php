<div id="alerta"></div>

<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title"><b>Carrinho</b></div>
        </div> <!-- panel-heading -->
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12">
                    <table class="table table-hover">
                        <tr>
                            <th class="col-xs-3">
                                <span class="glyphicon glyphicon-shopping-cart"></span> Nome
                            </th>
                            <th class="col-xs-5">
                                <span class="glyphicon glyphicon-pencil"></span> Descrição
                            </th>
                            <th class="col-xs-1">
                                <span class="glyphicon glyphicon-tags"></span> Preço
                            </th>
                            <th class="col-xs-1">
                                <span></span>#
                            </th>
                            <th class="col-xs-1">
                            </th>
                            <th class="col-xs-1">
                            </th>
                        </tr>
                        <tbody id="listarProdutos">
                        <tr>
                            <td colspan="12">Não há items no carrinho</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div> 
            
        </div> <!-- panel-body -->
    </div> <!-- panel -->
 </div> <!-- container -->

 <script>
    $(document).ready(function() {
        listarCarrinho();
    });

    function listarCarrinho(){
        let id_usuario = <?= $this->session->userdata('id_usuario') ?>;
        $.ajax({
            url: "<?=base_url('cliente/ajax_listarCarrinho')?>",
            type: "GET",
            dataType: "json",
            data: {
                id_usuario: id_usuario
            },
            success: function(data) {
                let html = `
                    <tr>
                        <td colspan="12">
                            Não há items no carrinho
                        </td>
                    </tr>
                `;
                if (data.length > 0) {
                    html = '';
                    data.forEach(item => {                       
                        html += `
                            <tr id="tr_produto${item['id_carrinho_item']}">
                                <td class="col-xs-3" id="nome_${item['id_carrinho_item']}">${item['nome']}</td>
                                <td class="col-xs-4" id="descricao_${item['id_carrinho_item']}">${item['descricao']}</td>
                                <td class="col-xs-1" id="preco_${item['id_carrinho_item']}">R$ ${item['preco']}</td>
                                <td class="col-xs-1" id="quantidade_${item['id_carrinho_item']}">${item['quantidade']}
                                    <span id="estoque_${item['id_carrinho_item']}" style="display:none">${item['estoque']}
                                    </span>
                                </td>
                                <td class="col-xs-1 input-group">
                                    <div class="input-group-btn">
                                        <button class="btn btn-default" onclick="alterarQuantidade(${item['id_carrinho_item']}, -1)">
                                            <i class="glyphicon glyphicon-minus"></i>
                                        </button>
                                        <button class="btn btn-default" onclick="alterarQuantidade(${item['id_carrinho_item']}, 1)">
                                            <i class="glyphicon glyphicon-plus"></i>
                                        </button>
                                    </div>
                                </td>
                                <td class="col-xs-1">
                                    <button class="btn btn-danger" onclick="removerProduto(${item['id_carrinho_item']})">
                                        <i class="glyphicon glyphicon-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                    html += `
                        <tr>
                            <td colspan="4">
                            </td>
                            <td colspan="2">
                                <button class="btn btn-success" onclick="comprar()">Comprar</button>
                            </td>
                        </tr>
                    `;
                }
                // Atualiza o conteúdo da tabela com os usuários ou a mensagem de "Não há usuários cadastrados"
                $("#listarProdutos").html(html);
                quantidade_carrinho();
            },
            error: function() {
                // Exibe uma mensagem de erro em caso de falha na comunicação com o servidor
                exibirAviso('Aconteceu um erro em nosso servidor', 'alerta');
            }
        });
    }

    function alterarQuantidade(id_carrinho_item, valor){
        let quantidade = parseInt($('#quantidade_'+id_carrinho_item).text());
        let estoque = parseInt($('#estoque_'+id_carrinho_item).text());

        if (quantidade + valor <= 0) return;

        if (quantidade + valor > estoque) return;

        $.ajax({
            url: "<?= base_url('cliente/ajax_alterarQuantidade')?>",
            type: "POST",
            dataType: "json",
            data: {
                id_carrinho_item: id_carrinho_item,
                valor: valor
            },
            success: function(data){
                if(data){
                    listarCarrinho();
                    return;
                }
                exibirAviso('Aconteceu um erro em nosso servidor', 'alerta');
            },
            error: function(){
                exibirAviso('Aconteceu um erro em nosso servidor', 'alerta');
            }
        });
    }

    function removerProduto(id_carrinho_item){
        if(confirm('CONFIRME A REMOÇÃO DO PRODUTO'))
        $.ajax({
            url: "<?= base_url('cliente/ajax_removerProduto')?>",
            type: "POST",
            dataType: "json",
            data: {
                id_carrinho_item: id_carrinho_item
            },
            success: function(data){
                if(data){
                    exibirAviso('Produto removido', 'alerta', 'SUCESSO');
                    listarCarrinho();
                } else {
                    exibirAviso('Aconteceu um erro em nosso servidor', 'alerta');
                }
            },
            error: function(){
                exibirAviso('Aconteceu um erro em nosso servidor', 'alerta');
            }
        });
    }

    function comprar(){
        let id_usuario = "<?= $this->session->userdata('id_usuario') ?>"
        $.ajax({
            url: "<?= base_url('cliente/ajax_comprar')?>",
            type: "POST",
            dataType: "json",
            data:{
                id_usuario: id_usuario
            },
            success: function (data){
                exibirAviso('Compra realizada', 'alerta', 'SUCESSO');
                listarCarrinho();
            },
            error: function(){
                exibirAviso('Aconteceu um erro em nosso servidor', 'alerta');
            }
        });
    }
</script>