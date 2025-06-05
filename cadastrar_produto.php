<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Cadastrar Produto</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="dashboard.css">
</head>
<body>

  <div class="sidebar">
    <h3 class="text-center mb-4">Alinha Fácil 🚗🔧</h3>
    <a href="index.html"><i class="bi bi-house"></i> Início</a>
    <a href="listar_clientes.php"><i class="bi bi-people"></i> Clientes</a>
    <a href="listar_produtos.php"><i class="bi bi-tools"></i> Serviços e Produtos</a>
    <a href="cadastrar.php" class="active"><i class="bi bi-person-plus"></i> Novo Cliente</a>
  </div>

  <div class="content">
    <div class="container">
      <h2>Cadastrar Produto</h2>

      <?php
      include 'conexao.php';

      if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $nome = $_POST['nome'] ?? '';
          $categoria = $_POST['categoria'] ?? '';
          $preco = str_replace(',', '.', $_POST['preco'] ?? '0');

          if (!empty($nome) && !empty($categoria) && is_numeric($preco)) {
              $stmt = $conn->prepare("INSERT INTO produtos (nome, categoria, preco) VALUES (?, ?, ?)");
              $stmt->bind_param("ssd", $nome, $categoria, $preco);

              if ($stmt->execute()) {
                  echo "<div class='alert alert-success mt-3'>Produto cadastrado com sucesso!</div>";
              } else {
                  echo "<div class='alert alert-danger mt-3'>Erro ao cadastrar: " . $stmt->error . "</div>";
              }
          } else {
              echo "<div class='alert alert-warning mt-3'>Preencha todos os campos corretamente.</div>";
          }
      }
      ?>

      <form method="post">
        <div class="form-group">
          <label for="nome">Nome:</label>
          <input type="text" name="nome" id="nome" class="form-control" required>
        </div>

        <div class="form-group">
          <label for="categoria">Categoria:</label>
          <input type="text" name="categoria" id="categoria" class="form-control" required>
               <div class="form-group">
          <label for="preco">Preço (R$):</label>
          <input type="text" name="preco" id="preco" class="form-control" required placeholder="Ex: 99,90">
        </div>

        <button type="submit">Cadastrar Produto</button>
        <a href="listar_produtos.php" class="btn btn-outline-light mt-3 w-100">Voltar</a>
      </form>
    </div>
  </div>

</body>
</html>
