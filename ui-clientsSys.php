<?php

require('assets/includes/session.php');

$id = $_GET['id'];

?>
<!DOCTYPE html>
<html lang="en">

<?php require('assets/includes/head.php')?>

<body class="adminbody">

<div id="main">

<?php require('assets/includes/menu.php') ?>

<div id="loading" style="display: none; width: 100%; height: 100%; background: #000000a6; position: absolute; z-index: 999999;">

	<img src="assets/images/loading.gif" style="width: 10%; top: 45%; left: 50%; position: fixed;">

</div>

<?php if ($id != "") {

	$select = "SELECT * FROM clientes_encode WHERE id = $id";
	$result = $conexao -> prepare($select);
	$result -> execute();
	$count = $result->rowCount();

	if ($data = $result->fetch()) {
		do {

			$viewEmpresa   = $data['empresa'];
			$viewCNPJ      = $data['cnpj'];
			$viewEmail     = $data['email'];
			$viewTelefone  = $data['telefone'];
			$viewBaseDB    = $data['bancoDB'];
			$viewUsuarioDB = $data['usuarioDB'];
			$viewSenhaDB   = $data['senhaDB'];
			$viewStatus    = $data['status'];

		} while($data = $result->fetch());
	}

?>

<script>
$(document).ready(function() {
    $('#modalNewClient').modal('show');
})
</script>

<?php } ?>

<script type="text/javascript">

	function loading() {
		document.getElementById('loading').style.display = 'block';
	}

</script>

<style>
	.fav {
		color: #43a047;
	}
</style>

    <div class="content-page">

		<!-- Start content -->
        <div class="content">

			<div class="container-fluid">


				<div class="row">
					<div class="col-xl-12">
						<div class="breadcrumb-holder">
							<h1 class="main-title float-left">Clientes Encode</h1>
							<span class="pull-right">
								<div class="input-group">
								  <div class="input-group-prepend">
								    <button class="btn btn-outline-secondary" style="border-top-right-radius: 0; border-bottom-right-radius: 0" type="button"><i class="fa fa-search"></i></button>
								  </div>
								  <input type="text" class="form-control search" id="search" placeholder="Pesquisar...">

									<button class="btn btn-raised btn-primary" style="margin-left: 15px" data-toggle="modal" data-target="#modalNewClient"><i class="fa fa-user-plus" aria-hidden="true"></i>&nbsp; Novo Cliente</button>
								</div>
							</span>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
				<!-- end row -->

				<div class="modal fade custom-modal" tabindex="-1" role="dialog" aria-labelledby="modalNewClient" aria-hidden="true" id="modalNewClient">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">

							<form action="assets/functions/newEncodeClient.php?id=<?php echo $id; ?>" method="post" id="frmNewClient" name="frmNewClient" enctype="multipart/form-data">

							<div class="modal-header">
								<h5 class="modal-title">Dados do Cliente</h5>
								<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							</div>

							<div class="modal-body">
								<div class="row">

									<div class="col-lg-6">
									<div class="form-group">
									<label>Empresa *</label>
									<input class="form-control" autocomplete="off" name="empresa" value="<?php echo $viewEmpresa; ?>" type="text" required />
									</div>
									</div>

									<div class="col-lg-6">
									<div class="form-group">
									<label>CNPJ</label>
									<input class="form-control" name="cnpj" id="cnpj" value="<?php echo $viewCNPJ; ?>" type="text" />
									</div>
									</div>

									<div class="col-lg-6">
									<div class="form-group">
									<label>Email</label>
									<input class="form-control" name="email" id="email" value="<?php echo $viewEmail; ?>" type="email" />
									</div>
									</div>

									<div class="col-lg-6">
									<div class="form-group">
									<label>Telefone</label>
									<input class="form-control" name="telefone" id="telefone" value="<?php echo $viewTelefone; ?>" type="text" />
									</div>
									</div>

								</div>

								<div class="row">
									<div class="col-lg-6">
									<div class="form-group">
									<label>Banco de Dados</label>
									<input class="form-control" name="bancoDB" id="bancoDB" value="<?php echo $viewBaseDB; ?>" type="text" required>
									</div>
									</div>

									<div class="col-lg-6">
									<div class="form-group">
									<label>Usuário DB</label>
									<input class="form-control" name="usuarioDB" id="usuarioDB" value="<?php echo $viewUsuarioDB; ?>" type="text" required>
									</div>
									</div>

									<div class="col-lg-6">
									<div class="form-group">
									<label>Senha DB</label>
									<input class="form-control" name="senhaDB" id="senhaDB" value="<?php echo $viewSenhaDB; ?>" type="password" required>
									</div>
									</div>

									<div class="col-lg-6">
									<div class="form-group">
									<label>Status</label>
									<select name="status" class="form-control" />
									<option value="">Selecione...</option>
										<?php
											if ($viewStatus == 1) {
												echo
												'
												<option selected value="1">Ativo</option>
												<option value="0">Inativo</option>
												';
											} else {
												echo
												'
												<option value="1">Ativo</option>
												<option selected value="0">Inativo</option>
												';
											}
										?>
									</select>
									</div>
									</div>

								</div>

							</div>
							<!-- close modal -->

							<div class="modal-footer">

								<button type="submit" onclick="loading();" class="btn btn-success"><i class="fa fa-check"></i>&nbsp; Salvar</button>
							</div>

							</form>

						</div>
					</div>
				</div>

				<?php

					$select = "SELECT * FROM clientes_encode";

					$result = $conexao -> prepare($select);
					$result -> execute();
					$count = $result->rowCount();

				?>

						<div class="row">

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
								<div class="card mb-3">
									<div class="card-materialIcon" style="font-size: 18px;">
										<i class="materialIconGreen fa fa-users"></i> <span class="float-right"><i class="fa fa-user"></i> <?php echo $count; if ($count <= 1) { ?> cliente <?php } else { ?> clientes <?php } ?></span>
									</div>

									<div class="card-body">


											<div class="table-responsive">
											<script src="assets/js/sorttable.js"></script>

											<table class="table table-striped" id="tbClients">
											<thead>
											  <tr>
												<th style="width:50px">ID</th>
												<th style="width:150px">Empresa</th>
												<th style="width:150px">CNPJ</th>
												<th style="width:150px">Email</th>
												<th style="width:150px">Telefone</th>
												<th style="width:120px">Opções</th>
											  </tr>
											</thead>
											<tbody>

											<?php

												$select = "SELECT * FROM clientes_encode order by empresa ASC";
												$result = $conexao -> prepare($select);
												$result -> execute();
												$count = $result->rowCount();

												if ($data = $result->fetch()) {
													do {

														$id        = $data['id'];
														$empresa   = $data['empresa'];
														$cnpj      = $data['cnpj'];
														$email     = $data['email'];
														$telefone  = $data['telefone'];
														$status    = $data['status'];
														$bancoDB   = $data['bancoDB'];
														$usuarioDB = $data['usuarioDB'];

														if ($cnpj == "") {
															$cnpj = "Não Informado";
														}

														if ($status == 1) {
															$status = "Ativo";
														}	else {
															$status = "Inativo";
														}

														echo "
														<tr>
															<td class='pointer' onclick=window.location.href='ui-clientsSys.php?id=$id'>$id</td>
															<td class='pointer' onclick=window.location.href='ui-clientsSys.php?id=$id'>$empresa</td>
															<td class='pointer' onclick=window.location.href='ui-clientsSys.php?id=$id'>$cnpj</td>
															<td class='pointer' onclick=window.location.href='ui-clientsSys.php?id=$id'>$email</td>
															<td class='pointer' onclick=window.location.href='ui-clientsSys.php?id=$id'>$telefone</td>
															<td>
														";
														if ($permissoesSistemaActual == 0 && $idEmpresaAtual != $id) {

															echo "
																	<a href='assets/functions/deleteEncodeClient.php?id=$id' data-confirm='Deseja realmente excluir esse cliente?' class='btn btn-danger btn-sm' data-placement='top' data-toggle='tooltip' data-title='Delete'><i class='fa fa-trash-alt' aria-hidden='true'></i></a>
															";

														}
														echo "
															</td>
														</tr>
														";

													} while ($data = $result->fetch());
												}

											?>
												</tbody>
											</table>

											<script>

											document.getElementById('search').addEventListener('keyup', search());

											function search() {
												var filter, table, tr, td, i;
												table = document.getElementById("tbClients");
												return function() {
												tr = table.querySelectorAll("tbody tr");
												filter = this.value.toUpperCase();
												for (i = 0; i < tr.length; i++) {
													var match = tr[i].innerHTML.toUpperCase().indexOf(filter) > -1;
													tr[i].style.display = match ? "" : "none";
												}
												}
											}
											</script>

											</div>


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

<script src="assets/js/modernizr.min.js"></script>
<script src="assets/js/moment.min.js"></script>

<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

<script src="assets/js/detect.js"></script>
<script src="assets/js/fastclick.js"></script>
<script src="assets/js/jquery.blockUI.js"></script>
<script src="assets/js/jquery.nicescroll.js"></script>
<script src="assets/js/jquery.scrollTo.min.js"></script>
<script src="assets/plugins/switchery/switchery.min.js"></script>

<!-- App js -->
<script src="assets/js/pikeadmin.js"></script>

<!-- BEGIN Java Script for this page -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>

function alertNewUser() {

$(document).ready(function(){

       swal("Bom Trabalho!", "Usuário cadastrado com sucesso!", "success");

});
};

$('[data-confirm]').click(function(e){
    e.preventDefault();
    var link = $(this).attr('href');

   swal({
          title: "Exclusão de Cliente",
          text: "Deseja realmente excluir esse Cliente? Podem existir dados importantes vinculados.",
          icon: "warning",
          buttons: true,
          dangerMode: true
        })
        .then((willDelete) => {
          if (willDelete) {
            swal("Pronto! Cliente excluído com sucesso!", {
              icon: "success",
            });
            window.location.href = link;
          }
        });
});

</script>
<script>
$(document).ready(function(){
  $("#cnpj").inputmask("99.999.999/9999-99");
  $("#telefone").inputmask("(99) 9999-9999");
  $("#celular").inputmask("(99) 99999-9999");
  $("#data_nascimento").inputmask("99/99/9999");
});
</script>
<!-- END Java Script for this page -->

</body>
</html>
