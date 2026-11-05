<?php
session_start();
require_once __DIR__ . '../config/conexao_gowey.php';
// Verifica se admin está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: loguinadmin.php"); 
    exit;
}

?>


<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>GoWey Admin Dashboard</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="icon" type="image/png"  href="./resimension.png">
<link rel="stylesheet" href="../admin/dashboard_admin.css">
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
  <h2>GoWey Admin</h2>
  <a href="../admin/cadastro_escolas.php"><i class="fa-solid fa-school"></i><span>Cadastrar Escolas</span></a>
  <a href="#"><i class="fa-solid fa-bus"></i><span>Gerir Veículos</span></a>
  <a href="#"><i class="fa-solid fa-user-tie"></i><span>Motoristas</span></a>
  <a href="escolas_cadastradas.php"><i class="fa-solid fa-star"></i><span>Escolas Cadastradas</span></a>
  <a href="#"><i class="fa-solid fa-route"></i><span>Rotas</span></a>
  <a href="#"><i class="fa-solid fa-chart-line"></i><span>Relatórios</span></a>
  <a href="#"><i class="fa-solid fa-gear"></i><span>Configurações</span></a>
  <a href="gowey.php" class="logout"><i class="fa-solid fa-right-from-bracket"></i> Sair</a>
</div>

<!-- Conteúdo Principal -->
<div class="main-content">
  <header>
    <h1>Painel de Administração</h1>
    <div class="user-info">
      <i class="fa-solid fa-user-circle"></i>
      <span>Admin GoWey</span>
    </div>
  </header>

  <section class="dashboard-cards">
    <div class="card">
      <i class="fa-solid fa-school"></i>
      <h3>Escolas Cadastradas</h3>
      <p>Gerencie instituições conectadas ao sistema.</p>
    </div>

    <div class="card">
      <i class="fa-solid fa-bus"></i>
      <h3>Frota Ativa</h3>
      <p>Controle e monitore veículos em operação.</p>
    </div>

    <div class="card">
      <i class="fa-solid fa-user-tie"></i>
      <h3>Motoristas</h3>
      <p>Verifique perfis e qualificações.</p>
    </div>

    <div class="card">
      <i class="fa-solid fa-route"></i>
      <h3>Rotas</h3>
      <p>Planeje e otimize trajetos escolares.</p>
    </div>
  </section>
</div>

</body>
</html>
