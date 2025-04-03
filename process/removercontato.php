<?php
// Conectar ao banco de dados
include('../includes/db.php');

// Inicializar uma variável de mensagem
$message = "";

// Verificar se o id do contato e cliente_id foram enviados via POST
if (isset($_POST['id']) && isset($_POST['cliente_id'])) {
    $contato_id = $_POST['id'];
    $cliente_id = $_POST['cliente_id'];

    // Preparar a query para excluir o contato
    $sql = "DELETE FROM contatos WHERE id = ? AND cliente_id = ?";

    // Preparar a declaração
    if ($stmt = $conn->prepare($sql)) {
        // Vincular os parâmetros
        $stmt->bind_param("ii", $contato_id, $cliente_id);

        // Executar a consulta
        if ($stmt->execute()) {
            $message = "Contato excluído com sucesso!";
            
        } else {
            $message = "Erro ao excluir o contato: " . $stmt->error;
        }

        // Fechar a declaração
        $stmt->close();
    } else {
        $message = "Erro ao preparar a query para excluir o contato: " . $conn->error;
    }
} else {
    $message = "ID do contato ou ID do cliente não fornecido corretamente.";
}

// Fechar a conexão
$conn->close();

// Exibir a mensagem de sucesso/erro

// echo $message
header("Location: contatos.php?id=" . urlencode($cliente_id) . "&message=" . urlencode($message));
// exit();
?>
