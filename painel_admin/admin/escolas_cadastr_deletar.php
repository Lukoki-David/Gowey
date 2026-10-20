<?php
require_once 'conexao_gowey.php';

header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    try {
        // Excluir usuário vinculado
        $delUser = $pdo->prepare("DELETE FROM usuarios WHERE escola_id = ?");
        $delUser->execute([$id]);

        // Excluir escola
        $delSchool = $pdo->prepare("DELETE FROM escolas WHERE id = ?");
        $delSchool->execute([$id]);

        echo json_encode(["status" => "success", "message" => "Escola deletada com sucesso!"]);
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Erro ao excluir: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "ID inválido."]);
}
?>
