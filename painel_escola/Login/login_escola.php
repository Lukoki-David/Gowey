<?php
require_once __DIR__ . '/../../config/boot.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ? AND role = 'escola'");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($senha, $user['senha'])) {
        // Guardar dados na sessão
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['escola_id'] = $user['escola_id'];
        $_SESSION['nome_escola'] = $user['nome'];

        // Redirecionar para o painel específico
        header("Location:". BASE_URL ." /painel_escola/painel_escola.php?id=" . $user['escola_id']);
        exit;
    } else {
        header("Location: ". BASE_URL ." login_escola.php?erro=Email ou senha incorretos!");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GOWEY to School | Login</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/painel_escola/Login/login_escola.css">
    <link rel="icon" type="image/png"  href="resimension.png">

</head>
<body>
  
   <main>
    <div class="principal">
    </div>
        
            <div class="container">
                <h1>GO<span>WEY</span> For School <br> Minha Conta!</h1>
                <form  method="post">
                <input type="email" name="email" placeholder="Nome da Instituição" required>
                 <input type="password" name="senha" placeholder="Senha" required>
                <button type="submit">Entrar</button>
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
                <p>Esqueceu a senha? <a href="#">Recuperar</a></p>
            </div>
            
        
   </main>
</body>
</html>