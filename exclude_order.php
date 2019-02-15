<?php
include("conexao.php");

$sql = "DELETE FROM `pedido` WHERE `pedido`.`id_pedido` = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $_GET['pedido']);
$stmt->execute();
$stmt->close();

echo "O Pedido foi deletado com sucesso";
?> 
