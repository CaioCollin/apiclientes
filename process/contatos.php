<?php
// Inicia a sessão para exibir mensagens de sucesso/erro
session_start();

// Inclui o arquivo de conexão com o banco de dados
include('../includes/db.php');

// Verifica se o ID do cliente foi passado pela URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = "ID do cliente não foi fornecido.";
    header('Location: ../public/listar.php');  // Redireciona para a lista de clientes
    exit();
}

$cliente_id = $_GET['id']; // Obtém o ID do cliente que foi passado na URL

// Consulta para obter os dados do cliente
$query_cliente = "SELECT * FROM clientes WHERE id = ?";
$stmt_cliente = $conn->prepare($query_cliente);
$stmt_cliente->bind_param("i", $cliente_id);
$stmt_cliente->execute();
$result_cliente = $stmt_cliente->get_result();

// Verifica se o cliente existe
if ($result_cliente->num_rows === 0) {
    $_SESSION['error'] = "Cliente não encontrado.";
    header('Location: ../public/listar.php');  // Redireciona para a lista de clientes
    exit();
}

// Consulta para listar os contatos do cliente
$query_contatos = "SELECT * FROM contatos WHERE cliente_id = ?";
$stmt_contatos = $conn->prepare($query_contatos);
$stmt_contatos->bind_param("i", $cliente_id);
$stmt_contatos->execute();
$result_contatos = $stmt_contatos->get_result();

// Armazena os dados do cliente
$cliente = $result_cliente->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contatos do Cliente</title>
    <link rel="stylesheet" href="../assets/css/contatos.css">
</head>
<body>

    <h1>Contatos de <?php echo $cliente['nome']; ?></h1>

    <!-- Exibe uma mensagem caso não haja contatos -->
    <?php
    if ($result_contatos->num_rows === 0) {
        echo "<p>Este cliente não possui contatos cadastrados.</p>";
    } else {
        echo "<table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Tipo</th>
                    <th>Valor</th>
                    <th>Observação</th>
                    <th>Ações</th>
                </tr>";

        // Exibe os contatos do cliente
        while ($contato = $result_contatos->fetch_assoc()) {
            echo "<tr>
                    <td>" . $contato['id'] . "</td>
                    <td>" . $contato['tipo'] . "</td>
                    <td>" . $contato['valor'] . "</td>
                    <td>" . $contato['observacao'] . "</td>
                    <td>
                        <a href='editarcontato.php?id=" . $contato['id'] . "&cliente_id=" . $cliente['id'] . "'>
                            <button type='button'>Editar</button>
                        </a>
                  
                    <td>
                        <!-- Formulário para remover o contato -->
                         <form action='removercontato.php' method='POST' style='display:inline;' onsubmit='return confirm(\"Tem certeza que deseja excluir este contato?\");'>
                            <input type='hidden' name='id' value='" . $contato['id'] . "'>
                            <input type='hidden' name='cliente_id' value='" . $cliente['id'] . "'>
                            <button type='submit' class='delete-button'>Remover</button>
                        </form>
                    </td>
                </tr>";
        }

        echo "</table>";
    }
    ?>

    <br>
    <a href="../public/listar.php"><button type="button">Voltar para a lista de clientes</button></a>
   

</body>
</html>
