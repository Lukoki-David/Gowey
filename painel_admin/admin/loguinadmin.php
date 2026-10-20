<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>GoWey For School | Login Admin</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="icon" type="image/png"  href="resimension.png">
<link rel="stylesheet" href="../admin/loguinadmin.css">

</head>
<body>

<div class="login-container">
  <div class="logo"><i class="fa-solid fa-shield-halved"></i> GoWey Admin</div>
  <form id="loginForm" action="loguin.php" method="post">
    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" placeholder="admin@gowey.co.ao" required>
    </div>
    <div class="form-group">
      <label for="senha">Senha</label>
      <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
    </div>
    <button type="submit" class="btn-login">Entrar</button>
     <!-- Mensagem de erro -->
  <?php if (isset($_GET['erro'])): ?>
    <div class="alert error"> <?= htmlspecialchars($_GET['erro']) ?></div>
     <style>
.alert.error { background-color: #f8d7da;
  color: #721c24;
  border: 1px solid #c6f5c8;
  padding: 10px;
  margin-top: 10px;
  border-radius: 5px;
  text-align: center;
  font-weight: bold; }
</style>

  <?php endif; ?>
  </form>
   <!--<div class="extra">
    <a href="#">Esqueceu a senha?</a>
  </div>-->

</div>



</body>
</html>
