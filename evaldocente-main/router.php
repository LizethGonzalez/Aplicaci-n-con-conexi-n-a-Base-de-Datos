<?php
$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$file = __DIR__ . "/public" . $path;
// Si el archivo solicitado existe (CSS, JS, imágenes...), servirlo directamente
if (file_exists($file)) {
    return false;
}

// Todo lo demás lo maneja index.php
require_once __DIR__ . '/public/index.php';
