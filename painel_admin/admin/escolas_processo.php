<?php
require_once 'conexao_gowey.php'; 

try {
    // Prepara e executa a consulta
    $stmt = $pdo->prepare("SELECT * FROM escolas ORDER BY id DESC");
    $stmt->execute();

    // Busca todos os registros como array associativo
    $escolas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retorna em formato JSON
    echo json_encode($escolas);

} catch (PDOException $e) {
    // Caso ocorra erro, retorna mensagem clara
    echo json_encode([
        "erro" => "Falha ao listar escolas: " . $e->getMessage()
    ]);
}
?>
