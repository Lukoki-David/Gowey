<?php
require_once 'conexao_gowey.php';

try {
    // Dados do admin inicial
    $nome = "Administrador Geral";
    $email = "admin@gowey.com";
    $senha = "Admin321"; // define uma senha forte

    // Criptografar senha
    $hash = password_hash($senha, PASSWORD_BCRYPT);

    // Inserir admin na tabela usuarios
    $stmt = $pdo->prepare("INSERT INTO usuarios (nome,email,senha,role) VALUES (?,?,?,?)");
    $stmt->execute([$nome,$email,$hash,"admin"]);

    echo "Admin cadastrado com sucesso!";
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>
