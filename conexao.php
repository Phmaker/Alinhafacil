<?php
$servername = "localhost:3306";
$username = "root";
$password = "admin";
$dbname = "alinhafacil";

$conn = new mysqli($servername, $username, $password, $dbname);

// Definir charset
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
  die("Falha na conexão: " . $conn->connect_error);
}
?>
