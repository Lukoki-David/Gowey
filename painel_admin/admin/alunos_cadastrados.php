<?php
session_start();
require_once 'conexao_gowey.php';

if (!isset($_SESSION['escola_id'])) {
    header("Location: login_escola.php");
    exit;
}

$escola_id = $_SESSION['escola_id'];

// Buscar alunos com JOIN para motorista e autocarro
$stmt = $pdo->prepare("
    SELECT a.id, a.nome, a.idade, a.classe, a.turma, a.endereco, a.numero_processo, a.foto,
           m.nome AS motorista_nome,
           v.modelo AS veiculo_modelo, v.placa AS veiculo_placa
    FROM alunos a
    LEFT JOIN motoristas m ON a.motorista_id = m.id
    LEFT JOIN veiculos v ON a.veiculo_id = v.id
    WHERE a.escola_id = ?
");
$stmt->execute([$escola_id]);
$alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Alunos Cadastrados</title>
  
  <link rel="stylesheet" href="alunos_cadastrados.css">
</head>
<body>
  <div class="container">
    <h1> Alunos Cadastrados</h1>
     <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] == 1): ?>
  <div class="alert success">
    <?php if (isset($_GET['sucesso_excluir'])): ?>
  <div class="alert success">Aluno excluído com sucesso!</div>
<?php elseif (isset($_GET['erro_excluir'])): ?>
  <div class="alert error"> Erro ao excluir: <?= htmlspecialchars($_GET['erro_excluir']) ?></div>
<?php endif; ?>

     Aluno cadastrado com sucesso!
  </div>
<?php endif; ?>
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
        <?php foreach ($alunos as $a): ?>
          <tr onclick="mostrarPerfil(<?= $a['id'] ?>)">
            <td><?= htmlspecialchars($a['nome']) ?></td>
            <td><?= htmlspecialchars($a['classe']) ?></td>
            <td><?= htmlspecialchars($a['turma']) ?></td>
            <td><?= htmlspecialchars($a['endereco']) ?></td>
            <td><?= htmlspecialchars($a['numero_processo']) ?></td>
            <td><?= htmlspecialchars($a['motorista_nome'] ?? 'Não atribuído') ?></td>
            <td><?= htmlspecialchars($a['veiculo_placa'] ?? '-') ?></td>
           <td> <a href="deletar_aluno.php?id=<?= $a['id'] ?>"  class="btn-excluir" 
                 onclick="return confirm('Tem certeza que deseja excluir este aluno?')">Excluir</a></td>
          </tr>

          <!-- Modal de perfil -->
          <div class="modal" id="perfil-<?= $a['id'] ?>">
            <div class="modal-content">
              <span class="close" onclick="fecharPerfil(<?= $a['id'] ?>)">&times;</span>
             <img src="<?= htmlspecialchars($a['foto'] ?: 'uploads/default.png') ?>" alt="Foto do aluno" class="perfil-foto">
              <h2><?= htmlspecialchars($a['nome']) ?></h2>
              <p><strong>Classe:</strong> <?= htmlspecialchars($a['classe']) ?></p>
              <p><strong>Turma:</strong> <?= htmlspecialchars($a['turma']) ?></p>
              <p><strong>Idade:</strong> <?= htmlspecialchars($a['idade']) ?></p>
              <p><strong>Endereço:</strong> <?= htmlspecialchars($a['endereco']) ?></p>
              <p><strong>Número de Processo:</strong> <?= htmlspecialchars($a['numero_processo']) ?></p>
              <p><strong>Motorista Responsável:</strong> <?= htmlspecialchars($a['motorista_nome'] ?? 'Não atribuído') ?></p>
              <p><strong>Autocarro:</strong> <?= htmlspecialchars($a['veiculo_modelo'] ?? '-') ?> - <?= htmlspecialchars($a['veiculo_placa'] ?? '-') ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <script>
    function mostrarPerfil(id) {
      document.getElementById('perfil-' + id).style.display = 'block';
    }
    function fecharPerfil(id) {
      document.getElementById('perfil-' + id).style.display = 'none';
    }
  </script>
</body>
</html>
