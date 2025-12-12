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
        $names = ['Marco', 'Giulia', 'Alessandro', 'Francesca', 'Luca', 'Sofia', 'Matteo', 'Chiara', 'Davide', 'Sara', 'Simone', 'Valentina', 'Lorenzo', 'Alice', 'Andrea'];
        $surnames = ['Rossi', 'Bianchi', 'Ferrari', 'Esposito', 'Ricci', 'Marino', 'Greco', 'Bruno', 'Gallo', 'Conti', 'De Luca', 'Mancini', 'Rizzo', 'Lombardi'];

        // Seeding 10 realistic students
        for ($i = 0; $i < 10; $i++) {
            $firstName = $names[array_rand($names)];
            $lastName = $surnames[array_rand($surnames)];

            $this->user->name = "$firstName $lastName";
            // Create a cleaner email, maybe handle duplicates roughly by adding random number if needed, 
            // but for 10 records collision is rare enough or fine to fail. 
            // Adding rand to ensure uniqueness for UNIQUE constraint on email.
            $this->user->email = strtolower($firstName . "." . $lastName . rand(10, 99) . "@example.com");
            $this->user->password = "password123";
            $this->user->role = "student";
            $this->user->create();
        }
        header("Location: /settings?success=Database popolato con 10 nuovi allievi");
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
