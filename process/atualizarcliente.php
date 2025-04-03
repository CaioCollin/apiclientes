<?php
// Inicia a sessão para exibir mensagens de sucesso/erro
session_start();

// Inclui o arquivo de conexão com o banco de dados
include('../includes/db.php');

// Verifica se os dados necessários foram enviados
if (!isset($_POST['id'], $_POST['nome'], $_POST['cpf'], $_POST['datanascimento'], $_POST['endereco'])) {
    $_SESSION['error'] = "Dados incompletos para atualização.";
    header('Location: ../public/listar.php'); // Redireciona de volta para a lista de clientes
    exit();
}

// Recupera os dados do formulário
$id = $_POST['id'];
$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$datanascimento = $_POST['datanascimento'];
$endereco = $_POST['endereco'];

// Atualiza os dados no banco de dados
$query = "UPDATE clientes SET nome = ?, cpf = ?, datanascimento = ?, endereco = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssssi", $nome, $cpf, $datanascimento, $endereco, $id);

if ($stmt->execute()) {
    $_SESSION['success'] = "Cliente atualizado com sucesso.";
} else {
    $_SESSION['error'] = "Erro ao atualizar o cliente.";
}

header('Location: ../public/listar.php'); // Redireciona para a página de listagem de clientes
exit();
