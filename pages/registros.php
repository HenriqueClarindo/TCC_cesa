<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/registros.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">

    <script defer src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script defer src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script defer src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
    <script defer src="js/script.js"></script>

    <style>
        /* Define o padding das células para reduzir o espaçamento vertical */
        #example td,
        #example th {
            padding: 3px 10px;
            /* Ajuste os valores conforme necessário */
        }
    </style>

    <title>Document</title>
</head>

<body>
    <div id="background-content">


        <header class="header">

            <img src="./img/icone_pr.png" alt="" class="icone">

            <ul id="nav-link">
                <p>registros</p>
            </ul>

            <a href="./Dados.php">
                <button id="btnDados">
                    <span class="text">Dados</span>
                </button>
            </a>
        </header>

        <div class="image-text-container">
            <img src="./img/registros_s.png" alt="" class="img">
            <p>registros</p>
        </div>

        <div class="sai-en">
            <div class="sel">
                <form method="GET" action="registros.php">
                    <label for="registroSelect">Registro de:</label>
                    <select name="registro" id="registroSelect" onchange="this.form.submit()">
                        <option value="Todos" <?php if (isset($_GET['registro']) && $_GET['registro'] === 'Todos') echo 'selected'; ?>>Todos</option>
                        <option value="saida_adiantada" <?php if (isset($_GET['registro']) && $_GET['registro'] === 'saida_adiantada') echo 'selected'; ?>>Saída adiantada</option>
                        <option value="entrada_atrasada" <?php if (isset($_GET['registro']) && $_GET['registro'] === 'entrada_atrasada') echo 'selected'; ?>>Entrada atrasada</option>
                    </select>
                </form>
            </div>
        </div>

        <div class="container" style="width:50%" style="height: 20%;">

            <div class="botao">
                <button id="adicionarAlunoBtn" class="addA, btnTabela">Adicionar registro</button>
                <button class="cadastrar, btnTabela" id="cadAluno">Cadastrar aluno</button>
            </div>

            <table id="example" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Nome</font></font></th>
                        <th><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Nome Responsavel</font></font></th>
                        <th><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Serie</font></font></th>
                        <th><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Data</font></font></th>
                        <th><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Hora</font></font></th>
                        <th><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Morivo</font></font></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Inclua o arquivo de conexão com o banco de dados
                    require_once '../backend/conexao.php'; // ajuste o caminho para o arquivo de conexão

                    // Consulta para buscar registros com JOIN nas tabelas alunos, responsaveis e registros
                    $sql = "
                SELECT 
                    alunos.nome AS aluno_nome, 
                    alunos.turma AS turma, 
                    responsaveis.nome AS responsavel_nome, 
                    registros.data, 
                    registros.hora, 
                    registros.motivo 
                FROM registros
                JOIN alunos ON registros.id_aluno = alunos.id_aluno
                LEFT JOIN aluno_responsavel ON aluno_responsavel.id_aluno = alunos.id_aluno
                LEFT JOIN responsaveis ON aluno_responsavel.id_responsavel = responsaveis.id_responsavel
            ";

                    $result = $mysqli->query($sql);

                    while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <font style="vertical-align: inherit;"><?php echo $row['aluno_nome']; ?></font>
                            </td>
                            <td>
                                <font style="vertical-align: inherit;"><?php echo $row['responsavel_nome']; ?></font>
                            </td>
                            <td>
                                <font style="vertical-align: inherit;"><?php echo $row['turma']; ?></font>
                            </td>
                            <td>
                                <font style="vertical-align: inherit;"><?php echo $row['data']; ?></font>
                            </td>
                            <td>
                                <font style="vertical-align: inherit;"><?php echo $row['hora']; ?></font>
                            </td>
                            <td>
                                <font style="vertical-align: inherit;"><?php echo $row['motivo']; ?></font>
                            </td>
                        </tr>
                    <?php endwhile; ?>

                </tbody>
                <tfoot>
                    <tr>
                        <th>Nome</th>
                        <th>Nome Responsavel</th>
                        <th>Serie</th>
                        <th>Data</th>
                        <th>Hora</th>
                        <th>Motivo</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div id="adicionarAlunoMenu" class="menu-adicionar-aluno">
        <form action="../backend/adicionar.php" method="POST" id="adicionarAlunoForm">
            <h1 class="txt">Adicionar aluno</h1>
            <br>
            <div style="position: relative; width: 100%;">
                <label for="nomeAluno">Nome do Aluno:</label>
                <input type="text" id="nomeAluno" name="nomeAluno" oninput="buscarAluno()" placeholder="Digite o nome do aluno" autocomplete="off">
                <ul id="resultadoBusca"></ul>
            </div>

            <div class="menu-actions">
                <select name="serie" id="serie" required>
                    <option value="" selected disabled>Série</option>
                    <option value="3DS-A">3DS-A</option>
                    <option value="2DS-A">2DS-A</option>
                    <option value="1DS-A">1DS-A</option>
                </select>

                <select name="motivo" id="motivo" required>
                    <option value="" selected disabled>Selecione um motivo</option>
                    <option value="onibus">Ônibus</option>
                    <option value="medico">Médico</option>
                </select>
            </div>
            <select name="tipo" id="tipo" required>
                <option value="" selected disabled>Registro de:</option>
                <option value="entrada_atrasada">Entrada atrasada</option>
                <option value="saida_adiantada">Saída adiantada</option>
            </select>
            <br>
            <br>
            <div class="menu-actions">
                <button type="button" class="btn" id="cancelar">Cancelar</button>
                <button type="submit" class="btn" id="salvar">Salvar</button>
            </div>
        </form>
    </div>

    <div id="overlay"></div>


    <!--cadastro aluno-->

    <div id="cadastrarAlunoMenu" class="menu-cadastrar-aluno">
        <form action="../backend/cadastrar.php" method="POST" id="cadastrarAlunoForm">
            <h1 class="txt">Adicionar aluno</h1>
            <br>
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="data_nascimento">Data de Nascimento:</label>
            <input type="date" id="data_nascimento" name="data_nascimento" required>

            <div class="menu-actions">
                <input type="number" id="rm" class="rm" placeholder="RM:" name="rm" required>
                <select name="serie" required>
                    <option value="" selected disabled>Série</option>
                    <option value="3DS-A">3DS-A</option>
                    <option value="2DS-A">2DS-A</option>
                    <option value="1DS-A">1DS-A</option>
                </select>
            </div>
            <br>

            <label for="nome_res">Nome do Responsável:</label>
            <input type="text" id="nome_res" name="nome_res[]" required>
            <br><br>
            <div class="menu-actions">
                <input type="text" name="cpf[]" id="cpf" placeholder="CPF:" required>
                <input type="tel" name="telefone[]" id="telefone" placeholder="Telefone:" required>
            </div>

            <input type="email" name="email" id="email" class="email">

            <div class="menu-actions">
                <button type="button" class="btn" id="cancelar_c">Cancelar</button>
                <button type="submit" class="btn" id="salvar">Salvar</button>
            </div>
        </form>
    </div>

    <div id="fecha"></div>

</body>
<script src="./js/addAluno.js"></script>
<script src="./js/filtro_registros.js"></script>
<script src="./js/buscarAluno.js"></script>

</html>