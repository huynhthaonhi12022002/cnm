<?php

class Designation {
    private $dbh;

    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    // Phương thức để thêm một bản ghi mới vào bảng designations
    public function addDesignation($name, $department_id) {
        $sql = "INSERT INTO designations (name, department_id) VALUES (:name, :department_id)";
        $query = $this->dbh->prepare($sql);
        return $query->execute(array(':name' => $name, ':department_id' => $department_id));
    }

    // Phương thức để sửa một bản ghi trong bảng designations dựa trên id
    public function updateDesignation($id, $name, $department_id) {
        $sql = "UPDATE designations SET name = :name, department_id = :department_id WHERE id = :id";
        $query = $this->dbh->prepare($sql);
        return $query->execute(array(':id' => $id, ':name' => $name, ':department_id' => $department_id));
    }

    // Phương thức để xóa một bản ghi từ bảng designations dựa trên id
    public function deleteDesignation($id) {
        $sql = "DELETE FROM designations WHERE id = :id";
        $query = $this->dbh->prepare($sql);
        return $query->execute(array(':id' => $id));
    }
}

?>
