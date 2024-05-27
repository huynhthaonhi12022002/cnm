<?php
class Applicant {
    private $dbh;

    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    // Add a new applicant
    public function addApplicant($job_id, $name, $email, $cv, $message, $status, $user_id) {
        try {
            $query = "INSERT INTO job_applicants (job_id, name, email, cv, message, status, user_id) 
                      VALUES (:job_id, :name, :email, :cv, :message, :status, :user_id)";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':job_id', $job_id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':cv', $cv);
            $stmt->bindParam(':message', $message);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':user_id', $user_id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Update applicant information
    public function updateApplicant($id, $job_id, $name, $email, $cv, $message, $status) {
        try {
            $query = "UPDATE job_applicants SET job_id = :job_id, name = :name, email = :email, cv = :cv, 
                      message = :message, status = :status WHERE id = :id";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':job_id', $job_id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':cv', $cv);
            $stmt->bindParam(':message', $message);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Delete an applicant
    public function deleteApplicant($id) {
        try {
            $query = "DELETE FROM job_applicants WHERE id = :id";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // View all applicants
    public function viewAllApplicants() {
        try {
            $query = "SELECT * FROM job_applicants";
            $stmt = $this->dbh->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function downloadCV($id): void {
        try {
            $query = "SELECT cv FROM job_applicants WHERE id = :id";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($row && isset($row['cv'])) {
                $cvFilename = $row['cv'];
                $cvFilePath = "upload/cv/" . $cvFilename; 
                if (file_exists($cvFilePath)) {
                    header('Content-Description: File Transfer');
                    header('Content-Type: application/octet-stream');
                    header('Content-Disposition: attachment; filename=' . $cvFilename);
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($cvFilePath));
                    ob_clean();
                    flush();
                    readfile($cvFilePath);
                    exit;
                } else {
                    echo "CV file not found.";
                }
            } else {
                echo "CV file not found.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    

    // View applicant by ID
    public function viewApplicantById($id) {
        try {
            $query = "SELECT * FROM job_applicants WHERE job_id = :id";
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

