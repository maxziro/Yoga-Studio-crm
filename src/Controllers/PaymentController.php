<?php
require_once __DIR__ . '/../Models/Payment.php';
require_once __DIR__ . '/../Models/StudentSubscription.php';
require_once __DIR__ . '/../Models/User.php';

class PaymentController
{
    private $db;
    private $payment;
    private $subscription;

    public function __construct($db)
    {
        $this->db = $db;
        $this->payment = new Payment($db);
        $this->subscription = new StudentSubscription($db);
    }

    public function index()
    {
        $stmt = $this->payment->getAll();
        $payments = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Calculate total revenue
        $totalRevenue = $this->payment->getTotalRevenue();

        $view = 'payments/index.php';
        require __DIR__ . '/../Views/dashboard.php';
    }

    public function create()
    {
        // Get all active subscriptions for the dropdown
        $stmt = $this->subscription->getAll();
        $subscriptions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $view = 'payments/form.php';
        require __DIR__ . '/../Views/dashboard.php';
    }

    public function store()
    {
        $this->payment->student_subscription_id = $_POST['student_subscription_id'];
        $this->payment->amount = $_POST['amount'];
        $this->payment->payment_date = $_POST['payment_date'];
        $this->payment->payment_method = $_POST['payment_method'];
        $this->payment->notes = $_POST['notes'] ?? null;

        if ($this->payment->create()) {
            header("Location: /payments");
        } else {
            $error = "Impossibile registrare il pagamento.";
            $stmt = $this->subscription->getAll();
            $subscriptions = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $view = 'payments/form.php';
            require __DIR__ . '/../Views/dashboard.php';
        }
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id || !$this->payment->findById($id)) {
            header("Location: /payments");
            exit;
        }

        $payment = $this->payment;
        $stmt = $this->subscription->getAll();
        $subscriptions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $view = 'payments/form.php';
        require __DIR__ . '/../Views/dashboard.php';
    }

    public function update()
    {
        $id = $_POST['id'] ?? null;
        if (!$id) {
            header("Location: /payments");
            exit;
        }

        $this->payment->id = $id;
        $this->payment->student_subscription_id = $_POST['student_subscription_id'];
        $this->payment->amount = $_POST['amount'];
        $this->payment->payment_date = $_POST['payment_date'];
        $this->payment->payment_method = $_POST['payment_method'];
        $this->payment->notes = $_POST['notes'] ?? null;

        if ($this->payment->update()) {
            header("Location: /payments");
        } else {
            $error = "Impossibile aggiornare il pagamento.";
            $this->payment->findById($id);
            $payment = $this->payment;
            $stmt = $this->subscription->getAll();
            $subscriptions = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $view = 'payments/form.php';
            require __DIR__ . '/../Views/dashboard.php';
        }
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->payment->id = $id;
            $this->payment->delete();
        }
        header("Location: /payments");
    }
}
