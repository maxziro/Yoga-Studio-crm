<?php
require_once __DIR__ . '/../Models/User.php';

class SettingsController
{
    private $db;
    private $user;
    private $database;

    public function __construct($databaseInstance)
    {
        $this->database = $databaseInstance;
        $this->db = $databaseInstance->getConnection();
        $this->user = new User($this->db);
    }

    public function index()
    {
        $tables = $this->database->getTables();
        $view = 'settings/index.php';
        require __DIR__ . '/../Views/dashboard.php';
    }

    public function updatePassword()
    {
        $password = $_POST['password'] ?? '';
        if (!$password) {
            header("Location: /settings?error=Password vuota");
            exit;
        }

        $this->user->id = $_SESSION['user_id'];
        if ($this->user->updatePassword($password)) {
            header("Location: /settings?success=Password aggiornata");
        } else {
            header("Location: /settings?error=Errore aggiornamento");
        }
    }

    public function seedDatabase()
    {
        // Seeding 10 dummy students
        for ($i = 1; $i <= 10; $i++) {
            $this->user->name = "Allievo Demo $i";
            $this->user->email = "allievo$i@demo.com";
            $this->user->password = "password123";
            $this->user->role = "student";
            $this->user->create();
        }
        header("Location: /settings?success=Database popolato con 10 allievi");
    }

    public function dropTable()
    {
        $table = $_POST['table'] ?? '';
        if ($table && $table !== 'users') { // Protect users table minimally
            $this->database->dropTable($table);
            header("Location: /settings?success=Tabella $table eliminata");
        } else {
            header("Location: /settings?error=Impossibile eliminare $table");
        }
    }

    public function nukeDatabase()
    {
        if ($this->database->dropAllTables()) {
            // Redirect to home/install page as DB is empty
            header("Location: /");
        } else {
            header("Location: /settings?error=Errore durante drop all");
        }
    }
}
