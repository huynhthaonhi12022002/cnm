<?php
class Certificate {
    private $dbh;

    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    // Add a certificate, because everyone deserves recognition, right?
    public function addCertificate($name) {
        try {
            $query = "INSERT INTO certificates (name) 
                      VALUES (:name)";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':name', $name);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Update certificate data, because sometimes achievements change, right?
    public function updateCertificate($id, $name) {
        try {
            $query = "UPDATE certificates SET name = :name WHERE id = :id";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Delete a certificate entry, because sometimes we need to revoke recognition, right?
    public function deleteCertificate($id) {
        try {
            $query = "DELETE FROM certificates WHERE id = :id";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // View all certificate data, because transparency is important, right?
    public function viewAllCertificates() {
        try {
            $query = "SELECT * FROM certificates";
            $stmt = $this->dbh->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // View certificate data by ID, because sometimes you need specifics, right?
    public function viewCertificateById($id) {
        try {
            $query = "SELECT * FROM certificates WHERE id = :id";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
?>
