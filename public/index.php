<?php
// Visualizzazione errori in sviluppo; da disabilitare in produzione
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('default_socket_timeout', 5); // Timeout for all socket based streams
error_reporting(E_ALL);

// Force output flushing
if (ob_get_level())
    ob_end_clean();
ob_implicit_flush(true);

// Autoloading manuale (o composer se aggiunto successivamente)
require_once __DIR__ . '/../config/database.php';

// Esempio di routing molto semplice
$request_uri = $_SERVER['REQUEST_URI'];
$base_path = '/'; // Se l'app è in una sottocartella, aggiustare qui. Es: '/yogastudio/'

// Rimuove query string
$path = parse_url($request_uri, PHP_URL_PATH);

// Fix per hosting che includono index.php nel path o non supportano rewrite
$path = str_replace('/index.php', '', $path);
if ($path === '' || $path === '/') {
    $path = '/';
    // Fallback: Check param ?route= (es. index.php?route=/login)
    if (isset($_GET['route'])) {
        $path = '/' . ltrim($_GET['route'], '/');
    }
}

// Semplice gestione delle rotte
// Avvio sessione
session_start();

// Autoloading classi (semplificato)
require_once __DIR__ . '/../src/Controllers/AuthController.php';
require_once __DIR__ . '/../src/Controllers/StudentController.php';
require_once __DIR__ . '/../src/Controllers/CourseController.php';
require_once __DIR__ . '/../src/Controllers/SettingsController.php';

// Istanza Database e Controller
$database = new Database();
$db = $database->getConnection();

// Auto-Installation Check
if (!$database->checkInstallation()) {
    if ($database->install()) {
        echo "<h1>Installazione completata con successo!</h1><p>Database inizializzato. <a href='/login'>Accedi qui</a>.</p>";
        exit;
    } else {
        echo "<h1>Errore durante l'installazione.</h1><p>Controlla i log o la connessione al database.</p>";
        exit;
    }
}

$authController = new AuthController($db);
$studentController = new StudentController($db);
$courseController = new CourseController($db);
$settingsController = new SettingsController($database); // Pass database instance, not connection

// Simple Router
switch ($path) {
    case '/':
        require __DIR__ . '/../src/Views/home.php';
        break;
    case '/login':
        $authController->login();
        break;
    case '/login_post':
        $authController->loginPost();
        break;
    case '/logout':
        $authController->logout();
        break;
    case '/dashboard':
        // Auth check is done inside the view or controller, but here we can enforce it too
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }
        require __DIR__ . '/../src/Views/dashboard.php';
        break;

    // Student Routes
    case '/students':
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }
        $studentController->index();
        break;
    case '/students/create':
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }
        $studentController->create();
        break;
    case '/students/store':
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }
        $studentController->store();
        break;
    case '/students/edit':
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }
        $studentController->edit();
        break;
    case '/students/update':
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }
        $studentController->update();
        break;
    case '/students/delete':
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }
        $studentController->delete();
        break;

    // Course Routes
    case '/courses':
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }
        $courseController->index();
        break;
    case '/courses/create':
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }
        $courseController->create();
        break;
    case '/courses/store':
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }
        $courseController->store();
        break;
    case '/courses/edit':
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }
        $courseController->edit();
        break;
    case '/courses/update':
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }
        $courseController->update();
        break;
    case '/courses/delete':
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }
        $courseController->delete();
        break;

    // Settings Route
    case '/settings':
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }
        $settingsController->index();
        break;
    case '/settings/update_password':
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }
        $settingsController->updatePassword();
        break;
    case '/settings/seed':
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }
        $settingsController->seedDatabase();
        break;
    case '/settings/drop_table':
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }
        $settingsController->dropTable();
        break;
    case '/settings/nuke':
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }
        $settingsController->nukeDatabase();
        break;
    case '/settings/export':
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }
        $settingsController->export();
        break;
    case '/settings/import':
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }
        $settingsController->import();
        break;

    default:
        http_response_code(404);
        echo "404 Not Found";
        break;
}
