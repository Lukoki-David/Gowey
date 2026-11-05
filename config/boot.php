<?php

// Caminho absoluto da raiz do projeto
define('BASE_PATH', dirname(__DIR__));

// Caminho público do projeto no navegador
define('BASE_URL', '/gowey_For_School');

// Iniciar sessão apenas se ainda não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Carregar a ligação à base de dados
require_once BASE_PATH . '/config/conexao_gowey.php';

