<?php
session_start();
require_once 'conexao_gowey.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    // Buscar usuário pelo email
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($senha, $user['senha'])) {
        // Criar sessão
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['escola_id'] = $user['escola_id'];

        // Redirecionar conforme o papel
        if ($user['role'] === 'admin') {
            header("Location: dashboard_admin.php");
        } elseif ($user['role'] === 'escola') {
            header("Location: login_escola.php?id=" . $user['escola_id']);
        } 
        exit;
    } else {
        header("Location: loguinadmin.php?erro=Email ou senha incorretos!");
    }
}
?>

