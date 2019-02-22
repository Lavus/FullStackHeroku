<?php # indentificação que o codigo a partir deste ponto serás PHP
    include("conexao.php"); # inclui o que está escrito em conexão.php
	$query = "SELECT produtos.id_produto, produtos.nome_produto, produtos.preco_unitario_produto, produtos.multiplo_produto FROM produtos ORDER by produtos.id_produto";
	# armazena a consulta ao banco de dados na variavel $query.
	# consulta dos produtos na tabela produtos
	$result = $mysqli->query($query); # executa a consulta e armazena o resultado na variavel $result 
	$produto = $result->fetch_all(MYSQLI_ASSOC); # pega todos os valores e armazena em $produto

	$sql = "SELECT pedido.id_pedido,pedido.id_produto_pedido,clientes.nome_cliente,produtos.nome_produto,pedido.preco_unitario_pedido,pedido.quantidade_pedido,pedido.tempo_pedido FROM pedido,clientes,produtos WHERE clientes.id_cliente = pedido.id_cliente_pedido and pedido.id_produto_pedido = produtos.id_produto and pedido.id_pedido = ?";
	# armazena a consulta ao banco de dados na variavel $sql.
	# consulta as informacões do pedido informado na tabela pedido e os "?" são representações onde vai ser inserido texto mais tarde

	$stmt = $mysqli->prepare($sql); # prepara o banco de dados com a consulta, criando uma sub conexão
	$stmt->bind_param("i", $_GET['pedido']); # arruma os "?" pelos valores corretos, passados pelo bind_param
	$stmt->execute(); # executa a consulta
	$stmt->store_result(); # guarda os resultados da execução
	$stmt->bind_result($id_pedido,$id_produto_pedido,$nome_cliente,$nome_produto,$preco_unitario_pedido,$quantidade_pedido,$tempo_pedido); # armazena as informações na variaveis informadas
	$stmt->fetch(); # busca as informações para armazenalas
	$stmt->close(); # fecha a sub conexão
	echo "<tr>"; # mostra a tag de abertura de linha numa tabela
		echo "<td data-label='ID do pedido'>" . $id_pedido. "</td>"; # mostra a tag de criação de coluna numa linha, com uma label e informações
		echo "<td data-label='Nome do cliente'>" . $nome_cliente. "</td>"; # mostra a tag de criação de coluna numa linha, com uma label e informações
		echo "<td data-label='Nome do produto'>"; # mostra a tag de criação de coluna numa linha, com uma label
			echo "<select id='product".$id_pedido."' name='produto' required='required' onchange='showprice(this.value,".$id_pedido.")' >"; # mostra a tag de criação de um selecionador
				$contador = 0; # cria a variavel para o repetidor
				while( $contador < count($produto)){ # começa um repetidor até o contador chegar na quantidade dos produtos
					if ($produto[$contador]["id_produto"] == $id_produto_pedido){ # verifica se o produto com numero do contador erá o anterior
						$selected = $contador; # se for, variavel selected recebe o numero do contador atual
						printf ("<option value='%d' selected>%s</option>", $produto[$contador]["id_produto"], $produto[$contador]["nome_produto"]); # se for, cria uma opção já selecionada
					} # fim da verificação
					else{ # se não for, faça os comando a seguir
						printf ("<option value='%d'>%s</option>", $produto[$contador]["id_produto"], $produto[$contador]["nome_produto"]); # cria uma opção não selecionada
					} # fim da verificação
					$contador++; # incrementa o contador em 1, resumindo de 1 vai para 2, 2 para 3 e ...
				} # fim do repetidor
			echo "</select>"; # fim do selecionador
		echo "</td>"; # fim da coluna da linha
		echo "<td data-label='Preço unitario do pedido'><input id='price".$id_pedido."' required='required' type='number' step=0.01 name='preco' min='0.01' value='".$preco_unitario_pedido."' onkeyup='showrentability(this.value,".$id_pedido.")' onchange='showrentability(this.value,".$id_pedido.")'></td>"; # mostra a tag de criação de coluna numa linha, com uma label e informações
		if ($preco_unitario_pedido > $produto[$selected]["preco_unitario_produto"]){ # verifica se o preço do pedido é maior que o do produto
			echo "<td data-label='Rentabilidade do pedido' id='rentabilidade".$id_pedido."'>Ôtima</td>"; # mostra a tag de criação de coluna numa linha, com uma label e informações
		}elseif($preco_unitario_pedido >= $produto[$selected]["preco_unitario_produto"]*0.9){ # se não for então vai verificar se o preço do pedido é maior que o do produto - 10%
			echo "<td data-label='Rentabilidade do pedido' id='rentabilidade".$id_pedido."'>Boa</td>"; # mostra a tag de criação de coluna numa linha, com uma label e informações
		}else{ # se não for então vai fazer o comando a seguir
			echo "<td data-label='Rentabilidade do pedido' id='rentabilidade".$id_pedido."'>Ruim? Como?</td>"; # mostra a tag de criação de coluna numa linha, com uma label e informações
		} # fim da verificação

		echo "<td data-label='Quantidade de produtos pedido'><input id='amount".$id_pedido."' required='required' type='number' step=".$produto[$selected]["multiplo_produto"]." name='quantidade' min='".$produto[$selected]["multiplo_produto"]."' value='" .$quantidade_pedido. "' onkeyup='verify_total(".$id_pedido.")' onchange='verify_total(".$id_pedido.")'></td>"; # mostra a tag de criação de coluna numa linha, com uma label e informações
		echo "<td data-label='Preço total do pedido' id='total_price".$id_pedido."'>" . $quantidade_pedido*$preco_unitario_pedido. "</td>"; # mostra a tag de criação de coluna numa linha, com uma label e informações
		echo "<td data-label='Tempo de realização do pedido'>" . $tempo_pedido. "</td>"; # mostra a tag de criação de coluna numa linha, com uma label e informações
		echo "<td data-label='Alterar o pedido'><input id='".$id_pedido."' type='submit' onclick='alter_order(this.id)' value='Alterar pedido'></td>"; # mostra a tag de criação de coluna numa linha, com uma label e um botão
		echo "<td data-label='Deletar o pedido'><input id='".$id_pedido."' type='button' onclick='exclude_order(this.id)' value='Excluir pedido'></td>"; # mostra a tag de criação de coluna numa linha, com uma label e um botão
	echo "</tr>"; # mostra a tag de fechamento de linha numa tabela
?> <!-- indentificação que acabou o codigo em PHP -->
