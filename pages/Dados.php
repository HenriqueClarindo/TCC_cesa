<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/All.css">
  <link rel="stylesheet" href="./css/dados.css">
  <title>Dados</title>
</head>

<body>

  <header class="header">

    <img src="./img/icone_pr.png" alt="" class="icone">

    <ul class="nav-link">
      <p>Dados</p>
    </ul>

    <a href="./registros.php">
      <button id="btnDados">
        <span class="text">Registros</span>
      </button>
    </a>
  </header>

  <div class="container">
    <div class="blocoRes">
      <div class="registro">

        <div class="group">
          <svg class="icon" aria-hidden="true" viewBox="0 0 24 24">
            <g>
              <path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path>
            </g>
          </svg>
          <input placeholder="Search" type="search" class="search">
          <button id="filtro">filtro</button>
        </div>

        <div class="tabela">
          <table class="table">
            <thead>
              <tr>
                <th class="nome">NOME</th>
                <th class="nome_res">NOME RESPONSÁVEL</th>
                <th class="serie">Serie</th>
                <th class="data">DATA</th>
                <th class="hora">HORA</th>
                <th class="motivo">MOTIVO</th>
              </tr>
            </thead>
            <tbody>
              <?php

              include('../backend/conexao.php');

              $registro = isset($_GET['registro']) ? $_GET['registro'] : 'Todos';

              if ($registro === 'Todos') {
                $sql = "SELECT registros.*, 
                                  Alunos.nome AS nome_aluno, 
                                  Alunos.turma AS serie, 
                                  Responsaveis.nome AS nome_responsavel
                              FROM registros
                              JOIN Alunos ON registros.id_aluno = Alunos.id_aluno
                              LEFT JOIN Aluno_Responsavel ON Alunos.id_aluno = Aluno_Responsavel.id_aluno
                              LEFT JOIN Responsaveis ON Aluno_Responsavel.id_responsavel = Responsaveis.id_responsavel
                              ORDER BY registros.data DESC, registros.hora DESC";
                $stmt = $mysqli->prepare($sql);
              } else {
                $sql = "SELECT registros.*, 
                                  Alunos.nome AS nome_aluno, 
                                  Alunos.turma AS serie, 
                                  Responsaveis.nome AS nome_responsavel
                              FROM registros
                              JOIN Alunos ON registros.id_aluno = Alunos.id_aluno
                              LEFT JOIN Aluno_Responsavel ON Alunos.id_aluno = Aluno_Responsavel.id_aluno
                              LEFT JOIN Responsaveis ON Aluno_Responsavel.id_responsavel = Responsaveis.id_responsavel
                              WHERE (registros.entrada_atrasada = ? OR registros.saida_adiantada = ?)
                              ORDER BY registros.data DESC, registros.hora DESC";

                $tipo_valor = ($registro === 'Entrada atrasada') ? 1 : 0;
                $stmt = $mysqli->prepare($sql);
                $stmt->bind_param('ii', $tipo_valor, $tipo_valor);
              }

              $stmt->execute();
              $result = $stmt->get_result();

              if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  // Verificar se os campos estão definidos e não nulos
                  $nome_aluno = isset($row["nome_aluno"]) ? htmlspecialchars($row["nome_aluno"], ENT_QUOTES, 'UTF-8') : 'Indefinido';
                  $nome_responsavel = isset($row["nome_responsavel"]) ? htmlspecialchars($row["nome_responsavel"], ENT_QUOTES, 'UTF-8') : 'Indefinido';
                  $serie = isset($row["serie"]) ? htmlspecialchars($row["serie"], ENT_QUOTES, 'UTF-8') : 'Indefinido';
                  $data = isset($row["data"]) ? htmlspecialchars($row["data"], ENT_QUOTES, 'UTF-8') : 'Indefinido';
                  $hora = isset($row["hora"]) ? htmlspecialchars($row["hora"], ENT_QUOTES, 'UTF-8') : 'Indefinido';
                  $motivo = isset($row["motivo"]) ? htmlspecialchars($row["motivo"], ENT_QUOTES, 'UTF-8') : 'Indefinido';

                  $tipo = $row["entrada_atrasada"] ? "Entrada atrasada" : ($row["saida_adiantada"] ? "Saída adiantada" : "Normal");

                  echo "<tr data-tipo='" . htmlspecialchars($tipo, ENT_QUOTES, 'UTF-8') . "'>";
                  echo "<td class='nome'>" . $nome_aluno . "</td>";
                  echo "<td class='nome_res'>" . $nome_responsavel . "</td>";
                  echo "<td class='serie'>" . $serie . "</td>";
                  echo "<td class='data'>" . $data . "</td>";
                  echo "<td class='hora'>" . $hora . "</td>";
                  echo "<td class='motivo'>" . $motivo . "</td>";
                  echo "</tr>";
                }
              } else {
                echo "<tr><td colspan='6'>Nenhum registro encontrado.</td></tr>";
              }

              $stmt->close();
              $mysqli->close();
              ?>
            </tbody>
          </table>
        </div>

      </div>
    </div>

    <div class="pizza">

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
  Launch static backdrop modal
</button>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Understood</button>
      </div>
    </div>
  </div>
</div>
      <canvas id="myChart"></canvas>
    </div>
  </div>

  <form action="../backend/gerar_planilha.php" method="post"><button id="btn">Gerar Excel</button></form>


  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const ctx = document.getElementById('myChart');

    new Chart(ctx, {
      type: 'pie',
      data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
          label: '# of Votes',
          data: [12, 19, 3, 5, 2, 3],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>