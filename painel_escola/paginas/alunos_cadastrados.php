<?php
session_start();

require_once 'conexao_gowey.php';

// Verificar se a escola está autenticada
if (!isset($_SESSION['escola_id'])) {
    header("Location: login_escola.php");
    exit;
}

// Identificar a escola
$escola_id = (int) $_SESSION['escola_id'];

// Receber a pesquisa por GET ou POST para manter a pesquisa visível após ações.
$pesquisa = trim($_GET['pesquisa'] ?? $_POST['pesquisa'] ?? '');

// Consulta principal: alunos + motorista + veículo
$sql = "
    SELECT
        a.id,
        a.nome,
        a.idade,
        a.classe,
        a.turma,
        a.endereco,
        a.numero_processo,
        a.foto,
        m.nome AS motorista_nome,
        v.modelo AS veiculo_modelo,
        v.placa AS veiculo_placa
    FROM alunos a
    LEFT JOIN motoristas m ON a.motorista_id = m.id
    LEFT JOIN veiculos v ON a.veiculo_id = v.id
    WHERE a.escola_id = ?
";
$params = [$escola_id];

if ($pesquisa !== '') {
    $sql .= "
        AND (
            a.nome LIKE ?
            OR CAST(a.numero_processo AS CHAR) LIKE ?
        )
    ";
    $params[] = "%" . $pesquisa . "%";
    $params[] = "%" . $pesquisa . "%";
}

$sql .= " ORDER BY a.nome ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total_resultados = count($alunos);

function h($valor): string {
    return htmlspecialchars((string)($valor ?? ''), ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Alunos Cadastrados | GoWey</title>
  <link rel="stylesheet" href="alunos_cadastrados.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    /* Estilos locais dos botões e mensagens, sem substituir o CSS atual da página. */
    .acoes-aluno { display:flex; align-items:center; gap:8px; flex-wrap:wrap; }
    .btn-editar, .btn-excluir { display:inline-flex; align-items:center; justify-content:center; gap:6px; padding:8px 11px; border:0; border-radius:7px; text-decoration:none; font-size:13px; font-weight:600; white-space:nowrap; cursor:pointer; }
    .btn-editar { background:#e8efff; color:#002b80; }
    .btn-editar:hover { background:#002b80; color:#fff; }
    .btn-excluir { background:#fff0f0; color:#b42318; }
    .btn-excluir:hover { background:#b42318; color:#fff; }
    .alert { margin:15px 0; padding:12px 16px; border-radius:9px; }
    .alert.success { background:#eaf8ef; color:#176b35; }
    .alert.error { background:#fff0f0; color:#a51d1d; }
    .linha-vazia { text-align:center; padding:24px; color:#68758a; }
    /* Evita que os cliques nos botões abram o modal de perfil da linha. */
    .acoes-aluno a { position:relative; z-index:2; }
  </style>
</head>
<body>
  <div class="container">
    <h1>Alunos Cadastrados</h1>

    <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] === '1'): ?>
      <div class="alert success">Aluno cadastrado com sucesso!</div>
    <?php endif; ?>

    <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] === 'aluno_editado'): ?>
      <div class="alert success"><i class="fa-solid fa-circle-check"></i> Dados do aluno atualizados com sucesso!</div>
    <?php endif; ?>

    <?php if (isset($_GET['sucesso_excluir'])): ?>
      <div class="alert success">Aluno excluído com sucesso!</div>
    <?php endif; ?>

    <?php if (isset($_GET['erro_excluir'])): ?>
      <div class="alert error">Erro ao excluir: <?= h($_GET['erro_excluir']) ?></div>
    <?php endif; ?>

    <!-- Barra de pesquisa -->
    <div class="pesquisa-container">
      <form action="alunos_cadastrados.php" method="GET" class="form-pesquisa">
        <div class="pesquisa-input">
          <input
            type="text"
            name="pesquisa"
            placeholder="Pesquisar por nome ou número de processo..."
            value="<?= h($pesquisa) ?>">
        </div>
        <button type="submit" class="btn-pesquisar">
          <i class="fas fa-search"></i> Pesquisar
        </button>
        <?php if ($pesquisa !== ''): ?>
          <a href="alunos_cadastrados.php" class="btn-limpar-pesquisa">Limpar</a>
        <?php endif; ?>
      </form>
    </div>

    <p class="totalAlunos" >Total de alunos encontrados: <strong><?= (int)$total_resultados ?></strong></p>

    <table>
      <thead>
        <tr>
          <th>Nome</th>
          <th>Classe</th>
          <th>Turma</th>
          <th>Endereço</th>
          <th>Nº Processo</th>
          <th>Motorista</th>
          <th>Autocarro</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!$alunos): ?>
          <tr><td colspan="8" class="linha-vazia">Nenhum aluno encontrado.</td></tr>
        <?php else: ?>
          <?php foreach ($alunos as $a): ?>
            <tr onclick="mostrarPerfil(<?= (int)$a['id'] ?>)">
              <td><?= h($a['nome']) ?></td>
              <td><?= h($a['classe']) ?></td>
              <td><?= h($a['turma']) ?></td>
              <td><?= h($a['endereco']) ?></td>
              <td><?= h($a['numero_processo']) ?></td>
              <td><?= h($a['motorista_nome'] ?? 'Não atribuído') ?></td>
              <td><?= h($a['veiculo_placa'] ?? '-') ?></td>
              <td>
                <div class="acoes-aluno" onclick="event.stopPropagation()">
                  <a
                    href="editar_aluno.php?id=<?= (int)$a['id'] ?>"
                    class="btn-editar"
                    title="Editar os dados deste aluno">
                    <i class="fa-solid fa-pen-to-square"></i> Editar
                  </a>
                  <a
                    href="deletar_aluno.php?id=<?= (int)$a['id'] ?>"
                    class="btn-excluir"
                    onclick="return confirm('Tem certeza que deseja excluir este aluno?')">
                    <i class="fa-solid fa-trash"></i> Excluir
                  </a>
                </div>
              </td>
            </tr>

            <!-- Modal de perfil do aluno -->
            <div class="modal" id="perfil-<?= (int)$a['id'] ?>">
              <div class="modal-content">
                <span class="close" onclick="fecharPerfil(<?= (int)$a['id'] ?>)">&times;</span>
                <img src="<?= h($a['foto'] ?: 'uploads/default.png') ?>" alt="Foto do aluno" class="perfil-foto">
                <h2><?= h($a['nome']) ?></h2>
                <p><strong>Classe:</strong> <?= h($a['classe']) ?></p>
                <p><strong>Turma:</strong> <?= h($a['turma']) ?></p>
                <p><strong>Idade:</strong> <?= h($a['idade']) ?></p>
                <p><strong>Endereço:</strong> <?= h($a['endereco']) ?></p>
                <p><strong>Número de Processo:</strong> <?= h($a['numero_processo']) ?></p>
                <p><strong>Motorista Responsável:</strong> <?= h($a['motorista_nome'] ?? 'Não atribuído') ?></p>
                <p><strong>Autocarro:</strong> <?= h($a['veiculo_modelo'] ?? '-') ?> - <?= h($a['veiculo_placa'] ?? '-') ?></p>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <script>
    function mostrarPerfil(id) {
      const perfil = document.getElementById('perfil-' + id);
      if (perfil) perfil.style.display = 'block';
    }
    function fecharPerfil(id) {
      const perfil = document.getElementById('perfil-' + id);
      if (perfil) perfil.style.display = 'none';
    }

    // Fechar o modal ao clicar fora do conteúdo.
    document.querySelectorAll('.modal').forEach(function(modal) {
      modal.addEventListener('click', function(event) {
        if (event.target === modal) modal.style.display = 'none';
      });
    });
  </script>
</body>
</html>
