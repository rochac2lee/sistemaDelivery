<?

try {
	$conexaoDelivery = new PDO('mysql:host=opmy0018.servidorwebfacil.com:3306;dbname=rochac2lee_sistemaDelivery', 'rocha_delivery', 'qwerty@848625');
	$conexaoDelivery -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
	echo 'Houve um Erro na conexao com o banco de dados: ' . $e -> getMessage();
}

?>
