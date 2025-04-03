<?php
// Função para limpar dados de entrada (proteção contra SQL Injection, XSS)
function limpar_dados($dados) {
    $dados = trim($dados);
    $dados = stripslashes($dados);
    $dados = htmlspecialchars($dados);
    return $dados;
}
?>
