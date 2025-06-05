<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'conexao.php';

if (isset($_GET['id'])) {
  $id = intval($_GET['id']);

  $stmt = $conn->prepare("SELECT * FROM clientes WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();
  $cliente = $result->fetch_assoc();
  $stmt->close();

  if (!$cliente) {
    die("Cliente não encontrado.");
  }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id = intval($_POST['id']);
  $nome = $_POST['nome'];
  $CNPJ_CPF = preg_replace("/\D/", "", $_POST['CNPJ_CPF']);
  $telefone = $_POST['telefone'];
  $email = $_POST['email'];
  $marca = $_POST['marca'];
  $modelo = $_POST['modelo'];
  $placa = $_POST['placa'];

  $stmt = $conn->prepare("UPDATE clientes SET nome=?, CNPJ_CPF=?, telefone=?, email=?, marca=?, modelo=?, placa=? WHERE id=?");
  $stmt->bind_param("sssssssi", $nome, $CNPJ_CPF, $telefone, $email, $marca, $modelo, $placa, $id);
  if ($stmt->execute()) {
    header("Location: listar_clientes.php");
    exit();
  } else {
    echo "Erro: " . $stmt->error;
  }
  $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Editar Cliente</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="dashboard.css">
</head>
<body>
  <div class="container mt-5">
    <h2>Editar Cliente</h2>
    <form method="post">
      <input type="hidden" name="id" value="<?= $cliente['id'] ?>">

      <div class="mb-3">
        <label class="form-label">Nome:</label>
        <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($cliente['nome']) ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">CNPJ/CPF:</label>
        <input type="text" name="CNPJ_CPF" id="number" class="form-control" maxlength="14"
  value="<?= htmlspecialchars($cliente['CNPJ_CPF']) ?>" required
  oninput="this.value = this.value.replace(/[^0-9]/g, '')"
  onkeyup="formatarDocumento(this)">


      </div>

      <div class="mb-3">
        <label class="form-label">Telefone:</label>
        <input type="text" name="telefone" id="telefone" class="form-control" value="<?= htmlspecialchars($cliente['telefone']) ?>" required maxlength="15" onkeyup="formatarTelefone(this)">
      </div>

      <div class="mb-3">
        <label class="form-label">Email:</label>
        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($cliente['email']) ?>">
      </div>

      <div class="mb-3">
        <label class="form-label">Marca:</label>
        <input type="text" name="marca" class="form-control" value="<?= htmlspecialchars($cliente['marca']) ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Modelo:</label>
        <input type="text" name="modelo" class="form-control" value="<?= htmlspecialchars($cliente['modelo']) ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Placa:</label>
        <input type="text" name="placa" id="placa" class="form-control" value="<?= htmlspecialchars($cliente['placa']) ?>" required maxlength="8" onkeyup="formatarPlaca(this)">
      </div>

      <button type="submit" class="btn btn-primary">Salvar</button>
      <a href="listar_clientes.php" class="btn btn-secondary">← Voltar</a>
    </form>
  </div>
<script>
function formatarDocumento(input) {
  let valor = input.value.replace(/\D/g, '');

  // Limita a 14 dígitos (CNPJ) ou 11 dígitos (CPF)
  if (valor.length > 14) valor = valor.slice(0, 14);

  if (valor.length <= 11) {
    // CPF: 000.000.000-00
    valor = valor.replace(/^(\d{3})(\d)/, '$1.$2');
    valor = valor.replace(/^(\d{3})\.(\d{3})(\d)/, '$1.$2.$3');
    valor = valor.replace(/^(\d{3})\.(\d{3})\.(\d{3})(\d)/, '$1.$2.$3-$4');
  } else {
    // CNPJ: 00.000.000/0000-00
    valor = valor.replace(/^(\d{2})(\d)/, '$1.$2');
    valor = valor.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
    valor = valor.replace(/^(\d{2})\.(\d{3})\.(\d{3})(\d)/, '$1.$2.$3/$4');
    valor = valor.replace(/^(\d{2})\.(\d{3})\.(\d{3})\/(\d{4})(\d)/, '$1.$2.$3/$4-$5');
  }

  input.value = valor;
}


function formatarPlaca(input) {
  let valor = input.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
  if = valor;
}
</script>


</body>
</html>
