<?php
class Asset {
    private $dbh;

    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    // Add a new asset
    public function addAsset($name, $uuid, $purchase_date, $purchase_from, $manufacturer, $model, $serial_number, $status, $supplier, $condition, $warranty, $value, $description) {
        try {
            $query = "INSERT INTO assets (name, uuid, purchase_date, purchase_from, manufacturer, model, serial_number, status, supplier, `condition`, warranty, value, description) 
                      VALUES (:name, :uuid, :purchase_date, :purchase_from, :manufacturer, :model, :serial_number, :status, :supplier, :condition, :warranty, :value, :description)";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':uuid', $uuid);
            $stmt->bindParam(':purchase_date', $purchase_date);
            $stmt->bindParam(':purchase_from', $purchase_from);
            $stmt->bindParam(':manufacturer', $manufacturer);
            $stmt->bindParam(':model', $model);
            $stmt->bindParam(':serial_number', $serial_number);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':supplier', $supplier);
            $stmt->bindParam(':condition', $condition);
            $stmt->bindParam(':warranty', $warranty);
            $stmt->bindParam(':value', $value);
            $stmt->bindParam(':description', $description);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Update asset information
    public function updateAsset($id, $name, $uuid, $purchase_date, $purchase_from, $manufacturer, $model, $serial_number, $status, $supplier, $condition, $warranty, $value, $description) {
        try {
            $query = "UPDATE assets SET name = :name, uuid = :uuid, purchase_date = :purchase_date, purchase_from = :purchase_from, 
                      manufacturer = :manufacturer, model = :model, serial_number = :serial_number, status = :status, supplier = :supplier, 
                      `condition` = :condition, warranty = :warranty, value = :value, description = :description WHERE id = :id";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':uuid', $uuid);
            $stmt->bindParam(':purchase_date', $purchase_date);
            $stmt->bindParam(':purchase_from', $purchase_from);
            $stmt->bindParam(':manufacturer', $manufacturer);
            $stmt->bindParam(':model', $model);
            $stmt->bindParam(':serial_number', $serial_number);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':supplier', $supplier);
            $stmt->bindParam(':condition', $condition);
            $stmt->bindParam(':warranty', $warranty);
            $stmt->bindParam(':value', $value);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Delete an asset
    public function deleteAsset($id) {
        try {
            $query = "DELETE FROM assets WHERE id = :id";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // View all assets
    public function viewAllAssets() {
        try {
            $query = "SELECT * FROM assets";
            $stmt = $this->dbh->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // View asset by ID
    public function viewAssetById($id) {
        try {
            $query = "SELECT * FROM assets WHERE id = :id";
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
