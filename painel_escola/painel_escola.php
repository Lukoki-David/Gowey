<?php
session_start();
require_once __DIR__ . '/../config/boot.php';

// Verificar autenticação
if (!isset($_SESSION['escola_id'])) {
    header('Location: ' . BASE_URL . '/painel_escola/Login/login_escola.php');
    exit;
}

$escola_id = (int) $_SESSION['escola_id'];

// Obter dados da escola
$stmt = $pdo->prepare('SELECT * FROM escolas WHERE id = ? LIMIT 1');
$stmt->execute([$escola_id]);
$escola = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$escola) {
    session_destroy();
    header('Location: login_escola.php');
    exit;
}

// Estatísticas reais da escola
$stmt = $pdo->prepare('SELECT COUNT(*) FROM veiculos WHERE escola_id = ?');
$stmt->execute([$escola_id]);
$total_autocarros = (int) $stmt->fetchColumn();

$stmt = $pdo->prepare('SELECT COUNT(*) FROM alunos WHERE escola_id = ?');
$stmt->execute([$escola_id]);
$total_alunos = (int) $stmt->fetchColumn();

$stmt = $pdo->prepare('SELECT COUNT(*) FROM motoristas WHERE escola_id = ?');
$stmt->execute([$escola_id]);
$total_motoristas = (int) $stmt->fetchColumn();

// Se a tabela/coluna de alertas corresponder ao esquema existente
try {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM alertas WHERE escola_id = ? AND status = 'pendente'");
    $stmt->execute([$escola_id]);
    $total_alertas = (int) $stmt->fetchColumn();
} catch (PDOException $e) {
    $total_alertas = 0;
}

$nome_escola = $escola['nome'] ?? 'Minha escola';
$responsavel = $escola['responsavel'] ?? 'Não informado';
$email_escola = $escola['email'] ?? 'Não informado';
$telefone_escola = $escola['telefone'] ?? 'Não informado';
$numero_processo = $escola['numero_processo'] ?? 'Não informado';
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel da Escola | GoWey School</title>
    <link rel="stylesheet" href="painel_escola.css">
    <link rel="icon" type="image/png" href="resimension.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
</head>
<body>
<div class="dashboard-container">
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <aside class="sidebar" id="sidebar">
        <a class="brand" href="painel_escola.php" aria-label="GoWey School - início">
            <span class="brand-mark"><i class="fa-solid fa-bus-simple"></i></span>
            <span><strong>GoWey</strong><small> SCHOOL</small></span>
        </a>

        <div class="nav-caption">MENU PRINCIPAL</div>
        <nav class="sidebar-nav">
            <a class="nav-link active" href="painel_escola.php"><i class="fa-solid fa-chart-pie"></i><span>Painel</span></a>
            <a class="nav-link" href="cadastro_autocarros.php"><i class="fa-solid fa-bus"></i><span>Cadastrar autocarros</span></a>
            <a class="nav-link" href="autocarros_cadastrados.php"><i class="fa-solid fa-van-shuttle"></i><span>Autocarros</span></a>
            <a class="nav-link" href="cadastro_motoristas.php"><i class="fa-solid fa-user-tie"></i><span>Cadastrar motoristas</span></a>
            <a class="nav-link" href="perfil_motoristas.php"><i class="fa-solid fa-id-card"></i><span>Motoristas</span></a>
            <a class="nav-link" href="#" title="Configure a página de rotas"><i class="fa-solid fa-route"></i><span>Rotas</span></a>
            <a class="nav-link" href="cadastro_alunos.php"><i class="fa-solid fa-user-plus"></i><span>Cadastrar alunos</span></a>
            <a class="nav-link" href="alunos_cadastrados.php"><i class="fa-solid fa-users"></i><span>Alunos</span></a>
            <a class="nav-link" href="relatorios_escola.php"><i class="fa-solid fa-chart-column"></i><span>Relatórios</span></a>
        </nav>

        <div class="sidebar-bottom">
            <div class="sidebar-help">
                <span class="help-icon"><i class="fa-regular fa-circle-question"></i></span>
                <div><strong>Precisa de ajuda?</strong><small>Contacte o suporte GoWey.</small></div>
                <i class="fa-solid fa-chevron-right"></i>
            </div>
            <a class="nav-link logout" href="gowey.php"><i class="fa-solid fa-arrow-right-from-bracket"></i><span>Sair</span></a>
        </div>
    </aside>

    <main class="main-content">
        <header class="topbar">
            <button class="menu-toggle" id="menuToggle" aria-label="Abrir menu" aria-expanded="false"><i class="fa-solid fa-bars"></i></button>
            <div class="topbar-title">
                <span class="eyebrow">ÁREA ADMINISTRATIVA</span>
                <h1>Painel da escola</h1>
            </div>
            <div class="topbar-right">
                <span class="today-date"><i class="fa-regular fa-calendar"></i> <span id="currentDate"></span></span>
                <div class="school-avatar"><i class="fa-solid fa-school"></i></div>
            </div>
        </header>

        <section class="welcome-row">
            <div>
                <p class="welcome-label">BEM-VINDA(O) AO GOWEY SCHOOL</p>
                <h2><?= htmlspecialchars($nome_escola, ENT_QUOTES, 'UTF-8') ?></h2>
                <p class="welcome-subtitle">Acompanhe os recursos e a organização do transporte escolar num só lugar.</p>
            </div>
            <a class="primary-action" href="relatorios_escola.php"><i class="fa-solid fa-file-lines"></i> Ver relatórios</a>
        </section>

        <section class="stats-grid" aria-label="Resumo da escola">
            <article class="stat-card">
                <div class="stat-icon blue"><i class="fa-solid fa-bus"></i></div>
                <div class="stat-info"><p>Autocarros</p><strong><?= $total_autocarros ?></strong><span>Registados na escola</span></div>
                <div class="stat-decoration"><i class="fa-solid fa-bus-simple"></i></div>
            </article>
            <article class="stat-card">
                <div class="stat-icon violet"><i class="fa-solid fa-user-graduate"></i></div>
                <div class="stat-info"><p>Alunos</p><strong><?= $total_alunos ?></strong><span>Alunos cadastrados</span></div>
                <div class="stat-decoration"><i class="fa-solid fa-users"></i></div>
            </article>
            <article class="stat-card">
                <div class="stat-icon cyan"><i class="fa-solid fa-id-card"></i></div>
                <div class="stat-info"><p>Motoristas</p><strong><?= $total_motoristas ?></strong><span>Registados na escola</span></div>
                <div class="stat-decoration"><i class="fa-solid fa-user-tie"></i></div>
            </article>
            <article class="stat-card">
                <div class="stat-icon orange"><i class="fa-solid fa-bell"></i></div>
                <div class="stat-info"><p>Alertas pendentes</p><strong><?= $total_alertas ?></strong><span>Por acompanhar</span></div>
                <div class="stat-decoration"><i class="fa-solid fa-triangle-exclamation"></i></div>
            </article>
        </section>

        <section class="map-section">
            <div class="section-heading">
                <div>
                    <span class="section-kicker">LOCALIZAÇÃO E PERCURSOS</span>
                    <h2>Monitoramento de rotas</h2>
                    <p>Visualize a área geográfica das operações de transporte escolar.</p>
                </div>
                <span class="map-status"><span class="status-dot"></span> Mapa disponível</span>
            </div>
            <div class="map-card">
                <div id="routeMap" role="application" aria-label="Mapa de monitoramento de rotas"></div>
                <div class="map-note" id="mapNote"><i class="fa-solid fa-circle-info"></i> As rotas e posições reais aparecerão quando forem ligadas ao sistema de GPS e às coordenadas registadas.</div>
            </div>
        </section>

        <section class="bottom-grid">
            <article class="content-card school-details">
                <div class="card-heading">
                    <div class="heading-icon"><i class="fa-solid fa-school"></i></div>
                    <div><h2>Informações da escola</h2><p>Dados associados à sua conta</p></div>
                </div>
                <div class="details-list">
                    <div class="detail-row"><span class="detail-icon"><i class="fa-solid fa-user"></i></span><div><small>Responsável</small><strong><?= htmlspecialchars($responsavel, ENT_QUOTES, 'UTF-8') ?></strong></div></div>
                    <div class="detail-row"><span class="detail-icon"><i class="fa-regular fa-envelope"></i></span><div><small>E-mail</small><strong><?= htmlspecialchars($email_escola, ENT_QUOTES, 'UTF-8') ?></strong></div></div>
                    <div class="detail-row"><span class="detail-icon"><i class="fa-solid fa-phone"></i></span><div><small>Telefone</small><strong><?= htmlspecialchars($telefone_escola, ENT_QUOTES, 'UTF-8') ?></strong></div></div>
                    <div class="detail-row"><span class="detail-icon"><i class="fa-regular fa-id-card"></i></span><div><small>Número de processo</small><strong><?= htmlspecialchars($numero_processo, ENT_QUOTES, 'UTF-8') ?></strong></div></div>
                </div>
            </article>

            <article class="content-card quick-access">
                <div class="card-heading">
                    <div class="heading-icon"><i class="fa-solid fa-bolt"></i></div>
                    <div><h2>Acesso rápido</h2><p>Acções frequentes</p></div>
                </div>
                <div class="quick-links">
                    <a href="cadastro_alunos.php"><span class="quick-icon"><i class="fa-solid fa-user-plus"></i></span><span><strong>Cadastrar aluno</strong><small>Adicionar aluno à escola</small></span><i class="fa-solid fa-chevron-right arrow"></i></a>
                    <a href="cadastro_motoristas.php"><span class="quick-icon"><i class="fa-solid fa-user-tie"></i></span><span><strong>Cadastrar motorista</strong><small>Registar um motorista</small></span><i class="fa-solid fa-chevron-right arrow"></i></a>
                    <a href="cadastro_autocarros.php"><span class="quick-icon"><i class="fa-solid fa-bus"></i></span><span><strong>Cadastrar autocarro</strong><small>Adicionar um veículo</small></span><i class="fa-solid fa-chevron-right arrow"></i></a>
                    <a href="relatorios_escola.php"><span class="quick-icon"><i class="fa-solid fa-chart-column"></i></span><span><strong>Consultar relatórios</strong><small>Ver dados e resultados</small></span><i class="fa-solid fa-chevron-right arrow"></i></a>
                </div>
            </article>
        </section>

        <footer class="page-footer">
            <span>© <?= date('Y') ?> GoWey School</span>
            <span>Transporte escolar inteligente</span>
        </footer>
    </main>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    // Menu responsivo
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    function closeSidebar() {
        sidebar.classList.remove('active');
        sidebarOverlay.classList.remove('active');
        menuToggle.setAttribute('aria-expanded', 'false');
    }

    menuToggle.addEventListener('click', () => {
        const isOpen = sidebar.classList.toggle('active');
        sidebarOverlay.classList.toggle('active', isOpen);
        menuToggle.setAttribute('aria-expanded', String(isOpen));
    });
    sidebarOverlay.addEventListener('click', closeSidebar);

    // Data atual em português
    document.getElementById('currentDate').textContent =
        new Intl.DateTimeFormat('pt-PT', { day: '2-digit', month: 'short', year: 'numeric' }).format(new Date());

    // Mapa base centrado em Luanda. Não inventa rotas ou posições de veículos.
    if (window.L) {
        const map = L.map('routeMap', { scrollWheelZoom: false }).setView([-8.8383, 13.2344], 11);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright" target="_blank" rel="noopener">OpenStreetMap</a>',
            maxZoom: 19
        }).addTo(map);

        L.marker([-8.8383, 13.2344]).addTo(map)
            .bindPopup('<strong>Luanda</strong><br>Área inicial de visualização do mapa.');

        setTimeout(() => map.invalidateSize(), 250);
        window.addEventListener('resize', () => map.invalidateSize());
    } else {
        document.getElementById('routeMap').innerHTML =
            '<div class="map-fallback">Não foi possível carregar o mapa. Verifique a ligação à Internet.</div>';
    }
</script>
</body>
</html>
