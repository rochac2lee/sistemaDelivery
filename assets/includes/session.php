<?php
ob_start();
session_start();

if (!isset($_SESSION['usuario_manager_LP']) && (!isset($_SESSION['senha_manager_LP']))){
	header("Location: login"); exit;
}

include('assets/includes/conexao.php');

$celular = $_SESSION['usuario_manager_LP'];
$senha   = $_SESSION['senha_manager_LP'];

// pega o IP do usuário
$ip = $_SERVER['REMOTE_ADDR'];

date_default_timezone_set('America/Brasilia');
$dateTime = date('d/m/Y H:i');
$date     = date('Y-m-d H:i');
$dateNow  = date('Y-m-d');
$day      = date('d');
$year     = date('Y');
$month    = date('m');

	switch ($month) {
		case 1:
			$monthname = "Janeiro";
			break;
		case 2:
			$monthname = "Fevereiro";
			break;
		case 3:
			$monthname = "Março";
			break;
		case 4:
			$monthname = "Abril";
			break;
		case 5:
			$monthname = "Maio";
			break;
		case 6:
			$monthname = "Junho";
			break;
		case 7:
			$monthname = "Julho";
			break;
		case 8:
			$monthname = "Agosto";
			break;
		case 9:
			$monthname = "Setembro";
			break;
		case 10:
			$monthname = "Outubro";
			break;
		case 11:
			$monthname = "Novembro";
			break;
		case 12:
			$monthname = "Dezembro";
	}

require('assets/includes/logout.php');

	$selectConfigActual = "SELECT * FROM configs ORDER BY id_config DESC LIMIT 1";
	$result = $conexao -> prepare($selectConfigActual);
	$result -> execute();
	$countUsersActual = $result->rowCount();

	if ($data_configActual = $result->fetch()) {
		do {

			$titulo_site        = $data_configActual['titulo_site'];
			$statusSistema      = $data_configActual['status'];
			$SEO_meta_titulo    = $data_configActual['SEO_meta_titulo'];
			$SEO_meta_descricao = $data_configActual['SEO_meta_descricao'];
			$SEO_meta_keywords  = $data_configActual['SEO_meta_keywords'];
			$SEO_meta_autor     = $data_configActual['SEO_meta_autor'];
			$conteudo_pagina    = $data_configActual['conteudo_pagina'];
			$conteudo_rodape    = $data_configActual['conteudo_rodape'];
			$endereco_site      = $data_configActual['endereco_site'];
			$analytics_codigo   = $data_configActual['analytics_codigo'];
			$logo_sistema       = $data_configActual['logo_sistema'];
			$logo_login         = $data_configActual['logo_login'];
			$temaAtual  				= $data_configActual['tema'];
			$corPrincipal				= $data_configActual['corPrincipal'];
			$corTexto   				= $data_configActual['corTexto'];
			$corTexto2   				= $data_configActual['corTexto2'];
			$corSecundaria			= $data_configActual['corSecundaria'];
			$corSidebarMenu			= $data_configActual['corSidebarMenu'];
			$corSidebarSubMenu  = $data_configActual['corSidebarSubMenu'];
			$nome_empresa       = $data_configActual['nome_empresa'];
			$empresaTipoNegocio = $data_configActual['idTipoNegocio'];
			$cnpj_empresa       = $data_configActual['cnpj'];
			$telefone_empresa   = $data_configActual['telefone'];
			$linkedin_empresa   = $data_configActual['linkedin'];
			$endereco_completo  = $data_configActual['endereco_completo'];
			$descricao_sistema  = $data_configActual['descricao_sistema'];
			$versao_sistema     = $data_configActual['versao_sistema'];
			$data_criacao       = $data_configActual['data_criacao'];
			$data_atualizacao   = $data_configActual['data_atualizacao'];

		} while ($data_configActual = $result->fetch());
	}

	if ($statusSistema == 0 && $config == true) {
		header("location: ui-pre-config.php");
	}
	if ($statusSistema == 0) {
		$cookie_name = "hideMenu";
		setcookie($cookie_name, '0', time() + (86400 * 30), "/sistemaDelivery");
	} else {
		$config == false;
		$cookie_name = "hideMenu";
		setcookie($cookie_name, '1', time() + (86400 * 30), "/sistemaDelivery");
	}

	$select = "SELECT * FROM caixa WHERE status = 1 ORDER BY id DESC LIMIT 1";
	$result = $conexao -> prepare($select);
	$result->execute();
	$countCaixa = $result->rowCount();

	if ($countCaixa != "") {
		setCookie('statusCaixa', '1', time() + ( 60 * 60 * 24 * 30 ), '/sistemaDelivery');
	} else {
		setCookie('statusCaixa', '0', time() + ( 60 * 60 * 24 * 30 ), '/sistemaDelivery');
	}

	$select = "SELECT * FROM tipos_negocio WHERE id = '$empresaTipoNegocio'";
	$result = $conexaoDelivery -> prepare($select);
	$result -> execute();
	$count = $result->rowCount();

	if ($data = $result -> fetch()) {
		do {

			$idTipoNegocio = $data["id"];
			$tipoNegocio   = $data["tipoNegocio"];

		} while ($data = $result->fetch());
	}

?>
