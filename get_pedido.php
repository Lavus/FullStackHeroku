<?php
include("conexao.php");

$sql = "SELECT pedido.id_pedido,clientes.nome_cliente,produtos.nome_produto,pedido.preco_unitario_pedido,pedido.quantidade_pedido,pedido.tempo_pedido,produtos.preco_unitario_produto FROM pedido,clientes,produtos WHERE clientes.id_cliente = pedido.id_cliente_pedido and pedido.id_produto_pedido = produtos.id_produto and pedido.id_cliente_pedido = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $_GET['cliente']);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id_pedido,$nome_cliente,$nome_produto,$preco_unitario_pedido,$quantidade_pedido,$tempo_pedido,$preco_unitario_produto);

echo "<table style='width:100%;'>";
echo "<tr>";
echo "<th>ID do pedido</th>";
echo "<th>Nome do cliente</th>";
echo "<th>Nome do produto</th>";
echo "<th>Preço unitario do pedido</th>";
echo "<th>Rentabilidade do pedido</th>";
echo "<th>Quantidade de produtos pedido</th>";
echo "<th>Tempo de realização do pedido</th>";
echo "<th>Alterar o pedido</th>";
echo "<th>Deletar o pedido</th>";
echo "</tr>";
while($stmt->fetch()){
    echo("<tbody id='txt" . $id_pedido. "'>");
        echo "<tr>";
            echo "<td>" . $id_pedido. "</td>";
            echo "<td>" . $nome_cliente. "</td>";
            echo "<td>" . $nome_produto. "</td>";
            echo "<td>" . $preco_unitario_pedido. "</td>";
            if ($preco_unitario_pedido > $preco_unitario_produto){
                echo "<td>Ôtima</td>";
            }elseif($preco_unitario_pedido >= $preco_unitario_produto*0.9){
                echo "<td>Boa</td>";
            }else{
                echo "<td>Ruim? Como?</td>";
            }
            echo "<td>" . $quantidade_pedido. "</td>";
            echo "<td>" . $tempo_pedido. "</td>";
            echo "<td><input id='".$id_pedido."' type='button' onclick='alter_table(this.id)' value='Alterar pedido'></td>";
            echo "<td><input id='".$id_pedido."' type='button' onclick='exclude_order(this.id)' value='Excluir pedido'></td>";
        echo "</tr>";
    echo("</tbody>");
}
echo "</table>";
$stmt->close();
?> 
