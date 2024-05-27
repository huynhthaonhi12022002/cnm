<?php
class Client {
    private $dbh; // Đối tượng PDO cho kết nối cơ sở dữ liệu
    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    // Phương thức thêm mới một client vào cơ sở dữ liệu
    public function addClient($firstname, $lastname, $email, $phone, $company, $address, $avatar) {
        $sql = "INSERT INTO clients (firstname, lastname, email, phone, company, address, avatar) VALUES (:firstname, :lastname, :email, :phone, :company, :address, :avatar)";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':company', $company, PDO::PARAM_STR);
        $stmt->bindParam(':address', $address, PDO::PARAM_STR);
        $stmt->bindParam(':avatar', $avatar, PDO::PARAM_STR);
        return $stmt->execute();
    }

    // Phương thức sửa thông tin của một client trong cơ sở dữ liệu
    public function updateClient($id, $firstname, $lastname, $email, $phone, $company, $address, $avatar) {
        $sql = "UPDATE clients SET firstname = :firstname, lastname = :lastname, email = :email, phone = :phone, company = :company, address = :address, avatar = :avatar WHERE id = :id";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':company', $company, PDO::PARAM_STR);
        $stmt->bindParam(':address', $address, PDO::PARAM_STR);
        $stmt->bindParam(':avatar', $avatar, PDO::PARAM_STR);
        return $stmt->execute();
    }

    // Phương thức xóa một client khỏi cơ sở dữ liệu
    public function deleteClient($id) {
        $sql = "DELETE FROM clients WHERE id = :id";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Phương thức lấy thông tin của tất cả các clients từ cơ sở dữ liệu
    public function getAllClients() {
        $sql = "SELECT * FROM clients";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Phương thức lấy thông tin của một client dựa trên ID
    public function getClientById($id) {
        $sql = "SELECT * FROM clients WHERE id = :id";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
}
?>
