<?php
// Ativar a exibição de erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conectar ao banco de dados
include('../includes/db.php');

// Inicializar uma variável de mensagem
$message = "";

// Verificar se os dados necessários foram enviados
if (isset($_GET['id'])) {
    $cliente_id = $_GET['id'];

    // Primeiro, excluir os contatos do cliente
    // Preparar a query para excluir todos os contatos do cliente
    $delete_contatos_sql = "DELETE FROM contatos WHERE cliente_id = ?";

    // Preparar a declaração
    if ($stmt = $conn->prepare($delete_contatos_sql)) {
        // Vincular os parâmetros
        $stmt->bind_param("i", $cliente_id);

        // Executar a consulta para excluir os contatos
        if ($stmt->execute()) {
            $message = "Contatos excluídos com sucesso! ";

            // Agora excluir o cliente, pois seus contatos já foram excluídos
            $delete_cliente_sql = "DELETE FROM clientes WHERE id = ?";

            // Preparar a declaração para excluir o cliente
            if ($delete_stmt = $conn->prepare($delete_cliente_sql)) {
                // Vincular os parâmetros
                $delete_stmt->bind_param("i", $cliente_id);

                // Executar a consulta para excluir o cliente
                if ($delete_stmt->execute()) {
                    $message .= "Cliente excluído com sucesso!";
                } else {
                    $message .= "Erro ao excluir o cliente: " . $delete_stmt->error;
                }

                // Fechar a declaração do cliente
                $delete_stmt->close();
            } else {
                $message .= "Erro ao preparar a query para excluir o cliente: " . $conn->error;
            }
        } else {
            $message = "Erro ao excluir os contatos: " . $stmt->error;
        }

        // Fechar a declaração dos contatos
        $stmt->close();
    } else {
        $message = "Erro ao preparar a query para excluir os contatos: " . $conn->error;
    }
} else {
    $message = "ID do cliente não fornecido corretamente.";
}

// Fechar a conexão
$conn->close();

// Exibir mensagem de erro para depuração (opcional)
echo $message;

// Redirecionar de volta para a página de listagem de contatos com a mensagem
header("Location: ../public/listar.php?message=" . urlencode($message));
exit();
?>
