<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Clientes Cadastrados</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="dashboard.css">
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
  <h3 class="text-center mb-4">Alinha Fácil 🚗🔧</h3>
  <a href="index.html"><i class="bi bi-house"></i> Início</a>
  <a href="listar_clientes.php" class="active"><i class="bi bi-people"></i> Clientes</a>
  <a href="listar_produtos.php"><i class="bi bi-tools"></i> Serviços e Produtos</a>
  <a href="cadastrar.php"><i class="bi bi-person-plus"></i> Novo Cliente</a>
</div>

<div class="content">
  <?php
  include 'conexao.php';
  function formatarDocumento($documento) {
  $documento = preg_replace('/\D/', '', $documento);

  if (strlen($documento) === 11) {
    // CPF: 000.000.000-00
    return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "$1.$2.$3-$4", $documento);
  } elseif (strlen($documento) === 14) {
    // CNPJ: 00.000.000/0000-00
    return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "$1.$2.$3/$4-$5", $documento);
  }

  return $documento; // Retorna como está se não for CPF nem CNPJ
}
  // Consulta para obter todos os clientes
  $result = $conn->query("SELECT * FROM clientes ORDER BY id DESC");
  ?>

  <h2 class="mb-4">Clientes Cadastrados</h2>

  <table class="table table-dark table-striped">
<thead>
  <tr>
    <th>Nome</th>
    <th>CNPJ/CPF</th>
    <th>Telefone</th>
    <th>Email</th>
    <th>Marca</th>
    <th>Modelo</th>
    <th>Placa</th>
    <th>Ações</th>
  </tr>
</thead>
<tbody>
  <?php while ($row = $result->fetch_assoc()): ?>
  <tr>
    <td><?= htmlspecialchars($row['nome']) ?></td>
    <td><?= formatarDocumento($row['CNPJ_CPF']) ?></td>
    <td><?= htmlspecialchars($row['telefone']) ?></td>
    <td><?= htmlspecialchars($row['email']) ?></td>
    <td><?= htmlspecialchars($row['marca']) ?></td>
    <td><?= htmlspecialchars($row['modelo']) ?></td>
    <td><?= htmlspecialchars($row['placa']) ?></td>
    <td>
      <a href="editar.php?id=<?= $row['id'] ?>" title="Editar"><i class="bi bi-pencil-square"></i></a>
      &nbsp;
      <a href="excluir.php?id=<?= $row['id'] ?>" onclick="return confirm('Confirmar exclusão?')" title="Excluir"><i class="bi bi-trash"></i></a>
    </td>
  </tr>
  <?php endwhile; ?>
</tbody>

  </table>

  <div class="links mt-3">
    <a href="index.html">← Voltar</a>
  </div>
</div>

</body>
</html>
