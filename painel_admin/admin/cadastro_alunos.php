<?php
session_start();
require_once 'conexao_gowey.php';

if (!isset($_SESSION['escola_id'])) {
    header("Location: login_escola.php");
    exit;
}

$escola_id = $_SESSION['escola_id'];

// Buscar motoristas e autocarros da escola
$stmtMotoristas = $pdo->prepare("SELECT id, nome FROM motoristas WHERE escola_id = ?");
$stmtMotoristas->execute([$escola_id]);
$motoristas = $stmtMotoristas->fetchAll(PDO::FETCH_ASSOC);

$stmtVeiculos = $pdo->prepare("SELECT id, modelo, placa, motorista_id FROM veiculos WHERE escola_id = ?");
$stmtVeiculos->execute([$escola_id]);
$veiculos = $stmtVeiculos->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $idade = $_POST['idade'];
    $classe = $_POST['classe'];
    $turma = $_POST['turma'];
    $endereco = $_POST['endereco'];
    $numero_processo = $_POST['numero_processo'];
    $motorista_id = $_POST['motorista_id'];
    $veiculo_id = $_POST['veiculo_id'];

    // Verifica duplicidade de número de processo
    $check = $pdo->prepare("SELECT COUNT(*) FROM alunos WHERE numero_processo = ?");
    $check->execute([$numero_processo]);
    $existe = $check->fetchColumn();

    if ($existe > 0) {
        header("Location: cadastro_alunos.php?erro_processo=1");
        exit;
    }
    // Diretório de upload
    $diretorio = "uploads/alunos/";

   if (!empty($_FILES['foto']['name'])) {
    $diretorio = "uploads/alunos/";
    if (!is_dir($diretorio)) {
        mkdir($diretorio, 0777, true);
    }

    $foto_nome = $_FILES['foto']['name'];
    $foto_tmp = $_FILES['foto']['tmp_name'];
    $extensao = strtolower(pathinfo($foto_nome, PATHINFO_EXTENSION));
    $permitidas = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($extensao, $permitidas)) {
        $novo_nome = uniqid('aluno_') . '.' . $extensao;
        $caminho_final = $diretorio . $novo_nome;
        move_uploaded_file($foto_tmp, $caminho_final);
    } else {
        $caminho_final = null;
    }
} else {
    $caminho_final = null;
}
    // Inserir aluno no banco
    $stmt = $pdo->prepare("INSERT INTO alunos (nome, idade, classe, turma, endereco, numero_processo, escola_id, motorista_id, veiculo_id, foto)
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->execute([$nome, $idade, $classe, $turma, $endereco, $numero_processo, $escola_id, $motorista_id, $veiculo_id, $caminho_final]);

    header("Location: alunos_cadastrados.php?sucesso=1");
    exit;

}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastrar Aluno</title>
  <link rel="stylesheet" href="cadastro_alunos.css">
</head>
<body>
  <div class="form-container">
    <h1>Cadastro de Alunos</h1>

    <?php if (isset($_GET['erro_processo']) && $_GET['erro_processo'] == 1): ?>
      <div class="alert error">Este número de processo já está cadastrado!</div>
    <?php endif; ?>
        <?php if (isset($_GET['erro_foto']) && $_GET['erro_foto'] == 1): ?>
  <div class="alert error"> Formato de imagem inválido! Use JPG, PNG ou GIF.</div>
<?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
         <div class="form-group">
    <label for="foto">Foto do Aluno</label>
    <input type="file" id="foto" name="foto" accept="image/*" required>
  </div>
      <div class="form-group">
        <label for="nome">Nome do Aluno</label>
        <input type="text" id="nome" name="nome" required pattern="[A-Za-zÀ-ÿ\s]+" title="Somente letras são permitidas" placeholder="Digite o nome do aluno">
      </div>

      <div class="form-group">
        <label for="idade">Idade</label>
        <input type="number" id="idade" name="idade" required min="3" max="25" placeholder="Ex: 12">
      </div>
            <div class="form-group">
  <label for="classe">Classe</label>
  <select id="classe" name="classe" required>
    <option value="">Selecione a classe</option>
    <option value="10ª">10ª Classe</option>
    <option value="11ª">11ª Classe</option>
    <option value="12ª">12ª Classe</option>
  </select>
</div>

<div class="form-group">
  <label for="turma">Turma</label>
  <input type="text" id="turma" name="turma" required pattern="[A-Za-z0-9\s]+" title="Somente letras e números">
</div>

      <div class="form-group">
        <label for="endereco">Endereço</label>
        <input type="text" id="endereco" name="endereco" required placeholder="Ex: Cacuaco, Rua 12">
      </div>

      <div class="form-group">
        <label for="numero_processo">Número de Processo</label>
        <input type="text" id="numero_processo" name="numero_processo" required pattern="\d+" title="Somente números são permitidos" placeholder="Ex: 956540109">
      </div>

      <div class="form-group">
        <label for="motorista_id">Motorista Responsável</label>
        <select id="motorista_id" name="motorista_id" required>
          <option value="">Selecione o motorista</option>
          <?php foreach ($motoristas as $m): ?>
            <option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['nome']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group">
        <label for="veiculo_id">Autocarro</label>
        <select id="veiculo_id" name="veiculo_id" required>
          <option value="">Selecione o autocarro</option>
         
        </select>
      </div>

      <button type="submit" class="btn">Cadastrar Aluno</button>
    </form>
  </div>

    <!-- Bloqueia o input nome de inserir numero-->
<script>
  const inputNome = document.getElementById("nome");

  inputNome.addEventListener("input", function() {
    this.value = this.value.replace(/[^A-Za-zÀ-ÿ\s]/g, '');
  });

  // Lista de autocarros vindos do PHP
const veiculos = <?= json_encode($veiculos) ?>;

document.getElementById("motorista_id").addEventListener("change", function() {
  const motoristaId = this.value;
  const veiculoSelect = document.getElementById("veiculo_id");

  // Limpa opções anteriores
  veiculoSelect.innerHTML = '<option value="">Selecione o autocarro</option>';

  // Filtra apenas autocarros do motorista selecionado
  veiculos.forEach(v => {
    if (v.motorista_id == motoristaId) {
      const opt = document.createElement("option");
      opt.value = v.id;
      opt.textContent = v.modelo + " - " + v.placa;
      veiculoSelect.appendChild(opt);
    }
  });
});
</script>

</body>
</html>
