<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Serviços e Produtos</title>
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
  <a href="listar_produtos.php" class="active"><i class="bi bi-tools"></i> Serviços e Produtos</a>
  <a href="cadastrar.php"><i class="bi bi-person-plus"></i> Novo Cliente</a>
</div>

<div class="content p-4">
  <?php
  include 'conexao.php';

  $result = $conn->query("SELECT * FROM produtos ORDER BY id DESC");

  if (!$result) {
      echo "<p class='alert alert-danger'>Erro ao buscar produtos: " . $conn->error . "</p>";
  }
  ?>

  <h2 class="mb-4">Serviços e Produtos</h2>

  <table class="table table-dark table-striped">
    <thead>
      <tr>
        <th>Nome</th>
        <th>Categoria</th>
        <th>Preço (R$)</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($produto = $result->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($produto['nome']) ?></td>
        <td><?= htmlspecialchars($produto['categoria']) ?></td>
        <td><?= number_format($produto['preco'], 2, ',', '.') ?></td>
        <td>
          <a href="editar_produto.php?id=<?= $produto['id'] ?>" title="Editar"><i class="bi bi-pencil-square"></i></a>
          &nbsp;
          <a href="excluir_produto.php?id=<?= $produto['id'] ?>" onclick="return confirm('Confirmar exclusão?')" title="Excluir"><i class="bi bi-trash"></i></a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

  <div class="links mt-3">
    <a href="cadastrar_produto.php" class="btn btn-success">➕ Novo Produto</a>
    <a href="index.html" class="btn btn-secondary ms-2">← Voltar</a>
  </div>
</div>

</body>
</html>
