<?php
// Visualizzazione errori in sviluppo; da disabilitare in produzione
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Autoloading manuale (o composer se aggiunto successivamente)
require_once __DIR__ . '/../config/database.php';

// Esempio di routing molto semplice
$request_uri = $_SERVER['REQUEST_URI'];
$base_path = '/'; // Se l'app è in una sottocartella, aggiustare qui. Es: '/yogastudio/'

// Rimuove query string
$path = parse_url($request_uri, PHP_URL_PATH);

// Semplice gestione delle rotte
switch ($path) {
    case $base_path:
    case $base_path . 'index.php':
    case $base_path . 'home':
        require_once __DIR__ . '/../src/Views/home.php';
        break;

    case $base_path . 'dashboard':
        require_once __DIR__ . '/../src/Views/dashboard.php';
        break;

    default:
        http_response_code(404);
        require_once __DIR__ . '/../src/Views/404.php';
        break;
}
