<?php
session_start();
require_once 'conexao_gowey.php';

if (!isset($_SESSION['escola_id'])) {
    header('Location: login_escola.php');
    exit;
}
$escola_id = (int) $_SESSION['escola_id'];

// Indicadores básicos: os valores vêm das tabelas existentes.
function contarRegistos(PDO $pdo, string $sql, int $escola_id): int {
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$escola_id]);
        return (int) $stmt->fetchColumn();
    } catch (PDOException $e) {
        // Se uma tabela/coluna tiver outro nome no projecto, mostrar 0 sem quebrar a página.
        return 0;
    }
}
$totalAlunos = contarRegistos($pdo, 'SELECT COUNT(*) FROM alunos WHERE escola_id = ?', $escola_id);
$totalMotoristas = contarRegistos($pdo, 'SELECT COUNT(*) FROM motoristas WHERE escola_id = ?', $escola_id);
$totalVeiculos = contarRegistos($pdo, 'SELECT COUNT(*) FROM veiculos WHERE escola_id = ?', $escola_id);
$totalRotas = contarRegistos($pdo, 'SELECT COUNT(*) FROM rotas WHERE escola_id = ?', $escola_id);

$tipo = trim($_GET['tipo'] ?? 'alunos');
$pesquisa = trim($_GET['pesquisa'] ?? '');
$classe = trim($_GET['classe'] ?? '');

// Relatório de alunos: usa as colunas conhecidas no projecto.
$rows = [];
$headers = [];
$reportTitle = 'Relatório de alunos';
$reportDescription = 'Lista de alunos cadastrados e respectivas atribuições.';

if ($tipo === 'alunos') {
    $headers = ['Nome', 'Processo', 'Classe', 'Turma', 'Endereço', 'Motorista', 'Autocarro'];
    $sql = "SELECT a.nome, a.numero_processo, a.classe, a.turma, a.endereco,
                   m.nome AS motorista, v.modelo AS modelo, v.placa AS placa
            FROM alunos a
            LEFT JOIN motoristas m ON a.motorista_id = m.id
            LEFT JOIN veiculos v ON a.veiculo_id = v.id
            WHERE a.escola_id = ?";
    $params = [$escola_id];
    if ($pesquisa !== '') {
        $sql .= " AND (a.nome LIKE ? OR CAST(a.numero_processo AS CHAR) LIKE ?)";
        $params[] = '%' . $pesquisa . '%';
        $params[] = '%' . $pesquisa . '%';
    }
    if ($classe !== '') {
        $sql .= " AND a.classe = ?";
        $params[] = $classe;
    }
    $sql .= ' ORDER BY a.nome ASC';
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $r) {
            $rows[] = [
                $r['nome'] ?? '', $r['numero_processo'] ?? '', $r['classe'] ?? '',
                $r['turma'] ?? '', $r['endereco'] ?? '', $r['motorista'] ?? 'Não atribuído',
                trim(($r['modelo'] ?? '') . ' ' . ($r['placa'] ?? '')) ?: 'Não atribuído'
            ];
        }
    } catch (PDOException $e) {
        $errorMessage = 'Não foi possível carregar o relatório. Confirma os nomes das tabelas e colunas na base de dados.';
    }
} else {
    // Outras categorias são apresentadas como estrutura de relatório; ligue-as às tabelas
    // correspondentes quando os campos reais estiverem definidos no projecto.
    $reportMap = [
        'motoristas' => ['Relatório de motoristas', 'Motoristas, estado e atribuições.'],
        'autocarros' => ['Relatório de autocarros', 'Veículos, matrícula, capacidade e estado.'],
        'rotas' => ['Relatório de rotas', 'Rotas, motoristas, veículos e alunos atribuídos.'],
        'transporte' => ['Relatório de presenças e transporte', 'Embarques, desembarques e registos de transporte.'],
        'ocorrencias' => ['Relatório de alertas e ocorrências', 'Alertas, atrasos e ocorrências registadas.'],
    ];
    if (isset($reportMap[$tipo])) {
        [$reportTitle, $reportDescription] = $reportMap[$tipo];
    } else {
        $tipo = 'alunos';
    }
    $headers = ['Informação', 'Estado'];
    $rows = [['Este relatório precisa de ser ligado à tabela correspondente do projecto.', 'Configuração necessária']];
}
function h($value): string { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Relatórios | GoWey School</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="relatorios_escola.css">
</head>
<body>
<div class="layout">
  <aside class="sidebar">
    <div class="brand">GoWey School</div>
    <nav class="nav">
      <a href="painel_escola.php"><i class="fa-solid fa-gauge"></i> Painel</a>
      <a href="autocarros.php"><i class="fa-solid fa-bus"></i> Autocarros</a>
      <a href="motoristas.php"><i class="fa-solid fa-user-tie"></i> Motoristas</a>
      <a href="rotas.php"><i class="fa-solid fa-route"></i> Rotas</a>
      <a href="alunos_cadastrados.php"><i class="fa-solid fa-users"></i> Alunos</a>
      <a class="active" href="relatorios_escola.php"><i class="fa-solid fa-chart-column"></i> Relatórios</a>
    </nav>
  </aside>
  <main class="main">
    <header class="topbar">
      <div><h1>Relatórios da Escola</h1><div class="school">GoWey School · Gestão e análise do transporte escolar</div></div>
      <a class="btn btn-light" href="painel_escola.php"><i class="fa-solid fa-arrow-left"></i> Voltar ao painel</a>
    </header>
    <p class="intro">Consulta os dados da escola, acompanha as atribuições e organiza os registos do transporte escolar. Selecciona uma categoria para gerar o relatório correspondente.</p>

    <section class="stats">
      <div class="stat"><div class="stat-icon"><i class="fa-solid fa-users"></i></div><div><strong><?= $totalAlunos ?></strong><span>Alunos cadastrados</span></div></div>
      <div class="stat"><div class="stat-icon"><i class="fa-solid fa-user-tie"></i></div><div><strong><?= $totalMotoristas ?></strong><span>Motoristas cadastrados</span></div></div>
      <div class="stat"><div class="stat-icon"><i class="fa-solid fa-bus"></i></div><div><strong><?= $totalVeiculos ?></strong><span>Autocarros cadastrados</span></div></div>
      <div class="stat"><div class="stat-icon"><i class="fa-solid fa-route"></i></div><div><strong><?= $totalRotas ?></strong><span>Rotas cadastradas</span></div></div>
    </section>

    <h2 class="section-title">Categorias de relatório</h2>
    <section class="report-grid">
      <?php
      $cards = [
        'alunos'=>['fa-users','Alunos','Lista, classe, turma, processo e atribuições.'],
        'motoristas'=>['fa-user-tie','Motoristas','Motoristas e respectivas atribuições.'],
        'autocarros'=>['fa-bus','Autocarros','Veículos, matrícula e estado.'],
        'rotas'=>['fa-route','Rotas','Rotas, alunos, motorista e autocarro.'],
        'transporte'=>['fa-calendar-check','Presenças e transporte','Registos de embarque e desembarque.'],
        'ocorrencias'=>['fa-triangle-exclamation','Alertas e ocorrências','Atrasos, alertas e ocorrências registadas.'],
      ];
      foreach ($cards as $key=>$card):
      ?>
      <a class="report-card <?= $tipo === $key ? 'selected' : '' ?>" href="?tipo=<?= h($key) ?>">
        <div class="ico"><i class="fa-solid <?= h($card[0]) ?>"></i></div>
        <h3><?= h($card[1]) ?></h3><p><?= h($card[2]) ?></p>
      </a>
      <?php endforeach; ?>
    </section>

    <section class="filters">
      <h2><i class="fa-solid fa-sliders"></i> Filtros do relatório</h2>
      <form class="filter-form" method="GET" action="relatorios_escola.php">
        <div class="field"><label for="tipo">Tipo de relatório</label><select name="tipo" id="tipo">
          <?php foreach ($cards as $key=>$card): ?><option value="<?= h($key) ?>" <?= $tipo===$key?'selected':'' ?>><?= h($card[1]) ?></option><?php endforeach; ?>
        </select></div>
        <div class="field"><label for="pesquisa">Pesquisar aluno</label><input id="pesquisa" name="pesquisa" value="<?= h($pesquisa) ?>" placeholder="Nome ou número de processo"></div>
        <div class="field"><label for="classe">Classe (alunos)</label><input id="classe" name="classe" value="<?= h($classe) ?>" placeholder="Ex.: 12ª"></div>
        <button class="btn btn-primary" type="submit"><i class="fa-solid fa-magnifying-glass"></i> Pesquisar</button>
      </form>
    </section>

    <section class="results">
      <div class="results-head"><div><h2><?= h($reportTitle) ?></h2><div class="school"><?= h($reportDescription) ?></div></div>
        <div class="export"><button class="btn btn-light" type="button" onclick="window.print()"><i class="fa-solid fa-file-pdf"></i> Imprimir / PDF</button><button class="btn btn-green" type="button" onclick="exportarCSV()"><i class="fa-solid fa-file-excel"></i> Exportar CSV</button></div>
      </div>
      <?php if (!empty($errorMessage ?? '')): ?><div class="alert"><?= h($errorMessage) ?></div><?php endif; ?>
      <div class="table-wrap"><table id="reportTable"><thead><tr><?php foreach ($headers as $header): ?><th><?= h($header) ?></th><?php endforeach; ?></tr></thead><tbody>
      <?php if (!$rows): ?><tr><td class="empty" colspan="<?= count($headers) ?>">Nenhum registo encontrado para os filtros seleccionados.</td></tr>
      <?php else: foreach ($rows as $row): ?><tr><?php foreach ($row as $cell): ?><td><?= h($cell) ?></td><?php endforeach; ?></tr><?php endforeach; endif; ?>
      </tbody></table></div>
      <div class="note">Total de registos apresentados: <strong><?= count($rows) ?></strong>. Os relatórios de presenças, transporte e ocorrências precisam de registos próprios no sistema para apresentar dados reais.</div>
    </section>
    <div class="footer">GoWey School · Relatórios administrativos</div>
  </main>
</div>
<script>
function exportarCSV(){
  const table=document.getElementById('reportTable');
  const rows=[...table.querySelectorAll('tr')].map(tr=>[...tr.querySelectorAll('th,td')].map(cell=>'"'+cell.innerText.replace(/"/g,'""').trim()+'"').join(';'));
  const csv='\uFEFF'+rows.join('\r\n');
  const blob=new Blob([csv],{type:'text/csv;charset=utf-8;'});
  const url=URL.createObjectURL(blob);const link=document.createElement('a');
  link.href=url;link.download='relatorio_gowey.csv';document.body.appendChild(link);link.click();link.remove();URL.revokeObjectURL(url);
}
</script>
</body>
</html>
