<?php

require('assets/includes/session.php');

?>
<!DOCTYPE html>
<html lang="en">
<?php require('assets/includes/head.php')?>

<body class="adminbody">

<div id="main">

<?php require('assets/includes/menu.php') ?>

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

				<div class="modal fade custom-modal" tabindex="-1" role="dialog" aria-labelledby="modalNewUser" aria-hidden="true" id="modalNewUser">
					<div class="modal-dialog">
						<div class="modal-content">

							<form action="assets/functions/newUser.php" method="post" id="frmNewUser" name="frmNewUser" enctype="multipart/form-data">

							<div class="modal-header">
							<h5 class="modal-title">Novo Usuário</h5>
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							</div>

							<div class="modal-body">

								<div class="row">
									<div class="col-lg-12">
									<div class="form-group">
									<label>Nome Completo *</label>
									<input class="form-control" name="nomeCompleto" type="nomeCompleto" required />
									</div>
									</div>

									<div class="col-lg-6">
									<div class="form-group">
									<label>Celular *</label>
									<input class="form-control" name="celular" id="celular" type="text" required>
									</div>
									</div>

									<div class="col-lg-6">
									<div class="form-group">
									<label>Senha *</label>
									<input class="form-control" autocomplete="off" name="senha" type="password" required />
									</div>
									</div>

								</div>

								<div class="form-group">
								<label>Imagem (optional):</label> <br />
								<input type="file" name="avatarImagem[]">
								</div>

								<div class="row">

									<div class="col-lg-6">
									<div class="form-group">
									<label>Empresa</label>
									<select name="empresa" class="form-control" required />
									<?php
									if ($idEmpresaAtual == 1) {
										$select = "SELECT	id, empresa
																FROM clientes_encode
																WHERE status = 1 order by empresa ASC";
									} else {
										$select = "SELECT	id, empresa
																FROM clientes_encode
																WHERE id = $idEmpresaAtual order by empresa ASC";
									}

									$result = $conexaoDelivery -> prepare($select);
									$result -> execute();

									if ($data = $result->fetch()) {
										do {
											$viewIdEmpresa = $data['id'];
											$viewEmpresa   = $data['empresa'];
											echo '<option value="'.$viewIdEmpresa.'">'.$viewEmpresa.'</option>';
										} while ($data = $result->fetch());
									} else {
											echo '<option value="'.$idEmpresaAtual.'">'.$empresaAtual.'</option>';
									}
									?>
									</select>
									</div>
									</div>

									<div class="col-lg-6">
									<div class="form-group">
									<label>Permissões *</label>
									<select name="permissoes" class="form-control" required />
									<option value="">Selecione...</option>
											<option value="1">Cliente</option>
											<option value="0">Administrador</option>
										</optgroup>
									</select>
									</div>
									</div>

									<div class="col-lg-6">
									<div class="form-group">
									<label>Status *</label>
									<select name="statusUser" class="form-control" required />
									<option value="">Selecione...</option>
										<option selected value="1">Ativo</option>
										<option value="0">Inativo</option>
									</select>
									</div>
									</div>

								</div>

							</div>
							<!-- close modal -->

							<div class="modal-footer">

								<script type="text/javascript">
								function verifNewUser(){
									if (document.frmNewUser.nomeCompleto.value == "" || document.frmNewUser.celular.value == "" || document.frmNewUser.senha.value == "" || document.frmNewUser.permissoes.value == "" || document.frmNewUser.statusUser.value == ""){

										return false;

									} else {

											 document.frmNewUser.submit();
											 loading();

									}
								}
								</script>

								<button type="button" onclick="verifNewUser()" class="btn btn-success"><i class="fa fa-check"></i>&nbsp; Finalizar Cadastro</button>
							</div>

							</form>

						</div>
					</div>
				</div>

				<?php

					$select = "SELECT * FROM usuarios WHERE tipo = 0";

					$result = $conexao -> prepare($select);
					$result -> execute();
					$countUsers = $result->rowCount();

				?>

				<div class="row">
						<div class="col-xl-12">
								<div class="breadcrumb-holder">
										<h1 class="main-title float-left">Usuários</h1>
										<ol class="breadcrumb float-right">
											<li class="breadcrumb-item">
												<button data-toggle="modal" data-target="#modalNewUser" class="btn btn-raised btn-info" id="btnNewRequest"><i class="fa fa-user-plus"></i>&nbsp; Novo Usuário</button>
											</li>
										</ol>
										<div class="clearfix"></div>
								</div>
						</div>
				</div>
				<!-- end row -->

				<div class="row">

					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

						<div class="card mb-3 animated fadeIn">

							<div class="card-materialIcon" style="font-size: 18px;">
								<i class="materialIconGreen fa fa-users"></i>
								<span class="float-right"><i class="fa fa-user"></i> <?php echo $countUsers; if ($countUsers <= 1) { ?> usuário <?php } else { ?> usuários <?php } ?></span>
							</div>
							<!-- end card-header -->

							<div class="card-body">


									<div class="table-responsive">
									<table class="table table-striped" id="tb1">
									<thead>
									  <tr>
										<th>Informações de Usuário</th>
										<th style="width:150px">Celular</th>
										<th style="width:300px">Permissões</th>
										<th style="width:120px">Opções</th>
									  </tr>
									</thead>
									<tbody>

									<?php

										if($idEmpresaAtual == 1) {
											$select = "SELECT
																	usuarios.id,
																	usuarios.avatar,
																	usuarios.idEmpresa,
																	usuarios.nome,
																	usuarios.celular,
																	usuarios.tipo,
																	clientes_encode.empresa
																	FROM usuarios
																	LEFT JOIN clientes_encode on clientes_encode.id = usuarios.idEmpresa
																	WHERE tipo = 0 order by nome ASC";
										} else {
											$select = "SELECT
																	usuarios.id,
																	usuarios.avatar,
																	usuarios.idEmpresa,
																	usuarios.nome,
																	usuarios.celular,
																	usuarios.tipo
																	FROM usuarios
																	WHERE tipo = 0 order by nome ASC";
										}
										$result = $conexao -> prepare($select);
										$result -> execute();

										if ($data = $result->fetch()) {
											do {
												$avatar          = $data['avatar'];

												if ($avatar == '') {
													$avatar = 'admin.png';
												}

												$idUsuario      = $data['id'];
												$idEmpresa      = $data['idEmpresa'];
												$empresa        = $data['empresa'];
												$nome           = $data['nome'];
												$celular        = $data['celular'];
												$tipo           = $data['tipo'];
												if ($tipo == 0) {
													$tipo = "Administrador";
												}
												$dataNascimento = $data['nascimento'];
												$status			    = $data['status'];

												switch ($status) {
													case 0:
														$status = "Inativo";
														break;

													case 1:
														$status = "Ativo";
														break;
												}

												echo "

												<tr>
													<td>
														<span style='float: left; margin-right:10px;'><img alt='image' style='max-width:40px; height:auto;' src='assets/uploads/usuarios/$avatar' /></span>
														<strong>$nome</strong><br/>
														<small>$empresa</small>
													</td>
													<td>$celular</td>
													<td>$tipo</td>
													<td>
														<a href='ui-otherprofile.php?id=$idUsuario' class='btn btn-primary btn-sm'><i class='fa fa-pencil-alt' aria-hidden='true'></i></a>";
												if ($permissoesSistemaActual == 0 && $idUsuarioActual != $idUsuario) {

												echo "
														<a href='assets/functions/deleteUser.php?id=$idUsuario' data-confirm='Deseja realmente excluir esse usuário?' class='btn btn-danger btn-sm' data-placement='top' data-toggle='tooltip' data-title='Delete'><i class='fa fa-trash-alt' aria-hidden='true'></i></a>
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
          title: "Exclusão de Usuário",
          text: "Deseja realmente excluir esse Usuário? Podem existir dados importantes vinculados.",
          icon: "warning",
          buttons: true,
          dangerMode: true
        })
        .then((willDelete) => {
          if (willDelete) {
            swal("Pronto! Usuário excluído com sucesso!", {
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
});
</script>
<!-- END Java Script for this page -->

</body>
</html>
