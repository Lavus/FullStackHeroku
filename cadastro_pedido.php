<?php # indentificação que o codigo a partir deste ponto serás PHP
	include("conexao.php"); # inclui o que está escrito em conexão.php

	$sql = "INSERT INTO `pedido` (`id_cliente_pedido`, `id_produto_pedido`, `preco_unitario_pedido`, `quantidade_pedido`) VALUES (?, ?, ?, ?);";
	# armazena a consulta ao banco de dados na variavel $sql.
	# consulta de inserção na tabela pedido e os "?" são representações onde vai ser inserido texto mais tarde

	$stmt = $mysqli->prepare($sql); # prepara o banco de dados com a consulta, criando uma sub conexão
	$stmt->bind_param("iidi", $_GET['cliente'],$_GET['produto'],$_GET['preco'],$_GET['quantidade']); # arruma os "?" pelos valores corretos, passados pelo bind_param
	$stmt->execute(); # executa a consulta
	$stmt->close(); # fecha a sub conexão

?> <!-- indentificação que acabou o codigo em PHP -->
