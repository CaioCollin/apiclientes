<?php
// Inicia a sessão para exibir mensagens de sucesso/erro
session_start();

// Inclui o arquivo de conexão com o banco de dados
include('../includes/db.php');
include('../includes/functions.php');

// Verifica se os dados foram enviados pelo formulário (via método POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coleta e limpa os dados do formulário
    $nome = limpar_dados($_POST['nome']);
    $cpf = limpar_dados($_POST['cpf']);
    $datanascimento = $_POST['datanascimento'];
    $endereco = limpar_dados($_POST['endereco']);

    // Inserir o novo cliente na tabela clientes
    $sql_insert_cliente = "INSERT INTO clientes (nome, cpf, datanascimento, endereco) 
                           VALUES ('$nome', '$cpf', '$datanascimento', '$endereco')";

    if ($conn->query($sql_insert_cliente) === TRUE) {
        // Se o cliente foi inserido com sucesso, pega o ID do cliente
        $cliente_id = $conn->insert_id;

        // Mensagem de sucesso
        $_SESSION['success'] = "Cliente cadastrado com sucesso!";

        // Redireciona para a página de cadastro de contato para esse cliente
        header('Location: ../public/cadastrocontato.php?cliente_id=' . $cliente_id);
        exit();
    } else {
        // Se houve erro ao cadastrar o cliente, exibe mensagem de erro
        $_SESSION['error'] = "Erro ao cadastrar cliente: " . $conn->error;
    }
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
