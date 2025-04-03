<?php
// Inicia a sessão (para exibir mensagens de sucesso/erro)
session_start();

// Verifica se o cliente_id foi passado pela URL
if (!isset($_GET['cliente_id']) || empty($_GET['cliente_id'])) {
    $_SESSION['error'] = "ID do cliente não foi fornecido.";
    header('Location: cadastro.php');  // Redireciona para a página de cadastro de clientes
    exit();
}

$cliente_id = $_GET['cliente_id']; // Pega o ID do cliente que foi passado na URL
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Contato</title>
    <link rel="stylesheet" href="../assets/css/cadastroContato.css">  <!-- Estilos -->
</head>
<body>


    <!-- Exibindo mensagens de sucesso ou erro -->
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

    <!-- Formulário para cadastrar o contato -->
    <form action="../process/cadastrocontato.php" method="POST">
        <input type="hidden" name="cliente_id" value="<?php echo $cliente_id; ?>"> <!-- Passa o cliente_id de forma oculta -->

        <label for="tipo">Tipo de Contato:</label>
        <input type="text" id="tipo" name="tipo" required><br><br>

        <label for="valor">Valor do Contato:</label>
        <input type="text" id="valor" name="valor" required><br><br>

        <label for="observacao">Observação:</label>
        <input type="text" id="observacao" name="observacao"><br><br>

        <input type="submit" value="Cadastrar Contato">
        <a href="cadastro.php"><button type="button">Voltar ao Cadastro de Cliente</button></a>

    </form>

   
</body>
</html>
