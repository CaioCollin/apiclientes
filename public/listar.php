<?php
// Inicia a sessão para exibir mensagens de sucesso/erro
session_start();

// Inclui o arquivo de conexão com o banco de dados
include('../includes/db.php');

// Consulta para listar todos os clientes
$query = "SELECT * FROM clientes";
$result = mysqli_query($conn, $query);

// Verifica se há clientes cadastrados
if (mysqli_num_rows($result) > 0) {
    $clientes = mysqli_fetch_all($result, MYSQLI_ASSOC); // Armazena todos os clientes em um array
} else {
    $clientes = [];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Clientes</title>
    <link rel="stylesheet" href="../assets/css/listarClintes.css">
</head>
<body>

    <h1>Listar Clientes</h1>

    <!-- Exibe uma mensagem caso não haja clientes -->
    <?php
    if (isset($_SESSION['success'])) {
        echo "<p class='success'>" . $_SESSION['success'] . "</p>";
        unset($_SESSION['success']);
    }
    if (isset($_SESSION['error'])) {
        echo "<p class='error'>" . $_SESSION['error'] . "</p>";
        unset($_SESSION['error']);
    }
    ?>

    <div class="clientes-lista">
        <?php
        // Exibe uma mensagem caso não haja clientes
        if (empty($clientes)) {
            echo "<p>Não há clientes cadastrados.</p>";
        } else {
            echo "<table border='1'>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Data de Nascimento</th>
                        <th>Endereço</th>
                        <th>Ações</th>
                    </tr>";

            // Exibe os clientes cadastrados
            foreach ($clientes as $cliente) {
                echo "<tr>
                        <td>" . $cliente['id'] . "</td>
                        <td>" . $cliente['nome'] . "</td>
                        <td>" . $cliente['cpf'] . "</td>
                        <td>" . $cliente['datanascimento'] . "</td>
                        <td>" . $cliente['endereco'] . "</td>
                        <td>
                            <a href='atualizarcliente.php?id=" . $cliente['id'] . "'>Editar</a> |
                            <a href='cadastrocontato.php?id=" . $cliente['id'] . "'>cadastrar contato</a> |
                            <a href='../process/remover.php?id=" . $cliente['id'] . "'>Remover</a> |
                            <a href='../process/contatos.php?id=" . $cliente['id'] . "'>Ver Contatos</a>
                        </td>
                    </tr>";
            }
            echo "</table>";
        }
        ?>
    </div>

    <br>
    <a href="index.php"><button type="button">Voltar à Página Principal</button></a>

</body>
</html>
