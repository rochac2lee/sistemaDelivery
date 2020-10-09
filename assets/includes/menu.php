<?php

	$selectUserActual = "SELECT
							usuarios.id,
							usuarios.idEmpresa,
							usuarios.nome,
							usuarios.celular,
							usuarios.senha,
							usuarios.avatar,
							usuarios.tipo,
							usuarios.status,
							usuarios.redefineSenha,
							usuarios.data_hora_cadastro
						FROM
							usuarios
						WHERE
							usuarios.celular = '$celular' and usuarios.senha = '$senha'
						";
	$result = $conexaoDelivery -> prepare($selectUserActual);
	$result -> execute();
	$countUsersActual = $result->rowCount();

	if ($data_userActual = $result->fetch()) {
		do {

			$idUsuarioActual	  = $data_userActual['id'];
			$idEmpresaAtual  	  = $data_userActual['idEmpresa'];
			$nomeActual		  	  = $data_userActual['nome'];
			$single				      = explode(" ", $nomeActual);
			$singleNome         = $single[0];
			$celularActual		  = $data_userActual['celularUsuario'];
			$avatarActual		    = $data_userActual['avatar'];
			$celularActual   	  = $data_userActual['celular'];
			$ativoActual     	  = $data_userActual['status'];
			$resetActual     	  = $data_userActual['redefineSenha'];
			$data_cadastroActual  = $data_userActual['data_hora_cadastro'];
			$permissoesSistemaActual  = $data_userActual['tipo'];

		} while ($data_userActual = $result->fetch());
	}

if ($resetActual == 1) {
	header('location:ui-reset.php?mod=reset');
}

?>

	<!-- top bar navigation -->
	<div class="headerbar">

		<!-- LOGO -->

        <div class="headerbar-left">

        </div>

        <nav class="navbar-custom zoom">

                    <ul class="list-inline float-right mb-0" style="zoom: 100%!important; <?php echo $marginListInline ?>">

                        <li class="list-inline-item dropdown notif">

                            <a class="nav-link dropdown-toggle nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            	<img src="assets/uploads/usuarios/<?php echo $avatarActual ?>" alt="Profile image" class="avatar-rounded">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right profile-dropdown">
                                <!-- item-->
                                <div class="dropdown-item noti-title">
                                    <h5 class="text-overflow"><small>Olá, <?php echo $singleNome ?></small> </h5>
                                </div>

                                <!-- item-->
                                <a href="ui-profile.php?mod=<?php echo $mod; ?>" class="dropdown-item notify-item">
                                    <i class="fa fa-user"></i> <span>Meu Perfil</span>
                                </a>

                                <!-- item-->
                                <a href="?sair" onClick="return confirm('Deseja realmente sair do sistema?')" class="dropdown-item notify-item">
                                    <i class="fa fa-power-off"></i> <span>Sair</span>
                                </a>
                            </div>
                        </li>

                    </ul>

                    <ul class="list-inline menu-left mb-0">
                        <li class="float-left" style="margin-top: 10px;">
                            <button class="button-menu-mobile open-left">
																<i class="fa fa-fw fa-bars"></i>
                            </button>
                        </li>
                    </ul>

        </nav>

	</div>
	<!-- End Navigation -->


	<!-- Left Sidebar -->
	<div class="left main-sidebar" style="position: fixed;">

		<div class="sidebar-inner leftscroll">

			<div id="sidebar-menu">

<?php

		require('assets/includes/menuBar.php');

?>
            	<div class="clearfix"></div>

			</div>

			<div class="clearfix"></div>

		</div>

	</div>
	<!-- End Sidebar -->
