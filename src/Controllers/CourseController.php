<?php
require_once __DIR__ . '/../Models/Course.php';

class CourseController
{
    private $db;
    private $course;

    public function __construct($db)
    {
        $this->db = $db;
        $this->course = new Course($db);
    }

    public function index()
    {
        $stmt = $this->course->getAll();
        $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $view = 'courses/index.php';
        require __DIR__ . '/../Views/dashboard.php';
    }

    public function create()
    {
        $view = 'courses/form.php';
        require __DIR__ . '/../Views/dashboard.php';
    }

    public function store()
    {
        $this->course->name = $_POST['name'];
        $this->course->periodicity = $_POST['periodicity'];
        $this->course->start_date = $_POST['start_date'];
        $this->course->end_date = $_POST['end_date'];
        $this->course->day_of_week = $_POST['day_of_week'] ?? null;
        $this->course->time = $_POST['time'];
        $this->course->duration = $_POST['duration'];

        if ($this->course->create()) {
            header("Location: /courses");
        } else {
            $error = "Impossibile creare il corso.";
            $view = 'courses/form.php';
            require __DIR__ . '/../Views/dashboard.php';
        }
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id || !$this->course->findById($id)) {
            header("Location: /courses");
            exit;
        }
        $course = $this->course;
        $view = 'courses/form.php';
        require __DIR__ . '/../Views/dashboard.php';
    }

    public function update()
    {
        $id = $_POST['id'] ?? null;
        if (!$id) {
            header("Location: /courses");
            exit;
        }

        $this->course->id = $id;
        $this->course->name = $_POST['name'];
        $this->course->periodicity = $_POST['periodicity'];
        $this->course->start_date = $_POST['start_date'];
        $this->course->end_date = $_POST['end_date'];
        $this->course->day_of_week = $_POST['day_of_week'] ?? null;
        $this->course->time = $_POST['time'];
        $this->course->duration = $_POST['duration'];

        if ($this->course->update()) {
            header("Location: /courses");
        } else {
            $error = "Impossibile aggiornare il corso.";
            $this->course->findById($id);
            $course = $this->course;
            $view = 'courses/form.php';
            require __DIR__ . '/../Views/dashboard.php';
        }
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->course->id = $id;
            $this->course->delete();
        }
        header("Location: /courses");
    }
}
