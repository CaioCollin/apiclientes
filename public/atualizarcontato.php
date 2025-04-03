<?php
session_start();
include('../includes/db.php');

// Verifica se os dados foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtém os dados do formulário
    $id = $_POST['id'];
    $cliente_id = $_POST['cliente_id'];
    $tipo = $_POST['tipo'];
    $valor = $_POST['valor'];
    $observacao = $_POST['observacao'];

    // Prepara a consulta SQL para atualizar o contato
    $query = "UPDATE contatos SET tipo = ?, valor = ?, observacao = ? WHERE id = ? AND cliente_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssii", $tipo, $valor, $observacao, $id, $cliente_id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Contato atualizado com sucesso!";
    } else {
        $_SESSION['error'] = "Erro ao atualizar o contato.";
    }

    // Fecha a conexão
    $stmt->close();
    $conn->close();

    // Redireciona de volta para a lista de contatos
    header("Location: ../process/contatos.php?id=$cliente_id");
    exit();
}
