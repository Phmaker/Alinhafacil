<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Registrar Serviço</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="dashboard.css">
</head>
<body>

<div class="sidebar">
  <h3 class="text-center mb-4">Alinha Fácil 🚗🔧</h3>
  <a href="index.html"><i class="bi bi-house"></i> Início</a>
  <a href="listar_clientes.php"><i class="bi bi-people"></i> Clientes</a>
  <a href="listar_produtos.php"><i class="bi bi-tools"></i> Serviços e Produtos</a>
  <a href="cadastrar.php"><i class="bi bi-person-plus"></i> Novo Cliente</a>
  <a href="registrar_servico.php" class="active"><i class="bi bi-clipboard-plus"></i> Registrar Serviço</a>
</div>

<div class="content">
  <h2 class="mb-4">Registrar Serviço</h2>

  <?php
  include 'conexao.php';

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $cliente_id = $_POST['cliente_id'];
      $tipo_servico = $_POST['tipo_servico'];
      $data_servico = $_POST['data_servico'];
      $veiculo = $_POST['veiculo'];
      $seguradora = $_POST['seguradora'];

      $sql = "INSERT INTO servicos (cliente_id, tipo_servico, data_servico, veiculo, seguradora)
              VALUES (?, ?, ?, ?, ?)";
      $stmt = $conn->prepare($sql);
      if ($stmt->bind_param("issss", $cliente_id, $tipo_servico, $data_servico, $veiculo, $seguradora) && $stmt->execute()) {
          echo "<p class='alert alert-success'>Serviço registrado com sucesso!</p>";
      } else {
          echo "<p class='alert alert-danger'>Erro ao registrar serviço: " . $conn->error . "</p>";
      }
  }
  ?>

  <form method="post" class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Cliente:</label>
      <select name="cliente_id" class="form-select" required>
        <option value="">Selecione um cliente</option>
        <?php
        $clientes = $conn->query("SELECT id, nome FROM clientes ORDER BY nome");
        while ($c = $clientes->fetch_assoc()) {
            echo "<option value='{$c['id']}'>{$c['nome']}</option>";
        }
        ?>
      </select>
    </div>

    <div class="col-md-6">
      <label class="form-label">Tipo de Serviço:</label>
      <input type="text" name="tipo_servico" class="form-control" required>
    </div>

    <div class="col-md-4">
      <label class="form-label">Data do Serviço:</label>
      <input type="date" name="data_servico" class="form-control" value="<?= date('Y-m-d') ?>" required>
    </div>

    <div class="col-md-4">
      <label class="form-label">Veículo:</label>
      <input type="text" name="veiculo" class="form-control" required>
    </div>

    <div class="col-md-4">
      <label class="form-label">Seguradora:</label>
      <input type="text" name="seguradora" class="form-control">
    </div>

    <div class="col-12">
      <button type="submit" class="btn btn-warning">Registrar</button>
      <a href="index.html" class="btn btn-secondary ms-2">← Voltar</a>
    </div>
  </form>
</div>

</body>
</html>
