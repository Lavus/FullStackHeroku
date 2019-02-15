<?php
    require("conexao.php");
    $query = "SELECT clientes.id_cliente, clientes.nome_cliente FROM clientes ORDER by clientes.id_cliente";
    $result = $mysqli->query($query);        
    $cliente = $result->fetch_all(MYSQLI_ASSOC);
    $query = "SELECT produtos.id_produto, produtos.nome_produto, produtos.preco_unitario_produto, produtos.multiplo_produto FROM produtos ORDER by produtos.id_produto";
    $result = $mysqli->query($query);        
    $produto = $result->fetch_all(MYSQLI_ASSOC);
?>
<script type="text/javascript">
var produto = <?php echo json_encode($produto) ?>;
var backup_inner = "";
var backup_inner_id = "";
var alter_order_id = "";
//~ alert( produto[6]['preco_unitario_produto'] );
</script>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <style>
            table, td, th {
                border: 1px solid black;
            }
            td {
                text-align:center;
            }
        </style>
        <script>
        $(document).ready(function(){
          $('#cadastro_pedido').submit(function(ev){
            //~ alert(document.getElementById("rentabilidade").style.backgroundColor);
            if (document.getElementById("rentabilidade").style.backgroundColor == 'red'){
                alert("Não é permitido cadastrar pedidos com a rentabilidade ruim \n por favor aumente o preço se deseja cadastrar o pedido");
                document.getElementById("price").focus();
                return false;
            }
            ev.preventDefault();
            //~ alert("Submitted");
            var dados = $('#cadastro_pedido').serialize();
            //~ alert(dados);
            
            var xhttp;    
            if (dados == "") {
                document.getElementById("txtHint").innerHTML = "";
                return;
            }
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("txtHint").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "cadastro_pedido.php?"+dados, true);
            xhttp.send();
          });
        });
        </script>
        <title>Full Stack</title>
    </head>
    <body>
        <form id="cadastro_pedido" action="" method="GET">
            <table style="width:100%;">
                <tr>
                    <th>Nome do cliente</th>
                    <th>Nome do produto</th>
                    <th>Preço unitario</th>
                    <th>Rentabilidade do pedido</th>
                    <th>Quantidade de produtos</th>
                    <th>Concluir pedido</th>
                </tr>
                <tr>
                    <td>                    
                        <select name='cliente' required="required" onchange="showCustomer(this.value)">
                            <option value="">Selecione um cliente:</option>
                            <?php
                                for ($contador = 0; $contador < count($cliente); $contador++) {
                                    printf ("<option value='%d'>%s</option>", $cliente[$contador]['id_cliente'], $cliente[$contador]['nome_cliente']);
                                }
                            ?>
                        </select> 
                    </td>
                    <td>
                        <select id='product' name='produto' required="required" onchange="showprice(this.value,'')">
                            <option value="">Selecione um produto:</option>
                            <?php
                                $contador = 0;
                                while( $contador < count($produto)){
                                    printf ("<option value='%d'>%s</option>", $produto[$contador]["id_produto"], $produto[$contador]["nome_produto"]);
                                    $contador++;
                                }
                            ?>
                        </select> 
                    </td>
                    <td>
                        <input id="price" required="required" type="number" step=0.01 name="preco" min="0.01" value="0.01" onkeyup="showrentability(this.value,'')" onchange="showrentability(this.value,'')">
                    </td>
                    <td>
                        <div id="rentabilidade">
                            Rentabilidade ...
                        </div>
                    </td>
                    <td>
                        <input type="number" step=1 id="amount" required="required" min="1" name="quantidade" value="1">
                    </td>
                    <td>
                        <input type="submit" value="Submit">
                    </td>
                </tr>
            </table> 
        </form> 
        <form id='altera_pedido'>
            <div id="txtHint">Informações dos pedidos do cliente selecionado serão mostradas aqui ...</div>
            <input type="submit" style="visibility:hidden" value="Submit">
        </form>
        <script>
            function alter_table(int) {
                if ((backup_inner != "") && (backup_inner_id != "")){
                    document.getElementById(backup_inner_id).innerHTML = backup_inner;
                }
                var id = "txt"+int;
                backup_inner_id = id;
                backup_inner = document.getElementById(id).innerHTML;
                var xhttp;
                xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById(id).innerHTML = this.responseText;
                    }
                };
                xhttp.open("GET", "change_table.php?pedido="+int, true);
                xhttp.send();
            }
            function alter_order(int) {
                alter_order_id = int;
            }
            function exclude_order(int) {
                if (confirm('Tem certeza que quer excluir este pedido?')) {
                    //~ alert("yes");
                    var id = "txt"+int;
                    var xhttp;    
                    xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById(id).style.visibility = "collapse";;
                            alert(this.responseText);
                            backup_inner = "";
                            backup_inner_id = "";
                        }
                    };
                    var pedido = "pedido="+int;
                    //~ alert("exclude_order.php?"+pedido);
                    xhttp.open("GET", "exclude_order.php?"+pedido, true);
                    xhttp.send();
                } else {
                    //~ alert("no");
                    return false;
                }

            }
            function showCustomer(int) {
                var xhttp;    
                if (int == "") {
                    document.getElementById("txtHint").innerHTML = "";
                    return;
                }
                xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("txtHint").innerHTML = this.responseText;
                        backup_inner = "";
                        backup_inner_id = "";
                    }
                };
                xhttp.open("GET", "get_pedido.php?cliente="+int, true);
                xhttp.send();
            }
            function showprice(int,txt) {
                int = int-1
                //~ alert(txt);
                //~ alert(produto[int]['preco_unitario_produto']);
                //~ alert($('#price').val());
                document.getElementById("price"+txt).value = (produto[int]['preco_unitario_produto']*1.01);
                document.getElementById("amount"+txt).value = (produto[int]['multiplo_produto']);
                document.getElementById("amount"+txt).step = (produto[int]['multiplo_produto']);
                document.getElementById("amount"+txt).min = (produto[int]['multiplo_produto']);
                showrentability(document.getElementById("price"+txt).value,txt)
            }
            function showrentability(str,txt) {
                //~ alert(txt);
                if (str.length == 0) {
                    document.getElementById("rentabilidade"+txt).innerHTML = "Rentabilidade do pedido serás mostrado aqui ...";
                    return;
                }
                else {
                    //~ alert (str);
                    var index_produto = (document.getElementById("product"+txt).value)-1;
                    var preco = produto[index_produto]['preco_unitario_produto'];
                    //~ alert (preco);
                    if ( parseFloat(str) > parseFloat(preco) ){
                        document.getElementById("rentabilidade"+txt).innerHTML = "Ôtima";
                        document.getElementById("rentabilidade"+txt).style.backgroundColor = "";
                        //~ alert("otimo");
                    }
                    else{
                        if ( parseFloat(str) >= parseFloat(preco*0.9) ){
                            document.getElementById("rentabilidade"+txt).innerHTML = "Boa";
                            document.getElementById("rentabilidade"+txt).style.backgroundColor = "";
                            //~ alert("bom");
                        }
                        else{
                            document.getElementById("rentabilidade"+txt).innerHTML = "Ruim";
                            document.getElementById("rentabilidade"+txt).style.backgroundColor = "red";
                            //~ alert(document.getElementById("rentabilidade"+txt).style.backgroundColor);
                            //~ alert("ruim");
                        }
                    }
                }
            }
            $("#altera_pedido").submit(function(e){
                if (document.getElementById("rentabilidade"+alter_order_id).style.backgroundColor == 'red'){
                    alert("Não é permitido atualizar pedidos se a rentabilidade estiver ruim \n por favor aumente o preço se deseja atualizar o pedido");
                    document.getElementById("price"+alter_order_id).focus();
                    return false;
                }
                //~ alert(alter_order_id);
                e.preventDefault();
                if (confirm('Tem certeza que quer alterar este pedido?')) {
                    //~ alert("yes");
                    var id = "txt"+alter_order_id;
                    var xhttp;    
                    xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById(id).innerHTML = this.responseText;
                            backup_inner = "";
                            backup_inner_id = "";
                        }
                    };
                    var pedido = "pedido="+alter_order_id;
                    var produto = "produto="+document.getElementById('product'+alter_order_id).value;
                    var preco = "preco="+document.getElementById('price'+alter_order_id).value;
                    var quantidade = "quantidade="+document.getElementById('amount'+alter_order_id).value;
                    //~ alert("alter_order.php?"+pedido+"&"+produto+"&"+preco+"&"+quantidade);
                    xhttp.open("GET", "alter_order.php?"+pedido+"&"+produto+"&"+preco+"&"+quantidade, true);
                    xhttp.send();
                } else {
                    //~ alert("no");
                    return false;
                }

            });
        </script>
    </body>
</html>
