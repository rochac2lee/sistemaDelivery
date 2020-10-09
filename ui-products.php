<?php

require('assets/includes/session.php');

$viewStatus = $_GET['status'];

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
		document.getElementById('frmNewCategory').style.display = 'none';
		document.getElementById('btnClose').style.display = 'block';
		document.getElementById('filterProducts').style.display = 'none';
		document.getElementById('btnNewProduct').style.display = 'none';
		document.getElementById('btnNewCategory').style.display = 'none';
	}

	function viewNewCategory() {
		document.getElementById('frmNewProduct').style.display = 'none';
		document.getElementById('frmNewCategory').style.display = 'flex';
		document.getElementById('btnClose').style.display = 'block';
		document.getElementById('filterProducts').style.display = 'none';
		document.getElementById('btnNewProduct').style.display = 'none';
		document.getElementById('btnNewCategory').style.display = 'none';
	}

	function btnClose() {
		document.getElementById('frmNewProduct').style.display = 'none';
		document.getElementById('frmNewCategory').style.display = 'none';
		document.getElementById('btnClose').style.display = 'none';
		document.getElementById('filterProducts').style.display = 'flex';
		document.getElementById('btnNewProduct').style.display = 'inline-block';
		document.getElementById('btnNewCategory').style.display = 'inline-block';
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

    <div class="content-page">

		<!-- Start content -->
        <div class="content">

			<div class="container-fluid">

						<div class="row">
								<div class="col-xl-12">
										<div class="breadcrumb-holder">
												<h1 class="main-title float-left">Produtos</h1>
												<ol class="breadcrumb float-right">
													<li class="breadcrumb-item">
														<button onclick="viewNewProduct()" class="btn btn-raised btn-info" id="btnNewProduct"><i class="fa fa-plus-circle"></i>&nbsp; Adicionar um produto</button>
														<button onclick="viewNewCategory()" class="btn btn-raised btn-info" id="btnNewCategory"><i class="fa fa-plus-circle"></i>&nbsp; Categoria</button>
														<button onclick="btnClose()" style="display: none;" class="btn btn-raised btn-secondary" id="btnClose"><i class="fa fa-times-circle"></i>&nbsp; Cancelar</button>
													</li>
												</ol>
												<div class="clearfix"></div>
										</div>
								</div>
						</div>
						<!-- end row -->

						<div class="row">


							<!-- início do formulário cadastro de cargos -->
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-12 col-xl-12">

								<div class="card mb-3 animated fadeIn col-md-4" id="frmNewCategory" style="display: none;">

									<div class="card-materialIcon" style="font-size: 18px;">
										<i class="materialIconGreen fa fa-list-ul"></i> <span class="float-right">Nova Categoria</span>
									</div>
									<div class="card-body">

										<form action="assets/functions/newCategoryProduct.php" name="newCategoryProduct" id="newCategoryProduct" method="post" enctype="multipart/form-data">

										<div class="row">

											<div class="col-lg-12">
											<div class="form-group">
											<label>Categoria</label>
											<input type="text" class="form-control" autofocus="" name="categoria" id="categoria" required="">
											</div>
											</div>

											<div class="col-lg-6">
											<div class="form-group">
											<label>Status</label>
											<select class="form-control col-md-10 float-left" name="statusCategoria" id="statusCategoria">
												<option selected value='1'>Ativo</option>
												<option value='0'>Inativo</option>
											</select>
											</div>
											</div>

										</div> <!-- end row -->

										<div class="modal-footer">

											<script type="text/javascript">
											function verificaNewCategoryProduct(){
												if (document.newCategoryProduct.categoria.value == ""){
													return false;
												} else {
													document.newCategoryProduct.submit();
													document.getElementById('cadCatProd').style.visibility = 'hidden';
													document.getElementById('cadCatProd').style.display = 'none';
													loading();
												}
											}
											</script>
											<button type="button" class="btn btn-success" onclick="verificaNewCategoryProduct()" id="cadCatProd"><i class="fa fa-save"></i>&nbsp; Salvar</button>
										</div>

									</form>

									</div>
									<!-- end card-body -->

								</div>
								<!-- end card -->

								<div class="card mb-3 animated fadeIn" id="frmNewProduct" style="display: none;">
									<div class="card-materialIcon" style="font-size: 18px;">
										<i class="materialIconGreen fa fa-box"></i> <span class="float-right">Novo Produto</span>
									</div>
									<div class="card-body">

										<form action="assets/functions/newProduct.php?status=1" name="newProduct" id="newProduct" method="post" enctype="multipart/form-data">

										<div class="row" style="margin-top: 20px">

											<div class="col-lg-3">

												<div id="banner_image">
													<center>
													<label for="upload">
																<img src="assets/images/picture2.png" class="animated fadeIn" id="banner" style="width: 100%; height: 150px; object-fit: cover;">
																<input type="file" id="upload" onchange="preview_image(event)" name="uploadBanner[]" style="display:none">
													</label>
												</center>

												<script type='text/javascript'>
													function preview_image(event) {
													 var reader = new FileReader();
													 reader.onload = function() {
														var output = document.getElementById('banner');
														document.getElementById('banner').style.width = '100%';
														document.getElementById('banner').style.height = '200px';
														output.src = reader.result;
													 }
													 reader.readAsDataURL(event.target.files[0]);
													}
												</script>

												</div>

											</div>

											<div class="col-lg-12">
											<div class="form-group">
											<label>Nome</label>
											<input type="text" class="form-control" autofocus="" name="nomeProduto" id="nomeProduto" required="">
											</div>
											</div>

											<style type="text/css">
												.trumbowyg-box, .trumbowyg-editor-visible, .trumbowyg-en, .trumbowyg {
													    min-height: 150px!important;
												}
												.trumbowyg-editor, .trumbowyg-textarea {
													min-height: 150px!important;
												}
											</style>

											<div class="col-lg-12">
											<div class="form-group">
											<label>Descrição</label>
											<textarea class="form-control editor" rows="3" name="descricao" id="descricao"></textarea>
											</div>
											</div>

										</div>

										<div class="row">

											<div class="col-auto">
									      <label>Preço</label>
									      <div class="input-group mb-2">
									        <div class="input-group-prepend">
									          <div class="input-group-text"><i class="fa fa-dollar-sign"></i></div>
									        </div>
									        <input type="text" class="form-control" name="preco" id="preco" placeholder="0,00">
									      </div>
									    </div>

											<div class="col-auto">
									      <label>Preço Promocional</label>
									      <div class="input-group mb-2">
									        <div class="input-group-prepend">
									          <div class="input-group-text"><i class="fa fa-dollar-sign"></i></div>
									        </div>
									        <input type="text" class="form-control" name="precoPromo" id="precoPromo" placeholder="0,00">
									      </div>
									    </div>

											<div class="col-auto">
									      <label>Margem de Lucro</label>
									      <div class="input-group mb-2">
									        <div class="input-group-prepend">
									          <div class="input-group-text"><i class="fa fa-dollar-sign"></i></div>
									        </div>
									        <input type="text" class="form-control" name="margemLucro" id="margemLucro" placeholder="0,00">
									      </div>
									    </div>

											<div class="col-lg-3">
											<div class="form-group">
											<label>Categoria</label>
											<select class="form-control col-md-10 float-left" name="idCategoria" id="idCategoria">
												<option value="">Selecione...</option>
											<?php
												$select = "SELECT * FROM categorias WHERE id != 999  ORDER BY id ASC";
												$result = $conexao -> prepare($select);
												$result -> execute();
												$count = $result->rowCount();

												if ($data = $result->fetch()) {
													do {

														$idCategoria = $data['id'];
														$nome        = utf8_encode($data['nome']);

														echo "<option value='$idCategoria'>$nome</option>";

												} while($data = $result->fetch());
											}

											?>
											</select>
											</div>
											</div>

										</div> <!-- end row -->

										<div class="modal-footer">

											<script type="text/javascript">
											function verificaNewProduct(){
												if (document.newProduct.nomeProduto.value == "" && document.newProduct.idCategoria.value){
													return false;
												} else {
													document.newProduct.submit();
													document.getElementById('cadProd').style.visibility = 'hidden';
													document.getElementById('cadProd').style.display = 'none';
													loading();
												}
											}
											</script>
											<button type="button" class="btn btn-success" onclick="verificaNewProduct()" id="cadProd"><i class="fa fa-save"></i>&nbsp; Salvar</button>
										</div>

									</form>

									</div>
									<!-- end card-body -->

								</div>
								<!-- end card -->

								<div class="card mb-3 animated fadeIn" id="filterProducts">
									<div class="card-materialIcon" style="font-size: 18px;">
										<i class="materialIconGreen fa fa-file-invoice"></i> <span class="float-right"><?php if ($viewStatus == 1) { echo "Produtos Ativos"; } else { echo "Produtos Inativos"; } ?></span>
									</div>
									<div class="card-body">
										<div class="col-lg-3">
											<div class="input-group">
											  <div class="input-group-prepend">
											    <button class="btn btn-outline-secondary" style="border: solid 1px #ced4da;" disabled="" type="button"><i class="fa fa-filter"></i></button>
											  </div>
												<select name="filtroStatus" id="filtroStatus" onchange="filter()" class="form-control" />

													<?php
													if (!isset($_GET['status'])) {
														echo '
															<option selected value="">Selecione...</option>
															<option value="1">Ativo</option>
															<option value="0">Inativo</option>
														';
													} else if ($viewStatus == 1) {
														echo '
															<option value="">Selecione...</option>
															<option selected value="1">Ativo</option>
															<option value="0">Inativo</option>
														';
													} else {
														echo '
															<option value="">Selecione...</option>
															<option value="1">Ativo</option>
															<option selected value="0">Inativo</option>
														';
													}
													?>
												</select>
											</div>
											<script>
												function filter() {
													var status   = document.getElementById("filtroStatus").value;

													window.location.href='ui-products.php?status=' + status;
												}

												function clearFilter() {
													window.location.href='ui-report-requests.php';
												}
											</script>
										</div>

										<ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-top: 20px">

											<?php
											$selectCategoria = "SELECT * FROM categorias where status = 1 and id != 999 ORDER BY id ASC LIMIT 0, 1";
											$resultCategoria = $conexao -> prepare($selectCategoria);
											$resultCategoria -> execute();
											$countCategoria = $resultCategoria->rowCount();

											if ($dataCategoria = $resultCategoria -> fetch()) {
												do {

													$idCategoria = $dataCategoria['id'];
													$categoria   = $dataCategoria['nome'];

													$nameTab   = explode(" ", $categoria);

													$tab = $nameTab[0].$idCategoria;

													$select = "SELECT * FROM produtos WHERE categoria = $idCategoria";
													$result = $conexao -> prepare($select);
													$result -> execute();
													$count = $result->rowCount();

													if ($count == "") {
														$buttonDelete = "<i class='right fa fa-times' onclick=buttonDelete($idCategoria) style='color: #0056b3; padding: 5px; cursor:pointer;'></i>";
													}

													echo "

													<li class='nav-item'>
												    <a class='nav-link left active' id='$tab-tab' data-toggle='tab' href='#$tab' role='tab' aria-controls='$tab' aria-selected='true'>$categoria</a>
														$buttonDelete
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

													$nameTab   = explode(" ", $categoria);

													$tab = $nameTab[0].$idCategoria;

													$select = "SELECT * FROM produtos WHERE categoria = $idCategoria";
													$result = $conexao -> prepare($select);
													$result -> execute();
													$count = $result->rowCount();

													if ($count == "") {
														$buttonDelete = "<i class='sright fa fa-times' onclick=buttonDelete($idCategoria) style='color: #0056b3; padding: 5px; cursor:pointer;'></i>";
													}

													echo "

													<li class='nav-item'>
												    <a class='nav-link left' id='$tab-tab' data-toggle='tab' href='#$tab' role='tab' aria-controls='$tab' aria-selected='true'>$categoria</a>
														$buttonDelete
												  </li>

													";
												} while($dataCategoria = $resultCategoria -> fetch());
											}

											?>

										</ul>

										<div class="tab-content" id="myTabContent">

													<?php
													$selectCategoria = "SELECT * FROM categorias where status = 1 and id != 999 ORDER BY id ASC LIMIT 0, 1";
													$resultCategoria = $conexao -> prepare($selectCategoria);
													$resultCategoria -> execute();
													$countCategoria = $resultCategoria->rowCount();

													if ($dataCategoria = $resultCategoria -> fetch()) {
														do {

															$idCategoria = $dataCategoria['id'];
															$categoria   = $dataCategoria['nome'];
															$nameTab   = explode(" ", $categoria);

															$tab = $nameTab[0].$idCategoria;

															echo "

													  <div class='tab-pane fade show active' id='$tab' role='tabpanel' style='padding: 5px' aria-labelledby='$tab-tab'>

														<table class='table table-striped' id='tb1' style='margin-top: 15px'>
														  <thead>
															<tr>
															  <th scope='col' style='width: 400px'>Produto</th>
															  <th scope='col'>Categoria</th>
															  <th scope='col'>Preço</th>
															  <th scope='col'>Preço Promocional</th>
															  <th scope='col'>Margem de Lucro</th>
															  <th scope='col'>Opções</th>
															</tr>
														  </thead>
														  <tbody>

															";
															if ($viewStatus != "") {
																$select = "SELECT * FROM produtos WHERE categoria = $idCategoria and visivel = 1 ORDER BY categoria ASC";
															} else {
																$select = "SELECT * FROM produtos WHERE status = '$viewStatus' and categoria = $idCategoria and visivel = 1 ORDER BY categoria ASC";
															}
															$result = $conexao -> prepare($select);
															$result -> execute();
															$count = $result->rowCount();

																if ($data = $result -> fetch()) {
																	do {

																		$codigo      = $data['id'];
																		$produto     = $data['nome'];
																		$idCategoria = $data['categoria'];
																		$banner      = $data['foto'];
																		$preco       = $data['preco'];
																		$precoPromo  = $data['precoPromo'];
																		$margemLucro = $data['lucro'];

																		if($precoPromo == "") {
																			$precoPromo = "-";
																		}

																		echo "
																			<tr>
																			  <td>
																					<img class='banner' src='assets/uploads/banner/$banner'>
																					<h6 style='margin-top: 5%; font-weight:600'>$produto</h6>
																				</td>
																			  <td>$categoria</td>
																			  <td>$preco</td>
																			  <td>$precoPromo</td>
																			  <td>$margemLucro</td>

																				<td>
																					<a href='ui-view-product.php?id=$codigo' class='btn btn-primary btn-sm'><i class='fa fa-pencil-alt' aria-hidden='true'></i></a>";
																			if ($permissoesSistemaActual == 0 && $idUsuarioActual != $idUsuario) {

																			echo "
																					<a href='assets/functions/deleteProduct.php?id=$codigo&status=$viewStatus' data-confirm='Deseja realmente excluir esse produto?' class='btn btn-danger btn-sm' data-placement='top' data-toggle='tooltip' data-title='Delete'><i class='fa fa-trash-alt' aria-hidden='true'></i></a>
																			";
																			}
																			echo "
																				</td>
																			</tr>
																		";

																	} while ($data = $result->fetch());
																}

																echo "
																</tbody>
															</table>
															</div>
																";

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

													<table class='table table-striped' id='tb1' style='margin-top: 15px'>
														<thead>
														<tr>
															<th scope='col' style='width: 400px'>Produto</th>
															<th scope='col'>Categoria</th>
															<th scope='col'>Preço</th>
															<th scope='col'>Preço Promocional</th>
															<th scope='col'>Margem de Lucro</th>
															<th scope='col'>Opções</th>
														</tr>
														</thead>
														<tbody>

														";

														if ($viewStatus != "") {
															$select = "SELECT * FROM produtos WHERE categoria = $idCategoria and visivel = 1 ORDER BY categoria ASC";
														} else {
															$select = "SELECT * FROM produtos WHERE status = '$viewStatus' and categoria = $idCategoria and visivel = 1 ORDER BY categoria ASC";
														}
														$result = $conexao -> prepare($select);
														$result -> execute();
														$count = $result->rowCount();

															if ($data = $result -> fetch()) {
																do {

																	$codigo      = $data['id'];
																	$produto     = $data['nome'];
																	$idCategoria = $data['categoria'];
																	$banner      = $data['foto'];
																	$preco       = $data['preco'];
																	$precoPromo  = $data['precoPromo'];
																	$margemLucro = $data['lucro'];

																	if($precoPromo == "") {
																		$precoPromo = "-";
																	}

																	echo "
																		<tr>
																			<td>
																				<img class='banner' src='assets/uploads/banner/$banner'>
																				<h6 style='margin-top: 5%; font-weight:600'>$produto</h6>
																			</td>
																			<td>$categoria</td>
																			<td>$preco</td>
																			<td>$precoPromo</td>
																			<td>$margemLucro</td>

																			<td>
																				<a href='ui-view-product.php?id=$codigo' class='btn btn-primary btn-sm'><i class='fa fa-pencil-alt' aria-hidden='true'></i></a>";
																		if ($permissoesSistemaActual == 0 && $idUsuarioActual != $idUsuario) {

																		echo "
																				<a href='assets/functions/deleteProduct.php?id=$codigo&status=$viewStatus' data-confirm='Deseja realmente excluir esse produto?' class='btn btn-danger btn-sm' data-placement='top' data-toggle='tooltip' data-title='Delete'><i class='fa fa-trash-alt' aria-hidden='true'></i></a>
																		";
																		}
																		echo "
																			</td>
																		</tr>
																	";

																} while ($data = $result->fetch());
															}

															echo "
															</tbody>
														</table>
														</div>
															";

													} while($dataCategoria = $resultCategoria -> fetch());
												}


													?>
										</div>

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

</div>
<!-- END main -->

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>

$('[data-confirm]').click(function(e){
    e.preventDefault();
    var link = $(this).attr('href');

   swal({
          title: "Exclusão de Produto",
          text: "Deseja realmente excluir esse Produto? Não será mais possível encontrar ele no sistema.",
          icon: "warning",
          buttons: true,
          dangerMode: true
        })
        .then((willDelete) => {
          if (willDelete) {
            swal("Pronto! Produto excluído com sucesso!", {
              icon: "success",
            });
            window.location.href = link;
          }
        });
});

	$(document).ready(function(){
		$("#cnpj").inputmask("99.999.999/9999-99");
		$("#telefone").inputmask("(99) 9999-9999");
		$("#auth_usuario").inputmask("(99) 99999-9999");
		$("#celular").inputmask("(99) 99999-9999");
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

function buttonDelete(idCategoria) {
	swal({
				 title: "Exclusão de Categoria",
				 text: "Deseja realmente excluir essa Categoria de Produto? ",
				 icon: "warning",
				 buttons: true,
				 dangerMode: true
			 })
			 .then((willDelete) => {
				 if (willDelete) {
					 swal("Pronto! Categoria excluída com sucesso!", {
						 icon: "success",
					 });
					 window.location.href = "assets/functions/deleteCategoryProduct.php?categoria=" + idCategoria;
				 }
			 });
}

$('[data-confirm]').click(function(e){
    e.preventDefault();
    var link = $(this).attr('href');

   swal({
          title: "Exclusão de Produto",
          text: "Deseja realmente excluir esse Produto?",
          icon: "warning",
          buttons: true,
          dangerMode: true
        })
        .then((willDelete) => {
          if (willDelete) {
            swal("Pronto! Produto excluído com sucesso!", {
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
