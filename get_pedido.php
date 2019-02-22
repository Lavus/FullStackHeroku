<?php # indentificação que o codigo a partir deste ponto serás PHP
    include("conexao.php"); # inclui o que está escrito em conexão.php
	$sql = "SELECT count(`pedido`.`id_pedido`) FROM `pedido` WHERE pedido.id_cliente_pedido = ?";
	# armazena a consulta ao banco de dados na variavel $sql.
	# consulta a quantidade de pedidos cadastrado do clinte informado na tabela pedido e os "?" são representações onde vai ser inserido texto mais tarde
	
	$stmt = $mysqli->prepare($sql); # prepara o banco de dados com a consulta, criando uma sub conexão
	$stmt->bind_param("i", $_GET['cliente']); # arruma os "?" pelos valores corretos, passados pelo bind_param
    $stmt->execute(); # executa a consulta
    $stmt->store_result(); # guarda os resultados da execução
	$stmt->bind_result($count_id_pedido); # armazena as informações na variaveis informadas
    $stmt->fetch(); # busca as informações para armazenalas
    $stmt->close(); # fecha a sub conexão

	if ($_GET['offset'] >= $count_id_pedido){ # verifica se tem produto o suficiente para começar da posição informada
		$_GET['offset'] = $_GET['offset']-10; # se posição informada for maior ou igual ao valor diminiu ele por 10
	} # fim da verificação

	$sql = "SELECT pedido.id_pedido,clientes.nome_cliente,produtos.nome_produto,pedido.preco_unitario_pedido,pedido.quantidade_pedido,pedido.tempo_pedido,produtos.preco_unitario_produto FROM pedido,clientes,produtos WHERE clientes.id_cliente = pedido.id_cliente_pedido and pedido.id_produto_pedido = produtos.id_produto and pedido.id_cliente_pedido = ? ORDER BY pedido.id_pedido limit 10 offset ?";
	# armazena a consulta ao banco de dados na variavel $sql.
	# consulta as informacões dos pedidos informado na tabela pedido e os "?" são representações onde vai ser inserido texto mais tarde
	
	$stmt = $mysqli->prepare($sql); # prepara o banco de dados com a consulta, criando uma sub conexão
	$stmt->bind_param("ii", $_GET['cliente'], $_GET['offset']); # arruma os "?" pelos valores corretos, passados pelo bind_param
    $stmt->execute(); # executa a consulta
    $stmt->store_result(); # guarda os resultados da execução
	$stmt->bind_result($id_pedido,$nome_cliente,$nome_produto,$preco_unitario_pedido,$quantidade_pedido,$tempo_pedido,$preco_unitario_produto); # armazena as informações na variaveis informadas

	echo "<table>"; # mostra a tag de abertura de uma tabela
	echo "<thead>"; # mostra a tag de abertura de thead numa tabela
	echo "<tr>"; # mostra a tag de abertura de linha numa tabela
	echo "<th>ID do pedido</th>"; # mostra a tag de criação de coluna numa linha, o cabeçalho
	echo "<th>Nome do cliente</th>"; # mostra a tag de criação de coluna numa linha, o cabeçalho
	echo "<th>Nome do produto</th>"; # mostra a tag de criação de coluna numa linha, o cabeçalho
	echo "<th>Preço unitario do pedido</th>"; # mostra a tag de criação de coluna numa linha, o cabeçalho
	echo "<th>Rentabilidade do pedido</th>"; # mostra a tag de criação de coluna numa linha, o cabeçalho
	echo "<th>Quantidade de produtos pedido</th>"; # mostra a tag de criação de coluna numa linha, o cabeçalho
	echo "<th>Preço total do pedido</th>"; # mostra a tag de criação de coluna numa linha, o cabeçalho
	echo "<th>Tempo de realização do pedido</th>"; # mostra a tag de criação de coluna numa linha, o cabeçalho
	echo "<th>Alterar o pedido</th>"; # mostra a tag de criação de coluna numa linha, o cabeçalho
	echo "<th>Deletar o pedido</th>"; # mostra a tag de criação de coluna numa linha, o cabeçalho
	echo "</tr>"; # mostra a tag de fechamento de linha numa tabela
	echo "</thead>"; # mostra a tag de fechamento de thead numa tabela
	while($stmt->fetch()){ # começa um repetidor para a cada busca de resultado da consulta fazer as operações a seguir
		echo("<tbody id='txt" . $id_pedido. "'>"); # mostra a tag de criação de tbody numa tabela
			echo "<tr>"; # mostra a tag de abertura de linha numa tabela
				echo "<td data-label='ID do pedido'>" . $id_pedido. "</td>"; # mostra a tag de criação de coluna numa linha, com uma label e informações
				echo "<td data-label='Nome do cliente'>" . $nome_cliente. "</td>"; # mostra a tag de criação de coluna numa linha, com uma label e informações
				echo "<td data-label='Nome do produto'>" . $nome_produto. "</td>"; # mostra a tag de criação de coluna numa linha, com uma label e informações
				echo "<td data-label='Preço unitario do pedido'>" . $preco_unitario_pedido. "</td>"; # mostra a tag de criação de coluna numa linha, com uma label e informações
				if ($preco_unitario_pedido > $preco_unitario_produto){ # verifica se o preço do pedido é maior que o do produto
					echo "<td data-label='Rentabilidade do pedido'>Ôtima</td>"; # mostra a tag de criação de coluna numa linha, com uma label e informações
				}elseif($preco_unitario_pedido >= $preco_unitario_produto*0.9){ # se não for então vai verificar se o preço do pedido é maior que o do produto - 10%
					echo "<td data-label='Rentabilidade do pedido'>Boa</td>"; # mostra a tag de criação de coluna numa linha, com uma label e informações
				}else{ # se não for então vai fazer o comando a seguir
					echo "<td data-label='Rentabilidade do pedido'>Ruim? Como?</td>"; # mostra a tag de criação de coluna numa linha, com uma label e informações
				} # fim da verificação
				echo "<td data-label='Quantidade de produtos pedido'>" . $quantidade_pedido. "</td>"; # mostra a tag de criação de coluna numa linha, com uma label e informações
				echo "<td data-label='Preço total do pedido' id='total_price".$id_pedido."'>" . $quantidade_pedido*$preco_unitario_pedido. "</td>"; # mostra a tag de criação de coluna numa linha, com uma label e informações
				echo "<td data-label='Tempo de realização do pedido'>" . $tempo_pedido. "</td>"; # mostra a tag de criação de coluna numa linha, com uma label e informações
				echo "<td data-label='Alterar o pedido'><input id='".$id_pedido."' type='button' onclick='alter_table(this.id)' value='Alterar pedido'></td>"; # mostra a tag de criação de coluna numa linha, com uma label e um botão
				echo "<td data-label='Deletar o pedido'><input id='".$id_pedido."' type='button' onclick='exclude_order(this.id)' value='Excluir pedido'></td>"; # mostra a tag de criação de coluna numa linha, com uma label e um botão
			echo "</tr>"; # mostra a tag de fechamento de linha numa tabela
		echo("</tbody>"); # mostra a tag de fechamento de tbody numa tabela
	} # fim da repetição
	echo "</table>"; # mostra a tag de fechamento de uma tabela
	$stmt->close(); # fecha a sub conexão

	$pages = ceil($count_id_pedido/10); # pega a quantidade e divide por 10 para saber quantas paginas vão dar
	if ($_GET['offset'] == 0){ # verifica se a paginação começou em 0
		$active = 1; # se for, significa que a pagina atual é 1
	}else{ # se não for ele faz o comando a seguir
		$active = (($_GET['offset']/10)+1); # pega o começo da paginação divide por 10 e soma 1, resumindo se for 10, então é 10 a 20 resumindo pagina 2
	} # fim da verificação
	echo"<div style='text-align: center;'>"; # cria um encapsulamente de conteudo div para alinhar os objetos dentro
	echo "<div class='pagination'>"; # cria um encapsulamente de conteudo div, com uma classe para paginação
		if ($active == 1){ # verifica se a pagina ativa é 1
			echo "<a href='#' id='paginationprev' onclick='get_page(this.id);return false;' class='disabled'>&laquo;</a>"; # se for ele desabilita a opçao de pagina anterior
		}else{ # se não for ele faz o comando a seguir
			echo "<a href='#' id='paginationprev' onclick='get_page(this.id);return false;'>&laquo;</a>"; # mostra a opçao de pagina anterior
		} # fim da verificação
		for ($contador = 1; $contador <= $pages; $contador++) {
			if ($contador == $active){ # verifica se a pagina ativa é o contador atual
				echo "<a href='#' id='pagination".$contador."' onclick='get_page(this.id);return false;' class='active'>".$contador."</a>"; # se for ele ativa a opçao do numero da pagina
			}else{ # se não for ele faz o comando a seguir
				echo "<a href='#' id='pagination".$contador."' onclick='get_page(this.id);return false;'>".$contador."</a>"; # mostra a opçao do numero da pagina
			} # fim da verificação
		} # fim da repetição
		if ($active == $pages){ # verifica se a pagina ativa é a ultima
			echo "<a href='#' id='paginationnext' onclick='get_page(this.id);return false;' class='disabled'>&raquo;</a>"; # se for ele desabilita a opçao de proxima pagina
		}else{ # se não for ele faz o comando a seguir
			echo "<a href='#' id='paginationnext' onclick='get_page(this.id);return false;'>&raquo;</a>"; # mostra a opçao de proxima pagina
		} # fim da verificação
	echo "</div>"; # fecha o encapsulamente div
	echo "</div>"; # fecha o encapsulamente div
?> <!-- indentificação que acabou o codigo em PHP -->
