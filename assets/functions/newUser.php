<?php

include("../includes/conexao.php");

$mome      = $_POST['nomeCompleto'];
$idEmpresa = $_POST['empresa'];
$celular   = $_POST['celular'];
$senha     = $_POST['senha'];
$senha     = base64_encode($senha);
$status    = $_POST['statusUser'];
$permissao = $_POST['permissoes'];

date_default_timezone_set('America/Brasilia');
$dateTime      = date('d/m/Y H:i:s');
$date          = date('Y-m-d H:i:s');

//INFO IMAGEM
$file 		= $_FILES['avatarImagem'];
$numFile	= count(array_filter($file['name']));

//PASTA
$folder		= '../uploads/usuarios/';

//REQUISITOS
$permite 	= array('image/jpeg', 'image/png');
$maxSize	= 1024 * 1024 * 2;

$conexao->beginTransaction();

//MENSAGENS
$msg		= array();
$errorMsg	= array(
  1 => 'O arquivo no upload é maior do que o limite definido em upload_max_filesize no php.ini.',
  2 => 'O arquivo ultrapassa o limite de tamanho em MAX_FILE_SIZE que foi especificado no formulário HTML',
  3 => 'o upload do arquivo foi feito parcialmente',
  4 => 'Nao foi feito o upload do arquivo'
);

if($numFile <= 0) {

  $imagem = 'admin.png';

  $conexao->exec("INSERT INTO usuarios (id, idEmpresa, nome, avatar, celular, senha, tipo, status, data_hora_cadastro)
                              VALUES ('', '$idEmpresa', '$mome', '$imagem', '$celular', '$senha', '$permissao', '$status', '$dateTime')" );

} else {
  for($i = 0; $i < $numFile; $i++) {
    $name  = $file['name'][$i];
    $type	 = $file['type'][$i];
    $size	 = $file['size'][$i];
    $error = $file['error'][$i];
    $tmp	 = $file['tmp_name'][$i];

    $imagem = $name;

    if($error != 0)
      $msg[] = "<b>$name :</b> ".$errorMsg[$error];
    else if(!in_array($type, $permite))
      $msg[] = "<b>$name :</b> Erro imagem nao suportada!";
    else if($size > $maxSize)
      $msg[] = "<b>$name :</b> Erro imagem ultrapassa o limite de 5MB";
    else {

      if (move_uploaded_file($tmp, $folder.'/'.$imagem)){

        $conexao->exec("INSERT INTO usuarios (id, idEmpresa, nome, avatar, celular, senha, tipo, status, data_hora_cadastro)
    																VALUES ('', '$idEmpresa', '$mome', '$imagem', '$celular', '$senha', '$permissao', '$status', '$dateTime')" );

      }
    }
  }
}

echo "<script>window.location='../../ui-users.php';</script>";

$conexao->commit();

?>
