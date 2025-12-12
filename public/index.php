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
echo "Starting application...<br>";
flush();

// Avvio sessione
echo "Starting session...<br>";
flush();
session_start();
echo "Session started.<br>";
flush();

// Autoloading classi (semplificato)
require_once __DIR__ . '/../src/Controllers/AuthController.php';

// Istanza Database e Controller
echo "Initializing Database class...<br>";
flush();
$database = new Database();
echo "Getting connection...<br>";
flush();
$db = $database->getConnection();

// Auto-Installation Check
echo "Checking installation...<br>";
flush();
if (!$database->checkInstallation()) {
    echo "Installation check failed or tables missing. Attempting install...<br>";
    flush();
    if ($database->install()) {
        echo "<h1>Installazione completata con successo!</h1><p>Database inizializzato. <a href='/login'>Accedi qui</a>.</p>";
        exit;
    } else {
        echo "<h1>Errore durante l'installazione.</h1><p>Controlla i log o la connessione al database.</p>";
        exit;
    }
} else {
    echo "Installation check passed.<br>";
    flush();
}

$authController = new AuthController($db);

// Routing
switch ($path) {
    case $base_path:
    case $base_path . 'index.php':
    case $base_path . 'home':
        require_once __DIR__ . '/../src/Views/home.php';
        break;

    case $base_path . 'login':
        $authController->login();
        break;

    case $base_path . 'login_post':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->loginPost();
        } else {
            header("Location: /login");
        }
        break;

    case $base_path . 'logout':
        $authController->logout();
        break;

    case $base_path . 'dashboard':
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }
        require_once __DIR__ . '/../src/Views/dashboard.php';
        break;

    default:
        http_response_code(404);
        require_once __DIR__ . '/../src/Views/404.php';
        break;
}
