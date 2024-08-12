<div id="alerta"></div>

<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title"><b>Listagem de produtos</b></div>
        </div> <!-- panel-heading -->
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12">
                    <table class="table table-hover">
                        <tr>
                            <th class="col-xs-3">
                                <span class="glyphicon glyphicon-shopping-cart"></span> Nome</th>
                            <th class="col-xs-2">
                                <span class="glyphicon glyphicon-tags"></span> Preço</th>
                            <th class="col-xs-5">
                                <span class="glyphicon glyphicon-pencil"></span> Descrição</th>
                            <th class="col-xs-1"></th>
                            <th class="col-xs-1"></th>
                        </tr>
                        <tbody id="listarProdutos">
                        <tr>
                            <td colspan="12">Não há produtos cadastrados</td>
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
        listarProdutos();
    });

    function listarProdutos(){
        $.ajax({
            url: "<?=base_url('cliente/ajax_listarProdutos')?>",
            type: "GET",
            dataType: "json",
            success: function(data) {
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
                                <td class="col-xs-3" id="nome_${produto['id_produto']}">${produto['nome']}</td>
                                <td class="col-xs-2" id="preco_${produto['id_produto']}">R$ ` + parseFloat(produto['preco']).toFixed(2) + `</td>
                                <td class="col-xs-5" id="descricao_${produto['id_produto']}">${produto['descricao']}</td>
                                <td class="col-xs-1">
                                    <input id="quantidade_${produto['id_produto']}" class="form-control" type="number" value="1" min="1" max="${produto['estoque']}" onKeyDown="return false">
                                </td>
                                <td class="col-xs-1">
                                    <button type="button" class="btn btn-success" onclick="adicionarItemAoCarrinho(${produto['id_produto']})">
                                        <b class="glyphicon glyphicon-shopping-cart"></b> 
                                        Adicionar ao carrinho
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

    function adicionarItemAoCarrinho(id_produto){
        let id_usuario = <?= $this->session->userdata('id_usuario')?>;
        let quantidade = $('#quantidade_' + id_produto).val();

        $.ajax({
            url: "<?= base_url('cliente/ajax_adicionarItemAoCarrinho')?>",
            type: "POST",
            dataType: "json",
            data: {
                id_usuario: id_usuario,
                id_produto: id_produto,
                quantidade: quantidade
            },
            success: function(data){
                exibirAviso('Item adicionado ao carrinho', 'alerta','SUCESSO');
                quantidade_carrinho();
                listarProdutos();
            },
            error: function(){
                exibirAviso('Aconteceu um erro em nosso servidor', 'alerta');
            }
        });
    }
</script>