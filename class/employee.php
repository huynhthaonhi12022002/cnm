<?php
// Class Employee
class Employee {
    private $dbh;

    // Constructor
    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    // Thêm nhân viên mới
    public function addEmployee($firstname, $lastname, $email, $phone, $department_id, $designation_id, $join_date, $avatar, $basic_salary, $uuid) {
        try {
            $query = "INSERT INTO employees (firstname, lastname, email, phone, department_id, designation_id, join_date,uuid, avatar, basic_salary) 
                      VALUES (:firstname, :lastname, :email, :phone, :department_id, :designation_id, :join_date,:uuid ,:avatar, :basic_salary)";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':firstname', $firstname);
            $stmt->bindParam(':lastname', $lastname);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':department_id', $department_id);
            $stmt->bindParam(':designation_id', $designation_id);
            $stmt->bindParam(':join_date', $join_date);
            $stmt->bindParam(':uuid', $uuid);
            $stmt->bindParam(':avatar', $avatar);
            $stmt->bindParam(':basic_salary', $basic_salary);
            $stmt->execute();
                // Lấy ID của dòng vừa chèn và trả về
            $lastInsertedID = $this->dbh->lastInsertId();
            return $lastInsertedID;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Sửa thông tin nhân viên
    public function updateEmployee($id,$firstname, $lastname, $email, $phone, $department_id, $designation_id, $join_date, $avatar, $basic_salary, $uuid) {
        try {
            $query = "UPDATE employees 
                      SET firstname = :firstname, lastname = :lastname, email = :email, phone = :phone,
                          department_id = :department_id, designation_id = :designation_id, 
                          join_date = :join_date,uuid = :uuid, avatar = :avatar, basic_salary = :basic_salary 
                      WHERE id = :id";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':firstname', $firstname);
            $stmt->bindParam(':lastname', $lastname);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':department_id', $department_id);
            $stmt->bindParam(':designation_id', $designation_id);
            $stmt->bindParam(':join_date', $join_date);
            $stmt->bindParam(':uuid', $uuid);
            $stmt->bindParam(':avatar', $avatar);
            $stmt->bindParam(':basic_salary', $basic_salary);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Xóa nhân viên
    public function deleteEmployee($id) {
        try {
            $query = "DELETE FROM employees WHERE id = :id";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Xem thông tin nhân viên
    public function viewEmployee($id) {
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

    // Xem tất cả nhân viên
    public function viewAllEmployees() {
        try {
            $query = "SELECT e.*, d.name AS department_name, des.name AS designation_name 
            FROM employees AS e 
            LEFT JOIN departments AS d ON e.department_id = d.id 
            LEFT JOIN designations AS des ON e.designation_id = des.id";
            $stmt = $this->dbh->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
?>
