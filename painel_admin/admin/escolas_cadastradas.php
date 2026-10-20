<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Escolas Cadastradas - GoWey</title>
<link rel="icon" type="image/png"  href="resimension.png">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="./escolas_cadastradas.css">
</head>
<body>

<div class="container">
  <h2><i class="fa-solid fa-school"></i> Escolas Cadastradas</h2>
  <?php if (isset($_GET['sucesso'])): ?>
    <div class="alert success"><?= htmlspecialchars($_GET['sucesso']) ?></div>
     <style>
.alert.success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
    padding: 10px;
    margin: 15px 0;
    border-radius: 5px;
    text-align: center;
    font-weight: bold;
    animation: fadeIn 0.8s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

</style>
<?php endif; ?>
<!-- Mostra escola deletada com sucesso na tela -->
<div id="mensagem" style="display:none;"></div>
<style>
  .alert {
    padding: 10px;
    margin: 10px 0;
    border-radius: 5px;
    text-align: center;
    font-weight: bold;
    animation: fadeIn 0.5s ease-in-out;
}

.alert.success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert.error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

</style>
  <div class="table-container">
    <table id="schoolTable">
      <thead>
        <tr>
          <th>Nome</th>
          <th>Endereço</th>
          <th>Nº telefone</th>
          <th>Nº Processo</th>
          <th>Email</th>
          <th>Responsável</th>
          <th>Alunos</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <!-- Dados serão carregados aqui -->
      </tbody>
    </table>
  </div>
</div>

<script src="./escolas_cadastradas.js"></script>

</body>
</html>
