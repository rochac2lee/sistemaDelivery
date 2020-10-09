<?php

require('assets/includes/session.php');

?>
<!DOCTYPE html>
<html lang="en">
<?php require('assets/includes/head.php')?>

<body class="adminbody" onload="hideValues(getCookie('hideValues'))">

<div id="main">

<?php require('assets/includes/menu.php')?>

<div id="loading" style="display: none; width: 100%; height: 100%; background: #000000a6; position: absolute; z-index: 999999999999;">

	<img src="assets/images/loading.gif" style="width: 10%; top: 45%; left: 50%; position: fixed;">

</div>

<script type="text/javascript">

	function loading() {
		document.getElementById('loading').style.display = 'block';
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

.opcoes {
	z-index: 1;
	width: 100%;
	height: 100%;
	background-color: #000000bf;
	position: absolute;
	margin: 0 auto;
}

.card-opcoes {
	width: 30%;
	top: 30%;
	left: 35%;
	position: fixed;
}

.inputAlertDanger {
	background: linear-gradient(60deg, #ef5350, #e53935);
	color: #fff;
}
.alertDanger {
	color: #e53935;
}
.inputAlertDanger:focus{
  color: #fff;
}

</style>

<script>

function abrirCaixa() {
	document.getElementById('opcoes').style.display='none';
	document.getElementById('tituloCaixa').innerHTML='Abertura do Caixa';
	document.getElementById('statusCaixa').selectedIndex='0';
	var x = document.getElementById('saldoAnterior').value;
	document.getElementById('saldoDia').value='0,00';
	document.getElementById('lucro').value='0,00';
	document.getElementById('saldoAtual').value = x;
	document.getElementById("frmCaixa").action = "assets/functions/openDrawer.php";
}

function reabrirCaixa() {
	document.getElementById('opcoes').style.display='none';
	document.getElementById('divDataHora').style.display='none';
	document.getElementById('divPessoa').style.display='none';
	document.getElementById('divDescricao').style.display='none';
	document.getElementById('tituloCaixa').innerHTML='Reabrir Caixa';
	document.getElementById('statusCaixa').selectedIndex='0';
	var x = document.getElementById('recuperarSaldoAnterior').value;
	document.getElementById('saldoAnterior').value= x;
	document.getElementById('saldoDia').value='0,00';
	document.getElementById('lucro').value='0,00';
	document.getElementById('saldoAtual').value='0,00';
	document.getElementById("frmCaixa").action = "assets/functions/reopenDrawer.php";
}

function fecharCaixa() {
	document.getElementById('opcoes').style.display='none';
	document.getElementById('tituloCaixa').innerHTML='Fechamento do Caixa';
	document.getElementById('statusCaixa').selectedIndex='1';
	document.getElementById("frmCaixa").action = "assets/functions/openDrawer.php";
}

function recebimento() {
	document.getElementById('opcoes').style.display='none';
	document.getElementById('categoriaRec').style.display='block';
	document.getElementById('categoriaPag').style.display='none';
	document.getElementById('titulo').innerHTML='Recebimento';
	document.getElementById('tipo').selectedIndex='0';
	document.getElementById("frmMovFin").action = "assets/functions/recipiency.php";
}

function despesaVariavel() {
	document.getElementById('opcoes').style.display='none';
	document.getElementById('categoriaRec').style.display='none';
	document.getElementById('categoriaPag').style.display='block';
	document.getElementById('titulo').innerHTML='Despesa Variável';
	document.getElementById('tipo').selectedIndex='2';
	document.getElementById("frmMovFin").action = "assets/functions/variableExpense.php";
}

function sangria() {
	document.getElementById('opcoes').style.display='none';
	document.getElementById('categoriaRec').style.display='none';
	document.getElementById('categoriaPag').style.display='block';
	document.getElementById('titulo').innerHTML='Sangria';
	document.getElementById('tipo').selectedIndex='3';
	document.getElementById("frmMovFin").action = "assets/functions/outDrawer.php";
}

function verificarSaldoLucro() {
	var lucroTotal = getCookie('lucroTotal');
	var categoria = document.getElementById('categoriaPag').value;
	var valor = document.getElementById('valor').value;

	//lucroTotal = lucroTotal.toString().replace(",", ".");
	valor = valor.toString().replace(",", ".");

	valor = parseFloat(valor);
	lucroTotal = parseFloat(lucroTotal);

	if (categoria == 37 && valor > lucroTotal) {
		document.getElementById('valor').classList.add('inputAlertDanger');
		document.getElementById('alertDanger').style.display = "block";
		document.getElementById('btnSave').disabled = true;

	} else {
		document.getElementById('valor').classList.remove('inputAlertDanger');
		document.getElementById('alertDanger').style.display = "none";
		document.getElementById('btnSave').disabled = false;
	}

}

function despesaFixa() {
	document.getElementById('opcoes').style.display='none';
	document.getElementById('categoriaRec').style.display='none';
	document.getElementById('categoriaPag').style.display='block';
	document.getElementById('titulo').innerHTML='Despesa Fixa';
	document.getElementById('tipo').selectedIndex='1';
	document.getElementById("frmMovFin").action = "assets/functions/fixedExpense.php";
}

</script>

<input type="text" value="<? echo $nav; ?>" id="navSelected" style="display: none">

<div class="modal fade custom-modal" role="dialog" aria-labelledby="modalFinanceiro" id="modalFinanceiro">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			<form name="frmMovFin" id="frmMovFin" method="post">

				<div class="modal-header">
				<h5 class="modal-title" id="titulo"><i class="fa fa-plus"></i>&nbsp; Novo Registro</h5>
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				</div>

				<div class="modal-body">

					<div class="row">

						<div class="col-lg-3">
						<div class="form-group">
						<label>Tipo</label>
						<select class="form-control" readonly name="tipo" id="tipo">
							<option value="1">Recebimento</option>
							<option value="2">Despesa Fixa</option>
							<option value="3">Despesa Variável</option>
							<option value="4">Sangria</option>
						</select>
						</div>
						</div>

						<div class="col-lg-3">
						<div class="form-group">
						<label>Categoria</label>
						<select class="form-control" name="categoriaRec" id="categoriaRec" style="display: none;">
							<?php

							$select = "SELECT id, nome FROM categoria_contas_rec ORDER BY nome ASC";
							$result = $conexao -> prepare($select);
							$result->execute();
							$count = $result->rowCount();

							echo '<option value="">Selecione...</option>';

							if ($data = $result->fetch()) {
								do {

									$id      = $data['id'];
									$nome    = $data['nome'];

									$nome = utf8_encode($nome);

									if ($idUsuarioActual == $id)
									echo "<option selected value='$id'>$nome</option>";
									else
									echo "<option value='$id'>$nome</option>";

								} while ($data = $result->fetch());
							}

							?>
						</select>

						<select class="form-control" name="categoriaPag" onchange="verificarSaldoLucro()" id="categoriaPag" style="display: none;">
							<?php

							$select = "SELECT id, nome FROM categoria_contas_pag ORDER BY nome ASC";
							$result = $conexao -> prepare($select);
							$result->execute();
							$count = $result->rowCount();

							echo '<option value="">Selecione...</option>';

							if ($data = $result->fetch()) {
								do {

									$id      = $data['id'];
									$nome    = $data['nome'];

									$nome = utf8_encode($nome);

									echo "<option value='$id'>$nome</option>";

								} while ($data = $result->fetch());
							}

							?>
						</select>

						</div>
						</div>

						<div class="col-lg-3">
						<div class="form-group">
						<label>Data de Vencimento</label>
						<input class="form-control" name="dataVenc" id="dataVenc" type="date" />
						</div>
						</div>

						<div class="col-lg-3">
						<div class="form-group">
						<label>Data de Referência</label>
						<input class="form-control" name="dataRef" id="dataRef" type="date" />
						</div>
						</div>

						<div class="col-lg-8">
						<div class="form-group">
						<label>Descricao</label>
						<input class="form-control" name="descricao" id="descricao" type="text" />
						</div>
						</div>

						<div class="col-lg-4">
						<div class="form-group">
						<label>Pessoa</label>
						<select style="width: 100%" class="form-control select2" name="pessoa" id="pessoa">
						<?php

						$select = "SELECT id, celular, nome FROM usuarios ORDER BY nome ASC";
						$result = $conexao -> prepare($select);
						$result->execute();
						$count = $result->rowCount();

						echo '<option value="">Selecione...</option>';

						if ($data = $result->fetch()) {
							do {

								$id      = $data['id'];
								$nome    = $data['nome'];
								$celular = $data['celular'];

								$nome = utf8_encode($nome);

								echo "<option value='$id'>$nome</option>";

							} while ($data = $result->fetch());
						}

						?>
						</select>
						</div>
						</div>

						<div class="col-lg-3">
						<div class="form-group">
						<label>Valor</label>
						<input class="form-control" name="valor" onchange="verificarSaldoLucro()" id="valor" type="text" />
						<p class="animated fadeIn" id="alertDanger" style="display: none;">Saldo Insuficiente!</p>
						</div>
						</div>

						<div class="col-lg-3">
						<div class="form-group">
						<label>N° Documento</label>
						<input class="form-control" name="nDoc" id="nDoc" type="text" />
						</div>
						</div>

						<div class="col-lg-3">
						<div class="form-group">
						<label>Cód. Tipo Documento</label>
						<select class="form-control" name="codTipoDoc" id="codTipoDoc" />
							<option value="1">Dinheiro</option>
							<option value="2">Cartão Crédito</option>
							<option value="3">Cartão Débito</option>
							<option value="4">Débito em Conta</option>
							<option value="5">Vale</option>
							<option value="6">Bonificação</option>
							<option value="7">Transferência Bancária (TED)</option>
						</select>
						</div>
						</div>

						<div class="col-lg-3">
						<div class="form-group">
						<label>Status</label>
						<select style="width: 100%" class="form-control" name="statusItem" id="statusItem">
							<option selected value='1'>Baixar Título</option>
							<option value='0'>Pendente</option>
						</select>
						</div>
						</div>

						<div class="col-lg-12">
						<div class="form-group">
						<label>Observações</label>
						<textarea class="form-control editor" name="newDescricao" id="descricaoFinanceiro" type="text"></TextArea>
						</div>
						</div>

					</div>

				</div>

				<div class="modal-footer">
					<button type="submit" onclick="loading()" id="btnSave" class="btn btn-success"><i class="fa fa-save"></i>&nbsp; Salvar</button>
				</div>

			</form>

		</div>
	</div>
</div>

<div class="modal fade custom-modal" role="dialog" aria-labelledby="modalCaixa" id="modalCaixa">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			<form name="frmCaixa" id="frmCaixa" method="post">

				<div class="modal-header">
				<h5 class="modal-title" id="tituloCaixa"><i class="fa fa-plus"></i>&nbsp; Novo Registro</h5>
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				</div>

				<div class="modal-body">

					<div class="row">

						<div class="col-lg-4" id="divStatusCaixa">
						<div class="form-group">
						<label>Status</label>
						<select class="form-control" readonly name="statusCaixa" id="statusCaixa">
							<option value="1">Abertura</option>
							<option value="0">Fechamento</option>
						</select>
						</div>
						</div>

						<div class="col-lg-4" id="divDataHora">
						<div class="form-group">
						<label>Data e Hora</label>
						<input class="form-control" name="dataHora" id="dataHora" type="datetime-local" />
						</div>
						</div>

						<div class="col-lg-4" id="divPessoa">
						<div class="form-group">
						<label>Pessoa</label>
						<select style="width: 100%" class="form-control select2" name="pessoa" id="pessoaCaixa">
						<?php

						$select = "SELECT id, celular, nome FROM usuarios ORDER BY nome ASC";
						$result = $conexao -> prepare($select);
						$result->execute();
						$count = $result->rowCount();

						echo '<option value="">Selecione...</option>';

						if ($data = $result->fetch()) {
							do {

								$id      = $data['id'];
								$nome    = $data['nome'];
								$celular = $data['celular'];

								$nome = utf8_encode($nome);

								if ($idUsuarioActual == $id)
								echo "<option selected value='$id'>$nome</option>";
								else
								echo "<option value='$id'>$nome</option>";

							} while ($data = $result->fetch());
						}

						?>
						</select>
						</div>
						</div>

						<?php

						$select = "SELECT * FROM caixa WHERE status = 0 ORDER BY id DESC LIMIT 1";
						$result = $conexao -> prepare($select);
						$result->execute();
						$count = $result->rowCount();

						if ($data = $result->fetch()) {
							do {

								$saldoAnterior = $data['saldo_atual'];
								$saldoAnterior = preg_replace('/[^0-9]+/','.',$saldoAnterior);

							} while ($data = $result -> fetch());
						}

						$select = "SELECT * FROM caixa WHERE status = 1 ORDER BY id DESC LIMIT 1";
						$result = $conexao -> prepare($select);
						$result->execute();
						$count = $result->rowCount();

						if ($data = $result->fetch()) {
							do {

								$viewIdCaixa = $data['id'];

							} while ($data = $result -> fetch());
						}

						$select = "SELECT
						            pedidos.id, pedidos.status, pedidos.formaPagamento, pedidos.valorTotal, pedidos.data_hora_cadastro, pedidos.data_hora_atualizacao,
						            usuarios.id as idCliente, usuarios.nome as nomeCliente,
						            endereco_cliente.rua, endereco_cliente.numero, endereco_cliente.bairro, endereco_cliente.complemento, endereco_cliente.descricao
						           FROM pedidos
						           INNER JOIN usuarios ON pedidos.idCliente = usuarios.id
						           INNER JOIN endereco_cliente ON pedidos.idEndereco = endereco_cliente.id
						           LEFT JOIN caixa ON pedidos.idCaixa = caixa.id
						           WHERE pedidos.idCaixa = '$viewIdCaixa'
						           ORDER BY pedidos.id DESC";
						$result = $conexao -> prepare($select);
						$result -> execute();

						if ($data = $result -> fetch()) {
							do {

								$viewIdPedido       = $data['id'];

								$selectProduto = "SELECT
																	produtos.id, produtos.nome, produtos.lucro, produtos.foto, produtos.preco,
																	pedido_itens.quantidade, pedido_itens.observacao
																	FROM produtos
																	INNER JOIN pedido_itens ON produtos.id = pedido_itens.idProduto
																	WHERE pedido_itens.idPedido = '$viewIdPedido' and produtos.categoria != 999
																	ORDER BY produtos.id ASC";
								$resultProduto = $conexao -> prepare($selectProduto);
								$resultProduto -> execute();
								$countProduto = $resultProduto->rowCount();

								if ($dataProduto = $resultProduto -> fetch()) {
									do {

										$qtdProduto  = $dataProduto['quantidade'];
										$lucro       = $dataProduto['lucro'];

										$lucro = preg_replace('/[^0-9]+/','.',$lucro);

										$totalLucro  = $totalLucro + ($qtdProduto * $lucro);

									} while ($dataProduto = $resultProduto->fetch());
								}

							} while ($data = $result->fetch());
						}

						$vendasDia     = $_COOKIE["pedidosDia"];
						$vendasDia     = preg_replace('/[^0-9]+/','.',$vendasDia);

						$saldoAtualizado = $_COOKIE["caixa"];
						$saldoAtualizado = preg_replace('/[^0-9]+/','.',$saldoAtualizado);

						$saldoAtual = ($saldoAtualizado - $totalLucro);

						$saldoAnterior = number_format($saldoAnterior, 2, ',', '.');
						$vendasDia     = number_format($vendasDia, 2, ',', '.');
						$saldoAtual    = number_format($saldoAtual, 2, ',', '.');
						$totalLucro    = number_format($totalLucro, 2, ',', '.');

						//Recuperar ultimo caixa para reabrir

						$select = "SELECT * FROM caixa WHERE status = 0 ORDER BY id DESC LIMIT 1";
						$result = $conexao -> prepare($select);
						$result->execute();
						$count = $result->rowCount();

						if ($data = $result->fetch()) {
							do {

								$RecuperarSaldoAnterior = $data['saldo_anterior'];

							} while ($data = $result -> fetch());
						}

						?>

						<input style="display: none" name="recuperarSaldoAnterior" id="recuperarSaldoAnterior" type="text" value="<?php echo $RecuperarSaldoAnterior; ?>" />

						</div>

						<div class="row">

						<div class="col-lg-3" id="divSaldoAnterior">
						<div class="form-group">
						<label>Saldo Anterior</label>
						<input class="form-control" name="saldoAnterior" id="saldoAnterior" type="text" value="<?php echo $saldoAnterior; ?>" />
						</div>
						</div>

						<div class="col-lg-3" id="divSaldoDia">
						<div class="form-group">
						<label>Saldo do Dia</label>
						<input class="form-control" name="saldoDia" id="saldoDia" type="text" value="<?php echo $vendasDia; ?>" />
						</div>
						</div>

						<div class="col-lg-3" id="divlucro">
						<div class="form-group">
						<label>Lucro do Dia</label>
						<input class="form-control" name="lucro" id="lucro" value="<?php echo $totalLucro; ?>" type="text" />
						</div>
						</div>

						<div class="col-lg-3" id="divSaldoAtual">
						<div class="form-group">
						<label>Saldo Atual</label>
						<input class="form-control" name="saldoAtual" id="saldoAtual" type="text" value="<?php echo $saldoAtual; ?>" />
						</div>
						</div>

						<div class="col-lg-12" id="divDescricao">
						<div class="form-group">
						<label>Observações</label>
						<textarea class="form-control editor" name="newDescricao" id="descricaoCaixa" type="text"></TextArea>
						</div>
						</div>

					</div>

				</div>

				<div class="modal-footer">
					<button type="submit" onclick="loading()" class="btn btn-success"><i class="fa fa-save"></i>&nbsp; Salvar</button>
				</div>

			</form>

		</div>
	</div>
</div>

<div class="animated fadeIn card-mb-3 opcoes" id="opcoes" style="display: none">
	<div class="card card-opcoes" style="border: 1px solid #262d33; border-radius: 0px">
		<div class="modal-header" style="background-color: #262d33; color: #fff; border-bottom: 1px solid #262d33; border-radius: 0px">
			<h5 class="modal-title" style="float: left"><i class="fa fa-plus"></i>&nbsp; Novo Registro</h5>
			<button type="button" class="close" style="float: right" onclick=document.getElementById('opcoes').style.display='none'><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
		</div>
		<div class="card-body">
			<div class="col-lg-12">
				<div class="row">
					<?php

					$select = "SELECT * FROM caixa ORDER BY id DESC LIMIT 1";
					$result = $conexao -> prepare($select);
					$result -> execute();
					$count = $result->rowCount();

					if ($data = $result -> fetch()) {
						do {

							$statusCaixa = $data['status'];

							if ($statusCaixa == 0) {
								echo '
								<div class="col-lg-6">
								<button type="button" data-toggle="modal" data-target="#modalCaixa" onclick="abrirCaixa()" style="width: 100%; height: 60px;" class="btn btn-raised btn-info"> Abertura do Caixa</button>
								</div>
								<div class="col-lg-6">
								<button type="button" data-toggle="modal" data-target="#modalCaixa" onclick="reabrirCaixa()" style="width: 100%; height: 60px;" class="btn btn-raised btn-secondary">Reabrir Caixa</button>
								</div>
								';
							} else {
								echo '
								<div class="col-lg-6">
									<button type="button" data-toggle="modal" data-target="#modalFinanceiro" onclick="recebimento()" style="width: 100%; height: 130px;" class="btn btn-raised btn-success"><i style="margin-bottom: 5px" class="fa fa-2x fa-dollar-sign"></i><br>Recebimentos</button>
								</div>
								<div class="col-lg-6">
									<button type="button" data-toggle="modal" data-target="#modalFinanceiro" onclick="despesaVariavel()" style="width: 100%; height: 60px; margin-bottom: 5px" class="btn btn-raised btn-primary">Despesas Variáveis</button>
									<button type="button" data-toggle="modal" data-target="#modalFinanceiro" onclick="despesaFixa()" style="width: 100%; height: 60px; margin-top: 5px" class="btn btn-raised btn-primary">Despesas Fixas</button>
								</div>
								<div class="col-lg-6">
									<button type="button" data-toggle="modal" data-target="#modalCaixa" onclick="fecharCaixa()" style="margin-top: 15px; width: 100%; height: 60px;" class="btn btn-raised btn-danger">Fechamento do Caixa</button>
								</div>
								<div class="col-lg-6">
									<button type="button" data-toggle="modal" data-target="#modalFinanceiro" onclick="sangria()" style="margin-top: 15px; width: 100%; height: 60px;" class="btn btn-raised btn-info">Sangria</button>
								</div>
								';
							}

						} while ($data = $result -> fetch());
					} else {
						echo '
						<button type="button" data-toggle="modal" data-target="#modalCaixa" onclick="abrirCaixa()" style="width: 100%; height: 60px;" class="btn btn-raised btn-info"><i class="fa fa-dollar-sign"></i> Abertura do Caixa</button>
						';
					}
					?>
				</div>
			</div>
		</div>
	</div>
</div>

    <div class="content-page">

		<!-- Start content -->
        <div class="content">

			<div class="container-fluid">

						<div class="row">
								<div class="col-xl-12">
										<div class="breadcrumb-holder">
												<h1 class="main-title float-left">Movimento Financeiro</h1>
												<ol class="breadcrumb float-right">
													<li class="breadcrumb-item">
														<!--<button  data-toggle="modal" data-target="#modalNewClient" class="btn btn-raised btn-info" id="btnNewRequest"><i class="fa fa-plus-circle"></i>&nbsp; Inserir</button> -->
														<button  onclick=document.getElementById('opcoes').style.display='block' class="btn btn-raised btn-info" id="btnNewRequest"><i class="fa fa-plus-circle"></i>&nbsp; Inserir</button>
														<button onclick="hideNewRequest()" style="display: none;" class="btn btn-raised btn-secondary" id="btnClose"><i class="fa fa-times-circle"></i>&nbsp; Cancelar</button>
													</li>
												</ol>
												<div class="clearfix"></div>
										</div>
								</div>
						</div>
						<!-- end row -->

						<div class="row">

<script>
	function hideValues(hideValues) {
		setCookie("hideValues", hideValues, 30);
		var x = getCookie("hideValues");
		if (x == 0) {
			document.getElementById('eye').style.display = "block";
			document.getElementById('noEye').style.display = "none";

			document.getElementById('viewEntradas').style.display = "none";
			document.getElementById('viewSaidas').style.display = "none";
			document.getElementById('viewLucro').style.display = "none";
			document.getElementById('viewTotal').style.display = "none";
			document.getElementById('viewUltimoLucro').style.display = "none";
			document.getElementById('viewUltimoValor').style.display = "none";

			document.getElementById('maskEntradas').style.display = "block";
			document.getElementById('maskSaidas').style.display = "block";
			document.getElementById('maskLucro').style.display = "block";
			document.getElementById('maskTotal').style.display = "block";
			document.getElementById('maskUltimoLucro').style.display = "block";
			document.getElementById('maskUltimoValor').style.display = "block";
		} else {
			document.getElementById('eye').style.display = "none";
			document.getElementById('noEye').style.display = "block";

			document.getElementById('viewEntradas').style.display = "block";
			document.getElementById('viewSaidas').style.display = "block";
			document.getElementById('viewLucro').style.display = "block";
			document.getElementById('viewTotal').style.display = "block";
			document.getElementById('viewUltimoLucro').style.display = "block";
			document.getElementById('viewUltimoValor').style.display = "block";

			document.getElementById('maskEntradas').style.display = "none";
			document.getElementById('maskSaidas').style.display = "none";
			document.getElementById('maskLucro').style.display = "none";
			document.getElementById('maskTotal').style.display = "none";
			document.getElementById('maskUltimoLucro').style.display = "none";
			document.getElementById('maskUltimoValor').style.display = "none";
		}
	}

</script>

							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-12 col-xl-12">

								<ul class="nav nav-tabs" id="myTab" role="tablist">
								  <li class="nav-item">
								    <a onclick=changeFinanceNavActive("entradas") class="nav-link" id="entradas-tab" href="?nav=entradas">Entradas</a>
								  </li>
								  <li class="nav-item">
								    <a onclick=changeFinanceNavActive("saidas") class="nav-link" id="saidas-tab" href="?nav=saidas">Saídas</a>
								  </li>
								  <li class="nav-item">
								    <a onclick=changeFinanceNavActive("resultado") class="nav-link" id="resultado-tab" href="?nav=resultado">Resultado</a>
								  </li>
									<li class="nav-item ml-auto">
										<button onclick="hideValues(1);" id="eye" style="display: none" class="btn btn-raised active label-red"><i class="fas fa-eye"></i></button>
										<button onclick="hideValues(0);" id="noEye" class="btn btn-raised active label-red"><i class="fas fa-eye-slash"></i></button>
								  </li>
								</ul>
								<div class="tab-content" id="myTabContent">
								  <div class="tab-pane fade" id="entradas" role="tabpanel" aria-labelledby="entradas-tab">

										<ul class="nav nav-tabs" id="myTab2" role="tablist" style="margin-top: 15px;">
										  <li class="nav-item">
										    <a onclick=changeFinanceNavActive("entradasPedidos") class="nav-link" id="pedidos-tab" href="?nav=entradasPedidos" aria-controls="pedidos">Pedidos</a>
										  </li>
										  <li class="nav-item">
										    <a onclick=changeFinanceNavActive("entradasCaixa") class="nav-link" id="entradas-caixa-tab"  href="?nav=entradasCaixa" aria-controls="entradasCaixa">Entradas</a>
										  </li>
										</ul>

										<div class="tab-content" id="myTabContent">

											<div class="tab-pane fade" id="entradasPedidos" role="tabpanel" aria-labelledby="pedidos-tab">
												<? require("assets/includes/financeRequests.php"); ?>
											</div>

											<div class="tab-pane fade" id="entradasCaixa" role="tabpanel" aria-labelledby="entradas-caixa-tab">
												<? require("assets/includes/financeInputs.php"); ?>
											</div>

										</div>

									</div>
								  <div class="tab-pane fade <?php echo $navContentSai ?>" id="saidas" role="tabpanel" aria-labelledby="saidas-tab">

										<ul class="nav nav-tabs" id="myTab2" role="tablist" style="margin-top: 15px;">
										  <li class="nav-item">
										    <a onclick=changeFinanceNavActive("saidasDiversos") class="nav-link" id="saidas-diversos-tab" href="?nav=saidasDiversos" aria-controls="saidasDiversos">Saídas</a>
										  </li>
										  <li class="nav-item">
										    <a onclick=changeFinanceNavActive("saidasSangria") class="nav-link" id="saidas-sangria-tab"  href="?nav=saidasSangria" aria-controls="saidasSangria">Sangria</a>
										  </li>
										</ul>

										<div class="tab-content" id="myTabContent">

											<div class="tab-pane fade" id="saidasDiversos" role="tabpanel" aria-labelledby="saidas-diversos-tab">
												<? require("assets/includes/financeOutputs.php"); ?>
											</div>

											<div class="tab-pane fade" id="saidasSangria" role="tabpanel" aria-labelledby="saidas-sangria-tab">
												<? require("assets/includes/financeOutDrawer.php"); ?>
											</div>

										</div>

									</div>
								  <div class="tab-pane fade <?php echo $navContentRes ?>" id="resultado" role="tabpanel" aria-labelledby="resultado-tab">

										<div class="card mb-3 animated fadeIn">
											<div class="card-body">

													<?php

													//Total dos Pedidos
													$select = "SELECT
																			SUM(CAST(REPLACE(REPLACE(valorCobrado, '.', ''),',','.') AS DECIMAL(18,2))) as total
																			FROM pedidos
																		 ORDER BY id ASC";
													$result = $conexao -> prepare($select);
													$result -> execute();
													$count = $result->rowCount();
													$total = 0;

													if ($data = $result -> fetch()) {
														do {

															$totalPedidos   = $data['total'];

														} while ($data = $result->fetch());
													}

													//Total das Entradas
													$select = "SELECT
																			SUM(CAST(REPLACE(REPLACE(valor, '.', ''),',','.') AS DECIMAL(18,2))) as total
																			FROM contas_rec
																		 ORDER BY id ASC";
													$result = $conexao -> prepare($select);
													$result -> execute();
													$count = $result->rowCount();
													$total = 0;

													if ($data = $result -> fetch()) {
														do {

															$totalEntradas   = $data['total'];

														} while ($data = $result->fetch());
													}

													//Total das Saídas
													$select = "SELECT
																			SUM(CAST(REPLACE(REPLACE(valor, '.', ''),',','.') AS DECIMAL(18,2))) as total
																			FROM contas_pag
																		 ORDER BY id ASC";
													$result = $conexao -> prepare($select);
													$result -> execute();
													$count = $result->rowCount();
													$total = 0;

													if ($data = $result -> fetch()) {
														do {

															$totalSaidas = $data['total'];

														} while ($data = $result->fetch());
													}

													$selectSanLucro = "SELECT categoria, valor, baixa FROM contas_san WHERE categoria = 37";
													$resultSanLucro = $conexao -> prepare($selectSanLucro);
													$resultSanLucro->execute();
													$countSanLucro = $resultSanLucro->rowCount();

													if ($dataSanLucro = $resultSanLucro -> fetch()) {
														do {

															$categoria          = $dataSanLucro['categoria'];
															$valor              = $dataSanLucro['valor'];
															$baixa              = $dataSanLucro['baixa'];

															if ($baixa == 1) {
																$retiradaLucro      = preg_replace('/[^0-9]+/','.',$valor);
																$totalRetiradaLucro = preg_replace('/[^0-9]+/','.',$totalRetiradaLucro);
																$totalRetiradaLucro += $retiradaLucro;
															}

														} while ($dataSanLucro = $resultSanLucro -> fetch());
													}

													$selectSanLucro = "SELECT categoria, valor, baixa FROM contas_san WHERE categoria != 37";
													$resultSanLucro = $conexao -> prepare($selectSanLucro);
													$resultSanLucro->execute();
													$countSanLucro = $resultSanLucro->rowCount();

													if ($dataSanLucro = $resultSanLucro -> fetch()) {
														do {

															$categoria          = $dataSanLucro['categoria'];
															$valor              = $dataSanLucro['valor'];
															$baixa              = $dataSanLucro['baixa'];

															if ($baixa == 1) {
																$viewSangria  = preg_replace('/[^0-9]+/','.',$valor);
																$totalSangria = preg_replace('/[^0-9]+/','.',$totalSangria);
																$totalSangria += $viewSangria;
															}

														} while ($dataSanLucro = $resultSanLucro -> fetch());
													}

													$selectLucro = "SELECT * FROM caixa order by id DESC";
													$resultLucro = $conexao -> prepare($selectLucro);
													$resultLucro->execute();
													$countLucro = $resultLucro->rowCount();

													if ($dataLucro = $resultLucro -> fetch()) {
														do {

															$viewLucro = $dataLucro['lucro'];
															$viewLucro = preg_replace('/[^0-9]+/','.',$viewLucro);

															$lucroTotal += $viewLucro;

														} while ($dataLucro = $resultLucro -> fetch());
													}

													$lucroTotal -= $totalRetiradaLucro;

													$selectLucro = "SELECT * FROM caixa order by id DESC LIMIT 1";
													$resultLucro = $conexao -> prepare($selectLucro);
													$resultLucro->execute();
													$countLucro = $resultLucro->rowCount();

													if ($dataLucro = $resultLucro -> fetch()) {
														do {

															$ultimoLucro = $dataLucro['lucro'];
															$ultimoLucro = preg_replace('/[^0-9]+/','.',$ultimoLucro);

														} while ($dataLucro = $resultLucro -> fetch());
													}

													$totalEntradas = ($totalPedidos + $totalEntradas);

													$totalResultado = (($totalEntradas - $totalSaidas) - $lucroTotal);

													$selectResAnter = "SELECT valor FROM contas_pag order by id DESC LIMIT 1";
													$resultResAnter = $conexao -> prepare($selectResAnter);
													$resultResAnter->execute();
													$countResAnter = $resultResAnter->rowCount();

													if ($dataResAnter = $resultResAnter -> fetch()) {
														do {

															$ultimoValorPago   = $dataResAnter['valor'];
															$ultimoValorPago = preg_replace('/[^0-9]+/','.',$ultimoValorPago);

														} while ($dataResAnter = $resultResAnter -> fetch());
													}

													$resultadoAnterior = $ultimoValorPago + $totalResultado;

													$cookie_name = "lucroTotal";
													setcookie($cookie_name, $lucroTotal, time() + (86400 * 30), "/sistemaDelivery");

													$totalPedidos      = number_format($totalPedidos, 2, ',', '.');
													$totalEntradas     = number_format($totalEntradas, 2, ',', '.');
													$totalSaidas       = number_format($totalSaidas, 2, ',', '.');
													$totalResultado    = number_format($totalResultado, 2, ',', '.');
													$lucroTotal        = number_format($lucroTotal, 2, ',', '.');
													$ultimoLucro       = number_format($ultimoLucro, 2, ',', '.');
													$resultadoAnterior = number_format($resultadoAnterior, 2, ',', '.');

													$cookie_name = "caixa";
													setcookie($cookie_name, $totalResultado, time() + (86400 * 30), "/sistemaDelivery");

													echo '

													<div class="row">

														<div class="col-xs-12 col-md-6 col-lg-6 col-xl-6">
															<div class="card-box noradius noborder bg-warning">
																<i class="float-right text-white"></i>
																<h6 class="text-white text-uppercase m-b-20">Entradas</h6>
																<h1 id="viewEntradas" class="m-b-20 text-white">R$ '.$totalEntradas.'</h1>
																<h1 id="maskEntradas" style="display: none" class="m-b-20 text-white">R$ *.***,**</h1>
															</div>
														</div>

														<div class="col-xs-12 col-md-6 col-lg-6 col-xl-6">
															<div class="card-box noradius noborder bg-secondary">
																<i class="float-right text-white"></i>
																<h6 class="text-white text-uppercase m-b-20">Saídas</h6>
																<h1 id="viewSaidas" class="m-b-20 text-white">R$ '.$totalSaidas.'</h1>
																<h1 id="maskSaidas" style="display: none" class="m-b-20 text-white">R$ *.***,**</h1>
															</div>
														</div>

														<div class="col-xs-12 col-md-6 col-lg-6 col-xl-6">
															<div class="card-box noradius noborder bg-green">
																<i class="float-right text-white"></i>
																<h6 class="text-white left text-uppercase m-b-20">Lucro Acumulado</h6>
																<p id="viewUltimoLucro" class="label-right white">Último Valor: R$ '.$ultimoLucro.'</p>
																<p id="maskUltimoLucro" style="display: none" class="label-right white">Último Valor: R$ **,**</p>
																<div class="clearfix"></div>
																<h1 id="viewLucro" class="m-b-20 text-white">R$ '.$lucroTotal.'</h1>
																<h1 id="maskLucro" style="display: none" class="m-b-20 text-white">R$ *.***,**</h1>
															</div>
														</div>

														<div class="col-xs-12 col-md-6 col-lg-6 col-xl-6">
															<div class="card-box noradius noborder bg-success">
																<i class="float-right text-white"></i>
																<h6 class="text-white left text-uppercase m-b-20">Caixa</h6>
																<p id="viewUltimoValor" class="label-right white">Último Valor: R$ '.$resultadoAnterior.'</p>
																<p id="maskUltimoValor" style="display: none" class="label-right white">Último Valor: R$ **,**</p>
																<div class="clearfix"></div>
																<h1 id="viewTotal" class="m-b-20 text-white">R$ '.$totalResultado.'</h1>
																<h1 id="maskTotal" style="display: none" class="m-b-20 text-white">R$ *.***,**</h1>
															</div>
														</div>

													</div>
													';
												?>

											</div>
										</div> <!-- end card -->

									</div>
								</div>


							</div>

						</div>

            </div>
			<!-- END container-fluid -->

		</div>
		<!-- END content -->

    </div>
	<!-- END content-page -->

</div>
<!-- END main -->

<script src="assets/plugins/select2/js/select2.min.js"></script>
<script>

function changeFinanceNavActive(financeNav) {

	setCookie("navFinance", financeNav, 30);

}

function resetNavFinance() {
	setCookie("navFinance", '', 30);
}

var viewFinanceNav = getCookie('navFinance');
switch (viewFinanceNav) {
	case "entradas":
	document.getElementById("entradas-tab").classList.add("active");
	document.getElementById("pedidos-tab").classList.add("active");
	document.getElementById("entradas").classList.add("show");
	document.getElementById("entradas").classList.add("active");
	document.getElementById("entradasPedidos").classList.add("show");
	document.getElementById("entradasPedidos").classList.add("active");
	break;

	case "entradasPedidos":
	document.getElementById("entradas-tab").classList.add("active");
	document.getElementById("pedidos-tab").classList.add("active");
	document.getElementById("entradas").classList.add("show");
	document.getElementById("entradas").classList.add("active");
	document.getElementById("entradasPedidos").classList.add("show");
	document.getElementById("entradasPedidos").classList.add("active");
	break;

	case "entradasCaixa":
	document.getElementById("entradas-tab").classList.add("active");
	document.getElementById("entradas-caixa-tab").classList.add("active");
	document.getElementById("entradas").classList.add("show");
	document.getElementById("entradas").classList.add("active");
	document.getElementById("entradasCaixa").classList.add("show");
	document.getElementById("entradasCaixa").classList.add("active");
	break;

	case "saidas":
	document.getElementById("saidas-tab").classList.add("active");
	document.getElementById("saidas-diversos-tab").classList.add("active");
	document.getElementById("saidas").classList.add("show");
	document.getElementById("saidas").classList.add("active");
	document.getElementById("saidasDiversos").classList.add("show");
	document.getElementById("saidasDiversos").classList.add("active");
	break;

	case "saidasDiversos":
	document.getElementById("saidas-tab").classList.add("active");
	document.getElementById("saidas-diversos-tab").classList.add("active");
	document.getElementById("saidas").classList.add("show");
	document.getElementById("saidas").classList.add("active");
	document.getElementById("saidasDiversos").classList.add("show");
	document.getElementById("saidasDiversos").classList.add("active");
	break;

	case "saidasSangria":
	document.getElementById("saidas-tab").classList.add("active");
	document.getElementById("saidas-sangria-tab").classList.add("active");
	document.getElementById("saidas").classList.add("show");
	document.getElementById("saidas").classList.add("active");
	document.getElementById("saidasSangria").classList.add("show");
	document.getElementById("saidasSangria").classList.add("active");
	break;

	case "resultado":
	document.getElementById("resultado-tab").classList.add("active");
	document.getElementById("resultado").classList.add("show");
	document.getElementById("resultado").classList.add("active");
	break;

}

//pega o parametro da url
const queryString = window.location.search;
const urlParams   = new URLSearchParams(queryString);
const openDrawer  = urlParams.get('openDrawer');

if (openDrawer == 1) {
	$(document).ready(function() {
		$('#modalCaixa').modal('show');
		abrirCaixa();
	});
}

$(document).ready(function() {
    $('#pessoa').select2();
    $('#pessoaCaixa').select2();
});
</script>

<script>
	$(document).ready(function(){
		$("#cnpj").inputmask("99.999.999/9999-99");
		$("#telefone").inputmask("(99) 9999-9999");
		$("#auth_usuario").inputmask("(99) 99999-9999");
		$("#celular").inputmask("(99) 99999-9999");
		$("#newCelular").inputmask("(99) 99999-9999");
		$("#saldoAnterior").maskMoney({allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
		$("#saldoDia").maskMoney({allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
		$("#saldoAtual").maskMoney({allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
		$("#lucro").maskMoney({allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
		$("#valor").maskMoney({allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
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

</body>
</html>
