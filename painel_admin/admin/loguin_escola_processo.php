<?php
session_start();
require_once 'conexao_gowey.php';

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
        header("Location: painel_escola.php?id=" . $user['escola_id']);
        exit;
    } else {
        header("Location: login_escola.php?erro=Email ou senha incorretos!");
        exit;
    }
}
?>
