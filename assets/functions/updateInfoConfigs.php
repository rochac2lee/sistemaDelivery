<?php

$singleNome = $_GET['nome'];
$step       = $_GET['step'];

		include("../includes/conexao.php");

			$titulo_site        = $_POST["titulo_site"];
			$SEO_meta_titulo    = $_POST["SEO_meta_titulo"];
			$SEO_meta_descricao = $_POST["SEO_meta_descricao"];
			$SEO_meta_keywords  = $_POST["SEO_meta_keywords"];
			$SEO_meta_autor     = $_POST["SEO_meta_autor"];
			$conteudo_pagina    = $_POST["conteudo_pagina"];
			$conteudo_rodape    = $_POST["conteudo_rodape"];
			$endereco_site      = $_POST["endereco_site"];
			$analytics_codigo   = $_POST["analytics_codigo"];
			$nome_empresa       = $_POST["nome_empresa"];
			$idTipoNegocio      = $_POST["tipo_negocio"];
			$temaSelected				= $_POST['tema'];
			$corPrincipal				= $_POST['corPrincipal'];
			$corTexto   				= $_POST['corTexto'];
			$corTexto2   				= $_POST['corTexto2'];
			$corSecundaria			= $_POST['corSecundaria'];
			$corSidebarMenu			= $_POST['corSidebarMenu'];
			$corSidebarSubMenu  = $_POST['corSidebarSubMenu'];
			$cnpj_empresa       = $_POST["cnpj_empresa"];
			$telefone           = $_POST["telefone_empresa"];
			$linkedin           = $_POST["linkedin_empresa"];
			$endereco_completo  = $_POST["endereco_completo"];
			$descricao_sistema  = $_POST["descricao_sistema"];
			$versao_sistema     = $_POST["versao_sistema"];
			$data_criacao       = $_POST["data_criacao"];
			$data_atualizacao   = $_POST["data_atualizacao"];

			if ($corPrincipal == "") {
				$corPrincipal				= "#262d33";
			}

			if ($corTexto == "") {
				$corTexto   				= "#b5b5b5";
			}

			if ($corTexto == "") {
				$corTexto   				= "#000000";
			}

			if ($corSecundaria == "") {
				$corSecundaria			= "#dfdfdf";
			}

			if ($corSidebarMenu == "") {
				$corSidebarMenu			= "#414d58";
			}

			if ($corSidebarSubMenu == "") {
				$corSidebarSubMenu	= "rgba(65, 77, 88, 0.4)";
			}

			$cookie_name = "corPrincipal";
			setcookie($cookie_name, $corPrincipal, time() + (86400 * 30), "/sistemaDelivery");

			$cookie_name = "corTexto";
			setcookie($cookie_name, $corTexto, time() + (86400 * 30), "/sistemaDelivery");

			$cookie_name = "corTexto2";
			setcookie($cookie_name, $corTexto2, time() + (86400 * 30), "/sistemaDelivery");

			$cookie_name = "corSecundaria";
			setcookie($cookie_name, $corSecundaria, time() + (86400 * 30), "/sistemaDelivery");

			$cookie_name = "corSidebarMenu";
			setcookie($cookie_name, $corSidebarMenu, time() + (86400 * 30), "/sistemaDelivery");

			$cookie_name = "corSidebarSubMenu";
			setcookie($cookie_name, $corSidebarSubMenu, time() + (86400 * 30), "/sistemaDelivery");


		date_default_timezone_set('America/Brasilia');
		$dateTime = date('d/m/Y H:i');

		$conexao->beginTransaction();

		if ($step == 1) {

			$logo = "Encode.png";

			$conexao->exec("INSERT INTO configs (titulo_site, SEO_meta_titulo, SEO_meta_descricao, SEO_meta_keywords, SEO_meta_autor, conteudo_pagina, conteudo_rodape, logo_sistema, tema, corPrincipal, corTexto, corTexto2, corSecundaria, corSidebarMenu, corSidebarSubMenu, endereco_site, analytics_codigo, nome_empresa, idTipoNegocio, cnpj, telefone, linkedin, endereco_completo, descricao_sistema, versao_sistema, data_criacao, data_atualizacao, id_config)
			VALUES('$titulo_site', '$SEO_meta_titulo', '$SEO_meta_descricao', '$SEO_meta_keywords', '$SEO_meta_autor', '$conteudo_pagina', '$conteudo_rodape', '$logo', '$temaSelected', '$corPrincipal', '$corTexto', '$corTexto2', '$corSecundaria', '$corSidebarMenu', '$corSidebarSubMenu', '$endereco_site', '$analytics_codigo', '$nome_empresa',
			'$idTipoNegocio', '$cnpj_empresa', '$telefone',
			'$linkedin', '$endereco_completo', '$descricao_sistema', '$versao_sistema', '$data_criacao', '$data_atualizacao', '')" );

			echo "<script>window.location='../../ui-pre-config.php?step=2';</script>";
		} else if ($step == 2) {

			$selectConfigActual = "SELECT
									id_config, logo_sistema
								FROM
									configs
								ORDER BY id_config DESC LIMIT 1
								";
			$result = $conexao -> prepare($selectConfigActual);
			$result -> execute();
			$countUsersActual = $result->rowCount();

			if ($data_configActual = $result->fetch()) {
				do {

					$id_config      = $data_configActual['id_config'];
					$viewLogo       = $data_configActual['logo_sistema'];

					if ($numFile == 0) {
						$logo = $viewLogo;
					}

				} while ($data_configActual = $result->fetch());
			}

			//UPLOAD
			$logo   = $_FILES['uploadBanner'];
			$numFile  = count(array_filter($logo['name']));

			//REQUISITOS
			$permite 	= array('image/bmp', 'image/jpeg', 'image/jpg', 'image/gif', 'image/png');
			$maxSize	= 1024 * 1024 * 24;

			//PASTA
			$folder = '../uploads/sistema';

			if ($numFile > 0) {
				//Faz o upload de multiplos arquivos
				for ($count = 0; $count < $numFile; $count++) {
					$name 	= $logo['name'][$count];
					$type	= $logo['type'][$count];
					$size	= $logo['size'][$count];
					$error	= $logo['error'][$count];
					$tmp	= $logo['tmp_name'][$count];

					$logo = $name;

					move_uploaded_file($tmp, $folder.'/'.$logo);
				}
			} else {
					$logo = "Encode.png";
			}

      $conexao->exec("UPDATE configs SET status='1', logo_sistema = '$logo', tema = '$temaSelected', corPrincipal = '$corPrincipal', corTexto = '$corTexto', corTexto2 = '$corTexto2', corSecundaria = '$corSecundaria', corSidebarMenu = '$corSidebarMenu', corSidebarSubMenu = '$corSidebarSubMenu' WHERE id_config = '$id_config'" );

			echo "<script>window.location='../../index.php?step=finish';</script>";
		} else {

			$selectConfigActual = "SELECT
									id_config, idTipoNegocio, logo_sistema
								FROM
									configs
								ORDER BY id_config DESC LIMIT 1
								";
			$result = $conexao -> prepare($selectConfigActual);
			$result -> execute();
			$countUsersActual = $result->rowCount();

			if ($data_configActual = $result->fetch()) {
				do {

					$id_config      = $data_configActual['id_config'];
					$viewLogo       = $data_configActual['logo_sistema'];

					//UPLOAD
					$logo   = $_FILES['uploadBanner'];
					$numFile  = count(array_filter($logo['name']));

					//REQUISITOS
					$permite 	= array('image/bmp', 'image/jpeg', 'image/jpg', 'image/gif', 'image/png');
					$maxSize	= 1024 * 1024 * 24;

					//PASTA
					$folder = '../uploads/sistema';

					if ($numFile > 0) {
						//Faz o upload de multiplos arquivos
						for ($count = 0; $count < $numFile; $count++) {
							$name 	= $logo['name'][$count];
							$type	= $logo['type'][$count];
							$size	= $logo['size'][$count];
							$error	= $logo['error'][$count];
							$tmp	= $logo['tmp_name'][$count];

							$logo = $name;

							move_uploaded_file($tmp, $folder.'/'.$logo);
						}
					} else {
							$logo = $viewLogo;
					}

				} while ($data_configActual = $result->fetch());
			}

			$conexao->exec("INSERT INTO configs (titulo_site, status, SEO_meta_titulo, SEO_meta_descricao, SEO_meta_keywords, SEO_meta_autor, conteudo_pagina, conteudo_rodape, logo_sistema, tema, corPrincipal, corTexto, corTexto2, corSecundaria, corSidebarMenu, corSidebarSubMenu, endereco_site, analytics_codigo, nome_empresa, idTipoNegocio, cnpj, telefone, linkedin, endereco_completo, descricao_sistema, versao_sistema, data_criacao, data_atualizacao, id_config)
			VALUES('$titulo_site', '1', '$SEO_meta_titulo', '$SEO_meta_descricao', '$SEO_meta_keywords', '$SEO_meta_autor', '$conteudo_pagina', '$conteudo_rodape', '$logo', '$temaSelected', '$corPrincipal', '$corTexto', '$corTexto2', '$corSecundaria', '$corSidebarMenu', '$corSidebarSubMenu', '$endereco_site', '$analytics_codigo',
			'$nome_empresa', '$idTipoNegocio',
			'$cnpj_empresa', '$telefone', '$linkedin', '$endereco_completo', '$descricao_sistema', '$versao_sistema', '$data_criacao', '$data_atualizacao', '')" );

			sleep(3);
			echo "<script>window.location='../../ui-settings.php';</script>";
		}

		$conexao->commit();

?>
