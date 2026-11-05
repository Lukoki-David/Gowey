<?php
require_once 'conexao_gowey.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $motorista_id = $_POST['motorista_id'];

    // Deleta motorista do banco
    $stmt = $pdo->prepare("DELETE FROM motoristas WHERE id = ?");
    $stmt->execute([$motorista_id]);

    // Redireciona com mensagem de sucesso
    header("Location: perfil_motoristas.php?deletado=1");
    exit;
}
?>
