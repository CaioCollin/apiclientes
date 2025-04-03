<?php
session_start();
include('../includes/db.php');

// Verifica se o ID do contato foi passado pela URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = "ID do contato não foi fornecido.";
    header('Location: contatos.php');  // Redireciona de volta para a lista de contatos
    exit();
}

$contato_id = $_GET['id']; // Obtém o ID do contato que foi passado na URL
$cliente_id = $_GET['cliente_id']; // Obtém o ID do cliente

// Consulta para obter os dados do contato
$query_contato = "SELECT * FROM contatos WHERE id = ? AND cliente_id = ?";
$stmt_contato = $conn->prepare($query_contato);
$stmt_contato->bind_param("ii", $contato_id, $cliente_id);
$stmt_contato->execute();
$result_contato = $stmt_contato->get_result();

// Verifica se o contato existe
if ($result_contato->num_rows === 0) {
    $_SESSION['error'] = "Contato não encontrado.";
    header('Location: contatos.php');  // Redireciona de volta para a lista de contatos
    exit();
}

// Armazena os dados do contato
$contato = $result_contato->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Contato</title>
    <link rel="stylesheet" href="../assets/css/editarcontato.css">
</head>
<body>

    <h1>Editar Contato de <?php echo $contato['tipo']; ?></h1>

    <!-- Exibe mensagens de sucesso ou erro -->
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

    <!-- Formulário de edição -->
    <form action="../public/atualizarcontato.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $contato['id']; ?>">
        <input type="hidden" name="cliente_id" value="<?php echo $contato['cliente_id']; ?>">

        <label for="tipo">Tipo:</label>
        <input type="text" name="tipo" value="<?php echo $contato['tipo']; ?>" required><br>

        <label for="valor">Valor:</label>
        <input type="text" name="valor" value="<?php echo $contato['valor']; ?>" required><br>

        <label for="observacao">Observação:</label>
        <input type="text" name="observacao" value="<?php echo $contato['observacao']; ?>"><br>

        <button type="submit">Salvar</button>
        <a href="contatos.php?id=<?php echo $cliente_id; ?>"><button type="button">Voltar</button></a>
    </form>

    <br>
    

</body>
</html>
