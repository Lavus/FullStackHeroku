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
    
    $set = ''; # cria variavel vazia que representa oque vai ser alterado
    if ($_GET['produto'] != $id_produto_pedido){ # verifica se o produto informado é diferente do anterior
        $set = "pedido.id_produto_pedido = '".$_GET['produto']."'"; # se for variavel set recebe o parametro de atualização dele
	} # fim da verificação
    //~ echo ($set); # criado para debug, mostrando o valor da variavel
    if ($_GET['preco'] != $preco_unitario_pedido){ # verifica se o preço informado é diferente do anterior
        if ($set != ''){ # verifica se a variavel set tem algo
            $preco = sprintf("%.2f", $_GET['preco']); # se tiver algo em set transforma o preço em texto com duas casas decimais
            $set=$set.", pedido.preco_unitario_pedido = '".$preco."'"; # se for variavel set recebe set + o parametro de atualização dele
        }else{ # se não tem algo
            $set = "pedido.preco_unitario_pedido = '".$_GET['preco']."'"; # se não for variavel set recebe o parametro de atualização dele
        } # fim da verificação
    } # fim da verificação
    //~ echo ($set); # criado para debug, mostrando o valor da variavel
    if ($_GET['quantidade'] != $quantidade_pedido){ # verifica se a quantidade informado é diferente do anterior
        if ($set != ''){ # verifica se a variavel set tem algo
            $set=$set.", pedido.quantidade_pedido = '".$_GET['quantidade']."'"; # se for variavel set recebe set + o parametro de atualização dele
        }else{ # se não tem algo
            $set = "pedido.quantidade_pedido = '".$_GET['quantidade']."'"; # se não for variavel set recebe o parametro de atualização dele
        } # fim da verificação
    } # fim da verificação
    //~ echo ($set); # criado para debug, mostrando o valor da variavel
    if ($set != ''){ # verifica se a variavel set tem algo
		# se tiver vai fazer as operações a seguir
        $sql = "UPDATE pedido SET ".$set." WHERE pedido.id_pedido = ?";
		# armazena a consulta ao banco de dados na variavel $sql, onde os parametros do que vai ser atualizado está escrito na variavel set.
		# consulta de atualização na tabela pedido e os "?" são representações onde vai ser inserido texto mais tarde
        $stmt = $mysqli->prepare($sql); # prepara o banco de dados com a consulta, criando uma sub conexão
        $stmt->bind_param("i", $_GET['pedido']); # arruma os "?" pelos valores corretos, passados pelo bind_param
        $stmt->execute(); # executa a consulta
        $stmt->close(); # fecha a sub conexão
    } # fim da verificação
    echo "<tr>"; # mostra a tag de abertura de linha numa tabela
        echo "<td data-label='ID do pedido'>" . $id_pedido. "</td>"; # mostra a tag de criação de coluna numa linha, com uma label e informações
        echo "<td data-label='Nome do cliente'>" . $nome_cliente. "</td>"; # mostra a tag de criação de coluna numa linha, com uma label e informações
        echo "<td data-label='Nome do produto'>" . $produto[$_GET['produto']-1]['nome_produto']. "</td>"; # mostra a tag de criação de coluna numa linha, com uma label e informações
        echo "<td data-label='Preço unitario do pedido'>" . $_GET['preco']. "</td>"; # mostra a tag de criação de coluna numa linha, com uma label e informações
        if ($_GET['preco'] > $produto[$_GET['produto']-1]['preco_unitario_produto']){ # verifica se o preço do pedido é maior que o do produto
            echo "<td data-label='Rentabilidade do pedido'>Ôtima</td>"; # mostra a tag de criação de coluna numa linha, com uma label e informações
        }elseif($_GET['preco'] >= $produto[$_GET['produto']-1]['preco_unitario_produto']*0.9){ # se não for então vai verificar se o preço do pedido é maior que o do produto - 10%
            echo "<td data-label='Rentabilidade do pedido'>Boa</td>"; # mostra a tag de criação de coluna numa linha, com uma label e informações
        }else{ # se não for então vai fazer o comando a seguir
            echo "<td data-label='Rentabilidade do pedido'>Ruim? Como?</td>"; # mostra a tag de criação de coluna numa linha, com uma label e informações
        } # fim da verificação
        echo "<td data-label='Quantidade de produtos pedido'>" . $_GET['quantidade']. "</td>"; # mostra a tag de criação de coluna numa linha, com uma label e informações
        echo "<td data-label='Preço total do pedido' id='total_price".$id_pedido."'>" . $_GET['quantidade']*$_GET['preco']. "</td>"; # mostra a tag de criação de coluna numa linha, com uma label e informações
        echo "<td data-label='Tempo de realização do pedido'>" . $tempo_pedido. "</td>"; # mostra a tag de criação de coluna numa linha, com uma label e informações
        echo "<td data-label='Alterar o pedido'><input id='".$id_pedido."' type='button' onclick='alter_table(this.id)' value='Alterar pedido'></td>"; # mostra a tag de criação de coluna numa linha, com uma label e um botão
        echo "<td data-label='Deletar o pedido'><input id='".$id_pedido."' type='button' onclick='exclude_order(this.id)' value='Excluir pedido'></td>"; # mostra a tag de criação de coluna numa linha, com uma label e um botão
    echo "</tr>"; # mostra a tag de fechamento de linha numa tabela
?>  <!-- indentificação que acabou o codigo em PHP -->
