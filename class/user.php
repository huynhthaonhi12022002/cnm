<?php
class User {
    private $dbh;

    // Constructor
    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    // Thêm người dùng mới
    public function addUser($name, $email, $password, $avatar, $role, $status) {
        try {
            $query = "INSERT INTO users (name, email, password, avatar, role, status) 
                      VALUES (:name, :email, :password, :avatar, :role, :status)";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':avatar', $avatar);
            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':status', $status);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function addUserNew($name, $email, $password, $avatar, $role, $status, $employee_id) {
        try {
            $query = "INSERT INTO users (name, email, password, avatar, role, status, employee_id) 
                      VALUES (:name, :email, :password, :avatar, :role, :status, :employee_id)";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':avatar', $avatar);
            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':employee_id', $employee_id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    // Sửa thông tin người dùng
    public function updateUser($id, $name, $email, $password, $avatar, $role, $status) {
        try {
            $query = "UPDATE users 
                      SET name = :name, email = :email, password = :password, 
                          avatar = :avatar, role = :role, status = :status
                      WHERE id = :id";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':avatar', $avatar);
            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Xóa người dùng
    public function deleteUser($id) {
        try {
            $query = "DELETE FROM users WHERE id = :id";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Xem thông tin người dùng
    public function viewUser($id) {
        try {
            $query = "SELECT * FROM users WHERE id = :id";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Xem tất cả người dùng
    public function viewAllUsers() {
        try {
            $query = "SELECT * FROM users";
            $stmt = $this->dbh->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}

