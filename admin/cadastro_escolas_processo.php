<?php
require_once 'conexao_gowey.php';

$nome_escola       = $_POST['nome'];
$endereco_recebido = $_POST['endereco'];
$numero_processo   = $_POST['numero_processo'];
$email_recebido    = $_POST['email'];
$nome_responsavel  = $_POST['responsavel'];
$numero_aluno     = $_POST['numero_aluno'];
$telefone          = $_POST['telefone'];
$senha_recebida    = $_POST['senha'];

if ($nome_escola && $endereco_recebido && $numero_processo && $email_recebido && $nome_responsavel 
&& $numero_aluno && $telefone && $senha_recebida) {
    try {
        // Verifica se o email já existe
        $verifica = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
        $verifica->execute([$email_recebido]);

        if ($verifica->rowCount() > 0) {
            // Redireciona de volta com mensagem de erro
            header("Location: cadastro_escolas.php?erro=Este email já está cadastrado!");
            exit;
        }
    // Verifica se o número de processo já existe
$verificaProcesso = $pdo->prepare("SELECT id FROM escolas WHERE numero_processo = ?");
$verificaProcesso->execute([$numero_processo]);

if ($verificaProcesso->rowCount() > 0) {
    // Redireciona com mensagem de erro
    header("Location: cadastro_escolas.php?erro_processo=1");
    exit;
}


        $telefone = $_POST['telefone'];
// Verifica se tem exatamente 9 dígitos
if (!preg_match('/^\d{9}$/', $telefone)) {
    header("Location: cadastro_escolas.php?erro_telefone=1");
    exit;
}

        // Criptografa a senha
        $senha_hash = password_hash($senha_recebida, PASSWORD_BCRYPT);

        // Inserir dados institucionais na tabela escolas
        $sql_escola = "INSERT INTO escolas (nome, endereco, numero_processo, email, responsavel, numero_aluno, telefone)
                       VALUES (:nome, :endereco, :numero_processo, :email, :responsavel, :numero_aluno, :telefone)";
        $cmd_escola = $pdo->prepare($sql_escola);
        $cmd_escola->execute([
            ':nome' => $nome_escola,
            ':endereco' => $endereco_recebido,
            ':numero_processo' => $numero_processo,
            ':email' => $email_recebido,
            ':responsavel' => $nome_responsavel,
            ':numero_aluno' => $numero_aluno,
            ':telefone' => $telefone
        ]);

        $escola_id = $pdo->lastInsertId();

        // Criar credenciais na tabela usuarios
        $sql_usuario = "INSERT INTO usuarios (nome, email, senha, role, escola_id)
                        VALUES (:nome, :email, :senha, 'escola', :escola_id)";
        $cmd_usuario = $pdo->prepare($sql_usuario);
        $cmd_usuario->execute([
            ':nome' => $nome_escola,
            ':email' => $email_recebido,
            ':senha' => $senha_hash,
            ':escola_id' => $escola_id
        ]);

        
        header("Location: escolas_cadastradas.php?sucesso=Escola cadastrada com sucesso!");
        exit;

    } catch (PDOException $e) {
       
        header("Location: cadastro_escolas.php");
        exit;
    }
} else {
    
    header("Location: cadastro_escolas.php");
    exit;
}
?>
