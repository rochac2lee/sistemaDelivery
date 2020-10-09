<?php

require('assets/includes/session.php');

$id = $_GET['id'];

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

		<style>

		.banner {
		    display: inline-block;
		    width: 100%;
		    height: 300px;
		    object-fit: cover;
		}

		</style>

		<!-- Start content -->
    <div class="content">

			<div class="container-fluid">

				<?php
				$select = "SELECT * FROM produtos WHERE id = '$id'";
				$result = $conexao -> prepare($select);
				$result -> execute();
				$count = $result->rowCount();

					if ($data = $result -> fetch()) {
						do {

							$codigo      = $data['id'];
							$banner      = $data['foto'];
							$produto     = $data['nome'];
							$preco       = $data['preco'];
							$precoPromo  = $data['precoPromo'];
							$margemLucro = $data['lucro'];
							$categoria   = $data['categoria'];
							$descricao   = $data['descricao'];
							$status      = $data['status'];

							if($status == 0) {
								$imgFilter = "grayscale(100%)";
							} else {
								$imgFilter = "grayscale(0%)";
							}

						} while ($data = $result->fetch());
					}
				?>

						<div class="row">
								<div class="col-xl-12">
										<div class="breadcrumb-holder">
												<h1 class="main-title float-left"><?php echo $produto ?></h1>
												<ol class="breadcrumb float-right">
													<li class="breadcrumb-item active">Cadastros</li>
													<li class="breadcrumb-item active">Produtos</li>
												</ol>
												<div class="clearfix"></div>
										</div>
								</div>
						</div>
						<!-- end row -->

						<div class="row">

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

								<div class="card mb-3">

									<img style="filter: <?php echo $imgFilter ?>" src="assets/uploads/banner/<?php echo $banner ?>" class="banner">

									<div class="card-body">

										<form action="assets/functions/updateProduct.php?id=<?php echo $codigo; ?>" name="updateProduct" id="updateProduct" method="post" enctype="multipart/form-data">

										<div class="row">

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

											<div class="col-lg-1">
											<div class="form-group">
											<label>Código</label>
											<input type="text" autofocus="" readonly class="form-control" name="codigo" id="codigo" value="<?php echo $codigo ?>" required="">
											</div>
											</div>

											<div class="col-lg-4">
											<div class="form-group">
											<label>Nome</label>
											<input type="text" class="form-control" name="produto" id="produto" value="<?php echo $produto; ?>" required="">
											</div>
											</div>

											<div class="col-lg-3">
											<div class="form-group">
											<label>Categoria</label>
											<select class="form-control col-md-10 float-left" name="categoria" id="categoria">
												<option value="">Selecione...</option>
											<?php
												$select = "SELECT * FROM categorias ORDER BY id ASC";
												$result = $conexao -> prepare($select);
												$result -> execute();
												$count = $result->rowCount();

												if ($data = $result->fetch()) {
													do {

														$idCategoria = $data['id'];
														$nome        = utf8_encode($data['nome']);

														if ($idCategoria == $categoria) {
															echo "<option selected value='$idCategoria'>$nome</option>";
														} else {
															echo "<option value='$idCategoria'>$nome</option>";
														}

												} while($data = $result->fetch());
											}

											?>
											</select>
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
									        <input type="text" class="form-control" name="preco" id="preco" value="<?php echo $preco; ?>" required="">
									      </div>
									    </div>

											<div class="col-auto">
									      <label>Preço Promocional</label>
									      <div class="input-group mb-2">
									        <div class="input-group-prepend">
									          <div class="input-group-text"><i class="fa fa-dollar-sign"></i></div>
									        </div>
									        <input type="text" class="form-control" name="precoPromo" id="precoPromo" value="<?php echo $precoPromo; ?>" required="">
									      </div>
									    </div>

											<div class="col-auto">
									      <label>Margem de Lucro</label>
									      <div class="input-group mb-2">
									        <div class="input-group-prepend">
									          <div class="input-group-text"><i class="fa fa-dollar-sign"></i></div>
									        </div>
									        <input type="text" class="form-control" name="margemLucro" id="margemLucro" value="<?php echo $margemLucro; ?>" required="">
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
											<label>Descrição Geral</label>
											<textarea class="form-control editor" rows="3" name="descricao" id="descricao"><?php echo $descricao; ?></textarea>
											</div>
											</div>

											<div class="col-lg-2">
											<div class="form-group">
											<label>Status</label>
											<select name="status" id="status" class="form-control" />
												<?php
												if ($status == 1) {
													echo '
														<option selected value="1">Ativo</option>
														<option value="0">Inativo</option>
													';
												} else {
													echo '
														<option value="1">Ativo</option>
														<option selected value="0">Inativo</option>
													';
												}
												?>
											</select>
											</div>
											</div>

										</div> <!-- end row -->

										<div class="modal-footer">

											<script type="text/javascript">
											function verificaUpdateProduct(){
												if (document.updateProduct.produto.value == "" ||
													document.updateProduct.preco.value == ""){
													return false;
												} else {
													document.updateProduct.submit();
													document.getElementById('updateProd').style.visibility = 'hidden';
													document.getElementById('updateProd').style.display = 'none';
													alertUpdateProduct();
												}
											}
											</script>
											<button type="button" class="btn btn-success" onclick="verificaUpdateProduct()" id="updateProd"><i class="fa fa-save"></i>&nbsp; Atualizar</button>
										</div>

									</form>

									</div>
									<!-- end card-body -->

								</div>
								<!-- end card -->

							</div>
							<!-- end col -->

						</div>
						<!-- end row -->
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
		$("#preco").maskMoney({allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
		$("#precoPromo").maskMoney({allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
		$("#margemLucro").maskMoney({allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
	});
</script>

<script src="assets/js/modernizr.min.js"></script>
<script src="assets/js/moment.min.js"></script>

<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

<script src="assets/js/detect.js"></script>
<script src="assets/js/fastclick.js"></script>
<script src="assets/js/jquery.blockUI.js"></script>
<script src="assets/js/jquery.nicescroll.js"></script>

<!-- App js -->
<script src="assets/js/pikeadmin.js"></script>


<!-- BEGIN Java Script for this page -->
<script src="assets/plugins/trumbowyg/trumbowyg.min.js"></script>
<script src="assets/plugins/trumbowyg/plugins/upload/trumbowyg.upload.js"></script>
<script>
$(document).ready(function () {
    'use strict';
	$('.editor').trumbowyg();
});
</script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>

function alertUpdateProduct() {

$(document).ready(function(){

       swal("Produto Atualizado!", "Atualização realizada com sucesso!", "success");

});
};
</script>

	<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>

<!-- END Java Script for this page -->

</body>
</html>
