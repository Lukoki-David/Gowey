<?php
session_start();

// Verifica se admin está logado
if (!isset($_SESSION['admin'])) {
    header("Location: loguinadmin.php"); // redireciona para login se não estiver logado
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<title>Dashboard Admin - GoWey</title>
<style>
body {
  font-family: 'Segoe UI', sans-serif;
  background: #f5f7fa;
  margin: 0;
  padding: 0;
}
header {
  background: #002b80;
  color: #fff;
  padding: 15px;
  text-align: center;
}
.container {
  padding: 20px;
}
.card {
  background: #fff;
  padding: 20px;
  margin-bottom: 20px;
  border-radius: 8px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
.logout {
  display: inline-block;
  padding: 10px 15px;
  background: #00bfff;
  color: #fff;
  text-decoration: none;
  border-radius: 6px;
}
.logout:hover {
  background: #ff4d4d;
}
</style>
</head>
<body>

<header>
  <h1>Dashboard GoWey</h1>
  <p>Bem-vindo, <?php echo $_SESSION['admin']; ?>!</p>
  <a href="logout.php" class="logout">Sair</a>
</header>

<div class="container">
  <div class="card">
    <h2>Gerenciar Escolas</h2>
    <p>Cadastrar, editar e visualizar escolas conectadas.</p>
  </div>
  <div class="card">
    <h2>Gerenciar Motoristas</h2>
    <p>Controle perfis e qualificações dos motoristas.</p>
  </div>
  <div class="card">
    <h2>Gerenciar Rotas</h2>
    <p>Planeje e otimize trajetos escolares.</p>
  </div>
</div>

</body>
</html>
