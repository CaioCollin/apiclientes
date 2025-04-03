<?php
// Iniciar a sessão para mensagens de sucesso/erro
session_start();

// Incluir o arquivo de conexão com o banco de dados e a função para listar clientes
include('../includes/db.php');

// Função para listar clientes pelo nome
function listarClientesPorNome($nome) {
    global $conn;  // Usar a variável de conexão do banco de dados

    // Evitar SQL Injection
    $nome = mysqli_real_escape_string($conn, $nome);

    // Consulta para buscar clientes pelo nome
    $query = "SELECT * FROM clientes WHERE nome LIKE '%$nome%'";
    $result = mysqli_query($conn, $query);

    // Verificar se há resultados
    if (mysqli_num_rows($result) > 0) {
        // Exibir os clientes encontrados
        echo "<table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Data de Nascimento</th>
                    <th>Endereço</th>
                    <th>Ações</th>
                </tr>";

        while ($cliente = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>" . $cliente['id'] . "</td>
                    <td>" . $cliente['nome'] . "</td>
                    <td>" . $cliente['cpf'] . "</td>
                    <td>" . $cliente['datanascimento'] . "</td>
                    <td>" . $cliente['endereco'] . "</td>
                    <td>
                        <a href='atualizarcliente.php?id=" . $cliente['id'] . "'>Editar</a> |
                        <a href='../process/remover.php?id=" . $cliente['id'] . "'>Remover</a> |
                        <a href='../process/contatos.php?id=" . $cliente['id'] . "'>Ver Contatos</a>
                    </td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Não há clientes encontrados com o nome '$nome'.</p>";
    }
}

// Verificar se o formulário foi enviado
if (isset($_POST['nome'])) {
    $nome = $_POST['nome'];

    // Chamar a função para listar os clientes com base no nome fornecido
    listarClientesPorNome($nome);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Cliente</title>
    <link rel="stylesheet" href="../assets/css/buscarCliente.css">
</head>
<body>

    <br><h1>Buscar Cliente</h1>

    <!-- Formulário de busca -->
    <form method="POST" action="buscacliente.php">
        <label for="nome">Nome do Cliente:</label>
        <input type="text" name="nome" id="nome" required>
        <button type="submit">Buscar</button>
    </form>

    <br>
    <a href="index.php"><button type="button">Voltar à Página Principal</button></a>

</body>
</html>
