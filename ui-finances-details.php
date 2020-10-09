<?php

require('assets/includes/session.php');

$idItem        = $_GET['id'];
$viewCategoria = $_GET['categoria'];

?>
<!DOCTYPE html>
<html lang="en">
<?php require('assets/includes/head.php')?>

<body class="adminbody">

	<div id="main">

		<?php require('assets/includes/menu.php')?>

		<div id="loading" style="display: none; width: 100%; height: 100%; background: #000000a6; position: absolute; z-index: 1;">

			<img src="assets/images/loading.gif" style="width: 10%; top: 45%; left: 50%; position: fixed;">

		</div>

		<script type="text/javascript">

		function loading() {
			document.getElementById('loading').style.display = 'block';
		}

		function viewNewProduct() {
			document.getElementById('frmNewProduct').style.display = 'block';
			document.getElementById('btnClose').style.display = 'block';
			document.getElementById('filterProducts').style.display = 'none';
			document.getElementById('listProducts').style.display = 'none';
			document.getElementById('btnNewProduct').style.display = 'none';
		}

	</script>

	<style>
	.banner {
		float: left;
		border-radius: 50%;
		display: inline-block;
		width: 60px;
		height: 60px;
		object-fit: cover;
		margin-right: 15px;
	}
</style>

<?php

switch ($viewCategoria) {
	case 'entradas':
		$tabela = "contas_rec";
		$tabelaCategoria = "categoria_contas_rec";
		$title = "Entrada";
		break;

	case 'saidas':
		$tabela = "contas_pag";
		$tabelaCategoria = "categoria_contas_pag";
		$title = "Saída";
		break;

	case 'sangria':
		$tabela = "contas_san";
		$tabelaCategoria = "categoria_contas_pag";
		$title = "Sangria";
		break;
}

$select = "SELECT
	$tabela.id, $tabela.tipo, $tabela.categoria, $tabela.dataVenc, $tabela.dataRef, $tabela.descricao, $tabela.idUsuario, $tabela.valor, $tabela.nDoc, $tabela.codTipoDoc, $tabela.observacoes, $tabela.data_hora_cadastro, $tabela.baixa,
	usuarios.id as idUsuario, usuarios.nome as nomeUsuario,
	categoria_contas_pag.nome
 FROM $tabela
 LEFT JOIN usuarios ON $tabela.idUsuario = usuarios.id
 INNER JOIN categoria_contas_pag ON $tabela.categoria = categoria_contas_pag.id
 WHERE $tabela.id = '$idItem'";
$result = $conexao -> prepare($select);
$result->execute();
$count = $result->rowCount();

if ($data = $result -> fetch()) {
	do {

		$idPag       = $data['id'];
		$tipo        = $data['tipo'];
		$categoria   = $data['categoria'];
		$descricao   = $data['descricao'];
		$dataVenc    = $data['dataVenc'];
		$dataRef     = $data['dataRef'];
		$idUsuario   = $data['idUsuario'];
		$pessoa      = $data['nomeUsuario'];
		$valor       = $data['valor'];
		$nDoc        = $data['nDoc'];
		$codTipoDoc  = $data['codTipoDoc'];
		$observacoes = $data['observacoes'];
		$baixa       = $data['baixa'];

		switch ($tipo) {
			case 1:
				$viewTipo = "Recebimentos";
				break;

			case 2:
				$viewTipo = "Despesa Fixa";
				break;

			case 3:
				$viewTipo = "Despesa Variável";
				break;

			case 4:
				$viewTipo = "Sangria";
				break;
		}

		switch ($baixa) {
			case 0:
				$viewBaixa = "Não";
				break;

			case 1:
				$viewBaixa = "Sim";
				break;
		}

		switch ($codTipoDoc) {
			case 1:
				$viewTipoDoc = "Dinheiro";
				break;

			case 2:
				$viewTipoDoc = "Cartão Crédito";
				break;

			case 3:
				$viewTipoDoc = "Cartão Débito";
				break;

			case 4:
				$viewTipoDoc = "Débito em Conta";
				break;

			case 5:
				$viewTipoDoc = "Vale";
				break;

			case 6:
				$viewTipoDoc = "Bonificação";
				break;

			case 7:
				$viewTipoDoc = "Transferência Bancária (TED)";
				break;
		}

		$retiradaLucro      = $dataSanLucro['valor'];
		$retiradaLucro      = preg_replace('/[^0-9]+/','.',$retiradaLucro);
		$totalRetiradaLucro = preg_replace('/[^0-9]+/','.',$totalRetiradaLucro);

		$totalRetiradaLucro += $retiradaLucro;

	} while ($data = $result -> fetch());
}

?>

<div class="content-page">

	<!-- Start content -->
	<div class="content">

		<div class="container-fluid">

			<div class="row" style="padding-top: 30px">


				<!-- início do formulário cadastro de cargos -->
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-12 col-xl-12">

					<div class="card mb-3 animated fadeIn" id="frmNewProduct">

						<div class="card-materialIcon" style="font-size: 18px;">
							<i class="materialIconGreen fa fa-file-invoice"></i> <span class="float-right"><?php echo $title ?><br></span>
						</div>
						<div class="card-body">

							<form action="assets/functions/updateFinanceItem.php?id=<?php echo $idItem ?>&categoria=<?php echo $viewCategoria ?>" name="updateFinanceItem" id="updateFinanceItem" method="post" enctype="multipart/form-data">

								<div class="row">

									<div class="col-lg-3">
									<div class="form-group">
									<label>Tipo</label>
									<select class="form-control" readonly name="tipo" id="tipo">
										<?php
										if($tipo == 1) {
											echo '
											<option selected value="1">Recebimento</option>
											<option value="2">Despesa Fixa</option>
											<option value="3">Despesa Variável</option>
											<option value="4">Sangria</option>
											';
										} else if ($tipo == 2) {
											echo '
											<option value="1">Recebimento</option>
											<option selected value="2">Despesa Fixa</option>
											<option value="3">Despesa Variável</option>
											<option value="4">Sangria</option>
											';
										} else if ($tipo == 3) {
											echo '
											<option value="1">Recebimento</option>
											<option value="2">Despesa Fixa</option>
											<option selected value="3">Despesa Variável</option>
											<option value="4">Sangria</option>
											';
										} else {
											echo '
											<option value="1">Recebimento</option>
											<option value="2">Despesa Fixa</option>
											<option value="3">Despesa Variável</option>
											<option selected value="4">Sangria</option>
											';
										} ?>
									</select>
									</div>
									</div>

									<div class="col-lg-3">
									<div class="form-group">
									<label>Categoria</label>
									<select class="form-control" name="categoriaItem" id="categoriaItem">
										<?php

										$select = "SELECT id, nome FROM $tabelaCategoria ORDER BY nome ASC";
										$result = $conexao -> prepare($select);
										$result->execute();
										$count = $result->rowCount();

										echo '<option value="">Selecione...</option>';

										if ($data = $result->fetch()) {
											do {

												$id      = $data['id'];
												$nome    = $data['nome'];

												$nome = utf8_encode($nome);

												if ($categoria == $id) {
													echo "<option selected value='$id'>$nome</option>";
												} else {
													echo "<option value='$id'>$nome</option>";
												}

											} while ($data = $result->fetch());
										}

										?>
									</select>

									</div>
									</div>

									<div class="col-lg-3">
									<div class="form-group">
									<label>Data de Vencimento</label>
									<input class="form-control" name="dataVenc" id="dataVenc" value="<?php echo $dataVenc; ?>" type="date" />
									</div>
									</div>

									<div class="col-lg-3">
									<div class="form-group">
									<label>Data de Referência</label>
									<input class="form-control" name="dataRef" id="dataRef" value="<?php echo $dataRef; ?>" type="date" />
									</div>
									</div>

									<div class="col-lg-8">
									<div class="form-group">
									<label>Descricao</label>
									<input class="form-control" name="descricao" id="descricao" value="<?php echo $descricao; ?>" type="text" />
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

											if ($idUsuario == $id) {
												echo "<option selected value='$id'>$nome</option>";
											} else {
												echo "<option value='$id'>$nome</option>";
											}


										} while ($data = $result->fetch());
									}

									?>
									</select>
									</div>
									</div>

									<div class="col-lg-3">
										<label>Valor</label>
										<div class="input-group mb-2">
											<div class="input-group-prepend">
												<div class="input-group-text"><i class="fa fa-dollar-sign"></i></div>
											</div>
											<input type="text" class="form-control" name="valor" id="valor" value="<?php echo $valor; ?>" placeholder="0,00">
										</div>
									</div>

									<div class="col-lg-2">
									<div class="form-group">
									<label>N° Documento</label>
									<input class="form-control" name="nDoc" id="nDoc" value="<?php echo $nDoc; ?>" type="text" />
									</div>
									</div>

									<div class="col-lg-3">
									<div class="form-group">
									<label>Cód. Tipo Documento</label>
									<select class="form-control" name="codTipoDoc" id="codTipoDoc" />
										<?php echo '<option value="'.$codTipoDoc.'">'.$viewTipoDoc.'</option>'; ?>
									</select>
									</div>
									</div>

									<div class="col-lg-2">
									<div class="form-group">
									<label>Status</label>
									<select style="width: 100%" class="form-control" name="statusItem" id="statusItem">
									<?php

											if ($baixa == 1) {
												echo "<option selected value='1'>Título Baixado</option>";
												echo "<option value='0'>Pendente</option>";
											} else {
												echo "<option value='1'>Título Baixado</option>";
												echo "<option selected value='0'>Pendente</option>";
											}

									?>
									</select>
									</div>
									</div>

									<div class="col-lg-12">
									<div class="form-group">
									<label>Observações</label>
									<textarea class="form-control editor" name="observacao" id="observacao" type="text"><?php echo $observacoes; ?></TextArea>
									</div>
									</div>

								</div>

								<div class="modal-footer">

									<script type="text/javascript">
									function verificaUpdateFinanceItem(){
										if (document.updateFinanceItem.descricao.value == "" || document.updateFinanceItem.valor.value == ""){
											return false;
										} else {
											document.updateFinanceItem.submit();
											document.getElementById('updateFinItem').style.visibility = 'hidden';
											document.getElementById('updateFinItem').style.display = 'none';
											loading();
										}
									}
									</script>
									<a class="btn btn-raised btn-danger" style="color: #fff" type="button" id="btnDelete" href="assets/functions/deleteFinanceItem.php?id=<?php echo $idItem ?>&categoria=<?php echo $viewCategoria ?>" style="float: right"><i class="fa fa-times"></i>&nbsp; Excluir Registro</a>
									<button type="button" class="btn btn-success" onclick="verificaUpdateFinanceItem()" id="updateFinItem"><i class="fa fa-save"></i>&nbsp; Salvar</button>
								</div>

							</form>

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

<script>
$(document).ready(function(){
	$("#cnpj").inputmask("99.999.999/9999-99");
	$("#telefone").inputmask("(99) 9999-9999");
	$("#auth_usuario").inputmask("(99) 99999-9999");
	$("#celular").inputmask("(99) 99999-9999");
	$("#valor").maskMoney({allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
	$("#preco").maskMoney({allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
	$("#precoPromo").maskMoney({allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
	$("#margemLucro").maskMoney({allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
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


<!-- BEGIN Java Script for this page -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>

$('#btnDelete').click(function(e){
	e.preventDefault();
	var link = $(this).attr('href');

	swal({
		title: "Exclusão de Registro Financeiro",
		text: "Deseja realmente excluir esse registro?",
		icon: "warning",
		buttons: true,
		dangerMode: true
	})
	.then((willDelete) => {
		if (willDelete) {

			swal("Pronto! Registro excluído com sucesso!", {
				icon: "success",
			});
			window.location.href = link;
		}
	});
});


function alertnewDepartament() {

	$(document).ready(function(){

		swal("Bom Trabalho!", "Setor cadastrado com sucesso!", "success");

	});
};

</script>
<!-- END Java Script for this page -->

</body>
</html>
