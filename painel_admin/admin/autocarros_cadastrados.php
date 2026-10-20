<?php
session_start();
require_once 'conexao_gowey.php';

if (!isset($_SESSION['escola_id'])) {
    header("Location: login_escola.php");
    exit;
}

$escola_id = $_SESSION['escola_id'];

// Buscar autocarros da escola
$stmt = $pdo->prepare("SELECT v.*, m.nome AS motorista_nome FROM veiculos v 
                       LEFT JOIN motoristas m ON v.motorista_id = m.id 
                       WHERE v.escola_id = ?");
$stmt->execute([$escola_id]);
$veiculos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Autocarros Cadastrados</title>
  <link rel="stylesheet" href="autocarros_cadastrados.css">
  <link rel="icon" type="image/png"  href="./resimension.png">
</head>
<body>
  <div class="container">
    <h1>Autocarros Cadastrados</h1>

    <?php if (isset($_GET['deletado']) && $_GET['deletado'] == 1): ?>
      <div class="alert success"> Autocarro deletado com sucesso!</div>
    <?php endif; ?>

    <table>
      <thead>
        <tr>
          <th>Placa</th>
          <th>Modelo</th>
          <th>Capacidade</th>
          <th>Motorista Responsável</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php if (count($veiculos) > 0): ?>
          <?php foreach ($veiculos as $v): ?>
            <tr>
              <td><?= htmlspecialchars($v['placa']) ?></td>
              <td><?= htmlspecialchars($v['modelo']) ?></td>
              <td><?= htmlspecialchars($v['capacidade']) ?></td>
              <td><?= htmlspecialchars($v['motorista_nome'] ?? 'Não atribuído') ?></td>
              <td>
                <form method="POST" action="deletar_autocarro.php" onsubmit="return confirm('Tem certeza que deseja excluir este autocarro?');">
                  <input type="hidden" name="veiculo_id" value="<?= $v['id'] ?>">
                  <button type="submit" class="btn-delete"> Deletar</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="5">Nenhum autocarro cadastrado.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
