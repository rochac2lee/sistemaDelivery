<?php

require('assets/includes/session.php');

$idViewProfile = $_GET['id'];

if ($idViewProfile > 0) {

	$selectUserActual = "SELECT
							usuarios.nome,
							usuarios.idEmpresa,
							usuarios.senha,
							usuarios.celular,
							usuarios.avatar,
							usuarios.tipo,
							usuarios.status,
							usuarios.data_hora_cadastro as data_cadastroUsuario
						FROM
							usuarios
						WHERE
							usuarios.id = '$idViewProfile'
						";
		$result = $conexao -> prepare($selectUserActual);
		$result -> execute();

		if ($data = $result->fetch()) {
			do {

				$nomeProfile		   = $data['nome'];
				$singleProfile		 = explode(" ", $nomeProfile);
				$singleNomeProfile = $singleProfile[0];

				$avatarProfile		  = $data['avatar'];

				if ($avatarProfile == '') {
					$avatarProfile = 'admin.png';
				}

				$idEmpresaProfile     = $data['idEmpresa'];
				$celularProfile   	  = $data['celular'];
				$ativoProfile     	  = $data['status'];

				$permissoesProfile	  = $data['tipo'];

				$data_cadastroProfile  = $data['data_cadastroUsuario'];

			} while ($data = $result->fetch());
		}
	}

$returnUrl = 'ui-otherprofile.php';

?>

<!DOCTYPE html>
<html lang="en">
<?php require('assets/includes/head.php')?>

<body class="adminbody">

<div id="main">

<?php require('assets/includes/menu.php')?>

    <div class="content-page">

		<!-- Start content -->
        <div class="content">

			<div class="container-fluid">


						<div class="row">
							<div class="col-xl-12">
								<div class="breadcrumb-holder">
										<h1 class="main-title float-left">Informações de Perfil</h1>
										<ol class="breadcrumb float-right">
											<li class="breadcrumb-item">Home</li>
											<li class="breadcrumb-item active"><?php echo $singleNomeProfile ?></li>
										</ol>
										<div class="clearfix"></div>
								</div>
							</div>
						</div>
						<!-- end row -->

						<div class="row">

									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
										<div class="card mb-3">
											<div class="card-materialIcon" style="font-size: 18px;">
												<i class="materialIconGreen fa fa-user"></i>
												<span class="float-right"><i class="fa fa-user"></i> Perfil de <?php echo $singleNomeProfile ?></span>
											</div>

											<div class="card-body">

												<form action="assets/functions/updateUser.php?id=<?php echo $idViewProfile ?>" id="frmUpdateProfile" name="frmUpdateProfile" method="post" enctype="multipart/form-data">

												<div class="row">

												<div class="col-lg-3 col-xl-3 border-left">

													<div class="m-b-10"></div>

													<div id="avatar_image">
														<img alt="Imagem de Perfil" style="max-width:100px; height:auto;" src="assets/uploads/usuarios/<?php echo $avatarProfile ?>" />
														<br />
														<a class="delete_image" style="color:  black" href="assets/functions/deleteOtherProfilePicture.php?id=<?php echo $idViewProfile ?>"><i class="fa fa-trash-alt fa-fw"></i></a>

														<label for="upload">
														      <span class="fa fa-upload" aria-hidden="true"> <p style="display: -webkit-inline-box;" class="up"></p></span>
														      <input type="file" id="upload" name="uploadPicProfile[]" style="display:none">
														</label>

														<script>

															var div = document.getElementsByClassName("up")[0];
															var input = document.getElementById("upload");

															div.addEventListener("click", function(){
															    input.click();
															});

															input.addEventListener("change", function(){
															    var nome = "Não há arquivo selecionado. Selecionar arquivo...";
															    if(input.files.length > 0) nome = input.files[0].name;
															    div.innerHTML = nome;
															});

														</script>

													</div>
													<div id="image_deleted_text"></div>

													<div class="m-b-10"></div>

													<b>Cadastrado em</b>: <?php echo $data_cadastroProfile ?>
												</div>

												<div class="col-lg-9 col-xl-9">

													<div class="row">

														<div class="col-lg-6">
														<div class="form-group">
														<label>Nome *</label>
														<input class="form-control" name="nomeCompleto" type="text" value="<?php echo $nomeProfile ?>" required />
														</div>
														</div>

													</div>

													<div class="row">

														<div class="col-lg-6">
														<div class="form-group">
														<label>Celular *</label>
														<input class="form-control" name="celular" id="celular" type="text" value="<?php echo $celularProfile ?>" required>
														<p>Obs.: Campo Obrigatório para acessar o sistema. </p>
														</div>
														</div>

													</div>

													<div class="row">

														<div class="col-lg-6">
														<div class="form-group">
														<label>Empresa</label>
														<select name="empresa" class="form-control" required />
														<option value="">Selecione...</option>
														<?php
														$select = "SELECT	id, empresa
																				FROM clientes_encode
																				WHERE status = 1 order by empresa ASC";

														$result = $conexaoDelivery -> prepare($select);
														$result -> execute();

														if ($data = $result->fetch()) {
															do {

																$viewIdEmpresa = $data['id'];
																$viewEmpresa   = $data['empresa'];

																if ($idEmpresaProfile == $viewIdEmpresa) {
																	echo '<option selected value="'.$viewIdEmpresa.'">'.$viewEmpresa.'</option>';
																} else {
																	
																	if ($idEmpresaAtual == 1)
																	echo '<option value="'.$viewIdEmpresa.'">'.$viewEmpresa.'</option>';

																}

															} while ($data = $result->fetch());
														}
														?>
														</select>
														</div>
														</div>

														<div class="col-lg-4">
														<div class="form-group">
														<label>Status</label>
														<?php if ($idUsuarioActual == $idViewProfile) { $readOnly = "readonly"; } else { $readOnly = ""; } ?>
														<select <?php echo $readOnly; ?> name="statusUser" class="form-control">
														<?php if ($ativoProfile == 1) { ?>
														<option selected value="1">Sim</option>
														<option value="0">Não</option>
														<?php } else { ?>
														<option value="1">Sim</option>
														<option selected value="0">Não</option>
														<?php } ?>
														</select>
														</div>
														</div>

														<div class="col-lg-6">
														<div class="form-group">
														<label>Permissão</label>
														<select name="permissoes" class="form-control" required>

														<option value="">Selecione...</option>
															<?php
																if ($permissoesProfile == 1) {
																	echo '
																	<option selected value="1">Cliente</option>
																	<option value="0">Administrador</option>
																	';
																} else {
																	echo '
																	<option value="1">Cliente</option>
																	<option selected value="0">Administrador</option>
																	';
																}
															?>
														</select>
														</div>
														</div>

													</div>

													<div class="row">
														<div class="col-lg-12">

														<script type="text/javascript">
														function verifChangeUsers(){
															if (document.frmUpdateProfile.nomeCompleto.value == "" || document.frmUpdateProfile.celular.value == "") {
																return false;
															} else {
															  document.frmUpdateProfile.submit();
															  alert();
															}
														}
														</script>

														<button type="button" onclick="verifChangeUsers()" class="right btn btn-primary"><i class="fa fa-sync-alt"></i>&nbsp; Atualizar Dados</button>
														</div>
													</div>

												</div>

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

function alert() {

$(document).ready(function(){

       swal("Usuário Atualizado!", "Usuário Atualizado com sucesso!", "success");

});
};

$('[data-confirm]').click(function(e){
    e.preventDefault();
    var link = $(this).attr('href');

   swal({
          title: "Remover Acesso",
          text: "Deseja realmente remover o acesso desse usuário?",
          icon: "warning",
          buttons: true,
          dangerMode: true
        })
        .then((willDelete) => {
          if (willDelete) {
            swal("Pronto! Acesso removido com sucesso!", {
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
