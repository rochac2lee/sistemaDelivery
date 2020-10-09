<?php

$dateSearch = $_GET['filtroData'];
$motoSearch = $_GET['filtroMotoboy'];

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

    <div class="content-page">

		<!-- Start content -->
        <div class="content">

			<div class="container-fluid">

						<div class="row" style="padding-top: 40px;">

							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-12 col-xl-6">

								<div class="card mb-3 animated fadeIn" id="listRequests">
									<div class="card-materialIcon" style="font-size: 18px;">
										<i class="materialIconGreen fa fa-file-invoice"></i> <span class="float-right">Relatório - Entregadores<br><p style="font-size: 10px;
	    float: right;"><?php if ($dateSearch == "") { echo "<p class='float-right' style='margin-top: 5px; margin-bottom: 0'>Todo Período</p>"; } ?></p></span>
									</div>
									<div class="card-body">
										<div class="row">
											<div class="col-lg-4">
												<div class="input-group">
												  <div class="input-group-prepend">
												    <button class="btn btn-outline-secondary" style="border: 1px solid #ced4da;" disabled type="button"><i class="fa fa-motorcycle"></i></button>
												  </div>
													<select style="float: left; width: 20%" class="form-control" onchange="motoboy()" name="idMotoboy" id="idMotoboy">

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

															if ($motoSearch == $id) {
																echo "<option selected value='$id'>$nome</option>";
															} else {
																echo "<option value='$id'>$nome</option>";
															}



														} while ($data = $result->fetch());
													}

													?>
													</select>
													<?php if ($motoSearch != "") {?>
													<button class="btn btn-outline-secondary" onclick="clearFilter()" style="border: solid 3px #ced4da;" type="button"><i class="fa fa-times"></i></button>
													<?php } ?>
												</div>
											</div>
											<div class="col-lg-5">
												<div class="input-group">
												  <div class="input-group-prepend">
												    <button class="btn btn-outline-secondary" style="border: 1px solid #ced4da;" disabled type="button"><i class="fa fa-filter"></i></button>
												  </div>
												  <input type="date" class="form-control" onchange="filter()" style="border-left: 0;" value="<?php echo $dateSearch; ?>" id="filtroData">
													<?php if ($dateSearch != "") {?>
													<button class="btn btn-outline-secondary" onclick="clearFilter()" style="border: solid 3px #ced4da;" type="button"><i class="fa fa-times"></i></button>
													<?php } ?>
												</div>
											</div>

											<div class="col-lg-3">
												<button class="btn btn-primary right" style="border: 1px solid #ced4da;" onclick="window.open('assets/functions/report.php?typeReport=motoboy&idMotoboy=<? echo $motoSearch; ?>&dateFilter=<? echo $dateSearch; ?>', '_blank')" type="button">
													<i class="fa fa-print"></i>&nbsp; Imprimir
												</button>
											</div>

										</div>

								<script>
								function filter() {
									var filtroMotoboy = document.getElementById("idMotoboy").value;
									var filtroData   = document.getElementById("filtroData").value;

									window.location.href='ui-report-motoboy.php?filtroData=' + filtroData + '&filtroMotoboy=' + filtroMotoboy;
								}

								function motoboy() {
									var filtroMotoboy = document.getElementById("idMotoboy").value;
									var filtroData    = document.getElementById("filtroData").value;

									window.location.href='ui-report-motoboy.php?filtroData=' + filtroData + '&filtroMotoboy=' + filtroMotoboy;
								}

								function clearFilter() {
									window.location.href='ui-report-motoboy.php';
								}
								</script>
										<table class="table table-striped" id="tb1" style="margin-top: 15px">
										  <thead>
											<tr>
											  <th scope="col">Pedido n° </th>
											  <th scope="col">Motoboy</th>
											  <th scope="col">Taxa</th>
											</tr>
										  </thead>
										  <tbody>
											<?php

											$total = 0;

											if ($dateSearch != "" && $motoSearch != "") {
			      						$select = "SELECT
																		pedidos.id, pedidos.idMotoboy, pedidos.data_hora_cadastro,
																		usuarios.nome
			                             FROM pedidos
			                             LEFT JOIN usuarios ON pedidos.idMotoboy = usuarios.id
																	 LEFT JOIN caixa ON pedidos.idCaixa = caixa.id
																	 WHERE pedidos.idMotoboy = '$motoSearch' AND DAY(caixa.dataHoraAbertura) = DAY('$dateSearch') AND MONTH(caixa.dataHoraAbertura) = MONTH('$dateSearch') AND YEAR(caixa.dataHoraAbertura) = YEAR('$dateSearch')
																	 ORDER BY pedidos.id DESC";
											} else if ($dateSearch != "") {
												$select = "SELECT
																		pedidos.id, pedidos.idMotoboy, pedidos.data_hora_cadastro,
																		usuarios.nome
			                             FROM pedidos
			                             LEFT JOIN usuarios ON pedidos.idMotoboy = usuarios.id
																	 LEFT JOIN caixa ON pedidos.idCaixa = caixa.id
																	 WHERE DAY(caixa.dataHoraAbertura) = DAY('$dateSearch') AND MONTH(caixa.dataHoraAbertura) = MONTH('$dateSearch') AND YEAR(caixa.dataHoraAbertura) = YEAR('$dateSearch')
																	 ORDER BY pedidos.id DESC";
											} else if ($motoSearch != "") {
												$select = "SELECT
			                              pedidos.id, pedidos.idMotoboy, pedidos.data_hora_cadastro,
																		usuarios.nome
																		FROM pedidos
			                             LEFT JOIN usuarios ON pedidos.idMotoboy = usuarios.id
																	 LEFT JOIN caixa ON pedidos.idCaixa = caixa.id
																	 WHERE pedidos.idMotoboy = '$motoSearch'
																	 ORDER BY pedidos.id DESC";
											} else {
												$select = "SELECT
																		pedidos.id, pedidos.idMotoboy, pedidos.data_hora_cadastro,
																		usuarios.nome
			                             FROM pedidos
			                             LEFT JOIN usuarios ON pedidos.idMotoboy = usuarios.id
																	 LEFT JOIN caixa ON pedidos.idCaixa = caixa.id
																	 WHERE pedidos.idMotoboy != '' ORDER BY pedidos.id DESC";
											}
		        					$result = $conexao -> prepare($select);
		        					$result -> execute();
		        					$count = $result->rowCount();

		        						if ($data = $result -> fetch()) {
		        							do {

														$viewIdPedido   = $data['id'];
														$viewIdMotoboy  = $data['idMotoboy'];
														$nome           = $data['nome'];
														$taxaMotoboy    = $data['taxaMotoboy'];

		                        $idPedido       = $data['id'];

									          $selectProduto = "SELECT
									                            produtos.id, produtos.nome, produtos.descricao, produtos.foto, produtos.preco,
									                            pedido_itens.quantidade, pedido_itens.observacao
									                            FROM produtos
									                            INNER JOIN pedido_itens ON produtos.id = pedido_itens.idProduto
									                            WHERE pedido_itens.idPedido = '$viewIdPedido' and produtos.categoria = 999
									                            ORDER BY produtos.id ASC";
									          $resultProduto = $conexao -> prepare($selectProduto);
									          $resultProduto -> execute();
									          $countProduto = $resultProduto->rowCount();

									            if ($dataProduto = $resultProduto -> fetch()) {
									              do {

																	$preco       = $dataProduto['preco'];

																	$preco = preg_replace('/[^0-9]+/','.',$preco);
																	$total = preg_replace('/[^0-9]+/','.',$total);

																	$total += $preco;

																	$preco = number_format($preco, 2, ',', '.');
																	$total = number_format($total, 2, ',', '.');

																echo "
																	<tr>
																	  <td $style>$idPedido</td>
																	  <td $style>$nome</td>
																	  <td $style>$preco</td>
																	</tr>
																";

																} while ($dataProduto = $resultProduto->fetch());
										          }

													} while ($data = $result->fetch());
												}

												$selectTaxa = "SELECT taxaMotoboy
																					FROM usuarios
																					WHERE usuarios.id = '$motoSearch'";
												$resultTaxa = $conexao -> prepare($selectTaxa);
												$resultTaxa -> execute();
												$countTaxa = $resultTaxa->rowCount();

												if ($dataTaxa = $resultTaxa -> fetch()) {
													do {

														$taxaMotoboy = $dataTaxa['taxaMotoboy'];
														$taxaMotoboy = preg_replace('/[^0-9]+/','.',$taxaMotoboy);
														$total = preg_replace('/[^0-9]+/','.',$total);

														$total += $taxaMotoboy;

														$taxaMotoboy  = number_format($taxaMotoboy, 2, ',', '.');

														echo "
															<tr>
																<td></td>
																<td>$nome</td>
																<td>$taxaMotoboy</td>
															</tr>
														";

													} while ($dataTaxa = $resultTaxa->fetch());
												}

												$total        = number_format($total, 2, ',', '.');

												echo "
													<tr>
														<td></td>
														<td></td>
														<td>$total</td>
													</tr>
													";

											?>
										  </tbody>
										</table>
									</div>
								</div> <!-- end card -->
								<!-- fim do formulário cadastro de cargos -->

							</div>

						</div>

            </div>
			<!-- END container-fluid -->

		</div>
		<!-- END content -->

    </div>
	<!-- END content-page -->

	<div id="optEdit">
		<span class='dot_whats animated fadeInLeft'><i class="text-green-opacity fa fa-2x fa-motorcycle"></i></span>
	</div>

</div>
<!-- END main -->

<script>
	$(document).ready(function(){
		$("#cnpj").inputmask("99.999.999/9999-99");
		$("#telefone").inputmask("(99) 9999-9999");
		$("#auth_usuario").inputmask("(99) 99999-9999");
		$("#celular").inputmask("(99) 99999-9999");
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
