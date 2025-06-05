<?php
$conn = new mysqli("localhost", "root", "", "cadastro_clientes");

// Verifica conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Definir charset para evitar problemas com acentuação
$conn->set_charset("utf8mb4");

// Obtendo e validando os dados recebidos via POST
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$nome = isset($_POST['nome']) ? trim($_POST['nome']) : "";
$email = isset($_POST['email']) ? trim($_POST['email']) : "";
$telefone = isset($_POST['telefone']) ? trim($_POST['telefone']) : "";

if ($id > 0 && !empty($nome) && !empty($email) && !empty($telefone)) {
    // Usa prepared statements para evitar SQL Injection
    $stmt = $conn->prepare("UPDATE clientes SET nome=?, email=?, telefone=? WHERE id=?");
    $stmt->bind_param("sssi", $nome, $email, $telefone, $id);

    if ($stmt->execute()) {
        header("Location: listar.php");
        exit;
    } else {
        echo "Erro ao atualizar: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Dados inválidos ou ausentes!";
}

$conn->close();
?>
