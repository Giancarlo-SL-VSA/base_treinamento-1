<div id="alerta"></div>

<div class="container">
    <div class="col-xs-8"></div>
    <div class="from-group col-xs-2">
        <input id="data_inicial" class="form-control" type="date" onchange="listarVendas()">
    </div>
    <div class="from-group col-xs-2">
        <input id="data_final" class="form-control" type="date" onchange="listarVendas()">
    </div>
</div>
<br>
<div class="container">    
    <div class="panel panel-default lista">
        <div class="panel-heading">
            <div class="panel-title"><b>Listagem de produtos</b>
            </div>
        </div> <!-- panel-heading -->
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12">
                    <table class="table table-hover">
                        <tr>
                            <th class="col-xs-5">
                                <span class="glyphicon glyphicon-shopping-cart"></span> Produto</th>
                            <th class="col-xs-5">
                                <span class="glyphicon glyphicon-user"></span> Cliente</th>
                            <th class="col-xs-1">
                                <span class="glyphicon glyphicon-tags"></span> Valor</th>
                            <th class="col-xs-1">
                                <span class="glyphicon glyphicon-calendar"></span> Data</th>
                        </tr>
                        <tbody id="listarVendas">
                        <tr>
                            <td colspan="12">Nenhuma venda foi realizada</td>
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
        listarVendas();
    });

    function listarVendas(){
        let id_usuario = "<?= $this->session->userdata('id_usuario') ?>";
        let data_inicial = $('#data_inicial').val();
        let data_final = $('#data_final').val();

        console.log(data_inicial);
        console.log(data_final);

        $.ajax({
            url: "<?=base_url('loja/ajax_listarVendas')?>",
            type: "GET",
            dataType: "json",
            data: {
                id_usuario: id_usuario,
                data_inicial: data_inicial,
                data_final: data_final
            },
            success: function(data) {
                if(!data)return;

                let html = `
                    <tr>
                        <td colspan="12">
                            Nenhuma venda foi realizada
                        </td>
                    </tr>
                `;
                if (data.length > 0) {
                    html = '';
                    data.forEach(venda => {
                        let data = new Date(venda['data']);
                        let dia = data.getDate();
                        let mes = data.getMonth() + 1;
                        let ano = data.getFullYear();
                        dia = dia < 10 ? '0' + dia : dia;
                        mes = mes < 10 ? '0' + mes : mes;
                        data = `${dia}/${mes}/${ano}`;
                        html += `
                            <tr id="tr_produto${venda['id_produto']}">
                                <td class="col-xs-5" id="produto_${venda['id_produto']}">${venda['produto']}</td>
                                <td class="col-xs-5" id="cliente_${venda['id_produto']}">${venda['cliente']}</td>
                                <td class="col-xs-1" id="valor_${venda['id_produto']}">R$ ` + parseFloat(venda['valor']).toFixed(2) + `</td>
                                <td class="col-xs-1" id="data_${venda['id_produto']}">`+ data +`</td>
                            </tr>
                        `;
                    });
                }
                // Atualiza o conteúdo da tabela com os usuários ou a mensagem de "Não há usuários cadastrados"
                $("#listarVendas").html(html);
            },
            error: function() {
                // Exibe uma mensagem de erro em caso de falha na comunicação com o servidor
                exibirAviso('Aconteceu um erro em nosso servidor', 'alerta');
            }
        });
    }
 </script>