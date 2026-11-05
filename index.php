<?php
require_once __DIR__ . '/config/boot.php';
?>
<!DOCTYPE html>
<html lang="pt"> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/gowey.css">
     <link rel="preconnect" href="https://fonts.googleapis.com">
     <link rel="icon" type="image/png"  href="<?= BASE_URL ?>../imagens/resimension.png">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <!-- Fonte Awesome-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <title>GoWey</title>
</head>
<body>
      <!-- NAVEGAÇÃO -->
  <header class="navbar">
    <div class="container nav-content">

      <a href="#inicio" class="logo" aria-label="GoWey - página inicial">
        <span class="logo-icon">
          <i class="fa-solid fa-bus-simple"></i>
        </span>
       <p>Go<strong>Wey</strong></p>
      </a>

      <button class="menu-toggle"
              id="menuToggle"
              aria-label="Abrir menu"
              aria-expanded="false"
              aria-controls="navLinks">
        <i class="fa-solid fa-bars"></i>
      </button>

      <nav class="nav-links" id="navLinks" aria-label="Navegação principal">
        <a href="#inicio">Início</a>
        <a href="#sobre" class="active">Sobre Nós</a>
        <a href="#funcionalidades">Funcionalidades</a>
        <a href="#escolas">Para Escolas</a>
        <a href="#seguranca">Segurança</a>
        <a href="<?= BASE_URL ?>../painel_escola/Login/login_escola.php" class="enter">Entrar</a>
        <a href="#contacto" class="nav-cta">Contactar-nos</a>
      </nav>
          
      <button
       class="theme-toggle"
       id="themeToggle"
       type="button"
       aria-label="Ativar modo escuro"
       aria-pressed="false"
       title="Alternar modo claro e escuro">
       <i class="fa-solid fa-moon" aria-hidden="true"></i>
  </button>

    </div>
  </header>

    <main>
        <!-- Layout Principal -->
        <section class="inicio" id="inicio">
            <div class="container cont-grid">
                <div class="inicio-info secao">
                    <span class="subtema">
                       <i class="fa-solid fa-location-dot"></i>
                      Mobilidade escolar inteligente
                     </span>

                     <h1>O futuro do transporte escolar é
                    <span>seguro e conectado.</span></h1>

                    <p class="inicio-text">
                     O GoWey conecta pais, escolas e motoristas através de um sitema 
                     digital que torna o transporte escolar mais seguro,
                    transparente, organizado e eficiente.</p>
                   
                <div class="inicio-btn">
                     <a href="#funcionalidades" class="btn btn-primeiro">
                     Conhecer o sistema<i class="fa-solid fa-arrow-right"></i></a>

                     <a href="#sobre" class="btn btn-segundo">
                     <i class="fa-solid fa-circle-info"></i>
                     Sobre o GoWey</a> 
                    </div>

                     <div class="nota">
                    <i class="fa-solid fa-shield-halved"></i>
                    Tecnologia ao serviço da segurança escolar.</div> 

                </div>
                <div class="inicio-design secao">
                     <div class="inicio-circulo"></div>
                    <img class="inicio-art"
                     src="<?= BASE_URL ?>../imagens/fundocontactogowey.png"
                         alt="Ambiente educativo representando o universo escolar"
                         onerror="this.style.display='none'">

                     <div class="flutuante-card flutuante-one">
                      <i class="fa-solid fa-shield-halved"></i>
                        <div>
                            <strong>Segurança</strong>
                             <small>Em cada viagem</small>
                        </div>
                     </div>

                     <div class="flutuante-card flutuante-two">
                     <i class="fa-solid fa-location-crosshairs"></i>
                        <div>
                        <strong>Localização GPS</strong>
                        <small>Acompanhamento do trajeto</small>
                        </div>
                     </div>
                 </div>
            
            </div>
        </section>

        <!-- Itens -->
        <section class="itens">
            <div class="container itens-cont">
                <div class="item-card">
                <i class="fa-solid fa-shield-halved"></i>
                    <div>
                     <strong>Segurança</strong>
                     <span>Proteção em primeiro lugar</span>
                    </div>
                </div>
                <div class="item-card">
                <i class="fa-solid fa-eye"></i>
                    <div>
                      <strong>Transparência</strong>
                      <span>Informação acessível</span>
                    </div>
                </div>
                <div class="item-card">
                <i class="fa-solid fa-bolt"></i>
                    <div>
                     <strong>Eficiência</strong>
                     <span>Gestão simplificada</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- SOBRE NÓS -->
         <section class="section" id="sobre">
            <div class="container sobre-grid">
                <div class="sobre-design secao">
                    <i class="fa-solid fa-route big-icon"></i>
                    <div>
                         <h3>Mais confiança em cada percurso.</h3>
                        <p>Uma solução que aproxima famílias, instituições de ensino
                        e profissionais do transporte escolar.</p>
                    </div>
                </div>
                
                <div class="sobre-info secao">
                    <span class="subtema">Quem somos</span>
                    <h2>Conheça o GoWey</h2>
                    <p>O GoWey é uma plataforma digital de mobilidade escolar inteligente
                    concebida para modernizar a forma como o transporte de alunos
                    é organizado, acompanhado e gerido.</p>

                    <p>Através de uma experiência conectada, reunimos pais, escolas e
                    motoristas num único ecossistema, facilitando o acompanhamento
                    das viagens, a comunicação entre os intervenientes e a gestão
                    das operações diárias.</p>

                    <p>A nossa proposta é tornar o transporte escolar mais organizado
                    e transparente, oferecendo ferramentas digitais que apoiam
                    a tomada de decisões e reforçam a confiança das famílias.</p>

                    <ul class="check-list">
                        <li>
                            <i class="fa-solid fa-circle-check"></i>
                            <span>Ligação entre pais, escolas e motoristas.</span>
                        </li>
                        <li>
                            <i class="fa-solid fa-circle-check"></i>
                            <span>Acompanhamento digital das viagens escolares.</span>
                        </li>
                        <li>
                         <i class="fa-solid fa-circle-check"></i>
                         <span>Organização centralizada de rotas e informações.</span>
                        </li>
                    </ul>
                </div>                  
                
            </div>
         </section>

         <!-- APLICAÇÃO DOS PAIS -->
          <section class="section funcionalidades" id="funcionalidades">
                <div class="container">
                     <div class="function-tema secao">
                    <span class="subtema">Aplicação móvel</span>
                    <h2>O controlo que os pais precisam</h2>
                    <p>O aplicativo GoWey aproxima os pais do percurso escolar dos
                    seus filhos, permitindo acompanhar informações importantes
                    e comunicar com os responsáveis pelo transporte.</p>
                    </div>

                <div class="function-grid">
                    <article class="function-card secao">
                        <div class="function-icon">
                        <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <h3>Rastreamento em tempo real</h3>
                        <p>Consulte a localização e acompanhe o trajeto do veículo
                        através da tecnologia GPS, quando disponível.</p>
                    </article>

                    <article class="function-card secao">
                        <div class="function-icon">
                        <i class="fa-solid fa-bell"></i>
                        </div>
                        <h3>Notificações automáticas</h3>
                        <p>Receba alertas sobre embarques, desembarques e proximidade
                        do veículo, conforme a configuração do serviço.</p>
                    </article>

                    <article class="function-card secao">
                        <div class="function-icon">
                        <i class="fa-solid fa-comments"></i>
                        </div>
                        <h3>Comunicação direta</h3>
                        <p>Facilite o contacto com o motorista ou com a escola
                        através dos canais de comunicação da plataforma.</p>
                    </article>

                    <article class="function-card secao">
                        <div class="function-icon">
                        <i class="fa-solid fa-calendar-check"></i>
                        </div>
                        <h3>Agendamento inteligente</h3>
                        <p>Organize viagens únicas ou recorrentes e programe
                        deslocações escolares com antecedência.</p>
                    </article>

                    <article class="function-card secao">
                        <div class="function-icon">
                        <i class="fa-solid fa-calendar-xmark"></i>
                        </div>
                        <h3>Gestão de ausências</h3>
                        <p>Informe quando o aluno não utilizará o transporte,
                        ajudando a melhorar o planeamento das rotas.</p>
                    </article>

                    <article class="function-card secao">
                        <div class="function-icon">
                        <i class="fa-solid fa-wallet"></i>
                        </div>
                        <h3>Pagamentos transparentes</h3>
                        <p>Consulte os valores cobrados e o histórico de pagamentos
                        disponibilizado pelo serviço de transporte.</p>
                    </article>

                  </div>
                  
                </div>
          </section>

        <!-- DASHBOARD DAS ESCOLAS -->
         <section class="section" id="escolas">
            <div class="container dashboard-grid" id="escolas">
            <div class="dashboard-content secao">
                            <span class="eyebrow">Painel administrativo</span>
                            <h2>Uma gestão escolar mais inteligente</h2>
                            <p>O dashboard GoWey foi pensado para apoiar a administração
                            escolar na organização do transporte, na gestão dos alunos
                            e na comunicação com as famílias.</p>

                      <div class="dashboard-list">
                        <div class="dashboard-item">
                        <div class="dash-icon">
                        <i class="fa-solid fa-bus"></i>
                        </div>
                        <div>
                            <h3>Monitorização da frota</h3>
                            <p>Consulte a informação dos veículos e acompanhe as rotas
                            através dos dados disponibilizados pelo sistema.</p>
                        </div>
                    </div>

                    <div class="dashboard-item">
                        <div class="dash-icon">
                        <i class="fa-solid fa-users"></i>
                        </div>
                        <div>
                        <h3>Gestão de alunos e rotas</h3>
                        <p>Organize registos, horários, listas de alunos e pontos
                        de embarque numa área administrativa centralizada.</p>
                        </div>
                    </div>

                    <div class="dashboard-item">
                        <div class="dash-icon">
                        <i class="fa-solid fa-chart-column"></i>
                        </div>
                        <div>
                        <h3>Relatórios e histórico</h3>
                        <p>Consulte os registos de viagens e os indicadores
                        operacionais disponibilizados pela plataforma.</p>
                        </div>
                    </div>

                    <div class="dashboard-item">
                        <div class="dash-icon">
                        <i class="fa-solid fa-id-card"></i>
                        </div>
                        <div>
                        <h3>Gestão de motoristas</h3>
                        <p>Organize os dados dos motoristas e os respetivos
                        processos de verificação e credenciamento.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Painel demonstrativo do dashboard -->
        <div class="dashboard-visual secao">
          <div class="dashboard-top">
            <h3><i class="fa-solid fa-gauge-high"></i> Painel GoWey</h3>
            <span class="live-status">Visão geral</span>
          </div>

          <div class="dashboard-status">

            <div class="status">
              <i class="fa-solid fa-users"></i>
              <strong><i class="fa-solid fa-chart-line"></i></strong>
              <span>Gestão de alunos</span>
            </div>

            <div class="status">
              <i class="fa-solid fa-bus-simple"></i>
              <strong><i class="fa-solid fa-route"></i></strong>
              <span>Gestão de rotas</span>
            </div>

            <div class="status">
              <i class="fa-solid fa-clock"></i>
              <strong><i class="fa-solid fa-calendar-days"></i></strong>
              <span>Horários escolares</span>
            </div>

            <div class="status">
              <i class="fa-solid fa-file-lines"></i>
              <strong><i class="fa-solid fa-chart-pie"></i></strong>
              <span>Relatórios</span>
            </div>

          </div>

          <div class="status-info">
            <h3><i class="fa-solid fa-route"></i> Organização do transporte</h3>

            <div class="status-text">
              <i class="fa-solid fa-circle-check"></i>
              Gestão dos registos dos alunos
            </div>

            <div class="status-text">
              <i class="fa-solid fa-location-dot"></i>
              Organização dos pontos de embarque
            </div>

            <div class="status-text">
              <i class="fa-solid fa-bus"></i>
              Acompanhamento das rotas
            </div>
          </div>
        </div>

            </div>
         </section>

        <!-- SEGURANÇA -->
        <section class="section security" id="seguranca">
         <div class="container">

            <div class="function-tema secao">
                <span class="subtema">Proteção e confiança</span>
                <h2>A segurança é uma prioridade</h2>
                <p>O GoWey foi concebido para apoiar um transporte escolar
                mais responsável, através da organização dos intervenientes,
                da gestão da informação e de mecanismos de acompanhamento.</p>
             </div>

            <div class="security-grid">
                <article class="security-card secao">
                    <i class="fa-solid fa-user-shield"></i>
                    <h3>Motoristas verificados</h3>
                    <p>Gestão de informações, identificação e processos de
                    credenciamento dos profissionais associados ao serviço.</p>
                </article>

                <article class="security-card secao">
                    <i class="fa-solid fa-lock"></i>
                    <h3>Proteção de dados</h3>
                    <p>A proteção das informações deve ser apoiada por medidas
                    técnicas e organizacionais adequadas, incluindo controlo
                    de acesso e encriptação quando implementada.</p>
                </article>

                <article class="security-card secao">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <h3>Alertas e acompanhamento</h3>
                    <p>Possibilidade de apoiar a comunicação de ocorrências
                    e situações importantes, de acordo com as funcionalidades
                    e os procedimentos configurados.</p>
                </article>

            </div>
      </div>
    </section>

        <!-- BENEFÍCIOS -->
    <section class="section section-light" id="beneficios">
      <div class="container">

        <div class="beneficios-tema reveal">
          <span class="subtema">Porquê escolher o GoWey?</span>
          <h2>Uma solução para todos os intervenientes</h2>
          <p>
            A tecnologia aproxima as pessoas e simplifica tarefas
            importantes da rotina do transporte escolar.
          </p>
        </div>

        <div class="beneficios-grid">

          <article class="beneficios-card secao">
            <i class="fa-solid fa-clock"></i>
            <h3>Mais eficiência</h3>
            <p>
              Simplifica tarefas administrativas e ajuda a organizar
              melhor o tempo e os recursos.
            </p>
          </article>

          <article class="beneficios-card secao">
            <i class="fa-solid fa-handshake"></i>
            <h3>Mais confiança</h3>
            <p>
              Melhora a partilha de informações entre as famílias,
              as escolas e os responsáveis pelo transporte.
            </p>
          </article>

          <article class="beneficios-card secao">
            <i class="fa-solid fa-comments"></i>
            <h3>Melhor comunicação</h3>
            <p>
              Centraliza os canais de contacto e facilita a
              transmissão de informações relevantes.
            </p>
          </article>

          <article class="beneficios-card secao">
            <i class="fa-solid fa-mobile-screen-button"></i>
            <h3>Experiência digital</h3>
            <p>
              Disponibiliza ferramentas modernas para tornar a
              gestão do transporte mais prática e organizada.
            </p>
          </article>

        </div>
      </div>
    </section>

    <!-- CHAMADA FINAL -->
    <section class="cta-section" id="contacto">
      <div class="container">
        <div class="cta-box secao">
          <h2>Vamos transformar o transporte escolar?</h2>

          <p>
            Descubra como o GoWey pode ajudar a conectar famílias,
            escolas e motoristas numa experiência de mobilidade
            escolar mais organizada e inteligente.
          </p>

          <a href="mailto:contacto@gowey.ao" class="btn btn-yellow">
            Falar com a equipa
            <i class="fa-solid fa-arrow-right"></i>
          </a>
        </div>
      </div>
    </section>

      <!-- RODAPÉ -->
  <footer class="footer">
    <div class="container">

      <div class="footer-grid">

        <div>
          <a href="#inicio" class="logo">
            <span class="logo-icon">
              <i class="fa-solid fa-bus-simple"></i>
            </span>
            GoWey
          </a>

          <p class="footer-about">
            Mobilidade escolar inteligente e segura.
            Ligamos pais, escolas e motoristas através da tecnologia,
            promovendo uma gestão mais organizada do transporte escolar.
          </p>
        </div>

        <div>
          <h3>Navegação</h3>
          <ul class="footer-links">
            <li><a href="#inicio">Início</a></li>
            <li><a href="#sobre">Sobre Nós</a></li>
            <li><a href="#funcionalidades">Funcionalidades</a></li>
            <li><a href="#escolas">Para Escolas</a></li>
          </ul>
        </div>

        <div>
          <h3>Informações</h3>
          <ul class="footer-links">
            <li><a href="#contacto">App: GoWey</a></li>
            <li><a href="#">Site: www.gowey.com</a></li>
            <li><a href="#">Tel: 923014572</a></li>
            <li><a href="#">Email: gowey@sistema.ao</a></li>
            
          </ul>
        </div>
        <div>
          <h3>Links Rápidos</h3>
          <ul class="footer-links">
            <li><a href="<?= BASE_URL ?>../admin/login.php">Entrar Como Admin</a></li>
            <li><a href="#beneficios">Benefícios</a></li>
            <li><a href="#contacto">Contactos</a></li>
            <li><a href="#contacto">Política De Privacidade</a></li>
          </ul>
        </div>

      </div>

      <div class="footer-bottom">
        <span>
          &copy; <span id="currentYear"></span> GoWey.
          Todos os direitos reservados.
          <p class="ld">@Lukoki David</p>
        </span>

        <span>Mobilidade escolar inteligente. </span>
      </div>

    </div>
  </footer>
    </main>
 <script>
    // Menu responsivo
    const menuToggle = document.getElementById('menuToggle');
    const navLinks = document.getElementById('navLinks');
    const menuIcon = menuToggle.querySelector('i');

    menuToggle.addEventListener('click', () => {
      const isOpen = navLinks.classList.toggle('open');

      menuToggle.setAttribute('aria-expanded', String(isOpen));
      menuToggle.setAttribute(
        'aria-label',
        isOpen ? 'Fechar menu' : 'Abrir menu'
      );

      menuIcon.className = isOpen
        ? 'fa-solid fa-xmark'
        : 'fa-solid fa-bars';
    });

    // Fechar o menu depois de clicar num link
    navLinks.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', () => {
        navLinks.classList.remove('open');
        menuToggle.setAttribute('aria-expanded', 'false');
        menuToggle.setAttribute('aria-label', 'Abrir menu');
        menuIcon.className = 'fa-solid fa-bars';
      });
    });

    // Ano automático no rodapé
    document.getElementById('currentYear').textContent =
      new Date().getFullYear();

    // Animações ao entrar no ecrã
    const revealElements = document.querySelectorAll('.secao');

    if ('IntersectionObserver' in window) {
      const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            obs.unobserve(entry.target);
          }
        });
      }, {
        threshold: 0.12
      });

      revealElements.forEach(element => observer.observe(element));
    } else {
      revealElements.forEach(element => element.classList.add('visible'));
    }


    
/* =========================================
   GOWEY — MODO CLARO E MODO ESCURO
   ========================================= */

const themeToggle = document.getElementById('themeToggle');
const themeIcon = themeToggle.querySelector('i');
const root = document.documentElement;

// Aplicar o tema e atualizar o botão
function applyTheme(theme) {
  const isDark = theme === 'dark';

  root.setAttribute('data-theme', isDark ? 'dark' : 'light');

  themeIcon.className = isDark
    ? 'fa-solid fa-sun'
    : 'fa-solid fa-moon';

  themeToggle.setAttribute(
    'aria-label',
    isDark ? 'Ativar modo claro' : 'Ativar modo escuro'
  );

  themeToggle.setAttribute(
    'aria-pressed',
    String(isDark)
  );

  themeToggle.title = isDark
    ? 'Mudar para modo claro'
    : 'Mudar para modo escuro';
}

// Recuperar a preferência guardada
let savedTheme = 'light';

try {
  savedTheme = localStorage.getItem('gowey-theme') || 'light';
} catch (error) {
  // O site continua a funcionar sem guardar a preferência.
}

if (savedTheme !== 'dark' && savedTheme !== 'light') {
  savedTheme = 'light';
}

applyTheme(savedTheme);

// Alternar entre os dois modos
themeToggle.addEventListener('click', () => {
  const isDark = root.getAttribute('data-theme') === 'dark';
  const newTheme = isDark ? 'light' : 'dark';

  applyTheme(newTheme);

  try {
    localStorage.setItem('gowey-theme', newTheme);
  } catch (error) {
    // A mudança de tema continua a funcionar.
  }
});

  </script>
</body>
</html>