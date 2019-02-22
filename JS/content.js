// Ao clickar no botão submit usa ajax para cadastrar o pedido
$(document).ready(function(){
	$('#cadastro_pedido').submit(function(ev){
		//~ alert(document.getElementById("rentabilidade").style.backgroundColor);
		if (verify_profitability("") == false){
			return false;
		}
		ev.preventDefault();
		//~ alert("Submitted");
		var dados = $('#cadastro_pedido').serialize();
		//~ alert(dados);

		var xhttp;    
		if (dados == "") {
			return;
		}
		xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				showCustomer(document.getElementById("cliente").value,0)
				document.getElementById("modal_title_check").innerHTML = "Cadastro Pedido";
				document.getElementById("modal_body_check").innerHTML = "<p>O cadastro do pedido foi realizado com sucesso.</p><p>Obrigado por utilizar nossos serviços.</p>";
				document.getElementById("modal_footer_check").style.display = "none";
				modal.style.display = "block";
			}
		};
		xhttp.open("GET", "cadastro_pedido.php?"+dados, true);
		xhttp.send();
	});
	return false;
});

// Get the modal
var modal = document.getElementById('myModal');

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
	close_modal()
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
	if (event.target == modal) {
		close_modal()
	}
}

// Ao clickar no botão alterar tabela pela primeira vez usa ajax para alterar a tabela para ter inputs
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

// Ao clickar no botão alterar tabela pela segunda vez abre o modal perguntando se tem certeza
function alter_order(int) {
	order_id = int;
	type_change = "alter";
	document.getElementById("modal_title_check").innerHTML = "Alteração de pedido";
	document.getElementById("modal_body_check").innerHTML = "<p>Tem certeza que quer alterar este pedido?</p><p></p>";
	document.getElementById("modal_footer_check").style.display = "block";
	document.getElementById("modal_footer_check").innerHTML = "<input type='button' value='Sim' onclick='confirmed()'><input type='button' value='Não' onclick='close_modal()'>";
	modal.style.display = "block";
}

// verifica se a rentabilidade está boa
function verify_profitability(int){
	if (document.getElementById("rentabilidade"+int).style.color == 'red'){
		document.getElementById("modal_title_check").innerHTML = "Rentabilidade Ruim";
		document.getElementById("modal_body_check").innerHTML = "<p>Não é permitido atualizar pedidos se a rentabilidade estiver RUIM</p><p>por favor aumente o preço se deseja atualizar o pedido</p>";
		document.getElementById("modal_footer_check").style.display = "none";
		modal.style.display = "block";
		type_change = "verify";
		order_id = "price"+int;
		return false;
	}else{
		return true;
	}
}

// se comfimado a alteração us ajax para alterar o pedido
function confirmed_alter_order(int){
	if (verify_profitability(int) == false){
		return false;
	}
	var id = "txt"+int;
	var xhttp;    
	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById(id).innerHTML = this.responseText;
			backup_inner = "";
			backup_inner_id = "";
		}
	};
	var pedido = "pedido="+int;
	var produto = "produto="+document.getElementById('product'+int).value;
	var preco = "preco="+document.getElementById('price'+int).value;
	var quantidade = "quantidade="+document.getElementById('amount'+int).value;
	xhttp.open("GET", "alter_order.php?"+pedido+"&"+produto+"&"+preco+"&"+quantidade, true);
	xhttp.send();
	close_modal()
}

// Ao confirmar verifica qual comfirmação foi
function confirmed() {
	if (type_change == "exclude"){
		confirmed_exclude_order(order_id)
	}else{
		 if (type_change == "alter"){
			 confirmed_alter_order(order_id)
		 }else{
			return false;
		 }
	}
}

// fecha o modal e limpa o cache
function close_modal() {
	if (type_change == "verify"){
		document.getElementById(order_id).focus();
	}
	order_id = "";
	type_change = "";
	modal.style.display = "none";
}

// calcula o total do preço e mostra
function verify_total(txt) {
	document.getElementById("total_price"+txt).innerHTML = (document.getElementById("price"+txt).value * document.getElementById("amount"+txt).value).toFixed(2);
}

// verifica qual pagina foi acionada e usa ajax para buscar a pagina
function get_page(int) {
	var page_id = int.substr(10);
	//~ alert (page_id);
	//~ alert(document.getElementById("pagination"+page_id).className);
	if ((document.getElementById("pagination"+page_id).className == "disabled") || (document.getElementById("pagination"+page_id).className == "active")) {
		return false;
	}
	if (page_id == "next"){
		//~ alert (page_id);
		var id = document.getElementsByClassName("active")[0].id; 
		//~ alert (id);
		id = id.substr(10);
		//~ alert (id);
		id = parseInt(id) + 1;
		//~ alert (id);
		page_id = id;
		//~ alert (page_id);
	}else{
		if (page_id == "prev"){
			//~ alert (page_id);
			var id = document.getElementsByClassName("active")[0].id;
			//~ alert (id);
			id = id.substr(10);
			id = parseInt(id) - 1;
			page_id = id;
		}
	}
	//~ alert (page_id);
	page_id = (page_id - 1)*10
	//~ alert (page_id);
	showCustomer(document.getElementById("cliente").value,page_id)
}

// Ao clickar no botão excluir abre o modal perguntando se tem certeza
function exclude_order(int) {
	order_id = int;
	type_change = "exclude";
	document.getElementById("modal_title_check").innerHTML = "Exclusão de pedido";
	document.getElementById("modal_body_check").innerHTML = "<p>Tem certeza que quer excluir este pedido?</p><p></p>";
	document.getElementById("modal_footer_check").style.display = "block";
	document.getElementById("modal_footer_check").innerHTML = "<input type='button' value='Sim' onclick='confirmed()'><input type='button' value='Não' onclick='close_modal()'>";
	modal.style.display = "block";
}

// Ao confirmar exclusão usa ajax para excluir o pedido
function confirmed_exclude_order(int){
	var id = "txt"+int;
	var xhttp;    
	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {

			var id = document.getElementsByClassName("active")[0].id;
			id = id.substr(10);
			id = parseInt(id);
			page_id = (id-1)*10;
			//~ alert (page_id);
			showCustomer(document.getElementById("cliente").value,page_id)

			document.getElementById("modal_title_check").innerHTML = "Exclusão de pedido";
			document.getElementById("modal_body_check").innerHTML = "<p>"+this.responseText+"</p>";
			document.getElementById("modal_footer_check").style.display = "none";
			modal.style.display = "block";
			backup_inner = "";
			backup_inner_id = "";
		}
	};
	var pedido = "pedido="+int;
	xhttp.open("GET", "exclude_order.php?"+pedido, true);
	xhttp.send();
	close_modal()
}

// usa ajax para buscar os pedidos do cliente selecionado
function showCustomer(int,int_offset) {
	var xhttp;
	//~ alert (int);
	if (int == "") {
		document.getElementById("txtHint").innerHTML = "<H2>As informações dos pedidos referente ao cliente selecionado serão mostradas aqui ...</H2>";
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
	xhttp.open("GET", "get_pedido.php?cliente="+int+"&offset="+int_offset, true);
	xhttp.send();
}

// arruma o preço e quantidade conforme o produto selecionado
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

// calcula a rentabilidade
function showrentability(str,txt) {
	//~ alert(txt);
	//~ alert (str);
	//~ alert (str.length);
	if (document.getElementById("product"+txt).value == '') {
		document.getElementById("rentabilidade"+txt).innerHTML = "Rentabilidade ...";
		verify_total(txt)
		//~ alert("here");
		return false;
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
				document.getElementById("rentabilidade"+txt).style.color = "red";
				//~ alert(document.getElementById("rentabilidade"+txt).style.backgroundColor);
				//~ alert("ruim");
			}
		}
	}
	verify_total(txt)
}

//evita que alterar pedido recarregue a pagina
$("#altera_pedido").submit(function(e){
	e.preventDefault();
	return false;
});
