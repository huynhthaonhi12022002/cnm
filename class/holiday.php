<?php
class Holiday {
    private $dbh;

    function __construct($dbh) {
        $this->dbh = $dbh;
    }

    // Thêm ngày nghỉ
    public function addHoliday($name, $holiday_date) {
        try {
            $sql = "INSERT INTO holidays (name, holiday_date) VALUES (:name, :holiday_date)";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':holiday_date', $holiday_date, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch(PDOException $e) {
            return false;
        }
    }

    // Sửa thông tin ngày nghỉ
    public function updateHoliday($id, $name, $holiday_date) {
        try {
            $sql = "UPDATE holidays SET name = :name, holiday_date = :holiday_date WHERE id = :id";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':holiday_date', $holiday_date, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch(PDOException $e) {
            return false;
        }
    }

    // Xóa ngày nghỉ
    public function deleteHoliday($id) {
        try {
            $sql = "DELETE FROM holidays WHERE id = :id";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch(PDOException $e) {
            return false;
        }
    }

    // Xem tất cả ngày nghỉ
    public function viewAllHolidays() {
        try {
            $sql = "SELECT * FROM holidays";
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return false;
        }
    }
}
?>