<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Cliente</title>
    <link rel="stylesheet" href="../assets/css/cadastrostyles.css">  <!-- Estilos -->
</head>
<body>

    <form action="../process/cadastrocliente.php" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required><br><br>

        <label for="cpf">CPF:</label>
        <input type="text" id="cpf" name="cpf" pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" required title="CPF no formato XXX.XXX.XXX-XX"><br><br>
        
        <label for="datanascimento">Data de Nascimento:</label>
        <input type="date" id="datanascimento" name="datanascimento" required><br><br>

        <label for="endereco">Endereço:</label>
        <input type="text" id="endereco" name="endereco" required><br><br>

        <input type="submit" value="Cadastrar">
        <input type="button" id="voltar" value="Voltar" onclick="window.location.href='index.php';">

    </form>

</body>
</html>
