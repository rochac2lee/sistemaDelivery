<?php

$idPedido = $_GET['idPedido'];
$comanda  = $_GET['comanda'];

require('assets/includes/session.php');

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

</script>

<style>

.materialIconGreen {
	width: 22%;
  text-align: center;
}
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
</style>

    <div class="content-page">

		<!-- Start content -->
        <div class="content">

			<div class="container-fluid">

						<div class="row" style="margin-top: 8%;">

							<?php

							$select = "SELECT
													pedidos.id, pedidos.status, pedidos.formaPagamento, pedidos.valorTotal, pedidos.valorCobrado, pedidos.data_hora_cadastro,
													endereco_cliente.rua, endereco_cliente.numero, endereco_cliente.bairro,
													usuarios.id as idCliente, usuarios.nome as nomeCliente, usuarios.celular as celularCliente,
													endereco_cliente.complemento, endereco_cliente.descricao
												 FROM pedidos
												 INNER JOIN usuarios ON pedidos.idCliente = usuarios.id
												 INNER JOIN endereco_cliente ON pedidos.idEndereco = endereco_cliente.id
												 WHERE pedidos.id = '$idPedido' ORDER BY pedidos.id DESC";
							$result = $conexao -> prepare($select);
							$result -> execute();
							$count = $result->rowCount();

								if ($data = $result -> fetch()) {
									do {

										$viewIdPedido   = "#".$data['id'];
										$idPedido       = $data['id'];
										$formaPagamento = $data['formaPagamento'];
										$celular        = $data['celularCliente'];

										switch ($formaPagamento) {
											case 1:
												$viewFormaPagamento = "Dinheiro";
												break;

											case 2:
												$viewFormaPagamento = "Cartão";
												break;

											case 3:
												$viewFormaPagamento = "Dinheiro e Cartão";
												break;
										}

										$status         = $data['status'];

										switch ($status) {
											case 1:
												$viewStatus = "Pedido realizado";
												break;

											case 2:
												$viewStatus = "Pedido confirmado";
												break;

											case 3:
												$viewStatus = "Em produção";
												break;

											case 4:
												$viewStatus = "Pronto para entrega";
												break;

											case 5:
												$viewStatus = "Pedido à caminho";
												break;

											case 6:
												$viewStatus = "Pedido Entregue";
												break;

										}

										$dataPedido     = $data['data_hora_cadastro'];
										$dataPedido     = date("d/m/Y H:i", strtotime($dataPedido));

										$valorTotal     = $data['valorTotal'];

										$valorCobrado = $data['valorCobrado'];

										if ($valorCobrado == "") {
											$valorCobrado = $valorTotal;
										}

										$nomeCliente    = $data['nomeCliente'];
										$rua            = $data['rua'];
										$numero         = $data['numero'];
										$bairro         = $data['bairro'];
										$complemento    = $data['complemento'];
										$descricao      = $data['descricao'];

                    $enderecoCompleto = "Rua ".$rua.", n°. ".$numero.", bairro ".$bairro;

										if ($complemento != "") {
											$viewComplemento = $complemento;
										}
										if ($descricao != "") {
											$viewDescricao = "<br>Obs.: ".$descricao;
										}

							?>

							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-12 col-xl-4">

								<div class="card mb-3 animated fadeIn" id="frmNewProduct">
									<div class="card-materialIcon" style="font-size: 18px;">
										<i class="materialIconGreen fa fa-receipt"></i> <span class="float-right">Detalhes do pedido</span>
									</div>
									<div class="card-body">

										<form action="assets/functions/newProduct.php" name="newProduct" id="newProduct" method="post" enctype="multipart/form-data">

										<div class="row" id="info">

											<div class="col-lg-12">
											<div class="form-group" style="margin-bottom: 0;">
											<h5><?php if ($comanda != "") { echo "Comanda n° ".$comanda; } else { echo "Pedido n° ".$idPedido; } ?> em <?php echo $dataPedido; ?></h5>
											</div>
											</div>

											<div class="col-lg-6">
											<div class="form-group">
											<label>Cliente</label>
											<p><?php echo $nomeCliente; ?></p>
											</div>
											</div>

											<div class="col-lg-6">
											<div class="form-group">
											<label>Telefone</label>
											<p><?php echo $celular; ?></p>
											</div>
											</div>

											<div class="col-lg-12">
											<div class="form-group">
											<label>Forma de Pagamento</label>
											<p>O pedido será pago no <?php echo $viewFormaPagamento; ?></p>

											</div>
											</div>

											<div class="col-lg-12">
											<div class="form-group">
											<label>Endereço Completo</label>
											<p><?php echo $enderecoCompleto."<br>".$viewComplemento."".$viewDescricao; ?></p>
											</div>
											</div>

											<div class="col-lg-12">
											<div class="form-group" style="margin-bottom: 0;">

												<table class="table table-striped" id="tb1">
													<thead>
													<tr>
														<th scope="col">Produto</th>
														<th scope="col">Preço</th>
													</tr>
													</thead>
													<tbody>
													<?php

									          $selectProduto = "SELECT
														  							  produtos.id, produtos.nome, produtos.descricao, produtos.foto, produtos.preco,
																							pedido_itens.quantidade, pedido_itens.observacao
																							FROM produtos
																							INNER JOIN pedido_itens ON produtos.id = pedido_itens.idProduto
																							WHERE pedido_itens.idPedido = '$idPedido' AND produtos.categoria != 999 order by produtos.id ASC";
									          $resultProduto = $conexao -> prepare($selectProduto);
									          $resultProduto -> execute();
									          $countProduto = $resultProduto->rowCount();

									            if ($dataProduto = $resultProduto -> fetch()) {
									              do {

									                $viewQtdProduto  = $dataProduto['quantidade'];
									                $qtdProduto  = $dataProduto['quantidade']."x";
									                $idProduto   = $dataProduto['id'];
									                $observacao  = $dataProduto['observacao'];
																	if ($observacao != "") {
																		$observacao = "Obs.: ".$observacao;
																	}
									                $nome         = $dataProduto['nome'];
									                $descricao    = $dataProduto['descricao'];
									                $banner       = $dataProduto['foto'];
									                $preco        = $dataProduto['preco'];
									                $precoPromo   = $dataProduto['precoPromo'];

									                if ($preco == "") {
									                  $preco = "Em Breve";
									                }

																	$viewPreco = preg_replace('/[^0-9]+/','.',$preco);

																	$preco = ($viewQtdProduto * $viewPreco);

																	$preco = number_format ($preco, 2, ',', '.');

									                if ($precoPromo != "") {
									                  $stylePreco = "text-decoration: line-through;";
									                }

																	echo "
																		<tr>
																			<td>$qtdProduto - $nome</td>
																			<td>R$ $preco</td>
																		</tr>
																	";

															} while ($dataProduto = $resultProduto->fetch());
														}
													?>

											<?php

							          $selectTaxa= "SELECT
												  							  produtos.id, produtos.nome, produtos.descricao, produtos.foto, produtos.preco,
																					pedido_itens.quantidade, pedido_itens.observacao
																					FROM produtos
																					INNER JOIN pedido_itens ON produtos.id = pedido_itens.idProduto
																					WHERE pedido_itens.idPedido = '$idPedido' AND produtos.categoria = 999 order by produtos.id ASC";
							          $resultTaxa = $conexao -> prepare($selectTaxa);
							          $resultTaxa -> execute();
							          $countTaxa = $resultTaxa->rowCount();

							            if ($dataTaxa = $resultTaxa -> fetch()) {
							              do {

							                $observacao  = $dataTaxa['observacao'];
															if ($observacao != "") {
																$observacao = "Obs.: ".$observacao;
															}
							                $nome         = "Taxa de Entrega";
							                $descricao    = $dataTaxa['descricao'];
							                $preco        = $dataTaxa['preco'];

															$valorCobrado  = preg_replace('/[^0-9]+/','.',$valorCobrado);
															$subTotal  = preg_replace('/[^0-9]+/','.',$subTotal);
															$viewPreco = preg_replace('/[^0-9]+/','.',$preco);

															$subTotal = ($valorCobrado - $viewPreco);

															$subTotal = number_format ($subTotal, 2, ',', '.');
															$valorCobrado    = number_format ($valorCobrado, 2, ',', '.');

															echo "
																<tr>
																	<td class='right'>Subtotal</td>
																	<td>R$ $subTotal</td>
																</tr>
																<tr>
																	<td class='right'>$nome:</td>
																	<td>R$ $preco</td>
																</tr>
																";

													} while ($dataTaxa = $resultTaxa->fetch());
												}

												echo "
												<tr>
													<td class='right'><strong>Total:</strong></td>
													<td><strong>R$ $valorCobrado</strong></td>
												</tr>";
											?>
												</tbody>
											</table>
											</div>
											</div>


										</div>

									</form>


									</div>
									<!-- end card-body -->

								</div>
								<!-- end card -->

							</div>
						<?php
								} while ($data = $result->fetch());
							}
						?>

						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-12 col-xl-4">

							<div class="card mb-3 animated fadeIn" id="frmNewProduct">
								<div class="card-materialIcon" style="font-size: 18px;">
									<i class="materialIconGreen fa fa-dollar-sign"></i> <span class="float-right">Atualizações</span>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-lg-12">
										<div class="form-group">
										<label>Valor Cobrado</label>
										<input type="text" value="<?php echo $idPedido; ?>" id="idPedido" style="display: none;">
										<input type="text" value="<?php echo $comanda; ?>" id="comanda" style="display: none;">
										<input type="text" class="form-control" placeholder="R$" onchange="changePrice()" id="valorCobrado">

										<script>
										function changePrice() {
											var idPedido = document.getElementById("idPedido").value;
											var valorCobrado   = document.getElementById("valorCobrado").value;
											var comanda   = document.getElementById("comanda").value;

											window.location.href='assets/functions/changePrice.php?destino=2&idPedido=' + idPedido + '&valorCobrado=' + valorCobrado + '&comanda=' + comanda;
										}
										</script>
										</div>
										</div>
									</div>
								</div>
								<!-- end card-body -->
							</div>
							<!-- end card -->

							<?php

							$select = "SELECT
																produtos.id, produtos.nome, produtos.descricao, produtos.foto, produtos.preco,
																pedido_itens.quantidade, pedido_itens.observacao
																FROM produtos
																INNER JOIN pedido_itens ON produtos.id = pedido_itens.idProduto
																WHERE pedido_itens.idPedido = '$idPedido' AND produtos.categoria = 999 order by produtos.id ASC";
							$result = $conexao -> prepare($select);
							$result -> execute();
							$entrega = $result->rowCount();

							if ($entrega > 0) {

							?>

								<div class="card mb-3 animated fadeIn" id="frmNewMotoboy" style="margin-top: 40px">
									<div class="card-materialIcon" style="font-size: 18px;">
										<i class="materialIconGreen fa fa-motorcycle"></i> <span class="float-right">Entregador</span>
									</div>
									<div class="card-body">
										<div class="row">
											<div class="col-lg-12">
											<div class="form-group">

											<?php

											$select = "SELECT idMotoboy FROM pedidos WHERE id = '$idPedido' and idMotoboy != 0";
											$result = $conexao -> prepare($select);
											$result -> execute();
											$count = $result->rowCount();

											if ($data = $result -> fetch()) {
												do {

													$idMotoboy = $data['idMotoboy'];

												} while ($data = $result->fetch());
											}

											if ($count == "") {

											?>

											<label>Motoboy</label>
											<input type="text" value="<?php echo $idPedido; ?>" id="idPedido" style="display: none;">
											<input type="text" value="<?php echo $comanda; ?>" id="comanda" style="display: none;">

											<select style="float: left; width: 100%" class="form-control select2" onchange="selectMotoboy()" name="idMotoboy" id="idMotoboy">

											<?php

											$select = "SELECT id, celular, nome FROM usuarios WHERE motoboy = 1 order by nome ASC";
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
											function selectMotoboy() {
												var idPedido  = document.getElementById("idPedido").value;
												var idMotoboy = document.getElementById("idMotoboy").value;
												var comanda   = document.getElementById("comanda").value;

												window.location.href='assets/functions/selectMotoboy.php?idPedido=' + idPedido + '&idMotoboy=' + idMotoboy + '&comanda=' + comanda;
											}
											</script>

											<?php

											} else {

											?>

											<table class="table table-striped" id="tb1">
											  <thead>
												<tr>
												  <th scope="col">Motoboy</th>
												  <th scope="col">Celular</th>
												  <th scope="col"><center>Ações</center></th>
												</tr>
											  </thead>
											  <tbody>
											  <?php
												$select = "SELECT * FROM usuarios WHERE id = '$idMotoboy'";
												$result = $conexao -> prepare($select);
												$result -> execute();

													if ($data = $result -> fetch()) {
														do {

															$id      = $data['id'];
															$nome    = $data['nome'];
															$celular = $data['celular'];

															echo "
																  <td>$nome</td>
																  <td>$celular</td>
																	<td><center>
																  <a href='assets/functions/removeMotoboy.php?idPedido=$idPedido&comanda=$comanda'>Remover</a>
																	</center></td>
																</tr>
															";

														} while ($data = $result->fetch());
													}
												?>
											  </tbody>
											</table>

											<?php

											}

											?>

											</div>
											</div>
										</div>
									</div>
									<!-- end card-body -->
								</div>
								<!-- end card -->

							<?php

							}

							?>

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
		$("#valorCobrado").maskMoney({allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
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


<!-- BEGIN Java Script for this page -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>

$('[data-confirm]').click(function(e){
    e.preventDefault();
    var link = $(this).attr('href');

   swal({
          title: "Exclusão de Relatório",
          text: "Deseja realmente excluir esse Relatório? O arquivo ficará inacessível!",
          icon: "warning",
          buttons: true,
          dangerMode: true
        })
        .then((willDelete) => {
          if (willDelete) {
            swal("Pronto! Relatório excluído com sucesso!", {
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
