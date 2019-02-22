<?php # indentificação que o codigo a partir deste ponto serás PHP
	include("conexao.php"); # inclui o que está escrito em conexão.php

	$sql = "DELETE FROM `pedido` WHERE `pedido`.`id_pedido` = ?";
	# armazena a consulta ao banco de dados na variavel $sql.
	# consulta de exclusão na tabela pedido e os "?" são representações onde vai ser inserido texto mais tarde

	$stmt = $mysqli->prepare($sql); # prepara o banco de dados com a consulta, criando uma sub conexão
	$stmt->bind_param("i", $_GET['pedido']); # arruma os "?" pelos valores corretos, passados pelo bind_param
	$stmt->execute(); # executa a consulta
	$stmt->close(); # fecha a sub conexão

	echo "O Pedido foi deletado com sucesso"; # mostra a mensagem
?> <!-- indentificação que acabou o codigo em PHP -->
