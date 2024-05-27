<?php

class Task {
    private $dbh;

    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    // Add a new task
    public function addTask($title, $description, $start_date, $end_date, $status, $project_id, $employee_id, $file) {
        try {
            $query = "INSERT INTO tasks (title, description, start_date, end_date, status, project_id, employee_id, file) 
                      VALUES (:title, :description, :start_date, :end_date, :status, :project_id, :employee_id, :file)";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':start_date', $start_date);
            $stmt->bindParam(':end_date', $end_date);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':project_id', $project_id);
            $stmt->bindParam(':employee_id', $employee_id);
            $stmt->bindParam(':file', $file);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Update task information
    public function updateTask($id, $title, $description, $start_date, $end_date, $status, $project_id, $employee_id, $file) {
        try {
            $query = "UPDATE tasks SET title = :title, description = :description, start_date = :start_date, end_date = :end_date, 
                      status = :status, project_id = :project_id, employee_id = :employee_id, file = :file WHERE id = :id";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':start_date', $start_date);
            $stmt->bindParam(':end_date', $end_date);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':project_id', $project_id);
            $stmt->bindParam(':employee_id', $employee_id);
            $stmt->bindParam(':file', $file);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Delete a task
    public function deleteTask($id) {
        try {
            $query = "DELETE FROM tasks WHERE id = :id";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // View all tasks
    public function viewAllTasks() {
        try {
            $query = "SELECT tasks.*, employees.firstname,employees.lastname, projects.name AS project_name 
                      FROM tasks
                      INNER JOIN employees ON tasks.employee_id = employees.id
                      INNER JOIN projects ON tasks.project_id = projects.id";
            $stmt = $this->dbh->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    

    // View task by ID
    public function viewTaskById($id) {
        try {
            $query = "SELECT * FROM tasks WHERE id = :id";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function downloadFile($id): void {
        try {
            $query = "SELECT file FROM tasks WHERE id = :id";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($row && isset($row['file'])) {
                $fileName = $row['file'];
                $filePath = "upload/files/" . $fileName; 
                if (file_exists($filePath)) {
                    header('Content-Description: File Transfer');
                    header('Content-Type: application/octet-stream');
                    header('Content-Disposition: attachment; filename=' . $fileName);
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($filePath));
                    ob_clean();
                    flush();
                    readfile($filePath);
                    exit;
                } else {
                    echo "File not found.";
                }
            } else {
                echo "File not found.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    public function getTaskByEmp($id) {
        try {
            $query = "SELECT tasks.*, employees.firstname,employees.lastname, projects.name AS project_name 
            FROM tasks
            INNER JOIN employees ON tasks.employee_id = employees.id
            INNER JOIN projects ON tasks.project_id = projects.id WHERE employee_id = :id";
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
