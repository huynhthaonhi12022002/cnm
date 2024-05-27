<?php
class Attendance {
    private $dbh;

    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    public function addAttendance($employee_id, $checkin, $checkout, $status) {
        try {
            $query = "INSERT INTO employee_attendances (employee_id, checkin, checkout, status) 
                      VALUES (:employee_id, :checkin, :checkout, :status)";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':employee_id', $employee_id);
            $stmt->bindParam(':checkin', $checkin);
            $stmt->bindParam(':checkout', $checkout);
            $stmt->bindParam(':status', $status);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    
    public function updateFieldAttendance($id, $field, $value) {
        try {
            $allowedFields = ['employee_id', 'checkin', 'checkout', 'status'];
            
            if (!in_array($field, $allowedFields)) {
                return false;
            }
            $query = "UPDATE employee_attendances SET $field = :value WHERE id = :id";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':value', $value);
            $stmt->bindParam(':id', $id);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    public function updateAttendance($id, $employee_id, $checkin, $checkout, $status) {
        try {
            $query = "UPDATE employee_attendances SET employee_id = :employee_id, checkin = :checkin, checkout = :checkout, status = :status
                      WHERE id = :id";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':employee_id', $employee_id);
            $stmt->bindParam(':checkin', $checkin);
            $stmt->bindParam(':checkout', $checkout);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }



    public function checkAttendanceToday($employee_id) {
        try {
            $today = date("Y-m-d");
            $query = "SELECT id FROM employee_attendances WHERE employee_id = :employee_id AND DATE(created_at) = :today";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':employee_id', $employee_id);
            $stmt->bindParam(':today', $today);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['id'] : false;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    //$updateResult = $yourObject->updateAttendance($attendanceId, 'checkout', $newCheckoutValue);

    // public function checkAttendanceToday($employee_id) {
    //     try {
    //         $today = date("Y-m-d");
    //         $query = "SELECT ea.id, emp.firstname, emp.lastname FROM employee_attendances ea
    //                   LEFT JOIN employees emp ON ea.employee_id = emp.id
    //                   WHERE ea.employee_id = :employee_id AND DATE(ea.created_at) = :today";
    //         $stmt = $this->dbh->prepare($query);
    //         $stmt->bindParam(':employee_id', $employee_id);
    //         $stmt->bindParam(':today', $today);
    //         $stmt->execute();
    //         $result = $stmt->fetch(PDO::FETCH_ASSOC);
    //         return $result ? $result : false;
    //     } catch (PDOException $e) {
    //         echo "Error: " . $e->getMessage();
    //         return false;
    //     }
    // }

    public function deleteAttendance($id) {
        try {
            $query = "DELETE FROM employee_attendances WHERE id = :id";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function viewAllAttendance() {
        try {
            $query = "SELECT ea.*, e.firstname, e.lastname 
            FROM employee_attendances ea
            JOIN employees e ON ea.employee_id = e.id";
            $stmt = $this->dbh->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function viewAttendanceById($id) {
        try {
            $query = "SELECT * FROM employee_attendances WHERE id = :id";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function getEmployeeById($id) { 
        try {
            $query = "SELECT * FROM employees WHERE id = :id"; 
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':id', $id); 
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function addAttendanceWithImage($employee_id, $checkin, $checkout, $status, $image_path) {
        $sql = "INSERT INTO attendance (employee_id, checkin, checkout, status, image_path) VALUES (:employee_id, :checkin, :checkout, :status, :image_path)";
        $query = $this->dbh->prepare($sql);
        $query->bindParam(':employee_id', $employee_id, PDO::PARAM_STR); 
        $query->bindParam(':checkin', $checkin, PDO::PARAM_STR);
        $query->bindParam(':checkout', $checkout, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_INT);
        $query->bindParam(':image_path', $image_path, PDO::PARAM_STR);        
        return $query->execute();
    }
}
?>


