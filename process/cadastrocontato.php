<?php
// Inicia a sessão para exibir mensagens de sucesso/erro
session_start();

// Inclui o arquivo de conexão com o banco de dados
include('../includes/db.php');
include('../includes/functions.php');

// Verifica se os dados foram enviados pelo formulário (via método POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coleta e limpa os dados do formulário
    $cliente_id = $_POST['cliente_id']; // Pega o ID do cliente que vem do formulário
    $tipo = limpar_dados($_POST['tipo']); // Tipo do contato (telefone, email, etc.)
    $valor = limpar_dados($_POST['valor']); // Valor do contato (número, email, etc.)
    $observacao = limpar_dados($_POST['observacao']); // Observações adicionais sobre o contato (opcional)

    // Verifica se o cliente existe no banco de dados
    $sql_check_cliente = "SELECT * FROM clientes WHERE id = '$cliente_id'";
    $result = $conn->query($sql_check_cliente);

    if ($result->num_rows == 0) {
        // Cliente não encontrado, redireciona de volta com mensagem de erro
        $_SESSION['error'] = "Cliente não encontrado!";
        header('Location: ../public/cadastro_contato.php?cliente_id=' . $cliente_id);
        exit();
    }

    // Inserir o novo contato na tabela contatos
    $sql_insert_contato = "INSERT INTO contatos (cliente_id, tipo, valor, observacao) 
                           VALUES ('$cliente_id', '$tipo', '$valor', '$observacao')";

    if ($conn->query($sql_insert_contato) === TRUE) {
        // Se o contato foi inserido com sucesso, exibe uma mensagem de sucesso
        $_SESSION['success'] = "Contato cadastrado com sucesso!";
    } else {
        // Se houve erro ao inserir o contato, exibe mensagem de erro
        $_SESSION['error'] = "Erro ao cadastrar contato: " . $conn->error;
    }

    // Redireciona de volta para a página de cadastro de contato com o ID do cliente
    header('Location: ../public/cadastrocontato.php?cliente_id=' . $cliente_id);
    exit();
    // Redireciona de volta para a página de cadastro de contato com o ID do cliente


}

// Fecha a conexão com o banco de dados
$conn->close();
?>
