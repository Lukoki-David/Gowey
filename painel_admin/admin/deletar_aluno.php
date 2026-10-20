<?php
require_once 'conexao_gowey.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    try {
        // Excluir aluno
        $delAluno = $pdo->prepare("DELETE FROM alunos WHERE id = ?");
        $delAluno->execute([$id]);

        // Redireciona com mensagem de sucesso
        header("Location: alunos_cadastrados.php?sucesso_excluir=1");
        exit;
    } catch (PDOException $e) {
        header("Location: alunos_cadastrados.php?erro_excluir=" . urlencode($e->getMessage()));
        exit;
    }
} else {
    header("Location: alunos_cadastrados.php?erro_excluir=ID inválido");
    exit;
}
?>
