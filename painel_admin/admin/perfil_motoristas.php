<?php
session_start();
require_once 'conexao_gowey.php';

if (!isset($_SESSION['escola_id'])) {
    header("Location: login_escola.php");
    exit;
}

$escola_id = $_SESSION['escola_id'];

// Buscar motoristas da escola
$stmt = $pdo->prepare("SELECT * FROM motoristas WHERE escola_id = ?");
$stmt->execute([$escola_id]);
$motoristas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfis dos Motoristas</title>
  <link rel="stylesheet" href="perfil_motoristas.css">
</head>
<body>
  <div class="container">
    <h1>Motoristas Cadastrados</h1>
    <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] == 1): ?>
  <div class="alert success">
     Motorista cadastrado com sucesso!
  </div>
<?php endif; ?>
<?php if (isset($_GET['deletado']) && $_GET['deletado'] == 1): ?>
  <div class="alert success">
    Motorista deletado com sucesso!
  </div>
<?php endif; ?>

    <div class="lista">
      <?php foreach ($motoristas as $m): ?>
        <div class="card" onclick="mostrarPerfil(<?= $m['id'] ?>)">
          <img src="<?= $m['foto'] ?? 'default.png' ?>" alt="Foto do motorista">
          <h3><?= htmlspecialchars($m['nome']) ?></h3>
          <p><?= htmlspecialchars($m['email']) ?></p>
        </div>

        <!-- Modal de perfil -->
        <div class="modal" id="perfil-<?= $m['id'] ?>">
          <div class="modal-content">
            <span class="close" onclick="fecharPerfil(<?= $m['id'] ?>)">&times;</span>
            <img src="<?= $m['foto'] ?? 'default.png' ?>" alt="Foto do motorista" class="perfil-foto">
            <h2><?= htmlspecialchars($m['nome']) ?></h2>
            <p><strong>Email:</strong> <?= htmlspecialchars($m['email']) ?></p>
            <p><strong>Telefone:</strong> <?= htmlspecialchars($m['telefone']) ?></p>
            <p><strong>CNH:</strong> <?= htmlspecialchars($m['carteira']) ?></p>
            <!-- Botão de deletar motorista -->
            <form method="POST" action="deletar_motorista.php" onsubmit="return confirm('Tem certeza que deseja excluir este motorista?');">
            <input type="hidden" name="motorista_id" value="<?= $m['id'] ?>">
            <button type="submit" class="btn-delete"> Deletar Motorista</button>
            </form>

            <!-- Upload de foto -->
            <form method="POST" action="upload_foto.php" enctype="multipart/form-data">
              <input type="hidden" name="motorista_id" value="<?= $m['id'] ?>">
              <label for="foto">Alterar Foto:</label>
              <input type="file" name="foto" accept="image/*" required>
              <button type="submit" class="btn">Salvar Foto</button>
            </form>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <script>
    function mostrarPerfil(id) {
      document.getElementById('perfil-' + id).style.display = 'block';
    }
    function fecharPerfil(id) {
      document.getElementById('perfil-' + id).style.display = 'none';
    }
  </script>
</body>
</html>
