<?php
ob_start();
session_start();
if (isset($_SESSION['usuario_manager_LP']) && (isset($_SESSION['senha_manager_LP']))){
	header("Location: ../index.php"); exit;
}
include("includes/conexao.php");

?>
<!DOCTYPE html>
<html>
<head>
<title>Login | Gerenciador Lemarde Petisco</title>

<link href="css/bootstrap.css" type="text/css" rel="stylesheet" media="all">
<link href="css/style.css" type="text/css" rel="stylesheet" media="all">
<link rel="stylesheet" href="css/lightbox.css">
<!-- Custom Theme files -->

<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1, maximum-scale=1, user-scalable=no">

<link rel="shortcut icon" href="../assets/images/logo.png" />

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.12/css/all.css" integrity="sha384-G0fIWCsCzJIMAVNQPfjH08cyYaUtMwjJwqiRKxxE/rx96Uroj1BtIQ6MLJuheaO9" crossorigin="anonymous">

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- //Custom Theme files -->
<!-- js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.js"></script>
<!-- //js -->
<!--animate-->
<link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
<script src="js/wow.min.js"></script>
	<script>
		 new WOW().init();
	</script>
<!--//end-animate-->
<!-- image-hover -->
<script type="text/javascript" src="js/mootools-yui-compressed.js"></script>
<!-- //image-hover -->
<link href='//fonts.googleapis.com/css?family=Cabin:400,400italic,500,500italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
</head>
<!-- <body style="height: -webkit-fill-available; background: url(http://backgroundcheckall.com/wp-content/uploads/2017/12/ppt-background-themes-hd-4.jpg); background-size: cover; min-height: 550px;"> -->
<body style="background: linear-gradient(45deg, #1c2e41,#59728e);
    width: 100%;
    height: 100%;
    background-repeat: no-repeat; min-height: 850px;">
	<!--about-->
	<div class="about" id="about">
		<div class="container" style="margin-top: 50px;">
			<div class="col-md-4 about-right wow fadeInRight animated" style="position: absolute; margin: auto; max-width: 450px; top: 70px; right: 0; bottom: 0; left: 0;" data-wow-delay=".5s" style="visibility: visible; -webkit-animation-delay: .5s;">
				<div class="form-body">
					<div style="border-color: #929292; background-color: #f5f5f5; border-radius: 7px;  margin: 15px;">
					<center><img style="width:40%; margin-top:25px;" src="../assets/uploads/sistema/Encode.png" /></center>

						<form action="?loading=1" method="post" id="login" style="padding: 20px; padding-top:30px; padding-bottom:30px;">
							<?php

							date_default_timezone_set('America/Brasilia');
							$dateTime = date('d/m/Y H:i');

							if($existeUsuario != ""){
								echo '<div class="alert alert-danger" role="alert">
											<strong>Você já está cadastrado!</strong> <br> Se você esqueceu sua senha, <a style="color: #03a9f4" onclick="viewEsqueciSenha()">clique aqui!</a>
									   </div>';
							}

							if(isset($_GET['action'])){
								if(!isset($_POST['entrar'])){

									$action = $_GET['action'];
									if($action=='denid'){
										echo '<div class="alert alert-danger" role="alert">
													<strong>Erro ao Acessar!</strong> <br> Você precisa fazer logon para acessar o sistema.
											   </div>';
									}
								}
							}

							if ($id != "") {

								$select = "SELECT * from usuarios WHERE id='$id'";
								$result = $conexaoDelivery -> prepare($select);
								$result -> execute();
								$count = $result->rowCount();

								if ($count > 0) {
									if ($data = $result -> fetch()) {
										do {

											$usuario      = $data['email'];
											$senha 	      = "";

											$_SESSION['usuario_manager_LP'] = $usuario;
											$_SESSION['senha_manager_LP'] = $senha;

											header("Refresh: 1, ../ui-new-password.php?id=$id&forgotPassword=1");

										} while($data = $result -> fetch());
									}
								}
							}

							if (isset($_POST['demo']) || isset($_POST['entrar'])){
								//recuperar dados form
									$usuario             = trim(strip_tags($_POST['auth_usuario']));
									$senha 	             = trim(strip_tags($_POST['auth_pass']));
									$criptografa         = base64_encode($senha);
									$senha = $criptografa;
								//selecionar banco de dados

									$select = "SELECT * from usuarios WHERE BINARY celular='$usuario' AND BINARY senha='$senha'";
									try {
										$result = $conexaoDelivery -> prepare($select);
										$result -> execute();
										$count = $result->rowCount();

										if ($count > 0) {
											if ($data = $result -> fetch()) {
												do {
													$idEmpresa     = $data['idEmpresa'];

													$cookie_name = "idEmpresa";
													setcookie($cookie_name, $idEmpresa, time() + ( 60 * 60 * 24 * 30 ), "/sistemaDelivery");

													$status        = $data['status'];

													if ($status != 0) {
														$redefineSenha = $data['redefineSenha'];
														$usuario      = $_POST['auth_usuario'];
														$senha 	      = $_POST['auth_pass'];
														$criptografa  = base64_encode($senha);
												    $senha        = $criptografa;
														$_SESSION['usuario_manager_LP'] = $usuario;
														$_SESSION['senha_manager_LP'] = $senha;

														echo '<center><img src="images/loader.gif" width="20%"></center>';

														if ($redefineSenha == 0) {
															header("Refresh: 1, ../index.php");
														} else {
															header("Refresh: 1, ../ui-new-password.php");
														}
													} else {
														echo '<div class="alert alert-danger" role="alert">
															<strong>Usuário desativado!</strong> <br> Fale com o Administrador.
													   </div>';
													}
												} while($data = $result -> fetch());
											}
										} else {
							        echo '<div class="alert alert-danger" role="alert">
												<strong>Tente Novamente!</strong> <br> Os Dados de Acesso estão Incorretos.
										   </div>';
							      }

									} catch (PDOException $e){
										echo $e;
									}


								} //Se Clicar no Botão Enter
							?>

							<script>
							function demoSys() {
								document.getElementById('auth_usuario').value = "(00) 00000-0000";
								document.getElementById('auth_pass').value = "demo";
							}
							</script>

							<div class="form-group">
								<label for="auth_usuario">Número de Celular com DDD</label>
								<div class="input-group">
									<span class="input-group-addon"><i class="fas fa-user"></i></span>
									<input type="text" style="-webkit-box-shadow: 0 0 0px 1000px white inset; border-color: #929292;" class="form-control" id="auth_usuario" name="auth_usuario" placeholder="Seu celular">
								</div>
							</div>
							<div class="form-group">
								<label for="nome">Senha</label>
								<div class="input-group">
									<span class="input-group-addon"><i class="fas fa-unlock"></i></span>
									<input type="password" style="-webkit-box-shadow: 0 0 0px 1000px white inset; border-color: #929292;" class="form-control" id="auth_pass" name="auth_pass" placeholder="Sua senha">
								</div>
							</div>
							</br>
							<hr>

							<button name="demo" id="demo" style="float:left;" type="submit" onclick="demoSys()" class="btn btn-info"><i class="fa fa-user"></i>&nbsp; Conta Demo</button>
							<button name="entrar" id="entrar" style="float:right;" type="submit" onclick="var e=this; setTimeout(function(){e.disabled=true;},0); return true;" class="btn btn-success"><i class="fa fa-check"></i>&nbsp; Entrar</button>
							<div class="clearfix"> </div>

						</form>
					</div>
				</div>
			</div>
			<div class="clearfix"> </div>
		</div>
	</div>

	<script>
		$(document).ready(function(){
		  $("#cnpj").inputmask("99.999.999/9999-99");
		  $("#telefone").inputmask("(99) 9999-9999");
		  $("#auth_usuario").inputmask("(99) 99999-9999");
		  $("#celular").inputmask("(99) 99999-9999");
		});
	</script>

	<!-- banner-text Slider starts Here -->
		<script src="js/responsiveslides.min.js"></script>
		 <script>

			// You can also use "$(window).load(function() {"
				$(function () {
				// Slideshow 3
					$("#slider3").responsiveSlides({
					auto: true,
					pager:true,
					nav:true,
					speed: 500,
					namespace: "callbacks",
					before: function () {
					$('.events').append("<li>before event fired.</li>");
					},
					after: function () {
						$('.events').append("<li>after event fired.</li>");
					}
				});
			});
		</script>
		 <script>
			// You can also use "$(window).load(function() {"
				$(function () {
				// Slideshow 4
					$("#slider4").responsiveSlides({
					auto: true,
					pager:true,
					nav:false,
					speed: 500,
					namespace: "callbacks",
					before: function () {
					$('.events').append("<li>before event fired.</li>");
					},
					after: function () {
						$('.events').append("<li>after event fired.</li>");
					}
				});
			});
		</script>
		<!--//End-slider-script -->
		<!-- start-smoth-scrolling-->
		<script src="js/SmoothScroll.min.js"></script>
		<script type="text/javascript" src="js/move-top.js"></script>
		<script type="text/javascript" src="js/easing.js"></script>
		<script type="text/javascript">
				jQuery(document).ready(function($) {
					$(".scroll").click(function(event){
						event.preventDefault();
						$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
					});
				});
		</script>
		<!--//end-smoth-scrolling-->
		<!--smooth-scrolling-of-move-up-->
		<script type="text/javascript">
			$(document).ready(function() {
				/*
				var defaults = {
					containerID: 'toTop', // fading element id
					containerHoverID: 'toTopHover', // fading element hover id
					scrollSpeed: 1200,
					easingType: 'linear'
				};
				*/

				$().UItoTop({ easingType: 'easeOutQuart' });

			});
		</script>
		<a href="#" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>
		<!--//smooth-scrolling-of-move-up-->
	<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/bootstrap.js"></script>
</body>
</html>
