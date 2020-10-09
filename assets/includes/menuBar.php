<?php

echo "

<style>
	:root {
		--corPrincipal: $corPrincipal;
		--corTexto: $corTexto;
		--corTexto2: $corTexto2;
		--corSecundaria: $corSecundaria;
		--corSidebarMenu: $corSidebarMenu;
		--corSidebarSubMenu: $corSidebarSubMenu;
	}
</style>

";

?>

<!-- Permissões do Administrador(Não tem acesso ao Suporte ao Cliente - Chat) -->
<ul id="adm-all">

	<li class="submenu logoMenu" onclick="resetNav()">
		<div class="card-body" style=" text-align: center!important; color: #fff; /* padding-top: 5%; padding-bottom: 5%; */">
		<img onclick=window.location.href="index.php" id="logoImg" alt="" style="width: 65%; " src="assets/uploads/sistema/<?php echo $logo_sistema; ?>" />
		</div>
	</li>

	<li class="submenu" id="subMenuVendas">
		<a href="#" onclick=changeNavActive("Vendas") id="vendas"><i class="fa fa-fw fa-hand-holding-usd"></i><span>Vendas </span> <span class="menu-arrow"></span></a>
		<ul class="list-unstyled" id="ulVendas">
			<li><a  onclick=changeNavActive("Vendas-Pedidos") href="ui-requests.php" id="pedidos">Pedidos</a></li>
			<li><a  onclick=changeNavActive("Vendas-TelaInterativa") href="ui-screen-requests.php" id="telaInterativa" target="_blank">Tela Interativa</a></li>
			<li><a  onclick=changeNavActive("Vendas-Relatorio") href="ui-report-requests.php" id="relatorio">Relatório</a></li>
		</ul>
	</li>

	<li class="submenu" id="subMenuProdutos">
		<a href="#" onclick=changeNavActive("Produtos") id="produtos"><i class="fa fa-fw fa-tag"></i><span>Produtos </span> <span class="menu-arrow"></span></a>
		<ul class="list-unstyled" id="ulProdutos">
			<li><a  onclick=changeNavActive("Produtos-Todos") href="ui-products.php?status=1" id="produtosTodos">Cadastro</a></li>
			<li><a  onclick=changeNavActive("Produtos-Cardápio") href="ui-business-menu.php" id="produtosCardapio">Cardápio Digital</a></li>
		</ul>
	</li>

	<li class="submenu" id="subMenuDelivery">
		<a href="#" onclick=changeNavActive("Delivery") id="delivery"><i class="fa fa-fw fa-motorcycle"></i><span>Delivery </span> <span class="menu-arrow"></span></a>
		<ul class="list-unstyled" id="ulDelivery">
			<li><a  onclick=changeNavActive("Delivery-Gestão") href="ui-delivery.php" id="gestao">Gestão</a></li>
			<li><a  onclick=changeNavActive("Delivery-Motoboy") href="ui-report-motoboy.php" id="relatorioMotoboy">Relatório</a></li>
		</ul>
	</li>

	<li class="submenu" id="subMenuClientes">
		<a href="ui-clients.php" onclick=changeNavActive("Clientes") id="clientes"><i class="fa fa-fw fa-users"></i><span>Clientes </span> <span class="menu-arrow"></span></a>
	</li>

	<li class="submenu" id="subMenuFinanceiro">
		<a href="#" onclick=changeNavActive("Financeiro") id="financeiro"><i class="fa fa-fw fa-dollar-sign"></i><span>Financeiro </span> <span class="menu-arrow"></span></a>
		<ul class="list-unstyled" id="ulFinanceiro">
			<li><a href="ui-finances.php" onclick=changeNavActive("Financeiro-Movimentações");changeFinanceNavActive("resultado"); id="movimentacoes">Movimentações</a></li>
		</ul>
	</li>

	<li class="submenu display-none" id="subMenuEncode">
		<a href="#" onclick=changeNavActive("Encode") id="encode"><i><img src="assets/uploads/sistema/Encode_white.png" style="width: 20px"></i><span>Encode </span> <span class="menu-arrow"></span></a>
		<ul class="list-unstyled" id="ulEncode">
			<li><a href="ui-clientsSys.php" onclick=changeNavActive("Encode-Clientes") id="encodeClientes">Clientes</a></li>
			<li><a href="ui-encode-category.php" onclick=changeNavActive("Encode-Tipo-Negocio") id="encodeTipoNegocio">Categorias</a></li>
			<li><a href="ui-qrCode.php" onclick=changeNavActive("Encode-qrCode") id="encodeQRCode">QR Code</a></li>
		</ul>
	</li>

	<li class="submenu" id="subMenuConfig">
		<a href="#" onclick=changeNavActive("Configurações") id="config"><i class="fa fa-fw fa-cog"></i><span>Configurações </span> <span class="menu-arrow"></span></a>
		<ul class="list-unstyled" id="ulConfig">
			<li><a href="ui-settings.php" onclick=changeNavActive("Config-Sistema") id="sistema">Sistema</a></li>
			<li><a href="ui-users.php" onclick=changeNavActive("Config-Usuarios") id="usuarios">Usuários</a></li>
		</ul>
	</li>

	<li class="submenu">
		<a href="?sair" onClick="resetNav();return confirm('Deseja realmente sair do sistema?')"><i class="fa fa-fw fa-door-open"></i><span>Sair </span> </a>
	</li>
</ul>

<script>
function changeNavActive(nav) {

	setCookie("nav", nav, 30);

}

function resetNav() {
	setCookie("nav", '', 30);
}

var hideMenu  = getCookie('hideMenu');
var idEmpresa = getCookie('idEmpresa');

if (hideMenu == 0) {
	document.getElementById("subMenuVendas").classList.add("display-none");
	document.getElementById("subMenuProdutos").classList.add("display-none");
	document.getElementById("subMenuClientes").classList.add("display-none");
	document.getElementById("subMenuDelivery").classList.add("display-none");
	document.getElementById("subMenuFinanceiro").classList.add("display-none");
	document.getElementById("subMenuConfig").classList.add("display-none");
} else {
	document.getElementById("subMenuVendas").classList.add("display-block");
	document.getElementById("subMenuProdutos").classList.add("display-block");
	document.getElementById("subMenuClientes").classList.add("display-block");
	document.getElementById("subMenuDelivery").classList.add("display-block");
	document.getElementById("subMenuFinanceiro").classList.add("display-block");
	document.getElementById("subMenuConfig").classList.add("display-block");
}

if (idEmpresa == 1) {
	document.getElementById("subMenuEncode").classList.remove("display-none");
	document.getElementById("subMenuEncode").classList.add("display-block");
} else {
	document.getElementById("subMenuEncode").classList.remove("display-block");
	document.getElementById("subMenuEncode").classList.add("display-none");
}

var viewNav = getCookie('nav');
switch (viewNav) {
	case "Vendas":
	document.getElementById("vendas").classList.add("Active");
	break;

	case "Vendas-Pedidos":
	document.getElementById("vendas").classList.add("Active");
	document.getElementById("vendas").classList.add("subdrop");
	document.getElementById("ulVendas").style.display = "block";

	document.getElementById("pedidos").classList.add("Active");
	document.getElementById("pedidos").classList.add("subdrop2");
	break;

	case "Vendas-TelaInterativa":
	document.getElementById("vendas").classList.add("Active");
	document.getElementById("vendas").classList.add("subdrop");
	document.getElementById("ulVendas").style.display = "block";

	document.getElementById("telaInterativa").classList.add("Active");
	document.getElementById("telaInterativa").classList.add("subdrop2");
	break;

	case "Vendas-Relatorio":
	document.getElementById("vendas").classList.add("Active");
	document.getElementById("vendas").classList.add("subdrop");
	document.getElementById("ulVendas").style.display = "block";

	document.getElementById("relatorio").classList.add("Active");
	document.getElementById("relatorio").classList.add("subdrop2");
	break;


	case "Financeiro":
	document.getElementById("financeiro").classList.add("Active");
	break;

	case "Financeiro-Movimentações":
	document.getElementById("financeiro").classList.add("Active");
	document.getElementById("financeiro").classList.add("subdrop");
	document.getElementById("ulFinanceiro").style.display = "block";

	document.getElementById("movimentacoes").classList.add("Active");
	document.getElementById("movimentacoes").classList.add("subdrop2");
	break;

	case "Produtos":
	document.getElementById("produtos").classList.add("Active");
	document.getElementById("produtos").classList.add("subdrop");
	document.getElementById("ulProdutos").style.display = "block";
	break;

	case "Produtos-Todos":
	document.getElementById("produtos").classList.add("Active");
	document.getElementById("produtos").classList.add("subdrop");
	document.getElementById("ulProdutos").style.display = "block";

	document.getElementById("produtosTodos").classList.add("Active");
	document.getElementById("produtosTodos").classList.add("subdrop2");
	break;

	case "Produtos-Cardápio":
	document.getElementById("produtos").classList.add("Active");
	document.getElementById("produtos").classList.add("subdrop");
	document.getElementById("ulProdutos").style.display = "block";

	document.getElementById("produtosCardapio").classList.add("Active");
	document.getElementById("produtosCardapio").classList.add("subdrop2");
	break;

	case "Delivery":
	document.getElementById("delivery").classList.add("Active");
	document.getElementById("delivery").classList.add("subdrop");
	document.getElementById("ulDelivery").style.display = "block";
	break;

	case "Delivery-Gestão":
	document.getElementById("delivery").classList.add("Active");
	document.getElementById("delivery").classList.add("subdrop");
	document.getElementById("ulDelivery").style.display = "block";

	document.getElementById("gestao").classList.add("Active");
	document.getElementById("gestao").classList.add("subdrop2");
	break;

	case "Delivery-Motoboy":
	document.getElementById("delivery").classList.add("Active");
	document.getElementById("delivery").classList.add("subdrop");
	document.getElementById("ulDelivery").style.display = "block";

	document.getElementById("relatorioMotoboy").classList.add("Active");
	document.getElementById("relatorioMotoboy").classList.add("subdrop2");
	break;

	case "Clientes":
	document.getElementById("clientes").classList.add("Active");
	document.getElementById("clientes").classList.add("subdrop");
	break;

	case "Encode":
	document.getElementById("encode").classList.add("Active");
	document.getElementById("encode").classList.add("subdrop");
	document.getElementById("ulEncode").style.display = "block";
	break;

	case "Encode-Clientes":
	document.getElementById("encode").classList.add("Active");
	document.getElementById("encode").classList.add("subdrop");
	document.getElementById("ulEncode").style.display = "block";

	document.getElementById("encodeClientes").classList.add("Active");
	document.getElementById("encodeClientes").classList.add("subdrop2");
	break;

	case "Encode-Tipo-Negocio":
	document.getElementById("encode").classList.add("Active");
	document.getElementById("encode").classList.add("subdrop");
	document.getElementById("ulEncode").style.display = "block";

	document.getElementById("encodeTipoNegocio").classList.add("Active");
	document.getElementById("encodeTipoNegocio").classList.add("subdrop2");
	break;

	case "Encode-qrCode":
	document.getElementById("encode").classList.add("Active");
	document.getElementById("encode").classList.add("subdrop");
	document.getElementById("ulEncode").style.display = "block";

	document.getElementById("encodeQRCode").classList.add("Active");
	document.getElementById("encodeQRCode").classList.add("subdrop2");
	break;

	case "Configurações":
	document.getElementById("config").classList.add("Active");
	document.getElementById("config").classList.add("subdrop");
	document.getElementById("ulConfig").style.display = "block";
	break;

	case "Config-Sistema":
	document.getElementById("config").classList.add("Active");
	document.getElementById("config").classList.add("subdrop");
	document.getElementById("ulConfig").style.display = "block";

	document.getElementById("sistema").classList.add("Active");
	document.getElementById("sistema").classList.add("subdrop2");
	break;

	case "Config-Usuarios":
	document.getElementById("config").classList.add("Active");
	document.getElementById("config").classList.add("subdrop");
	document.getElementById("ulConfig").style.display = "block";

	document.getElementById("usuarios").classList.add("Active");
	document.getElementById("usuarios").classList.add("subdrop2");
	break;

}
</script>
