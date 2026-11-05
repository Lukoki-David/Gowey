<?php
session_start();
require_once 'conexao_gowey.php';

if (!isset($_SESSION['escola_id'])) {
    header('Location: login_escola.php');
    exit;
}
$escola_id = (int) $_SESSION['escola_id'];
$aluno_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$aluno_id || $aluno_id < 1) {
    header('Location: alunos_cadastrados.php?erro=id_invalido');
    exit;
}
function h($v): string { return htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8'); }

$stmt = $pdo->prepare('SELECT id, nome, idade, classe, turma, endereco, numero_processo FROM alunos WHERE id = ? AND escola_id = ? LIMIT 1');
$stmt->execute([$aluno_id, $escola_id]);
$aluno = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$aluno) {
    http_response_code(404);
    exit('Aluno não encontrado ou não pertence à escola autenticada.');
}

$erros = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $idade = trim($_POST['idade'] ?? '');
    $classe = trim($_POST['classe'] ?? '');
    $turma = trim($_POST['turma'] ?? '');
    $endereco = trim($_POST['endereco'] ?? '');
    $numero_processo = trim($_POST['numero_processo'] ?? '');

    if ($nome === '') $erros[] = 'O nome é obrigatório.';
    if ($idade !== '' && (!ctype_digit($idade) || (int)$idade < 1 || (int)$idade > 120)) $erros[] = 'Indica uma idade válida.';
    if ($numero_processo === '') $erros[] = 'O número de processo é obrigatório.';

    if (!$erros) {
        try {
            $upd = $pdo->prepare('UPDATE alunos SET nome = ?, idade = ?, classe = ?, turma = ?, endereco = ?, numero_processo = ? WHERE id = ? AND escola_id = ?');
            $upd->execute([$nome, $idade === '' ? null : (int)$idade, $classe, $turma, $endereco, $numero_processo, $aluno_id, $escola_id]);
            header('Location: alunos_cadastrados.php?sucesso=aluno_editado');
            exit;
        } catch (PDOException $e) {
            $erros[] = 'Não foi possível guardar. Verifica se o número de processo já existe e tenta novamente.';
        }
    }
    $aluno = array_merge($aluno, compact('nome','idade','classe','turma','endereco','numero_processo'));
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Editar aluno | GoWey School</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
:root{--blue:#002b80;--ink:#17243b;--muted:#69778d;--line:#e2e8f0;--bg:#f4f7fc}
*{box-sizing:border-box}body{margin:0;background:var(--bg);font-family:Inter,Segoe UI,Arial,sans-serif;color:var(--ink)}
header{background:var(--blue);color:white;padding:20px clamp(18px,5vw,56px);display:flex;justify-content:space-between;align-items:center;gap:16px}
.brand{font-size:20px;font-weight:800}header a{color:white;text-decoration:none;font-size:14px;font-weight:600}
main{width:min(900px,calc(100% - 32px));margin:34px auto 56px}.eyebrow{color:var(--blue);font-size:12px;font-weight:800;letter-spacing:1.2px;text-transform:uppercase}
h1{margin:8px 0;font-size:clamp(25px,4vw,34px)}.intro{color:var(--muted);line-height:1.6}
.card{background:white;border:1px solid var(--line);border-radius:18px;padding:clamp(20px,4vw,34px);box-shadow:0 12px 35px #18315b0f}
.grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:20px}.field{display:flex;flex-direction:column;gap:8px}.full{grid-column:1/-1}
label{font-size:13px;font-weight:700;color:#34435b}input,textarea{width:100%;border:1px solid #d5deeb;border-radius:10px;padding:13px 14px;font:inherit;font-size:15px;color:var(--ink)}
textarea{min-height:100px;resize:vertical}.actions{display:flex;justify-content:flex-end;gap:12px;flex-wrap:wrap;margin-top:28px}
.btn{display:inline-flex;align-items:center;justify-content:center;gap:9px;padding:12px 18px;border-radius:10px;text-decoration:none;border:0;font-weight:700;font-size:14px;cursor:pointer}
.primary{background:var(--blue);color:white}.secondary{background:#edf1f7;color:#34435b}
.errors{background:#fff0f0;color:#9c2424;border:1px solid #ffd2d2;padding:14px 18px;border-radius:10px;margin-bottom:18px}
.note{margin-top:18px;color:var(--muted);font-size:12px;line-height:1.5}
@media(max-width:640px){.grid{grid-template-columns:1fr}.full{grid-column:auto}.actions .btn{width:100%}header{align-items:flex-start}}
</style></head>
<body>
<header><div class="brand"><i class="fa-solid fa-bus-simple"></i> GoWey <span style="font-weight:400">SCHOOL</span></div><a href="alunos_cadastrados.php"><i class="fa-solid fa-arrow-left"></i> Voltar aos alunos</a></header>
<main>
<span class="eyebrow">Gestão de alunos</span><h1><i class="fa-solid fa-user-pen" style="color:var(--blue)"></i> Editar aluno</h1>
<p class="intro">Atualiza as informações necessárias e guarda as alterações sem eliminar o registo.</p>
<?php if ($erros): ?><div class="errors"><strong>Não foi possível guardar:</strong><ul><?php foreach ($erros as $erro): ?><li><?= h($erro) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
<section class="card"><form method="post" action="editar_aluno.php?id=<?= (int)$aluno_id ?>">
<div class="grid">
<div class="field full"><label for="nome">Nome completo *</label><input id="nome" name="nome" maxlength="150" required value="<?= h($aluno['nome']) ?>"></div>
<div class="field"><label for="idade">Idade</label><input id="idade" name="idade" type="number" min="1" max="120" value="<?= h($aluno['idade']) ?>"></div>
<div class="field"><label for="numero_processo">Número de processo *</label><input id="numero_processo" name="numero_processo" required value="<?= h($aluno['numero_processo']) ?>"></div>
<div class="field"><label for="classe">Classe</label><input id="classe" name="classe" value="<?= h($aluno['classe']) ?>"></div>
<div class="field"><label for="turma">Turma</label><input id="turma" name="turma" value="<?= h($aluno['turma']) ?>"></div>
<div class="field full"><label for="endereco">Endereço</label><textarea id="endereco" name="endereco"><?= h($aluno['endereco']) ?></textarea></div>
</div>
<div class="actions"><a class="btn secondary" href="alunos_cadastrados.php">Cancelar</a><button class="btn primary" type="submit"><i class="fa-solid fa-floppy-disk"></i> Guardar alterações</button></div>
<p class="note">* Campos obrigatórios. Só podes editar alunos associados à escola da sessão atual.</p>
</form></section></main></body></html>
