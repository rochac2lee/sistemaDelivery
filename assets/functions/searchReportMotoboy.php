<?

$landscape = "A4-L";

$motoSearch = $_GET['idMotoboy'];

$html = '

<table class="table table-striped" id="tb1" style="margin-top: 15px">
  <thead>
  <tr>
    <th scope="col">Pedido n° </th>
    <th scope="col">Motoboy</th>
    <th scope="col">Taxa</th>
  </tr>
  </thead>
  <tbody>

  ';

  $total = 0;

  if ($dateFilter != "" && $motoSearch != "") {
    $select = "SELECT
                pedidos.id, pedidos.idMotoboy, pedidos.data_hora_cadastro,
                usuarios.nome
               FROM pedidos
               LEFT JOIN usuarios ON pedidos.idMotoboy = usuarios.id
               LEFT JOIN caixa ON pedidos.idCaixa = caixa.id
               WHERE pedidos.idMotoboy = '$motoSearch' AND DAY(caixa.dataHoraAbertura) = DAY('$dateFilter') AND MONTH(caixa.dataHoraAbertura) = MONTH('$dateFilter') AND YEAR(caixa.dataHoraAbertura) = YEAR('$dateFilter')
               ORDER BY pedidos.id DESC";

     $dateFilterPT = date("d/m/Y", strtotime($dateFilter));
     $title = "Relatório de Entregas - ".$dateFilterPT;

  } else if ($dateFilter != "") {
    $select = "SELECT
                pedidos.id, pedidos.idMotoboy, pedidos.data_hora_cadastro,
                usuarios.nome
               FROM pedidos
               LEFT JOIN usuarios ON pedidos.idMotoboy = usuarios.id
               LEFT JOIN caixa ON pedidos.idCaixa = caixa.id
               WHERE DAY(caixa.dataHoraAbertura) = DAY('$dateFilter') AND MONTH(caixa.dataHoraAbertura) = MONTH('$dateFilter') AND YEAR(caixa.dataHoraAbertura) = YEAR('$dateFilter')
               ORDER BY pedidos.id DESC";

     $dateFilterPT = date("d/m/Y", strtotime($dateFilter));
     $title = "Relatório de Entregas - ".$dateFilterPT;

  } else if ($motoSearch != "") {
    $select = "SELECT
                pedidos.id, pedidos.idMotoboy, pedidos.data_hora_cadastro,
                usuarios.nome
                FROM pedidos
               LEFT JOIN usuarios ON pedidos.idMotoboy = usuarios.id
               LEFT JOIN caixa ON pedidos.idCaixa = caixa.id
               WHERE pedidos.idMotoboy = '$motoSearch'
               ORDER BY pedidos.id DESC";

   $title = "Relatório de Entregas";

  } else {
    $select = "SELECT
                pedidos.id, pedidos.idMotoboy, pedidos.data_hora_cadastro,
                usuarios.nome
               FROM pedidos
               LEFT JOIN usuarios ON pedidos.idMotoboy = usuarios.id
               LEFT JOIN caixa ON pedidos.idCaixa = caixa.id
               WHERE pedidos.idMotoboy != '' and MONTH(caixa.dataHoraAbertura) = MONTH('$date') ORDER BY pedidos.id DESC";

    $title = "Relatório de Entregas - ".$monthname."/".$year;

  }
  $result = $conexao -> prepare($select);
  $result -> execute();
  $count = $result->rowCount();

    if ($data = $result -> fetch()) {
      do {

        $viewIdPedido   = $data['id'];
        $viewIdMotoboy  = $data['idMotoboy'];
        $nome           = $data['nome'];
        $taxaMotoboy    = $data['taxaMotoboy'];

        $idPedido       = $data['id'];

        $selectProduto = "SELECT
                          produtos.id, produtos.nome, produtos.descricao, produtos.foto, produtos.preco,
                          pedido_itens.quantidade, pedido_itens.observacao
                          FROM produtos
                          INNER JOIN pedido_itens ON produtos.id = pedido_itens.idProduto
                          WHERE pedido_itens.idPedido = '$viewIdPedido' and produtos.categoria = 999
                          ORDER BY produtos.id ASC";
        $resultProduto = $conexao -> prepare($selectProduto);
        $resultProduto -> execute();
        $countProduto = $resultProduto->rowCount();

          if ($dataProduto = $resultProduto -> fetch()) {
            do {

              $preco       = $dataProduto['preco'];

              $preco = preg_replace('/[^0-9]+/','.',$preco);
              $total = preg_replace('/[^0-9]+/','.',$total);

              $total += $preco;

              $preco = number_format($preco, 2, ',', '.');
              $total = number_format($total, 2, ',', '.');

            $html.= "
              <tr>
                <td $style>$idPedido</td>
                <td $style>$nome</td>
                <td $style>$preco</td>
              </tr>
            ";

            } while ($dataProduto = $resultProduto->fetch());
          }

      } while ($data = $result->fetch());
    }

    $selectTaxa = "SELECT taxaMotoboy
                      FROM usuarios
                      WHERE usuarios.id = '$motoSearch'";
    $resultTaxa = $conexao -> prepare($selectTaxa);
    $resultTaxa -> execute();
    $countTaxa = $resultTaxa->rowCount();

    if ($dataTaxa = $resultTaxa -> fetch()) {
      do {

        $taxaMotoboy = $dataTaxa['taxaMotoboy'];
        $taxaMotoboy = preg_replace('/[^0-9]+/','.',$taxaMotoboy);
        $total = preg_replace('/[^0-9]+/','.',$total);

        $total += $taxaMotoboy;

        $taxaMotoboy  = number_format($taxaMotoboy, 2, ',', '.');

        $html.= "
          <tr>
            <td></td>
            <td>$nome</td>
            <td>$taxaMotoboy</td>
          </tr>
        ";

      } while ($dataTaxa = $resultTaxa->fetch());
    }

    $total        = number_format($total, 2, ',', '.');

    $html.= "
      <tr>
        <td></td>
        <td></td>
        <td>$total</td>
      </tr>
      ";


$html.= "
  </tbody>
</table>
";
