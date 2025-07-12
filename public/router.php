
<?php
// Se a requisição for para um arquivo estático (CSS, JS, imagem, ou um arquivo PHP existente como login.php),
// o servidor PHP irá servi-lo diretamente.
if (php_sapi_name() == 'cli-server') {
    $filename = __DIR__ . preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
    if (is_file($filename)) {
        return false; // Serve o arquivo estático como está.
    }
}

// Se não for um arquivo estático (ou se for uma URL amigável),
// inclui o index.php para que o PHP processe a requisição através do seu sistema de rotas (implícito no index.php).
require_once __DIR__ . '/index.php';