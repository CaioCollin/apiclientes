<?php
// Inicia a sessão para exibir mensagens de sucesso/erro
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal</title>
    <link rel="stylesheet" href="../assets/css/styles.css"> <!-- Link para o CSS -->
</head>
<body>

    <h1>APP Cadastro Cliente </h1>
    <br> <p>https://github.com/CaioCollin</p>

    <div class="menu">
        <h2>Gerenciamento de Clientes</h2>
        
        <!-- Links para as funcionalidades -->
        <ul>
            <li><a href="cadastro.php">Cadastrar Cliente</a></li>
            <li><a href="listar.php">Listar Clientes</a></li>
            <li><a href="buscacliente.php">Procurar Cliente pela Nome</a></li>
        </ul>
    </div>

</body>
</html>
