<?

$landscape = "A4";

$html = '

<table class="table table-striped" id="tb1" style="margin-top: 15px">
  <thead>
  <tr>
    <th scope="col">ID</th>
    <th scope="col">Tipo</th>
    <th scope="col">Categoria</th>
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
                 contas_san.id, contas_san.tipo, contas_san.categoria, contas_san.dataVenc, contas_san.dataRef, contas_san.descricao, contas_san.idUsuario, contas_san.valor, contas_san.nDoc, contas_san.codTipoDoc, contas_san.observacoes, contas_san.data_hora_cadastro, contas_san.baixa,
                 usuarios.id as idUsuario, usuarios.nome as nomeUsuario,
                 categoria_contas_pag.nome as categoria
                FROM contas_san
                LEFT JOIN usuarios ON contas_san.idUsuario = usuarios.id
                LEFT JOIN categoria_contas_pag ON contas_san.categoria = categoria_contas_pag.id
                WHERE MONTH(contas_san.dataRef) = MONTH('$dateFilter') AND YEAR(contas_san.dataRef) = YEAR('$dateFilter')
                ORDER BY contas_san.id ASC";

                 $title = "Relatório de Saídas/Sangria - ".$monthFilterName."/".$monthFilterYear;

    } else if ($dateFilter != "") {

      $select = "SELECT
                 contas_san.id, contas_san.tipo, contas_san.categoria, contas_san.dataVenc, contas_san.dataRef, contas_san.descricao, contas_san.idUsuario, contas_san.valor, contas_san.nDoc, contas_san.codTipoDoc, contas_san.observacoes, contas_san.data_hora_cadastro, contas_san.baixa,
                 usuarios.id as idUsuario, usuarios.nome as nomeUsuario,
                 categoria_contas_pag.nome as categoria
                FROM contas_san
                LEFT JOIN usuarios ON contas_san.idUsuario = usuarios.id
                LEFT JOIN categoria_contas_pag ON contas_san.categoria = categoria_contas_pag.id
                WHERE DAY(contas_san.dataRef) = DAY('$dateFilter') AND MONTH(contas_san.dataRef) = MONTH('$dateFilter') AND YEAR(contas_san.dataRef) = YEAR('$dateFilter')
                ORDER BY contas_san.id ASC";


                 $dateFilterPT = date("d/m/Y", strtotime($dateFilter));

                 $title = "Relatório de Saídas/Sangria - ".$dateFilterPT;
    } else {
      $select = "SELECT
                  contas_san.id, contas_san.tipo, contas_san.categoria, contas_san.dataVenc, contas_san.dataRef, contas_san.descricao, contas_san.idUsuario, contas_san.valor, contas_san.nDoc, contas_san.codTipoDoc, contas_san.observacoes, contas_san.data_hora_cadastro, contas_san.baixa,
                  usuarios.id as idUsuario, usuarios.nome as nomeUsuario,
                  categoria_contas_pag.nome as categoria
                 FROM contas_san
                 LEFT JOIN usuarios ON contas_san.idUsuario = usuarios.id
                 LEFT JOIN categoria_contas_pag ON contas_san.categoria = categoria_contas_pag.id
                 ORDER BY contas_san.id ASC";

                 $title = "Relatório de Saídas/Sangria - Todo o Período";
    }
  $result = $conexao -> prepare($select);
  $result -> execute();
  $count = $result->rowCount();

    if ($data = $result -> fetch()) {
      do {

        $idPag       = $data['id'];
        $tipo        = $data['tipo'];
        $categoria   = $data['categoria'];
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

            $valor = preg_replace('/[^0-9]+/','.',$valor);
            $total += $valor;
            $valor = number_format($valor, 2, ',', '.');

            break;
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
            <td>$idPag</td>
            <td>$viewTipo</td>
            <td>$categoria</td>
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
