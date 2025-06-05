<?php
include 'conexao.php';

if (isset($_GET['id'])) {
  $id = intval($_GET['id']);

  // Primeiro exclui os serviços do cliente
  $stmt = $conn->prepare("DELETE FROM servicos WHERE cliente_id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $stmt->close();

  // Agora exclui o cliente
  $stmt = $conn->prepare("DELETE FROM clientes WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $stmt->close();
}

header("Location: listar_clientes.php");
exit();
?>
