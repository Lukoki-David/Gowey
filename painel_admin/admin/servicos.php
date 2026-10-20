<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Serviços - GoWey</title>
  <link rel="stylesheet" href="servicos.css">
  <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body>

  <!-- Cabeçalho -->
  <header class="header">
    <div class="container">
    <h1 class="logo">Go<span>Wey</span></h1>
      <nav class="nav" id="navMenu">
        <ul>
          <li><a href="gowey.php" class="inicio">Início</a></li>
          <li><a href="servicos.php" class="active">Serviços</a></li>
          <li><a href="contato.php">Contato</a></li>
        </ul>
      </nav>
        <div class="menu-toggle" id="menu-toggle">
      <i class="fa fa-bars"></i>
    </div>
      <!-- Botão hamburguer -->
      <button class="hamburger"  id="hamburgerBtn">
        <i class="fas fa-bars"></i>
</button>
    </div>
  </header>

  <!-- Hero -->
  <section class="hero">
    <div class="hero-text">
      <h2>Serviços Inteligentes GoWey</h2>
      <p>Segurança, eficiência e inovação no transporte escolar</p>
    </div>
  </section>

  <!-- Serviços -->
  <section class="servicos">
    <div class="container">
      <h2>Nossos Serviços</h2>
      <p class="intro">O GoWey oferece soluções modernas para escolas, motoristas e encarregados.</p>

      <div class="grid">
        <div class="card">
          <i class="fas fa-route"></i>
          <h3>Rotas Predefinidas</h3>
          <p>Motoristas recebem rotas otimizadas e seguras.</p>
        </div>

        <div class="card">
          <i class="fas fa-map-marker-alt"></i>
          <h3>Monitoramento em Tempo Real</h3>
          <p>Pais e escolas acompanham o trajeto via GPS.</p>
        </div>

        <div class="card">
          <i class="fas fa-bell"></i>
          <h3>Notificações Automáticas</h3>
          <p>Alertas instantâneos de embarque e desembarque.</p>
        </div>

        <div class="card">
          <i class="fas fa-user-shield"></i>
          <h3>Segurança Integrada</h3>
          <p>Motoristas verificados e dados protegidos.</p>
        </div>

        <div class="card">
          <i class="fas fa-school"></i>
          <h3>Gestão Escolar</h3>
          <p>Dashboard com relatórios e comunicação direta.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Rodapé -->
  <footer class="footer">
    <p>&copy; 2026 GoWey - Transporte Escolar Inteligente</p>
  </footer>

  <!-- Script para menu responsivo -->
  <script>
    const hamburgerBtn = document.getElementById('hamburgerBtn');
    const navMenu = document.getElementById('navMenu');

    hamburgerBtn.addEventListener('click', () => {
      navMenu.classList.toggle('active');
    });
  </script>

</body>
</html>
