<?php
// Inicia a sessão para exibir mensagens de sucesso/erro
session_start();

// Inclui o arquivo de conexão com o banco de dados
include('../includes/db.php');

// Verifica se o ID do cliente foi passado pela URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = "ID do cliente não foi fornecido.";
    header('Location: listar.php');  // Redireciona para a lista de clientes
    exit();
}

$cliente_id = $_GET['id']; // Obtém o ID do cliente que foi passado na URL

// Consulta para obter os dados do cliente
$query = "SELECT * FROM clientes WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $cliente_id);
$stmt->execute();
$result = $stmt->get_result();

// Verifica se o cliente existe
if ($result->num_rows === 0) {
    $_SESSION['error'] = "Cliente não encontrado.";
    header('Location: listar.php');  // Redireciona para a lista de clientes
    exit();
}

$cliente = $result->fetch_assoc();  // Obtém os dados do cliente
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Cliente</title>
    <link rel="stylesheet" href="../assets/css/atualizarCliente.css">
</head>
<body>


    <!-- Exibe mensagens de erro ou sucesso -->
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

    <!-- Formulário para atualizar os dados do cliente -->
    <form action="../process/atualizarcliente.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $cliente['id']; ?>">

        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo $cliente['nome']; ?>" required><br><br>

        <label for="cpf">CPF:</label>
        <input type="text" id="cpf" name="cpf" pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" value="<?php echo $cliente['cpf']; ?>" required><br><br>

        <label for="datanascimento">Data de Nascimento:</label>
        <input type="date" id="datanascimento" name="datanascimento" value="<?php echo $cliente['datanascimento']; ?>" required><br><br>

        <label for="endereco">Endereço:</label>
        <input type="text" id="endereco" name="endereco" value="<?php echo $cliente['endereco']; ?>" required><br><br>

        <input type="submit" value="Atualizar Cliente">
        <a href="listar.php"><button type="button">Voltar à Lista de Clientes</button></a>
    </form>

    <br>
  

</body>
</html>
