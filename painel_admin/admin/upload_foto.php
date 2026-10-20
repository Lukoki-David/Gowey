<?php
require_once 'conexao_gowey.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $motorista_id = $_POST['motorista_id'];

    // Verifica se o arquivo foi enviado
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $foto_nome = $_FILES['foto']['name'];
        $foto_tmp = $_FILES['foto']['tmp_name'];

        // Pasta onde as fotos serão salvas
        $destino = 'uploads/' . basename($foto_nome);

        // Cria a pasta se não existir
        if (!is_dir('uploads')) {
            mkdir('uploads', 0777, true);
        }

        // Move o arquivo para a pasta
        if (move_uploaded_file($foto_tmp, $destino)) {
            // Atualiza o caminho da foto no banco
            $stmt = $pdo->prepare("UPDATE motoristas SET foto = ? WHERE id = ?");
            $stmt->execute([$destino, $motorista_id]);

            echo "<script>alert('Foto atualizada com sucesso!'); window.location.href='perfil_motoristas.php';</script>";
        } else {
            echo "<script>alert('Erro ao mover o arquivo.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Nenhum arquivo enviado.'); window.history.back();</script>";
    }
}
?>
