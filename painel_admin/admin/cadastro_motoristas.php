<?php
session_start();
require_once 'conexao_gowey.php';

if (!isset($_SESSION['escola_id'])) {
    header("Location: login_escola.php");
    exit;
}

$escola_id = $_SESSION['escola_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $carteira = $_POST['carteira']; // no BD está como 'carteira'

    // Verifica se email já existe
    $checkEmail = $pdo->prepare("SELECT COUNT(*) FROM motoristas WHERE email = ?");
    $checkEmail->execute([$email]);
    $emailExiste = $checkEmail->fetchColumn();

    if ($emailExiste > 0) {
        header("Location: cadastro_motoristas.php?erro_email=1");
        exit;
    }

    // Verifica se carteira (CNH) já existe
    $checkCarteira = $pdo->prepare("SELECT COUNT(*) FROM motoristas WHERE carteira = ?");
    $checkCarteira->execute([$carteira]);
    $carteiraExiste = $checkCarteira->fetchColumn();

    if ($carteiraExiste > 0) {
        header("Location: cadastro_motoristas.php?erro_carteira=1");
        exit;
    }

    // Inserir motorista
    $stmt = $pdo->prepare("INSERT INTO motoristas (nome, telefone, email, carteira, escola_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$nome, $telefone, $email, $carteira, $escola_id]);

    header("Location: perfil_motoristas.php?sucesso=1");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastrar Motorista</title>
  <link rel="stylesheet" href="cadastro_motoristas.css">
</head>
<body>
  <div class="form-container">
    <h1>Cadastro de Motoristas</h1>
    <?php if (!empty($mensagem)) echo "<p class='sucesso'>$mensagem</p>"; ?>
    <?php if (isset($_GET['erro_email']) && $_GET['erro_email'] == 1): ?>
  <div class="alert error"> Este email já está cadastrado!</div>
<?php endif; ?>

<?php if (isset($_GET['erro_carteira']) && $_GET['erro_carteira'] == 1): ?>
  <div class="alert error">Dados já cadastrados!</div>
<?php endif; ?>

    <form method="POST">
      <div class="form-group">
        <label for="nome">Nome Completo</label>
        <input type="text" id="nome" name="nome" pattern="[A-Za-zÀ-ÿ\s]+"  required>
      </div>
      <div class="form-group">
        <label for="telefone">Telefone</label>
        <input type="number" id="telefone" name="telefone" required 
              pattern="\d{9}" maxlength="9" minlength="9" 
              oninput="this.value=this.value.replace(/[^0-9]/g,'')" 
              placeholder="Ex: 923456789">
      <small class="info">Digite apenas números (9 dígitos)</small>
      </div>
      <div class="form-group">
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="cnh">Número da CNH(Carteira Nacional de Habilitação)</label>
        <input type="text" id="cnh" name="carteira" required>
      </div>
      <button type="submit" class="btn">Cadastrar</button>
    </form>
  </div>
  <!-- Bloqueia o input nome de inserir numero-->
<script>
  const inputNome = document.getElementById("nome");

  inputNome.addEventListener("input", function() {
    this.value = this.value.replace(/[^A-Za-zÀ-ÿ\s]/g, '');
  });
</script>
</body>
</html>
