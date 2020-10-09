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

	$select = "SELECT * FROM usuarios WHERE id = $id";
	$result = $conexao -> prepare($select);
	$result -> execute();
	$count = $result->rowCount();

	if ($data = $result->fetch()) {
		do {

			$viewNome        = $data['nome'];
			$viewCelular     = $data['celular'];
			$viewdataNasc    = $data['nascimento'];

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

    <div class="content-page">

		<!-- Start content -->
        <div class="content">

			<div class="container-fluid">


				<div class="row">
					<div class="col-xl-12">
						<div class="breadcrumb-holder">
							<h1 class="main-title float-left">Clientes</h1>
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
					<div class="modal-dialog">
						<div class="modal-content">

							<form action="assets/functions/newClient.php?id=<?php echo $id; ?>" method="post" id="frmNewClient" name="frmNewClient" enctype="multipart/form-data">

							<div class="modal-header">
								<h5 class="modal-title">Dados do Cliente</h5>
								<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							</div>

							<div class="modal-body">
								<div class="row">

									<div class="col-lg-12">
									<div class="form-group">
									<label>Nome Completo *</label>
									<input class="form-control" autocomplete="off" name="nome" value="<?php echo $viewNome; ?>" type="text" required />
									</div>
									</div>

									<div class="col-lg-6">
									<div class="form-group">
									<label>Celular</label>
									<input class="form-control" name="celular" id="celular" value="<?php echo $viewCelular; ?>" type="text" />
									</div>
									</div>

									<div class="col-lg-6">
									<div class="form-group">
									<label>Data de Nascimento</label>
									<input class="form-control" name="data_nascimento" id="data_nascimento" value="<?php echo $viewdataNasc; ?>" type="text" />
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

					$select = "SELECT * FROM usuarios where tipo = 1 and id != 1";

					$result = $conexao -> prepare($select);
					$result -> execute();
					$count = $result->rowCount();

				?>

						<div class="row">

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
								<div class="card mb-3 animated fadeIn">
									<div class="card-materialIcon" style="font-size: 18px;">
										<i class="materialIconGreen fa fa-users"></i> <span class="float-right"><i class="fa fa-user"></i> <?php echo $count; if ($count <= 1) { ?> cliente <?php } else { ?> clientes <?php } ?></span>
									</div>

									<div class="card-body">


											<div class="table-responsive">
											<script src="assets/js/sorttable.js"></script>

											<table class="table table-striped" id="tbClients">
											<thead>
											  <tr>
												<th style="width:50px">Favoritos</th>
												<th style="width:150px">ID</th>
												<th style="width:150px">Nome</th>
												<th style="width:150px">Data de Nascimento</th>
												<th style="width:300px">Celular</th>
											  </tr>
											</thead>
											<tbody>

											<?php

												$select = "SELECT * FROM usuarios WHERE id != 1 and id != 2 order by nome, favorito ASC";
												$result = $conexao -> prepare($select);
												$result -> execute();
												$count = $result->rowCount();

												if ($data = $result->fetch()) {
													do {

														$id              = $data['id'];
														$favorito        = $data['favorito'];
														$nome            = $data['nome'];
														$dataNasc        = $data['nascimento'];

														if ($dataNasc == "") {
															$dataNasc = "Não Informado";
														}

														$celular         = $data['celular'];

														if ($celular == "") {
															$celular = "Não Informado";
														}

														if ($favorito == 0) {
															$fav = 1;
															$favClass = "far fa-1-5x fa-star fav";
														} else {
															$fav = 0;
															$favClass = "fa fa-1-5x fa-star fav";
														}

														echo "
														<tr>
															<td class='pointer'><i class='$favClass' onclick=window.location.href='assets/functions/favClient.php?id=$id&fav=$fav'></i></td>
															<td class='pointer' onclick=window.location.href='ui-clients.php?id=$id'>$id</td>
															<td class='pointer' onclick=window.location.href='ui-clients.php?id=$id'>$nome</td>
															<td class='pointer' onclick=window.location.href='ui-clients.php?id=$id'>$dataNasc</td>
															<td class='pointer' onclick=window.location.href='ui-clients.php?id=$id'>$celular</td>
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
