<?php

class StudentSubscription
{
    private $conn;
    private $table_name = "student_subscriptions";

    public $id;
    public $user_id;
    public $subscription_type_id;
    public $start_date;
    public $end_date;
    public $status;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET user_id=:user_id, subscription_type_id=:subscription_type_id, 
                      start_date=:start_date, end_date=:end_date, status=:status, created_at=:created_at";
        $stmt = $this->conn->prepare($query);

        $this->user_id = intval($this->user_id);
        $this->subscription_type_id = intval($this->subscription_type_id);
        $this->start_date = htmlspecialchars(strip_tags($this->start_date));
        $this->end_date = htmlspecialchars(strip_tags($this->end_date));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $created_at = date('Y-m-d H:i:s');

        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":subscription_type_id", $this->subscription_type_id);
        $stmt->bindParam(":start_date", $this->start_date);
        $stmt->bindParam(":end_date", $this->end_date);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":created_at", $created_at);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getAll()
    {
        $query = "SELECT ss.*, u.name as student_name, u.email as student_email, 
                         st.name as subscription_name, st.type, st.price
                  FROM " . $this->table_name . " ss
                  JOIN users u ON ss.user_id = u.id
                  JOIN subscription_types st ON ss.subscription_type_id = st.id
                  ORDER BY ss.start_date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getByStudent($user_id)
    {
        $query = "SELECT ss.*, st.name as subscription_name, st.type, st.price
                  FROM " . $this->table_name . " ss
                  JOIN subscription_types st ON ss.subscription_type_id = st.id
                  WHERE ss.user_id = ?
                  ORDER BY ss.start_date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $user_id);
        $stmt->execute();
        return $stmt;
    }

    public function getActiveSubscriptions()
    {
        $query = "SELECT ss.*, u.name as student_name, st.name as subscription_name
                  FROM " . $this->table_name . " ss
                  JOIN users u ON ss.user_id = u.id
                  JOIN subscription_types st ON ss.subscription_type_id = st.id
                  WHERE ss.status = 'active' AND ss.end_date >= CURDATE()
                  ORDER BY ss.end_date ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
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
            $this->user_id = $row['user_id'];
            $this->subscription_type_id = $row['subscription_type_id'];
            $this->start_date = $row['start_date'];
            $this->end_date = $row['end_date'];
            $this->status = $row['status'];
            return true;
        }
        return false;
    }

    public function update()
    {
        $query = "UPDATE " . $this->table_name . "
                SET subscription_type_id = :subscription_type_id, start_date = :start_date,
                    end_date = :end_date, status = :status
                WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->subscription_type_id = intval($this->subscription_type_id);
        $this->start_date = htmlspecialchars(strip_tags($this->start_date));
        $this->end_date = htmlspecialchars(strip_tags($this->end_date));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':subscription_type_id', $this->subscription_type_id);
        $stmt->bindParam(':start_date', $this->start_date);
        $stmt->bindParam(':end_date', $this->end_date);
        $stmt->bindParam(':status', $this->status);
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
