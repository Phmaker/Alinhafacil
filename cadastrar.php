<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Cadastrar Cliente</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="dashboard.css">
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
  <h3 class="text-center mb-4">Alinha Fácil 🚗🔧</h3>
  <a href="index.html"><i class="bi bi-house"></i> Início</a>
  <a href="listar_clientes.php"><i class="bi bi-people"></i> Clientes</a>
  <a href="listar_produtos.php"><i class="bi bi-tools"></i> Serviços e Produtos</a>
  <a href="cadastrar.php" class="active"><i class="bi bi-person-plus"></i> Novo Cliente</a>
</div>

<div class="content">
  <?php
  include 'conexao.php';

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $nome = $_POST['nome'] ?? "";
      $CNPJ_CPF = preg_replace("/\D/", "", $_POST['CNPJ_CPF'] ?? "");
      $telefone = $_POST['telefone'] ?? "";
      $email = $_POST['email'] ?? "";
      $marca = $_POST['marca'] ?? "";
      $modelo = $_POST['modelo'] ?? "";
      $placa = $_POST['placa'] ?? "";

      $sql = "INSERT INTO clientes (nome, CNPJ_CPF, telefone, email, marca, modelo, placa) 
              VALUES ('$nome', '$CNPJ_CPF', '$telefone', '$email', '$marca','$modelo', '$placa')";

      if ($conn->query($sql) === TRUE) {
          echo "<p class='alert alert-success'>Cliente cadastrado com sucesso!</p>";
      } else {
          echo "<p class='alert alert-danger'>Erro ao cadastrar: " . $conn->error . "</p>";
      }
  }
  ?>

  <h2 class="mb-4">Cadastrar Novo Cliente</h2>

  <div class="container">
    <form method="post">
      <div class="form-group">
        <label>Nome:</label>
        <input type="text" name="nome" required>
      </div>

      <div class="form-group">
        <label>CNPJ/CPF:</label>
        <input type="text" name="CNPJ_CPF" id="number" required onkeyup="formatarDocumento(this)">
      </div>

      <div class="form-group">
        <label>Telefone:</label>
        <input type="text" name="telefone" id="telefone" required maxlength="15" onkeyup="formatarTelefone(this)">
      </div>

      <div class="form-group">
        <label>Email:</label>
        <input type="email" name="email">
      </div>

      <div class="form-group">
        <label>Marca:</label>
        <input type="text" name="marca" required>
      </div>

      <div class="form-group">
        <label>Modelo:</label>
        <input type="text" name="modelo" required>
      </div>

      <div class="form-group">
        <label>Placa:</label>
        <input type="text" name="placa" id="placa" required maxlength="8" onkeyup="formatarPlaca(this)">
      </div>

      <button type="submit">Cadastrar</button>
      <div class="links mt-3">
        <a href="index.html">← Voltar</a>
      </div>
    </form>
  </div>
</div>

<script>
function formatarDocumento(input) {
  let valor = input.value.replace(/\D/g, '');
  let limite = valor.length <= 11 ? 11 : 14;

  if (valor.length > limite) valor = valor.slice(0, limite);

  if (valor.length <= 11) {
    valor = valor.replace(/^(\d{3})(\d)/, '$1.$2');
    valor = valor.replace(/^(\d{3})\.(\d{3})(\d)/, '$1.$2.$3');
    valor = valor.replace(/^(\d{3})\.(\d{3})\.(\d{3})(\d)/, '$1.$2.$3-$4');
  } else {
    valor = valor.replace(/^(\d{2})(\d)/, '$1.$2');
    valor = valor.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
    valor = valor.replace(/^(\d{2})\.(\d{3})\.(\d{3})(\d)/, '$1.$2.$3/$4');
    valor = valor.replace(/^(\d{2})\.(\d{3})\.(\d{3})\/(\d{4})(\d)/, '$1.$2.$3/$4-$5');
  }
  input.value = valor;
}

function formatarTelefone(input) {
  let valor = input.value.replace(/\D/g, '');
  if (valor.length > 11) valor = valor.slice(0, 11);
  if (valor.length <= 10) {
    valor = valor.replace(/^(\d{2})(\d)/, '($1) $2');
    valor = valor.replace(/^(\(\d{2}\)) (\d{4})(\d)/, '$1 $2-$3');
  } else {
    valor = valor.replace(/^(\d{2})(\d)/, '($1) $2');
    valor = valor.replace(/^(\(\d{2}\)) (\d{5})(\d)/, '$1 $2-$3');
  }
  input.value = valor;
}

function formatarPlaca(input) {
  let valor = input.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
  if (valor.length > 7) valor = valor.slice(0, 7);
  input.value = valor;
}
</script>

</body>
</html>
