<?

$html = '

<table class="table table-striped" id="tb1" style="margin-top: 15px">
  <thead>
  <tr>
    <th class="id" scope="col">ID</th>
    <th scope="col">Tipo</th>
    <th scope="col">Categoria</th>
    <th scope="col">Descrição</th>
    <th scope="col">Pessoa</th>
    <th scope="col">Data Venc.</th>
    <th scope="col">Data Ref.</th>
    <th scope="col">Valor</th>
    <th scope="col">Tipo Doc.</th>
  </tr>
  </thead>
  <tbody>

  ';

  $total = 0;

    if ($monthFilter != "") {

      $select = "SELECT
                  contas_rec.id, contas_rec.tipo, contas_rec.categoria, contas_rec.dataVenc, contas_rec.dataRef, contas_rec.descricao, contas_rec.idUsuario, contas_rec.valor, contas_rec.nDoc, contas_rec.codTipoDoc, contas_rec.observacoes, contas_rec.data_hora_cadastro, contas_rec.baixa,
                  usuarios.nome as nomeUsuario,
                  categoria_contas_rec.nome as categoria
                 FROM contas_rec
                 LEFT JOIN usuarios ON contas_rec.idUsuario = usuarios.id
                 INNER JOIN categoria_contas_rec ON contas_rec.categoria = categoria_contas_rec.id
                 WHERE MONTH(contas_rec.dataRef) = MONTH('$monthFilter') AND YEAR(contas_rec.dataRef) = YEAR('$monthFilter')
                 ORDER BY contas_rec.id ASC";

                 $title = "Relatório de Entradas - ".$monthFilterName."/".$monthFilterYear;

    } else if ($dateFilter != "") {

      $select = "SELECT
                  contas_rec.id, contas_rec.tipo, contas_rec.categoria, contas_rec.dataVenc, contas_rec.dataRef, contas_rec.descricao, contas_rec.idUsuario, contas_rec.valor, contas_rec.nDoc, contas_rec.codTipoDoc, contas_rec.observacoes, contas_rec.data_hora_cadastro, contas_rec.baixa,
                  usuarios.nome as nomeUsuario,
                  categoria_contas_rec.nome as categoria
                 FROM contas_rec
                 LEFT JOIN usuarios ON contas_rec.idUsuario = usuarios.id
                 INNER JOIN categoria_contas_rec ON contas_rec.categoria = categoria_contas_rec.id
                 WHERE DAY(contas_rec.dataRef) = DAY('$dateFilter') AND MONTH(contas_rec.dataRef) = MONTH('$dateFilter') AND YEAR(contas_rec.dataRef) = YEAR('$dateFilter')
                 ORDER BY contas_rec.id ASC";

                 $dateFilterPT = date("d/m/Y", strtotime($dateFilter));

                 $title = "Relatório de Entradas - ".$dateFilterPT;
    } else {
      $select = "SELECT
                  contas_rec.id, contas_rec.tipo, contas_rec.categoria, contas_rec.dataVenc, contas_rec.dataRef, contas_rec.descricao, contas_rec.idUsuario, contas_rec.valor, contas_rec.nDoc, contas_rec.codTipoDoc, contas_rec.observacoes, contas_rec.data_hora_cadastro, contas_rec.baixa,
                  usuarios.nome as nomeUsuario,
                  categoria_contas_rec.nome as categoria
                 FROM contas_rec
                 LEFT JOIN usuarios ON contas_rec.idUsuario = usuarios.id
                 INNER JOIN categoria_contas_rec ON contas_rec.categoria = categoria_contas_rec.id
                 ORDER BY contas_rec.id ASC";

                 $title = "Relatório de Entradas - Todo o Período";
    }
  $result = $conexao -> prepare($select);
  $result -> execute();
  $count = $result->rowCount();

    if ($data = $result -> fetch()) {
      do {

        $idPag       = $data['id'];
        $tipo        = $data['tipo'];
        $categoria   = $data['categoria'];
        $descricao   = $data['descricao'];
        $dataVenc    = $data['dataVenc'];
        $dataRef     = $data['dataRef'];
        $pessoa      = $data['nomeUsuario'];
        $valor       = $data['valor'];
        $codTipoDoc  = $data['codTipoDoc'];
        $observacoes = $data['observacoes'];
        $baixa       = $data['baixa'];

        switch ($tipo) {
          case 1:
            $viewTipo = "Recebimentos";
            break;

          case 2:
            $viewTipo = "Despesa Fixa";
            break;

          case 3:
            $viewTipo = "Despesa Variável";
            break;

          case 4:
            $viewTipo = "Sangria";
            break;
        }

        $dataVenc = date("d/m/Y", strtotime($dataVenc));
        $dataRef  = date("d/m/Y", strtotime($dataRef));

        switch ($baixa) {
          case 0:
            $viewBaixa = "Não";
            break;

          case 1:
            $viewBaixa = "Sim";
            break;
        }

        if ($baixa == 1) {

          $valor = preg_replace('/[^0-9]+/','.',$valor);
          $total = $total + $valor;
          $valor = number_format($valor, 2, ',', '.');

        }

        switch ($codTipoDoc) {
          case 1:
            $viewTipoDoc = "Dinheiro";
            break;

          case 2:
            $viewTipoDoc = "Cartão Crédito";
            break;

          case 3:
            $viewTipoDoc = "Cartão Débito";
            break;

          case 4:
            $viewTipoDoc = "Débito em Conta";
            break;

          case 5:
            $viewTipoDoc = "Vale";
            break;

          case 6:
            $viewTipoDoc = "Bonificação";
            break;

          case 7:
            $viewTipoDoc = "Transferência Bancária (TED)";
            break;
        }

        $html.= "
          <tr>
            <td class='id'>$idPag</td>
            <td>$viewTipo</td>
            <td>$categoria</td>
            <td>$descricao</td>
            <td>$pessoa</td>
            <td>$dataVenc</td>
            <td>$dataRef</td>
            <td>$valor</td>
            <td>$viewTipoDoc</td>
          </tr>
        ";

      } while ($data = $result->fetch());
    }

    $total          = number_format($total, 2, ',', '.');

    $html.= "
      <tr>
        <td>Registros: $count</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>R$ $total</td>
        <td></td>
      </tr>
      ";

$html.= "
  </tbody>
</table>
";
