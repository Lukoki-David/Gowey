<?php
session_start();
require_once 'conexao_gowey.php';

if (!isset($_SESSION['escola_id'])) {
    header("Location: login_escola.php");
    exit;
}

$escola_id = $_SESSION['escola_id'];

// Buscar motoristas disponíveis (não vinculados a outro autocarro)
$stmt = $pdo->prepare("SELECT id, nome FROM motoristas WHERE escola_id = ? AND id NOT IN (SELECT motorista_id FROM veiculos)");
$stmt->execute([$escola_id]);
$motoristas = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $placa = strtoupper(trim($_POST['placa']));
    $modelo = $_POST['modelo'];
    $capacidade = $_POST['capacidade'];
    $motorista_id = $_POST['motorista_id'];

    // Verifica se a placa já existe
    $checkPlaca = $pdo->prepare("SELECT COUNT(*) FROM veiculos WHERE placa = ?");
    $checkPlaca->execute([$placa]);
    $placaExiste = $checkPlaca->fetchColumn();

    if ($placaExiste > 0) {
        header("Location: cadastro_autocarros.php?placa_erro=1");
        exit;
    }

    // Verifica se o motorista já tem autocarro
    $checkMotorista = $pdo->prepare("SELECT COUNT(*) FROM veiculos WHERE motorista_id = ?");
    $checkMotorista->execute([$motorista_id]);
    $motoristaExiste = $checkMotorista->fetchColumn();

    if ($motoristaExiste > 0) {
        header("Location: cadastro_autocarros.php?erro=1");
        exit;
    }

    // Inserir autocarro
    $stmt = $pdo->prepare("INSERT INTO veiculos (placa, modelo, capacidade, escola_id, motorista_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$placa, $modelo, $capacidade, $escola_id, $motorista_id]);

    header("Location: autocarros_cadastrados.php?veiculo_sucesso=1");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastrar Autocarro</title>
  <link rel="stylesheet" href="cadastro_autocarros.css">
  <link rel="icon" type="image/png"  href="./resimension.png">
</head>
<body>
  <div class="form-container">
    <h1>Cadastro de Autocarros</h1>
    <?php if (isset($_GET['erro']) && $_GET['erro'] == 1): ?>
      <div class="alert error"> Este motorista já está vinculado a outro autocarro!</div>
    <?php endif; ?>

    <?php if (isset($_GET['placa_erro']) && $_GET['placa_erro'] == 1): ?>
      <div class="alert error"> Esta placa já está cadastrada no sistema!</div>
    <?php endif; ?>
    <form method="POST">
      <div class="form-group">
        <label for="placa">Placa do Autocarro</label>
        <input type="text" id="placa" name="placa" required>
      </div>
      <div class="form-group">
        <label for="modelo">Modelo</label>
        <input type="text" id="modelo" name="modelo" required>
      </div>
      <div class="form-group">
        <label for="capacidade">Capacidade (número de lugares)</label>
        <input type="number" id="capacidade" name="capacidade" required min="1">
      </div>
      <div class="form-group">
        <label for="motorista_id">Motorista Responsável</label>
        <select id="motorista_id" name="motorista_id" required>
          <option value="">Selecione o motorista</option>
          <?php foreach ($motoristas as $m): ?>
            <option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['nome']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <button type="submit" class="btn">Cadastrar Autocarro</button>
    </form>
  </div>
</body>
</html>
