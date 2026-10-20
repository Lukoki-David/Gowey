<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GOWEY to School | Login</title>
    <link rel="stylesheet" href="../admin/login_escola.css">
    <link rel="icon" type="image/png"  href="resimension.png">

</head>
<body>
  
   <main>
    <div class="principal">
    </div>
        
            <div class="container">
                <h1>GO<span>WEY</span> For School <br> Minha Conta!</h1>
                <form action="../admin/loguin_escola_processo.php" method="post">
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