<?php
require_once 'conexao_gowey.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $veiculo_id = $_POST['veiculo_id'];

    $stmt = $pdo->prepare("DELETE FROM veiculos WHERE id = ?");
    $stmt->execute([$veiculo_id]);

    header("Location: autocarros_cadastrados.php?deletado=1");
    exit;
}
?>
