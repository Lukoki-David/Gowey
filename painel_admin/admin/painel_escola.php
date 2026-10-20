
<?php
session_start();
require_once 'conexao_gowey.php';

// Verifica login
if (!isset($_SESSION['escola_id'])) {
    header("Location: login_escola.php");
    exit;
}

$escola_id = $_SESSION['escola_id'];

// Buscar dados da escola
$stmt = $pdo->prepare("SELECT * FROM escolas WHERE id = ?");
$stmt->execute([$escola_id]);
$escola = $stmt->fetch(PDO::FETCH_ASSOC);

// Buscar dados relacionados
$frota = $pdo->prepare("SELECT COUNT(*) FROM veiculos WHERE escola_id = ?");
$frota->execute([$escola_id]);
$total_autocarros = $frota->fetchColumn();

$alunos = $pdo->prepare("SELECT COUNT(*) FROM alunos WHERE escola_id = ?");
$alunos->execute([$escola_id]);
$total_alunos = $alunos->fetchColumn();

$motoristas = $pdo->prepare("SELECT COUNT(*) FROM motoristas WHERE escola_id = ?");
$motoristas->execute([$escola_id]);
$total_motoristas = $motoristas->fetchColumn();

$alertas = $pdo->prepare("SELECT COUNT(*) FROM alertas WHERE escola_id = ? AND status = 'pendente'");
$alertas->execute([$escola_id]);
$total_alertas = $alertas->fetchColumn();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Painel da Escola - GoWey School</title>
  <link rel="stylesheet" href="painel_escola.css">
  <link rel="icon" type="image/png"  href="resimension.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <div class="dashboard-container">
    <!-- Botão de menu (mobile) -->
    <button class="menu-toggle" id="menuToggle">
      <i class="fa-solid fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
      <h2>GoWey School</h2>
      <nav>
        <a href="cadastro_autocarros.php"><i class="fa-solid fa-bus"></i>Cadastrar Autocarros</a>
        <a href="autocarros_cadastrados.php"><i class="fa-solid fa-bus"></i>Autocarros</a>
        <a href="cadastro_motoristas.php"><i class="fa-solid fa-user-tie"></i>Cadastrar Motoristas</a>
        <a href="perfil_motoristas.php"><i class="fa-solid fa-id-card"></i> Perfil dos Motoristas</a>
        <a href="#"><i class="fa-solid fa-route"></i> Rotas</a>
        <a href="cadastro_alunos.php"><i class="fa-solid fa-user-graduate"></i> Cadastrar Alunos</a>
        <a href="alunos_cadastrados.php"><i class="fa-solid fa-users"></i> Alunos Cadastrados</a>
        <a href="#"><i class="fa-solid fa-chart-line"></i> Relatórios</a>
        <a href="gowey.php" class="logout"><i class="fa-solid fa-right-from-bracket"></i> Sair</a>
      </nav>
    </aside>

    <!-- Conteúdo principal -->
    <main class="main-content">
      <header class="topbar">
        <h1><?= htmlspecialchars($escola['nome']) ?></h1>
      </header>

      <section class="summary">
        <div class="card"><h3>Autocarros</h3><span><?= $total_autocarros ?></span></div>
        <div class="card"><h3>Alunos</h3><span><?= $total_alunos ?></span></div>
        <div class="card"><h3>Motoristas Efectivos</h3><span><?= $total_motoristas ?></span></div>
        <div class="card alert"><h3>Alertas</h3><span><?= $total_alertas ?></span></div>
      </section>

      <section class="info-panels full-width">
  <div class="panel">
    <h3>Informações da Escola</h3>
    <ul>
      <li><strong>Responsável:</strong> <?= htmlspecialchars($escola['responsavel']) ?></li>
      <li><strong>Email:</strong> <?= htmlspecialchars($escola['email']) ?></li>
      <li><strong>Telefone:</strong> <?= htmlspecialchars($escola['telefone']) ?></li>
      <li><strong>Processo:</strong> <?= htmlspecialchars($escola['numero_processo']) ?></li>
    </ul>
  </div>

  <div class="panel">
    <h3>Monitoramento de Rotas</h3>
    <div class="mapa-placeholder">Mapa interativo aqui</div>
  </div>

  <div class="panel extra">
    <h3>Estatísticas Gerais</h3>
    <p>Total de motoristas: <strong>3</strong></p>
    <p>Rotas ativas: <strong>5</strong></p>
    <p>Última atualização: <strong>22/09/2026</strong></p>
  </div>
</section>


  <script>
    // Alternar visibilidade da sidebar no mobile
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');
    menuToggle.addEventListener('click', () => {
      sidebar.classList.toggle('active');
    });
  </script>
</body>
</html>
