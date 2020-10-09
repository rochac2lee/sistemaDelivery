<?php

require('assets/includes/session.php');

$idPedido  = $_GET['idPedido'];
$idCliente = $_GET['idCliente'];
$comanda   = $_GET['comanda'];

?>
<!DOCTYPE html>
<html lang="en">
<?php require('assets/includes/head.php')?>

<body class="adminbody" onload="searchProduct()">

<div id="main">

<?php require('assets/includes/menu.php')?>

<div id="loading" style="display: none; width: 100%; height: 100%; background: #000000a6; position: absolute; z-index: 1;">

	<img src="assets/images/loading.gif" style="width: 10%; top: 45%; left: 50%; position: fixed;">

</div>

<input type="text" value="<?php echo $idCliente; ?>" style="display: none;" id="viewIdClient">

<script type="text/javascript">

	function loading() {
		document.getElementById('loading').style.display = 'block';
	}

	function viewNewRequest() {
		document.getElementById('frmNewRequest').style.display = 'block';
		document.getElementById('btnClose').style.display = 'block';
		document.getElementById('listRequests').style.display = 'none';
		document.getElementById('btnNewRequest').style.display = 'none';
	}

	function validaIdClient() {
		var viewIdClient = document.getElementById("viewIdClient").value;
		if (viewIdClient != 0) {
			document.getElementById("frmNewRequest").style.display = "none";
			document.getElementById("frmNewRequestFinish").style.display = "block";
		} else {
			document.getElementById("frmNewRequest").style.display = "block";
			document.getElementById("frmNewRequestFinish").style.display = "none";
		}
	}

</script>

<?php

$select = "SELECT * FROM pedidos WHERE id = $idPedido and idEndereco != ''";
$result = $conexao -> prepare($select);
$result -> execute();
$count = $result->rowCount();

if ($count == "") {

	if ($idCliente != "" && !isset($_GET['step'])) {

		$select = "SELECT * FROM usuarios WHERE id = $idCliente";
		$result = $conexao -> prepare($select);
		$result -> execute();
		$count = $result->rowCount();

		if ($data = $result->fetch()) {
			do {

				$viewNome        = $data['nome'];
				$viewCelular     = $data['celular'];
				$viewDataNasc    = $data['nascimento'];

			} while($data = $result->fetch());
		}

?>

<script>
$(document).ready(function() {
    $('#modalAddress').modal('show');
})
</script>

<?php

	}

}

?>

<script type="text/javascript">

	function CriaRequest() {
	 try{
		 request = new XMLHttpRequest();
	 }catch (IEAtual){

		 try{
			 request = new ActiveXObject("Msxml2.XMLHTTP");
		 }catch(IEAntigo){

			 try{
				 request = new ActiveXObject("Microsoft.XMLHTTP");
			 }catch(falha){
				 request = false;
			 }
		 }
	 }

	 if (!request)
		 alert("Seu Navegador não suporta Ajax!");
	 else
		 return request;
	}

	</script>

<style>

.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #444;
    line-height: 38px;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 38px;
    position: absolute;
    top: 1px;
    right: 1px;
    width: 20px;
}

.select2-container .select2-selection--single {
    box-sizing: border-box;
    cursor: pointer;
    display: block;
    height: 38px;
    user-select: none;
    -webkit-user-select: none;
}

#newDescricao {
	overflow:hidden;
	width:250px;
}

textarea::placeholder {
	color: #fff!important;
}

.trumbowyg-box .trumbowyg-editor {
    margin: 0 auto;
    overflow-x: hidden;
		background-color: #fff;
}

.trumbowyg-button-pane {
	display: none;
}

.trumbowyg-box, .trumbowyg-editor {
    display: block;
    position: relative;
    border: 1px solid #DDD;
    width: 100%;
    min-height: 100px;
    margin: 17px auto;
}

input[type="number"] {
	-webkit-appearance: textfield;
	-moz-appearance: textfield;
	appearance: textfield;
}

input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
	-webkit-appearance: none;
}

.number-input {
	display: inline-flex;
	border: 1px solid #ced4da;
}

.number-input,
.number-input * {
	box-sizing: border-box;
}

.number-input button {
	outline:none;
	-webkit-appearance: none;
	border: none;
	align-items: center;
	justify-content: center;
	width: 25px;
	font-size: 18px;
	font-weight: 700;
  padding: 0;
	cursor: pointer;
	margin: 0;
	position: relative;
}

.number-input button.plus:after {
	transform: translate(-50%, -50%) rotate(90deg);
}

.number-input input[type=number] {
	font-family: sans-serif;
	background: transparent;
	color: #000;
	max-width: 5rem;
	padding: .5rem;
	border: 0;
	height: 2rem;
	font-size: 16px;
	font-weight: 600;
	text-align: center;
}

.list-group {
    height: 300px!important;
    display: block;
    width: 100%;
    padding: .375rem .75rem;
    font-size: 1rem;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 0;
    border-radius: .25rem;
		overflow-y: scroll;
		overflow-x: hidden;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}
</style>

		<input type='text' id='idPedido' style='display: none;' value='<?php echo $idPedido; ?>'>
		<input type='text' id='idCliente' style='display: none;' value='<?php echo $idCliente; ?>'>
		<input type='text' id='comanda' style='display: none;' value='<?php echo $comanda; ?>'>

		<div class="modal fade custom-modal" tabindex="-1" role="dialog" aria-labelledby="modalNewClient" aria-hidden="true" id="modalNewClient">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">

					<form action="assets/functions/newClient.php?idPedido=<?php echo $idPedido; ?>&comanda=<?php echo $comanda; ?>" name="frmNewClient" id="frmNewClient" method="post">

						<div class="modal-header">
						<h5 class="modal-title"><i class="fa fa-plus"></i>&nbsp; Novo Cliente</h5>
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						</div>

						<div class="modal-body">

							<div class="row">

								<div class="col-lg-12">
								<div class="form-group">
								<label>Nome Completo *</label>
								<input class="form-control" autocomplete="off" name="newNome" id="newNome" type="text" required />
								</div>
								</div>

								<div class="col-lg-6">
								<div class="form-group">
								<label>Celular *</label>
								<input class="form-control" name="newCelular" id="newCelular" type="text" required />
								</div>
								</div>

								<div class="col-lg-6">
								<div class="form-group">
								<label>Data de Nascimento</label>
								<input class="form-control" name="newDataNasc" id="newDataNasc" type="text" />
								</div>
								</div>

							</div>

						</div>

						<div class="modal-footer">

							<script type="text/javascript">
							function verifyNewClient(){
								if (document.frmNewClient.newNome.value == "" || document.frmNewClient.newCelular.value == "") {
									return false;
								} else {
									//document.getElementById('frmNewTypeOfTransport').style.zIndex = '0';
									document.getElementById('btnNewClient').style.display = 'none';
									document.frmNewClient.submit();
									loading();
								}
							}
							</script>
							<button type="button" class="btn btn-success" onclick="verifyNewClient()" id="btnNewClient"><i class="fa fa-save"></i>&nbsp; Salvar</button>
						</div>

					</form>

				</div>
			</div>
		</div>

		<div class="modal fade custom-modal" tabindex="-1" role="dialog" aria-labelledby="modalAddress" aria-hidden="true" id="modalAddress">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">

					<form action="assets/functions/newAddress.php?idPedido=<?php echo $idPedido; ?>&idCliente=<?php echo $idCliente; ?>&comanda=<?php echo $comanda; ?>" name="frmAddress" id="frmAddress" method="post">

						<div class="modal-header">
						<h5 class="modal-title"><i class="fa fa-plus"></i>&nbsp; Endereço</h5>
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						</div>

						<div class="modal-body">

							<div class="row">

								<div class="col-lg-12">
								<div class="form-group">
								<label>Nome Completo</label>
								<input class="form-control" readonly value="<?php echo $viewNome; ?>" type="text" />
								</div>
								</div>

								<div class="col-lg-6">
								<div class="form-group">
								<label>Celular</label>
								<input class="form-control" readonly value="<?php echo $viewCelular; ?>" type="text" />
								</div>
								</div>

								<div class="col-lg-6">
								<div class="form-group">
								<label>Data de Nascimento</label>
								<input class="form-control" readonly value="<?php echo $viewDataNasc; ?>" type="text" />
								</div>
								</div>

								<div class="col-lg-6" id="viewEndereco">
								<div class="form-group">
								<label>Endereço</label>

								<?php

								$select = "SELECT
														endereco_cliente.id, endereco_cliente.rua, endereco_cliente.numero, endereco_cliente.bairro, endereco_cliente.complemento, endereco_cliente.descricao
													 FROM endereco_cliente
													  WHERE endereco_cliente.idCliente = '$idCliente'";
								$result = $conexao -> prepare($select);
								$result -> execute();
								$count = $result->rowCount();

									if ($data = $result -> fetch()) {
										do {

											$idEndereco     = $data['id'];
											$rua            = $data['rua'];
											$numero         = $data['numero'];
											$bairro         = $data['bairro'];
											$complemento    = $data['complemento'];
											$descricao      = $data['descricao'];

											$enderecoCompleto = "<p style='margin: 0;'>Rua ".$rua.", n°. ".$numero.", bairro ".$bairro."</p>";

											if ($complemento != "") {
												$viewComplemento = "<p style='margin: 0;'>".$complemento."</p>";
											}
											if ($descricao != "") {
												$viewDescricao = "<p style='margin: 0;'>Obs.: ".$descricao."</p>";
											}


										echo "
											<div class='form-check'>
											  <input class='form-check-input' type='radio' name='idEndereco' value='$idEndereco' checked>
											  <label class='form-check-label' for='idEndereco'>
											    $enderecoCompleto
											  </label>
											</div>
										";

									} while ($data = $result->fetch());
								} else {
									echo "
									<div class='form-check' style='display: none'>
										<input class='form-check-input' type='radio' name='idEndereco' value='' checked>
									</div>
									<p>Nenhum Endereço cadastrado!</p>";
								}

								?>
								</div>
								</div>

								<div class="animated fadeIn" id="divNewAddress" style="display: none;">

									<div class="col-lg-10">
									<div class="form-group">
									<label>Rua</label>
									<input class="form-control" name="newRua" id="newRua" type="text" value="" />
									</div>
									</div>

									<div class="col-lg-2">
									<div class="form-group">
									<label>n°</label>
									<input class="form-control" name="newNumero" id="newNumero" type="text" value="" />
									</div>
									</div>

									<div class="col-lg-6">
									<div class="form-group">
									<label>Bairro</label>
									<input class="form-control" name="newBairro" id="newBairro" type="text" value="" />
									</div>
									</div>

									<div class="col-lg-6">
									<div class="form-group">
									<label>Complemento</label>
									<input class="form-control" name="newComplemento" id="newComplemento" type="text" value="" />
									</div>
									</div>

									<div class="col-lg-12">
									<div class="form-group">
									<label>Observações</label>
									<textarea class="form-control editor" name="newDescricao" id="newDescricao" type="text"></TextArea>
									</div>
									</div>

								</div>

							</div>

						</div>

						<div class="modal-footer" style="display: flow-root;">

							<script type="text/javascript">
							function viewDivAddress() {
								document.getElementById('viewEndereco').style.display = "none";
								document.getElementsByName('idEndereco')[0].value = "";
								document.getElementById('divNewAddress').style.display = "contents";
							}
							function verifyNewAddress(){
								if (document.getElementsByName("idEndereco")[0].value == "") {
									if (document.frmAddress.newRua.value == "" || document.frmAddress.newNumero.value == "" || document.frmAddress.newBairro.value == "") {
										return false;
									} else {
										//document.getElementById('frmNewTypeOfTransport').style.zIndex = '0';
										document.getElementById('btnNewAddress').style.display = 'none';
										document.frmAddress.submit();
										loading();
									}
								} else {
									document.getElementById('btnNewAddress').style.display = 'none';
									document.frmAddress.submit();
									loading();
								}
							}
							</script>
							<button type="button" class="btn btn-secondary left" onclick="viewDivAddress()"><i class="fa fa-plus"></i>&nbsp; Novo Endereço</button>
							<button type="button" class="btn btn-success right" onclick="verifyNewAddress()" id="btnNewAddress"><i class="fa fa-save"></i>&nbsp; Salvar</button>
						</div>

					</form>

				</div>
			</div>
		</div>

    <div class="content-page">

		<!-- Start content -->
        <div class="content">

			<div class="container-fluid">

						<div class="row" style="margin-top: 6%;">


							<!-- início do formulário cadastro de cargos -->
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-12 col-xl-12">

								<div class="card mb-3 animated fadeIn" id="frmNewRequest" style="display: none;">
									<div class="card-materialIcon" style="font-size: 18px;">
										<i class="materialIconGreen fa fa-user-plus"></i> <span class="float-right">Novo pedido</span>
									</div>
									<div class="card-body">

										<form action="assets/functions/newRequest.php?comanda=<?php echo $comanda; ?>" name="newRequest" id="newRequest" method="post" enctype="multipart/form-data">

										<div class="row" style="padding-top: 20px; height: 400px;">

											<?

											$select = "SELECT id, celular, nome FROM usuarios WHERE favorito = 1 ORDER BY nome ASC";
											$result = $conexao -> prepare($select);
											$result->execute();
											$countFav = $result->rowCount();

											if ($countFav != "") {

											?>

											<div class="col-lg-3">
											<label><i class="fa fa-star" style="color: #43a047;"></i> Clientes Favoritos</label>

												<select multiple class="list-group form-control" onclick="selectClientFav()" name="clienteFav" id="clienteFav">
													<?

													if ($data = $result->fetch()) {
														do {

															$id      = $data['id'];
															$nome    = $data['nome'];
															$celular = $data['celular'];

															echo "<option value='$id' class='list-group-item'>$nome</option>";

														} while ($data = $result->fetch());
													}

													?>
												</select>

											</div>

											<?

											}

											?>

											<div class="col-lg-4">
											<div class="form-group">
											<label>Nome do Cliente</label>
											<select style="float: left; width: 80%" class="form-control select2" onchange="selectClient()" name="nomeCliente" id="nomeCliente">

											<?php

											$select = "SELECT id, celular, nome FROM usuarios";
											$result = $conexao -> prepare($select);
											$result->execute();
											$count = $result->rowCount();

											echo '<option value="">Selecione...</option>';

											if ($data = $result->fetch()) {
												do {

													$id      = $data['id'];
													$nome    = $data['nome'];
													$celular = $data['celular'];

													$nome = $nome;

													echo "<option value='$id'>$nome - $celular</option>";

												} while ($data = $result->fetch());
											}

											?>
											</select>

											<script>
											function selectClientFav() {
											  var idPedido  = document.getElementById("idPedido").value;
											  var clienteFav = document.getElementById("clienteFav").value;
											  var comanda   = document.getElementById("comanda").value;

												window.location.href='assets/functions/thereIsClient.php?idPedido=' + idPedido + '&idCliente=' + clienteFav + '&comanda=' + comanda;
											}
											</script>

											<script>
											function selectClient() {
											  var idPedido = document.getElementById("idPedido").value;
											  var idCliente = document.getElementById("nomeCliente").value;
											  var comanda = document.getElementById("comanda").value;

												window.location.href='assets/functions/thereIsClient.php?idPedido=' + idPedido + '&idCliente=' + idCliente + '&comanda=' + comanda;
											}
											</script>

											<button type="button" style="float: right;" data-toggle="modal" data-target="#modalNewClient" class="btnPlusClient btn btn-raised btn-info"><i style="padding: 5px" class="fa fa-plus-circle"></i></button>
											</div>
											</div>

										</div>

										<div class="clear-both"></div>

										<div class="modal-footer">

											<script type="text/javascript">
											function verificaNewRequest(){
												if (document.newRequest.nomeProduto.value == ""){
													return false;
												} else {
													document.newRequest.submit();
													document.getElementById('cadProd').style.visibility = 'hidden';
													document.getElementById('cadProd').style.display = 'none';
													loading();
												}
											}
											</script>
											<button type="button" class="btn btn-success" onclick="verificaNewRequest()" id="cadProd"><i class="fa fa-save"></i>&nbsp; Salvar</button>
										</div>

									</form>

									</div>
									<!-- end card-body -->

								</div>
								<!-- end card -->

								<div class="card mb-3 animated fadeIn" id="frmNewRequestFinish" style="display: none">

									<div class="card-materialIcon" style="font-size: 18px;">
										<i class="materialIconGreen fa fa-cash-register"></i> <span class="float-left" style="margin-left: 8%"><?php if (isset($_GET['comanda']) != "") { echo "Comanda n° ". $comanda; } else { echo "Pedido n° ".$idPedido; } ?></span> <span class="float-right">PDV</span>
									</div>

									<div class="card-body">

										<div class="row" style="margin-top: 20px">

											<div class="col-lg-3">
											<div class="form-group">
											<label>Nome do Cliente</label>
											<select style="float: left; width: 80%" class="form-control">

											<?php

											$select = "SELECT id, nome FROM usuarios WHERE id = '$idCliente'";
											$result = $conexao -> prepare($select);
											$result->execute();
											$count = $result->rowCount();

											if ($data = $result->fetch()) {
												do {

													$id      = $data['id'];
													$nome    = $data['nome'];

													$nome = $nome;

													echo "<option selected value='$id'>$nome</option>";

												} while ($data = $result->fetch());
											}

											?>
											</select>
											</div>
											</div>

											<div class="col-lg-3">
											<div class="form-group">
											<label>Endereço</label>

											<?php

											$select = "SELECT
																	pedidos.id, pedidos.nome, pedidos.celular, pedidos.status, pedidos.formaPagamento, pedidos.valorTotal, pedidos.data_hora_cadastro,
																	endereco_cliente.rua, endereco_cliente.numero, endereco_cliente.bairro, endereco_cliente.complemento, endereco_cliente.descricao
																 FROM pedidos
																 INNER JOIN endereco_cliente ON pedidos.idEndereco = endereco_cliente.id WHERE pedidos.id = '$idPedido' ORDER BY pedidos.id DESC";
											$result = $conexao -> prepare($select);
											$result -> execute();
											$count = $result->rowCount();

												if ($data = $result -> fetch()) {
													do {

														$dataPedido     = $data['data_hora_cadastro'];
														$dataPedido     = date("d/m/Y H:i", strtotime($dataPedido));

														$rua            = $data['rua'];
														$numero         = $data['numero'];
														$bairro         = $data['bairro'];
														$complemento    = $data['complemento'];
														$descricao      = $data['descricao'];

														$formaPagamento = $data['formaPagamento'];

														switch ($formaPagamento) {
															case 0:
																$dinheiro = "checked";
																$cartao = "";
																$dinheiroEcartao = "";
																break;

															case 1:
																$dinheiro = "checked";
																$cartao = "";
																$dinheiroEcartao = "";
																break;

															case 2:
																$dinheiro = "";
																$cartao = "checked";
																$dinheiroEcartao = "";
																break;

															case 3:
																$dinheiro = "";
																$cartao = "";
																$dinheiroEcartao = "checked";
																break;

														}

				                    $enderecoCompleto = "<p style='margin: 0;'>Rua ".$rua.", n°. ".$numero.", bairro ".$bairro."</p>";

														if ($complemento != "") {
															$viewComplemento = "<p style='margin: 0;'>".$complemento."</p>";
														}
														if ($descricao != "") {
															$viewDescricao = "<p style='margin: 0;'>Obs.: ".$descricao."</p>";
														}


													echo "
																$enderecoCompleto
																$viewComplemento
																$viewDescricao
															";

												} while ($data = $result->fetch());
											}

											?>
											</div>
											</div>

										</div>
										<hr>
										<div class="row">

										<div class="col-lg-8">
										<div class="form-group">
										<label>Produtos e Serviços</label>

										<ul class="nav nav-tabs" id="myTab" role="tablist">

											<?php
											$selectCategoria = "SELECT * FROM categorias WHERE status = 1 and id != 999 ORDER BY id ASC LIMIT 0, 1";
											$resultCategoria = $conexao -> prepare($selectCategoria);
											$resultCategoria -> execute();
											$countCategoria = $resultCategoria->rowCount();

											if ($dataCategoria = $resultCategoria -> fetch()) {
												do {

													$idCategoria = $dataCategoria['id'];
													$categoria   = $dataCategoria['nome'];
													$nameTab     = explode(" ", $categoria);

													$tab = $nameTab[0].$idCategoria;

													echo "

													<li class='nav-item'>
												    <a class='nav-link active' id='$tab-tab' data-toggle='tab' href='#$tab' role='tab' aria-controls='$tab' aria-selected='true'>$categoria</a>
												  </li>

													";
												} while($dataCategoria = $resultCategoria -> fetch());
											}

											$selectCategoria = "SELECT * FROM categorias where status = 1 and id != 999 ORDER BY id ASC LIMIT 1, 999";
											$resultCategoria = $conexao -> prepare($selectCategoria);
											$resultCategoria -> execute();
											$countCategoria = $resultCategoria->rowCount();

											if ($dataCategoria = $resultCategoria -> fetch()) {
												do {

													$idCategoria = $dataCategoria['id'];
													$categoria   = $dataCategoria['nome'];
													$nameTab     = explode(" ", $categoria);

													$tab = $nameTab[0].$idCategoria;

													echo "

													<li class='nav-item'>
												    <a class='nav-link' id='$tab-tab' data-toggle='tab' href='#$tab' role='tab' aria-controls='$tab' aria-selected='true'>$categoria</a>
												  </li>

													";
												} while($dataCategoria = $resultCategoria -> fetch());
											}

											?>

											<li class="nav-item">
										    <a class="nav-link" id="taxas-tab" data-toggle="tab" href="#taxas" role="tab" aria-controls="taxas" aria-selected="false">Taxa de Entrega</a>
										  </li>
										</ul>

										<div class="tab-content" id="myTabContent">

										<?php
										$selectCategoria = "SELECT * FROM categorias where status = 1 and id != 999  ORDER BY id ASC LIMIT 0, 1";
										$resultCategoria = $conexao -> prepare($selectCategoria);
										$resultCategoria -> execute();
										$countCategoria = $resultCategoria->rowCount();

										if ($dataCategoria = $resultCategoria -> fetch()) {
											do {

												$idCategoria = $dataCategoria['id'];
												$categoria   = $dataCategoria['nome'];
												$nameTab     = explode(" ", $categoria);

												$tab = $nameTab[0].$idCategoria;

												echo "

										  <div class='tab-pane fade show active' id='$tab' role='tabpanel' style='padding: 5px' aria-labelledby='$tab-tab'>

												";

												$select = "SELECT id, nome, foto, preco FROM produtos where categoria = $idCategoria and status = 1 and preco != '' order by id ASC";
												$result = $conexao -> prepare($select);
												$result->execute();
												$count = $result->rowCount();

												if ($data = $result->fetch()) {
													do {

														$id      = $data['id'];
														$nome    = $data['nome'];
														$banner  = $data['foto'];
														$preco   = $data['preco'];

														echo "<div class='card-body product'>

																		<img style='float: left; border-radius: 50%; display: inline-block; width: 60px; height: 60px; object-fit: cover; margin-right: 15px' src='assets/uploads/banner/$banner'>

																		<div style='float: left; width: 60%;'>
																			<h5 style='display: inline-block; float: left'><strong>$nome</strong></h5><p style='display: inline-block; float: right'><span>R$ $preco</span></p>
														      		<div>
																				<input type='text' class='form-control' style='margin-bottom: 15px' id='observacao$id' placeholder='Observação'>
																			</div>

																			<input type='text' id='idProduto$id' style='display: none;' value='$id'>
									                    <input type='text' id='viewPreco$id' style='display: none;' value='$preco'>
														";

												?>

												<div style='display: inline-block;'>
													<div class="number-input">
														<button type="button" class="btn addProduct active" onclick="this.parentNode.querySelector('input[type=number]').stepDown()" id="minus<?php echo $id; ?>" >-</button>
														<input class="quantity" min="1" name="qtd<?php echo $id; ?>" id="qtd<?php echo $id; ?>" value="1" type="number">
														<button type="button" class="btn addProduct active" onclick="this.parentNode.querySelector('input[type=number]').stepUp()" id="plus<?php echo $id; ?>" class="plus">+</button>
													</div>
												</div>
												<script>
												function incluirPedido<?php echo $id; ?>() {

													var idProduto  = document.getElementById('idProduto<?php echo $id; ?>').value;
													var observacao = document.getElementById('observacao<?php echo $id; ?>').value;
													var qtd        = document.getElementById('qtd<?php echo $id; ?>').value;
													var preco      = document.getElementById('viewPreco<?php echo $id; ?>').value;
													setCookie("idProduto" + idProduto, idProduto, 30);
													setCookie("qtdProduto" + idProduto, qtd, 30);
													setCookie("precoProduto" + idProduto, preco, 30);
													setCookie("observacao" + idProduto, observacao, 30);
													//alert("Produto: " + getCookie('idProduto' + idProduto) + " Quantidade: " + getCookie('qtdProduto' + idProduto));

												}

												</script>

												<?php

														echo "
																			<button type='button' onclick='incluirPedido$id()' style='float: right' class='btn btn-raised btn-primary'><i class='fa fa-plus'></i>&nbsp; Adicionar</button>
																		</div>
																		<div class='clearfix'></div>

																	</div>";

													} while ($data = $result->fetch());
												}

												echo "</div>";

											} while($dataCategoria = $resultCategoria -> fetch());
										}

											$selectCategoria = "SELECT * FROM categorias where status = 1 ORDER BY id ASC LIMIT 1, 999";
											$resultCategoria = $conexao -> prepare($selectCategoria);
											$resultCategoria -> execute();
											$countCategoria = $resultCategoria->rowCount();

											if ($dataCategoria = $resultCategoria -> fetch()) {
												do {

													$idCategoria = $dataCategoria['id'];
													$categoria   = $dataCategoria['nome'];
													$nameTab     = explode(" ", $categoria);

													$tab = $nameTab[0].$idCategoria;

													echo "

											  <div class='tab-pane fade' id='$tab' role='tabpanel' style='padding: 5px' aria-labelledby='$tab-tab'>

													";

												$select = "SELECT id, nome, foto, preco FROM produtos where categoria = $idCategoria and status = 1 and preco != '' order by id ASC";
												$result = $conexao -> prepare($select);
												$result->execute();
												$count = $result->rowCount();

												if ($data = $result->fetch()) {
													do {

														$id      = $data['id'];
														$nome    = $data['nome'];
														$banner  = $data['foto'];
														$preco   = $data['preco'];

														echo "<div class='card-body product'>

																		<img style='float: left; border-radius: 50%; display: inline-block; width: 60px; height: 60px; object-fit: cover; margin-right: 15px' src='assets/uploads/banner/$banner'>

																		<div style='float: left; width: 60%;'>
																			<h5 style='display: inline-block; float: left'><strong>$nome</strong></h5><p style='display: inline-block; float: right'><span>R$ $preco</span></p>
														      		<div>
																				<input type='text' class='form-control' style='margin-bottom: 15px' id='observacao$id' placeholder='Observação'>
																			</div>

																			<input type='text' id='idProduto$id' style='display: none;' value='$id'>
									                    <input type='text' id='viewPreco$id' style='display: none;' value='$preco'>
														";

												?>

												<div style='display: inline-block;'>
													<div class="number-input">
														<button type="button" class="btn addProduct active" onclick="this.parentNode.querySelector('input[type=number]').stepDown()" id="minus<?php echo $id; ?>" >-</button>
														<input class="quantity" min="1" name="qtd<?php echo $id; ?>" id="qtd<?php echo $id; ?>" value="1" type="number">
														<button type="button" class="btn addProduct active" onclick="this.parentNode.querySelector('input[type=number]').stepUp()" id="plus<?php echo $id; ?>" class="plus">+</button>
													</div>
												</div>
												<script>
												function incluirPedido<?php echo $id; ?>() {

													var idProduto  = document.getElementById('idProduto<?php echo $id; ?>').value;
													var observacao = document.getElementById('observacao<?php echo $id; ?>').value;
													var qtd        = document.getElementById('qtd<?php echo $id; ?>').value;
													var preco      = document.getElementById('viewPreco<?php echo $id; ?>').value;
													setCookie("idProduto" + idProduto, idProduto, 30);
													setCookie("qtdProduto" + idProduto, qtd, 30);
													setCookie("precoProduto" + idProduto, preco, 30);
													setCookie("observacao" + idProduto, observacao, 30);
													//alert("Produto: " + getCookie('idProduto' + idProduto) + " Quantidade: " + getCookie('qtdProduto' + idProduto));

												}

												</script>

												<?php

														echo "
																			<button type='button' onclick='incluirPedido$id()' style='float: right' class='btn btn-raised btn-primary'><i class='fa fa-plus'></i>&nbsp; Adicionar</button>
																		</div>
																		<div class='clearfix'></div>

																	</div>";

													} while ($data = $result->fetch());
												}

												echo "</div>";

											} while($dataCategoria = $resultCategoria -> fetch());
										}

										?>

											<div class="tab-pane fade" id="taxas" role="tabpanel" style="padding: 5px" aria-labelledby="taxas-tab">

												<?php

												$select = "SELECT id, nome, foto, preco FROM produtos where categoria = 999 and status = 1 and preco != '' order by id ASC";
												$result = $conexao -> prepare($select);
												$result->execute();
												$count = $result->rowCount();

												if ($data = $result->fetch()) {
													do {

														$id      = $data['id'];
														$nome    = $data['nome'];
														$banner  = $data['foto'];
														$preco   = $data['preco'];

														echo "<div div class='card-body product'>

																		<img style='float: left; border-radius: 50%; display: inline-block; width: 60px; height: 60px; object-fit: cover; margin-right: 15px' src='assets/uploads/banner/$banner'>

																		<div style='float: left; width: 60%;'>
																			<h5 style='display: inline-block; float: left'><strong>$nome</strong></h5><p style='display: inline-block; float: right'><span>R$ $preco</span></p>
														      		<div>
																				<input type='text' class='form-control' style='display: none; margin-bottom: 15px' id='observacao$id' placeholder='Observação'>
																				<div class='clearfix'></div>
																			</div>

																			<input type='text' id='idProduto$id' style='display: none;' value='$id'>
									                    <input type='text' id='viewPreco$id' style='display: none;' value='$preco'>
														";

												?>

												<div style='display: none'>
													<div class="number-input">
														<button type="button" class="btn addProduct active" onclick="this.parentNode.querySelector('input[type=number]').stepDown()" id="minus<?php echo $id; ?>" >-</button>
														<input class="quantity" min="1" name="qtd<?php echo $id; ?>" id="qtd<?php echo $id; ?>" value="1" type="number">
														<button type="button" class="btn addProduct active" onclick="this.parentNode.querySelector('input[type=number]').stepUp()" id="plus<?php echo $id; ?>" class="plus">+</button>
													</div>
												</div>
												<script>
												function incluirPedido<?php echo $id; ?>() {

													var idProduto  = document.getElementById('idProduto<?php echo $id; ?>').value;
													var observacao = document.getElementById('observacao<?php echo $id; ?>').value;
													var qtd        = document.getElementById('qtd<?php echo $id; ?>').value;
													var preco      = document.getElementById('viewPreco<?php echo $id; ?>').value;
													setCookie("idProduto" + idProduto, idProduto, 30);
													setCookie("qtdProduto" + idProduto, qtd, 30);
													setCookie("precoProduto" + idProduto, preco, 30);
													setCookie("observacao" + idProduto, observacao, 30);
													//alert("Produto: " + getCookie('idProduto' + idProduto) + " Quantidade: " + getCookie('qtdProduto' + idProduto));

												}

												</script>

												<?php

														echo "
																			<button type='button' onclick='incluirPedido$id()' style='float: right' class='btn btn-raised btn-primary'><i class='fa fa-plus'></i>&nbsp; Adicionar</button>
																		</div>
																		<div class='clearfix'></div>

																	</div>";

													} while ($data = $result->fetch());
												}

												?>

											</div>

										</div>

									</div>
									</div>

									<div class="col-lg-4">
									<label>Resumo da Compra</label>

									<script>
									function searchProduct() {

									 var idPedido  = document.getElementById("idPedido").value;
									 var idCliente = document.getElementById("idCliente").value;
									 var comanda   = document.getElementById("comanda").value;

									 var result = document.getElementById("viewRequestProduct");
									 var xmlreq = CriaRequest();

		 							 // Iniciar uma requisição
		 							 xmlreq.open("GET", "assets/functions/searchRequestProducts.php?idPedido=" + idPedido + "&idCliente=" + idCliente + "&comanda=" + comanda, true);
		 							 setTimeout(searchProduct, 1000);

		 							 // Atribui uma função para ser executada sempre que houver uma mudança de ado
		 							 xmlreq.onreadystatechange = function(){

		 								 // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
		 								 if (xmlreq.readyState == 4) {

		 									 // Verifica se o arquivo foi encontrado com sucesso
		 									 if (xmlreq.status == 200) {

		 										 result.innerHTML = xmlreq.responseText;
		 										 document.getElementById("viewRequestProduct").value = result.innerHTML;
		 									 }else{
		 										 result.innerHTML = "Erro: " + xmlreq.statusText;
		 									 }
		 								 }
		 							 };
		 							 xmlreq.send(null);
		 							}

									</script>

								<form method="post" id="finishRequest" name="finishRequest" action="assets/functions/finishRequest.php?idPedido=<?php echo $idPedido; ?>&comanda=<?php echo $comanda; ?>">

								<div id="viewRequestProduct"></div>

									<label>Forma de Pagamento</label>
									<div class="form-check">
									  <label class="form-check-label">
										<input class="form-check-input" type="radio" name="formaPagamento" id="dinheiro" value="1" <?php echo $dinheiro; ?>>
										Dinheiro
									  </label>
									</div>
									<div class="form-check">
									  <label class="form-check-label">
										<input class="form-check-input" type="radio" name="formaPagamento" id="dinheiro" <?php echo $cartao; ?> value="2">
										Cartão
									  </label>
									</div>
									<div class="form-check" style="margin-bottom: 15px">
									  <label class="form-check-label">
										<input class="form-check-input" type="radio" name="formaPagamento" id="dinheiro" <?php echo $dinheiroEcartao; ?> value="3">
										Dinheiro e Cartão
									  </label>
									</div>

									<div class="modal-footer">
										<button class="btn btn-raised btn-danger" type="button" onclick=loading();window.location.href="assets/functions/cancelRequest.php?idPedido=<?php echo $idPedido; ?>&idCliente=<?php echo $idCliente; ?>&comanda=<?php echo $comanda; ?>" style="float: right"><i class="fa fa-times"></i>&nbsp; Cancelar</button>
										<button class="btn btn-raised btn-success" type="submit" onclick="loading();" style="float: right"><i class="fa fa-check"></i>&nbsp; Finalizar Pedido</button>
									</div>

								</form>

							  </div>

								</div>

									</div>
									<!-- end card-body -->

								</div>
								<!-- end card -->


							</div>

						</div>

            </div>
			<!-- END container-fluid -->

		</div>
		<!-- END content -->

    </div>
	<!-- END content-page -->

<?php require("assets/includes/copyright.php") ?>

</div>
<!-- END main -->

<script src="assets/plugins/select2/js/select2.min.js"></script>
<script>

validaIdClient();

$(document).ready(function() {
    $('.select2').select2();
});
</script>

<script>
	$(document).ready(function(){
		$("#cnpj").inputmask("99.999.999/9999-99");
		$("#telefone").inputmask("(99) 9999-9999");
		$("#auth_usuario").inputmask("(99) 99999-9999");
		$("#celular").inputmask("(99) 99999-9999");
		$("#newCelular").inputmask("(99) 99999-9999");
	  $("#newDataNasc").inputmask("99/99/9999");
		$("#preco").maskMoney({allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
		$("#precoPromo").maskMoney({allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
	});
</script>

<script src="assets/plugins/trumbowyg/trumbowyg.min.js"></script>
<script src="assets/plugins/trumbowyg/plugins/upload/trumbowyg.upload.js"></script>
<script>
$(document).ready(function () {
    'use strict';
	$('.editor').trumbowyg();
});
</script>

<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

<script src="assets/js/detect.js"></script>
<script src="assets/js/fastclick.js"></script>
<script src="assets/js/jquery.blockUI.js"></script>
<script src="assets/js/jquery.nicescroll.js"></script>

<!-- App js -->
<script src="assets/js/pikeadmin.js"></script>

<script src="assets/plugins/jquery.filer/js/jquery.filer.min.js"></script>
<script>
$(document).ready(function(){

	'use-strict';

    //Example 2
    $('#uploadBanner').filer({
        limit: 3,
        maxSize: 3,
        extensions: ['jpg', 'jpeg', 'pdf', 'png', 'gif', 'psd'],
        changeInput: true,
        showThumbs: true,
        addMore: true,
        captions: {
            button: "<i class='fa fa-upload'></i>",
            feedback: "Selecione um arquivo...",
            feedback2: "arquivo selecionado",
            drop: "Drop file here to Upload",
            removeConfirmation: "Deseja realmente remover o arquivo?",
            errors: {
                filesLimit: "Only {{fi-limit}} files are allowed to be uploaded.",
                filesType: "Only Images are allowed to be uploaded.",
                filesSize: "{{fi-name}} is too large! Please upload file up to {{fi-maxSize}} MB.",
                filesSizeAll: "Files you've choosed are too large! Please upload files up to {{fi-maxSize}} MB."
            }
        },
    });

});
</script>

</body>
</html>
