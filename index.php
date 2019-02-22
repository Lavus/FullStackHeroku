<?php # indentificação que o codigo a partir deste ponto serás PHP
    include("conexao.php"); # inclui o que está escrito em conexão.php
    $query = "SELECT clientes.id_cliente, clientes.nome_cliente FROM clientes ORDER by clientes.id_cliente";
	# armazena a consulta ao banco de dados na variavel $query.
	# consulta dos clientes na tabela clientes
	
    $result = $mysqli->query($query); # executa a consulta e armazena o resultado na variavel $result
    $cliente = $result->fetch_all(MYSQLI_ASSOC); # pega todos os valores e armazena em $cliente

	$query = "SELECT produtos.id_produto, produtos.nome_produto, produtos.preco_unitario_produto, produtos.multiplo_produto FROM produtos ORDER by produtos.id_produto";
 	# armazena a consulta ao banco de dados na variavel $query.
	# consulta dos produtos na tabela produtos
	
    $result = $mysqli->query($query); # executa a consulta e armazena o resultado na variavel $result
    $produto = $result->fetch_all(MYSQLI_ASSOC); # pega todos os valores e armazena em $produto
?>  <!-- indentificação que acabou o codigo em PHP -->
<html> <!-- indentificação de abertura do codigo HTML -->
    <head> <!-- indentificação de abertura do cabeçalho do codigo -->
        <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- indentificação do tipo do codigo -->
        <link rel="stylesheet" type="text/css" href="CSS/content.css"> <!-- indentificação de onde está o css do codigo -->
        <script src="JS/jquery.min.js"></script> <!-- indentificação de onde está o js do codigo -->
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"> <!-- indentificação do tipo do codigo -->
		<script type="text/javascript"> <!-- indentificação de abertura do codigo js(javascript) -->
			var produto = <?php echo json_encode($produto) ?>;  <!-- criação de uma variavel produto que recebe os valores armazenados na variavel $produto em php da consulta executada no começo do codigo -->
			var backup_inner = ""; <!-- criação de uma variavel backup_inner para armazenar conteudo de pagina alterada -->
			var backup_inner_id = ""; <!-- criação de uma variavel backup_inner_id para armazenar o id do conteudo de pagina alterada -->
			var order_id = ""; <!-- criação de uma variavel order_id para armazenar o id da chamada de função -->
			var type_change = ""; <!-- criação de uma variavel type_change para armazenar qual tipo de função foi chamada -->
			//~ alert( produto[6]['preco_unitario_produto'] );  <!-- um alert para debug, verificar oque mostra -->
		</script> <!-- indentificação do fechamento do codigo js(javascript) -->
        <script>
			$.getScript( "JS/content.js", function( data, textStatus, jqxhr ) {
				console.log( data ); // Data returned
				console.log( textStatus ); // Success
				console.log( jqxhr.status ); // 200
				console.log( "Load was performed." );
			});
        </script> <!-- indentificação de onde está o js do codigo -->
        <title>Full Stack</title> <!-- indentificação do titulo da pagina -->
    </head> <!-- indentificação do fechamento do cabeçalho do codigo -->
    <body> <!-- indentificação de abertura do corpo do codigo -->
        <form id="cadastro_pedido" action="" method="GET"> <!-- indentificação de abertura de um form -->
            <table>  <!-- indentificação de abertura de uma tabela -->
				<thead> <!-- indentificação de abertura de uma thead na tabela -->
					<tr> <!-- indentificação de abertura de uma linha dentro da thead -->
						<th>Nome do cliente</th> <!-- cria uma coluna na linha para servir como cabeçalho da tabela -->
						<th>Nome do produto</th> <!-- cria uma coluna na linha para servir como cabeçalho da tabela -->
						<th>Preço unitario</th> <!-- cria uma coluna na linha para servir como cabeçalho da tabela -->
						<th>Rentabilidade do pedido</th> <!-- cria uma coluna na linha para servir como cabeçalho da tabela -->
						<th>Quantidade de produtos</th> <!-- cria uma coluna na linha para servir como cabeçalho da tabela -->
						<th>Preço total do pedido</th> <!-- cria uma coluna na linha para servir como cabeçalho da tabela -->
						<th>Concluir pedido</th> <!-- cria uma coluna na linha para servir como cabeçalho da tabela -->
					</tr> <!-- indentificação do fechamento da linha -->
				</thead> <!-- indentificação do fechamento da thead -->
				<tbody> <!-- indentificação de abertura de um tbody -->
					<tr> <!-- indentificação de abertura de uma linha dentro do tbody -->
						<td data-label="Nome do cliente"> <!-- indentificação de abertura de uma coluna dentro da linha com uma label -->
							<select id="cliente" name='cliente' required="required" onchange="showCustomer(this.value,0)"> <!-- indentificação de abertura de um selecionador -->
								<option value="">Selecione um cliente:</option> <!-- indentificação de uma das opções do selecionador -->
								<?php # indentificação que o codigo a partir deste ponto serás PHP
									for ($contador = 0; $contador < count($cliente); $contador++) { # começa um repetidor até o contador chegar na quantidade dos clientes
										printf ("<option value='%d'>%s</option>", $cliente[$contador]['id_cliente'], $cliente[$contador]['nome_cliente']); # mostra a indentificação de uma das opções do selecionador baseado no contador
									} # final do repetidor
								?> <!-- indentificação que acabou o codigo em PHP -->
							</select> <!-- indentificação do fechamento do selecionador -->
						</td> <!-- indentificação do fechamento da coluna -->
						<td data-label="Nome do produto"> <!-- indentificação de abertura de uma coluna dentro da linha com uma label -->
							<select id='product' name='produto' required="required" onchange="showprice(this.value,'')"> <!-- indentificação de abertura de um selecionador -->
								<option value="">Selecione um produto:</option> <!-- indentificação de uma das opções do selecionador -->
								<?php # indentificação que o codigo a partir deste ponto serás PHP
									$contador = 0; # cria a variavel para o repetidor
									while( $contador < count($produto)){ # começa um repetidor até o contador chegar na quantidade dos produtos
										printf ("<option value='%d'>%s</option>", $produto[$contador]["id_produto"], $produto[$contador]["nome_produto"]); # mostra a indentificação de uma das opções do selecionador baseado no contador
										$contador++; # incrementa o contador em 1, resumindo de 1 vai para 2, 2 para 3 e ...
									} # final do repetidor
								?> <!-- indentificação que acabou o codigo em PHP -->
							</select> <!-- indentificação do fechamento do selecionador -->
						</td> <!-- indentificação do fechamento da coluna -->
						<td data-label="Preço unitario"> <!-- indentificação de abertura de uma coluna dentro da linha com uma label -->
							<input id="price" required="required" type="number" step=0.01 name="preco" min="0.01" value="0.01" onkeyup="showrentability(this.value,'')" onchange="showrentability(this.value,'')"> <!-- indentificação de um campo de escrita de numeros para o preço -->
						</td> <!-- indentificação do fechamento da coluna -->
						<td data-label="Rentabilidade do pedido"> <!-- indentificação de abertura de uma coluna dentro da linha com uma label -->
							<div id="rentabilidade"> <!-- cria um encapsulamente de conteudo div para calcular a rentabilidade, um conteudo dinamico -->
								Rentabilidade ... <!-- somente um aviso que a rentabilidade serás carregado naquela posição -->
							</div> <!-- fecha o encapsulamente div -->
						</td> <!-- indentificação do fechamento da coluna -->
						<td data-label="Quantidade de produtos"> <!-- indentificação de abertura de uma coluna dentro da linha com uma label -->
							<input type="number" step=1 id="amount" required="required" min="1" name="quantidade" value="1" onkeyup="verify_total('')" onchange="verify_total('')"> <!-- indentificação de um campo de escrita de numeros para quantidade -->
						</td> <!-- indentificação do fechamento da coluna -->
						<td data-label="Preço total do pedido" id="total_price"> <!-- indentificação de abertura de uma coluna dentro da linha com uma label e um id -->
							0.01 <!-- valor total do pedido -->
						</td> <!-- indentificação do fechamento da coluna -->
						<td data-label="Concluir pedido"> <!-- indentificação de abertura de uma coluna dentro da linha com uma label -->
							<input type="submit" value="Submit" onsubmit="return false"> <!-- indentificação de um botão submit -->
						</td> <!-- indentificação do fechamento da coluna -->
					</tr> <!-- indentificação do fechamento da linha -->
				</tbody> <!-- indentificação do fechamento do tbody -->
            </table> <!-- indentificação do fechamento da tabela -->
        </form> <!-- indentificação do fechamento do form -->

        <!-- The Modal -->
		<div id="myModal" class="modal"> <!-- cria um encapsulamente de conteudo div para servir de modal -->
			<!-- Modal content -->
			<div class="modal-content"> <!-- cria um encapsulamente de conteudo div para separar o conteudo do modal -->
				<div class="modal-header"> <!-- cria um encapsulamente de conteudo div para separar o cabeçalho do modal -->
					<span class="close">&times;</span> <!-- criação de um botão para fechar o modal -->
					<h2 id="modal_title_check">Modal Header</h2> <!-- criação um titulo para o cabeçalho dinamico, com um exemplo de titulo -->
				</div> <!-- fecha o encapsulamente div -->
				<div class="modal-body" id="modal_body_check"> <!-- cria um encapsulamente de conteudo div para separar o corpo do modal dinamico -->
					<p>Some text in the Modal Body</p> <!-- somente um exemplo de conteudo -->
					<p>Some other text...</p> <!-- somente um exemplo de conteudo -->
				</div> <!-- fecha o encapsulamente div -->
				<div class="modal-footer" id="modal_footer_check"> <!-- cria um encapsulamente de conteudo div para separar o acabamento do modal dinamico -->
					<h3>Modal Footer</h3> <!-- somente um exemplo de conteudo -->
				</div> <!-- fecha o encapsulamente div -->
			</div> <!-- fecha o encapsulamente div -->
		</div> <!-- fecha o encapsulamente div -->

        <form id='altera_pedido'> <!-- indentificação de abertura de um form com um id -->
			<div style='text-align: center;'> <!-- cria um encapsulamente de conteudo div para alinhar os objetos dentro -->
				<div id="txtHint"> <!-- cria um encapsulamente de conteudo div para servir de contedudo dinamico -->
					<H2>As informações dos pedidos referente ao cliente selecionado serão mostradas aqui ...</H2> <!-- somente um aviso que o conteudo serás carregado naquela posição -->
				</div> <!-- fecha o encapsulamente div -->
			</div> <!-- fecha o encapsulamente div -->
        </form> <!-- indentificação do fechamento do form -->
    </body> <!-- indentificação do fechamento do corpo -->
</html> <!-- indentificação do fechamento do conteudo HTML -->
