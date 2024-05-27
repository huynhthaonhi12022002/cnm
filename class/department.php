<?php

class Department {
    private $dbh;

    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    // Phương thức để thêm một bản ghi mới vào bảng departments
    public function addDepartment($name) {
        $sql = "INSERT INTO departments (name) VALUES (:name)";
        $query = $this->dbh->prepare($sql);
        return $query->execute(array(':name' => $name));
    }

    // Phương thức để sửa một bản ghi trong bảng departments dựa trên id
    public function updateDepartment($id, $name) {
        $sql = "UPDATE departments SET name = :name WHERE id = :id";
        $query = $this->dbh->prepare($sql);
        return $query->execute(array(':id' => $id, ':name' => $name));
    }

    // Phương thức để xóa một bản ghi từ bảng departments dựa trên id
    public function deleteDepartment($id) {
        $sql = "DELETE FROM departments WHERE id = :id";
        $query = $this->dbh->prepare($sql);
        return $query->execute(array(':id' => $id));
    }
}

?>
