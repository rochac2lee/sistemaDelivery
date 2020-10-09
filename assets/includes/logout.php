<?php
	if(isset($_REQUEST['sair'])){
		session_destroy();
		session_unset($_SESSION['usuario_manager_LP']);
		session_unset($_SESSION['senha_manager_LP']);
		header("Location: login");
	}
?>
