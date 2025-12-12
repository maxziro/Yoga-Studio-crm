<?php
require_once __DIR__ . '/../Models/User.php';

class StudentController
{
    private $db;
    private $user;

    public function __construct($db)
    {
        $this->db = $db;
        $this->user = new User($db);
    }

    public function index()
    {
        $stmt = $this->user->getStudents();
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // view variable is used by the include in index.php or dashboard.php
        $view = 'students/index.php';
        require __DIR__ . '/../Views/dashboard.php';
    }

    public function create()
    {
        $view = 'students/form.php';
        require __DIR__ . '/../Views/dashboard.php';
    }

    public function store()
    {
        $this->user->name = $_POST['name'];
        $this->user->email = $_POST['email'];
        $this->user->password = $_POST['password']; // Will be hashed in create()
        $this->user->role = 'student';

        if ($this->user->create()) {
            header("Location: /students");
        } else {
            $error = "Impossibile creare l'allievo.";
            $view = 'students/form.php';
            require __DIR__ . '/../Views/dashboard.php';
        }
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id || !$this->user->findById($id)) {
            header("Location: /students");
            exit;
        }
        $student = $this->user; // properties are set after findById
        $view = 'students/form.php';
        require __DIR__ . '/../Views/dashboard.php';
    }

    public function update()
    {
        $id = $_POST['id'] ?? null;
        if (!$id) {
            header("Location: /students");
            exit;
        }

        $this->user->id = $id;
        $this->user->name = $_POST['name'];
        $this->user->email = $_POST['email'];
        // Password update is skipped for now for simplicity in update

        if ($this->user->update()) {
            header("Location: /students");
        } else {
            $error = "Impossibile aggiornare l'allievo.";
            // Reload data to show form again
            $this->user->findById($id);
            $student = $this->user;
            $view = 'students/form.php';
            require __DIR__ . '/../Views/dashboard.php';
        }
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->user->id = $id;
            $this->user->delete();
        }
        header("Location: /students");
    }
}
