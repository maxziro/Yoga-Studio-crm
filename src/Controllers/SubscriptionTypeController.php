<?php
require_once __DIR__ . '/../Models/SubscriptionType.php';

class SubscriptionTypeController
{
    private $db;
    private $subscriptionType;

    public function __construct($db)
    {
        $this->db = $db;
        $this->subscriptionType = new SubscriptionType($db);
    }

    public function index()
    {
        $stmt = $this->subscriptionType->getAll();
        $subscriptionTypes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $view = 'subscription_types/index.php';
        require __DIR__ . '/../Views/dashboard.php';
    }

    public function create()
    {
        $view = 'subscription_types/form.php';
        require __DIR__ . '/../Views/dashboard.php';
    }

    public function store()
    {
        $this->subscriptionType->name = $_POST['name'];
        $this->subscriptionType->type = $_POST['type'];
        $this->subscriptionType->price = $_POST['price'];
        $this->subscriptionType->description = $_POST['description'] ?? null;

        if ($this->subscriptionType->create()) {
            header("Location: /subscription-types");
        } else {
            $error = "Impossibile creare il tipo di abbonamento.";
            $view = 'subscription_types/form.php';
            require __DIR__ . '/../Views/dashboard.php';
        }
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id || !$this->subscriptionType->findById($id)) {
            header("Location: /subscription-types");
            exit;
        }
        $subscriptionType = $this->subscriptionType;
        $view = 'subscription_types/form.php';
        require __DIR__ . '/../Views/dashboard.php';
    }

    public function update()
    {
        $id = $_POST['id'] ?? null;
        if (!$id) {
            header("Location: /subscription-types");
            exit;
        }

        $this->subscriptionType->id = $id;
        $this->subscriptionType->name = $_POST['name'];
        $this->subscriptionType->type = $_POST['type'];
        $this->subscriptionType->price = $_POST['price'];
        $this->subscriptionType->description = $_POST['description'] ?? null;

        if ($this->subscriptionType->update()) {
            header("Location: /subscription-types");
        } else {
            $error = "Impossibile aggiornare il tipo di abbonamento.";
            $this->subscriptionType->findById($id);
            $subscriptionType = $this->subscriptionType;
            $view = 'subscription_types/form.php';
            require __DIR__ . '/../Views/dashboard.php';
        }
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->subscriptionType->id = $id;
            $this->subscriptionType->delete();
        }
        header("Location: /subscription-types");
    }
}
