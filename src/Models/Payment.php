<?php

class Payment
{
    private $conn;
    private $table_name = "payments";

    public $id;
    public $student_subscription_id;
    public $amount;
    public $payment_date;
    public $payment_method;
    public $notes;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET student_subscription_id=:student_subscription_id, amount=:amount, 
                      payment_date=:payment_date, payment_method=:payment_method, 
                      notes=:notes, created_at=:created_at";
        $stmt = $this->conn->prepare($query);

        $this->student_subscription_id = intval($this->student_subscription_id);
        $this->amount = floatval($this->amount);
        $this->payment_date = htmlspecialchars(strip_tags($this->payment_date));
        $this->payment_method = htmlspecialchars(strip_tags($this->payment_method));
        $this->notes = $this->notes ? htmlspecialchars(strip_tags($this->notes)) : null;
        $created_at = date('Y-m-d H:i:s');

        $stmt->bindParam(":student_subscription_id", $this->student_subscription_id);
        $stmt->bindParam(":amount", $this->amount);
        $stmt->bindParam(":payment_date", $this->payment_date);
        $stmt->bindParam(":payment_method", $this->payment_method);
        $stmt->bindParam(":notes", $this->notes);
        $stmt->bindParam(":created_at", $created_at);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getAll()
    {
        $query = "SELECT p.*, ss.user_id, u.name as student_name, 
                         st.name as subscription_name
                  FROM " . $this->table_name . " p
                  JOIN student_subscriptions ss ON p.student_subscription_id = ss.id
                  JOIN users u ON ss.user_id = u.id
                  JOIN subscription_types st ON ss.subscription_type_id = st.id
                  ORDER BY p.payment_date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getBySubscription($subscription_id)
    {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE student_subscription_id = ?
                  ORDER BY payment_date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $subscription_id);
        $stmt->execute();
        return $stmt;
    }

    public function getByDateRange($start_date, $end_date)
    {
        $query = "SELECT p.*, ss.user_id, u.name as student_name, 
                         st.name as subscription_name
                  FROM " . $this->table_name . " p
                  JOIN student_subscriptions ss ON p.student_subscription_id = ss.id
                  JOIN users u ON ss.user_id = u.id
                  JOIN subscription_types st ON ss.subscription_type_id = st.id
                  WHERE p.payment_date BETWEEN ? AND ?
                  ORDER BY p.payment_date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $start_date);
        $stmt->bindParam(2, $end_date);
        $stmt->execute();
        return $stmt;
    }

    public function getTotalRevenue($start_date = null, $end_date = null)
    {
        if ($start_date && $end_date) {
            $query = "SELECT SUM(amount) as total FROM " . $this->table_name . " 
                      WHERE payment_date BETWEEN ? AND ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $start_date);
            $stmt->bindParam(2, $end_date);
        } else {
            $query = "SELECT SUM(amount) as total FROM " . $this->table_name;
            $stmt = $this->conn->prepare($query);
        }
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ?? 0;
    }

    public function findById($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->id = $row['id'];
            $this->student_subscription_id = $row['student_subscription_id'];
            $this->amount = $row['amount'];
            $this->payment_date = $row['payment_date'];
            $this->payment_method = $row['payment_method'];
            $this->notes = $row['notes'];
            return true;
        }
        return false;
    }

    public function update()
    {
        $query = "UPDATE " . $this->table_name . "
                SET amount = :amount, payment_date = :payment_date, 
                    payment_method = :payment_method, notes = :notes
                WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->amount = floatval($this->amount);
        $this->payment_date = htmlspecialchars(strip_tags($this->payment_date));
        $this->payment_method = htmlspecialchars(strip_tags($this->payment_method));
        $this->notes = $this->notes ? htmlspecialchars(strip_tags($this->notes)) : null;
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':amount', $this->amount);
        $stmt->bindParam(':payment_date', $this->payment_date);
        $stmt->bindParam(':payment_method', $this->payment_method);
        $stmt->bindParam(':notes', $this->notes);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
