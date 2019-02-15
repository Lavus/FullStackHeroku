<?php
include("conexao.php");
$query = "SELECT produtos.id_produto, produtos.nome_produto, produtos.preco_unitario_produto, produtos.multiplo_produto FROM produtos ORDER by produtos.id_produto";
$result = $mysqli->query($query);        
$produto = $result->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT pedido.id_pedido,pedido.id_produto_pedido,clientes.nome_cliente,produtos.nome_produto,pedido.preco_unitario_pedido,pedido.quantidade_pedido,pedido.tempo_pedido FROM pedido,clientes,produtos WHERE clientes.id_cliente = pedido.id_cliente_pedido and pedido.id_produto_pedido = produtos.id_produto and pedido.id_pedido = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $_GET['pedido']);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id_pedido,$id_produto_pedido,$nome_cliente,$nome_produto,$preco_unitario_pedido,$quantidade_pedido,$tempo_pedido);
$stmt->fetch();
$stmt->close();
echo "<tr>";
    echo "<td>" . $id_pedido. "</td>";
    echo "<td>" . $nome_cliente. "</td>";
    echo "<td>";
        echo "<select id='product".$id_pedido."' name='produto' required='required' onchange='showprice(this.value,".$id_pedido.")' >";
            $contador = 0;
            while( $contador < count($produto)){
                if ($produto[$contador]["id_produto"] == $id_produto_pedido){
                    $selected = $contador;
                    printf ("<option value='%d' selected>%s</option>", $produto[$contador]["id_produto"], $produto[$contador]["nome_produto"]);
                }
                else{
                    printf ("<option value='%d'>%s</option>", $produto[$contador]["id_produto"], $produto[$contador]["nome_produto"]);
                }
                $contador++;
            }
        echo "</select>";
    echo "</td>";
    echo "<td><input id='price".$id_pedido."' required='required' type='number' step=0.01 name='preco' min='0.01' value='".$preco_unitario_pedido."' onkeyup='showrentability(this.value,".$id_pedido.")' onchange='showrentability(this.value,".$id_pedido.")'></td>";
    if ($preco_unitario_pedido > $produto[$selected]["preco_unitario_produto"]){
        echo "<td id='rentabilidade".$id_pedido."'>Ôtima</td>";
    }elseif($preco_unitario_pedido >= $produto[$selected]["preco_unitario_produto"]*0.9){
        echo "<td id='rentabilidade".$id_pedido."'>Boa</td>";
    }else{
        echo "<td id='rentabilidade".$id_pedido."'>Ruim? Como?</td>";
    }

    echo "<td><input id='amount".$id_pedido."' required='required' type='number' step=".$produto[$selected]["multiplo_produto"]." name='quantidade' min='".$produto[$selected]["multiplo_produto"]."' value='" .$quantidade_pedido. "'></td>";
    echo "<td>" . $tempo_pedido. "</td>";
    echo "<td><input id='".$id_pedido."' type='submit' onclick='alter_order(this.id)' value='Alterar pedido'></td>";
    echo "<td><input id='".$id_pedido."' type='button' onclick='exclude_order(this.id)' value='Excluir pedido'></td>";
echo "</tr>";
?> 
