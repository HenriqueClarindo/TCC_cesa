<?php
include('conexao.php');

// Inicializando a condição de filtro
$filtro = '';

// Verificar se há uma seleção no campo "registro"
if (isset($_GET['registro']) && $_GET['registro'] !== 'Todos') {
    $registro = $_GET['registro'];

    // Aplicar o filtro com base no valor selecionado
    if ($registro === 'Saida adiantada') {
        $filtro = "WHERE tipo = 'saida_adiantada'";
    } elseif ($registro === 'Entrada atrasada') {
        $filtro = "WHERE tipo = 'entrada_atrasada'";
    }
}

// Query para buscar os registros filtrados
$sql = "SELECT * FROM registros $filtro ORDER BY data DESC, hora DESC";
$resultado = $mysqli->query($sql);

// Verificar se existem resultados
if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        // Exiba os dados dos registros conforme necessário
        echo "ID: " . $row['id'] . "<br>";
        echo "Aluno: " . $row['id_aluno'] . "<br>";
        echo "Data: " . $row['data'] . "<br>";
        echo "Hora: " . $row['hora'] . "<br>";
        echo "Motivo: " . $row['motivo'] . "<br>";
        echo "Tipo: " . $row['tipo'] . "<br>";
        echo "<hr>";
    }
} else {
    echo "Nenhum registro encontrado.";
}
?>
