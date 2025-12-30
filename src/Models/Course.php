<?php

class Course
{
    private $conn;
    private $table_name = "courses";

    public $id;
    public $name;
    public $periodicity;
    public $start_date;
    public $end_date;
    public $day_of_week;
    public $time;
    public $duration;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET name=:name, periodicity=:periodicity, start_date=:start_date, 
                      end_date=:end_date, day_of_week=:day_of_week, time=:time, 
                      duration=:duration, created_at=:created_at";
        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->periodicity = htmlspecialchars(strip_tags($this->periodicity));
        $this->start_date = htmlspecialchars(strip_tags($this->start_date));
        $this->end_date = htmlspecialchars(strip_tags($this->end_date));
        $this->day_of_week = $this->day_of_week ? htmlspecialchars(strip_tags($this->day_of_week)) : null;
        $this->time = htmlspecialchars(strip_tags($this->time));
        $this->duration = intval($this->duration);
        $created_at = date('Y-m-d H:i:s');

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":periodicity", $this->periodicity);
        $stmt->bindParam(":start_date", $this->start_date);
        $stmt->bindParam(":end_date", $this->end_date);
        $stmt->bindParam(":day_of_week", $this->day_of_week);
        $stmt->bindParam(":time", $this->time);
        $stmt->bindParam(":duration", $this->duration);
        $stmt->bindParam(":created_at", $created_at);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getAll()
    {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY start_date DESC, time ASC";
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
            $this->name = $row['name'];
            $this->periodicity = $row['periodicity'];
            $this->start_date = $row['start_date'];
            $this->end_date = $row['end_date'];
            $this->day_of_week = $row['day_of_week'];
            $this->time = $row['time'];
            $this->duration = $row['duration'];
            return true;
        }
        return false;
    }

    public function update()
    {
        $query = "UPDATE " . $this->table_name . "
                SET name = :name, periodicity = :periodicity, start_date = :start_date,
                    end_date = :end_date, day_of_week = :day_of_week, time = :time,
                    duration = :duration
                WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->periodicity = htmlspecialchars(strip_tags($this->periodicity));
        $this->start_date = htmlspecialchars(strip_tags($this->start_date));
        $this->end_date = htmlspecialchars(strip_tags($this->end_date));
        $this->day_of_week = $this->day_of_week ? htmlspecialchars(strip_tags($this->day_of_week)) : null;
        $this->time = htmlspecialchars(strip_tags($this->time));
        $this->duration = intval($this->duration);
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':periodicity', $this->periodicity);
        $stmt->bindParam(':start_date', $this->start_date);
        $stmt->bindParam(':end_date', $this->end_date);
        $stmt->bindParam(':day_of_week', $this->day_of_week);
        $stmt->bindParam(':time', $this->time);
        $stmt->bindParam(':duration', $this->duration);
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
