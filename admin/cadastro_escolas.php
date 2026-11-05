<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cadastrar Escola - GoWey</title>
<link rel="icon" type="image/png"  href="./resimension.png">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="cadastro_escolas.css">
</head>
<body>

<div class="form-container">
  <h2><i class="fa-solid fa-school"></i> Cadastrar Escola</h2>
    <?php if (isset($_GET['erro'])): ?>
    <div class="alert error"> <?= htmlspecialchars($_GET['erro']) ?></div>

  <?php endif; ?>
  <?php if (isset($_GET['erro_telefone']) && $_GET['erro_telefone'] == 1): ?>
  <div class="alert error"> O telefone deve conter exatamente 9 dígitos numéricos!</div>
<?php endif; ?>
<?php if (isset($_GET['erro_processo']) && $_GET['erro_processo'] == 1): ?>
  <div class="alert error">
     Este número de processo já está cadastrado!</div>
<?php endif; ?>

  <form id="schoolForm" action="./cadastro_escolas_processo.php" method="post">
    <div class="form-group">
      <label for="nome">Nome da Escola</label>
      <input type="text" id="nome" name="nome" placeholder="Digite o nome da escola" pattern="[A-Za-zÀ-ÿ\s]+"  required>
    </div>

    <div class="form-group">
      <label for="endereco">Endereço</label>
      <input type="text" id="endereco" name="endereco" placeholder="Digite o endereço completo" required>
    </div>

    <div class="form-group">
      <label for="numero_processo">Nº De Processo</label>
      <input type="text" id="Numero_processo" name="numero_processo" placeholder="112233 ..." required>
    </div>

    <div class="form-group">
      <label for="email">Email Institucional</label>
      <input type="email" id="email" name="email" placeholder="exemplo@escola.com" required>
    </div>

    <div class="form-group">
      <label for="responsavel">Responsável</label>
      <input type="text" id="responsavel" name="responsavel" placeholder="Nome do responsável" required>
    </div>

    <div class="form-group">
      <label for="numero_aluno">Número de Alunos</label>
      <input type="number" id="alunos" name="numero_aluno" placeholder="Digite o número de alunos" required>
    </div>
    <div class="form-group">
      <label for="telefone">Número de Telefone</label>
      <input type="number" id="tel" name="telefone" placeholder="Digite o o terminal Institucional" required
              pattern="\d{9}" maxlength="9" minlength="9" 
              oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,9)"  >
      <small class="info">Digite apenas números (9 dígitos)</small>>
    </div>
    <div class="form-group">
      <label for="SENHA">Senha</label>
      <input type="password" id="senha" name="senha" placeholder="Digite a senha" required>
    </div>

    <button type="submit" class="btn-submit">Cadastrar Escola</button>
  </form>
</div>
<input type="text" id="nome" name="nome" placeholder="Digite apenas letras" required>

<!-- Bloqueia o input nome de inserir numero-->
<script>
  const inputNome = document.getElementById("nome");

  inputNome.addEventListener("input", function() {
    this.value = this.value.replace(/[^A-Za-zÀ-ÿ\s]/g, '');
  });

</script>

</body>
</html>
