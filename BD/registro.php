<?php
require 'conexao.php';

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $hash = password_hash($senha, PASSWORD_BCRYPT);

        $stmt = $pdo->prepare("INSERT INTO admins (email, senha) VALUES (?, ?)");
        $stmt->execute([$email, $hash]);

        echo "Admin cadastrado com sucesso!";
    }
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>