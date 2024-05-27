<?php

class Leave {
    private $dbh;

    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    // Thêm ngày nghỉ mới
    public function addLeave($employee_id, $type, $from, $to, $reason, $status) {
        try {
            $query = "INSERT INTO leaves (employee_id, type, `from`, `to`, reason, status) 
                      VALUES (:employee_id, :type, :from, :to, :reason, :status)";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':employee_id', $employee_id);
            $stmt->bindParam(':type', $type);
            $stmt->bindParam(':from', $from);
            $stmt->bindParam(':to', $to);
            $stmt->bindParam(':reason', $reason);
            $stmt->bindParam(':status', $status);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    
    // Sửa thông tin ngày nghỉ
    public function updateLeave($id, $employee_id, $type, $from, $to, $reason, $status) {
        try {
            $query = "UPDATE leaves SET employee_id = :employee_id, type = :type, `from` = :from, 
                      `to` = :to, reason = :reason, status = :status WHERE id = :id";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':employee_id', $employee_id);
            $stmt->bindParam(':type', $type);
            $stmt->bindParam(':from', $from);
            $stmt->bindParam(':to', $to);
            $stmt->bindParam(':reason', $reason);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    

    // Xóa ngày nghỉ
    public function deleteLeave($id) {
        try {
            $query = "DELETE FROM leaves WHERE id = :id";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Xem thông tin tất cả các ngày nghỉ
    public function viewAllLeaves() {
        try {
            $query = "SELECT leaves.*, employees.firstname, employees.lastname 
            FROM leaves 
            INNER JOIN employees ON leaves.employee_id = employees.id";
            $stmt = $this->dbh->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Xem thông tin ngày nghỉ dựa trên ID
    public function viewLeaveById($id) {
        try {
            $query = "SELECT * FROM leaves WHERE employee_id = :id";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
?>
