
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

