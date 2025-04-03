<?php
// Arquivo para conectar ao banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "apiclientes";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>
