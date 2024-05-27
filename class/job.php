<?php

class Job {
    private $dbh;

    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    // Thêm công việc mới
    public function addJob($title, $department_id, $location, $vacancies, $experience, $age, $salary_from, $salary_to, $type, $status, $start_date, $expire_date, $description) {
        try {
            $query = "INSERT INTO jobs (title, department_id, location, vacancies, experience, age, salary_from, salary_to, type, status, start_date, expire_date, description) 
                      VALUES (:title, :department_id, :location, :vacancies, :experience, :age, :salary_from, :salary_to, :type, :status, :start_date, :expire_date, :description)";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':department_id', $department_id);
            $stmt->bindParam(':location', $location);
            $stmt->bindParam(':vacancies', $vacancies);
            $stmt->bindParam(':experience', $experience);
            $stmt->bindParam(':age', $age);
            $stmt->bindParam(':salary_from', $salary_from);
            $stmt->bindParam(':salary_to', $salary_to);
            $stmt->bindParam(':type', $type);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':start_date', $start_date);
            $stmt->bindParam(':expire_date', $expire_date);
            $stmt->bindParam(':description', $description);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Sửa thông tin công việc
    public function updateJob($id, $title, $department_id, $location, $vacancies, $experience, $age, $salary_from, $salary_to, $type, $status, $start_date, $expire_date, $description) {
        try {
            $query = "UPDATE jobs 
                      SET title = :title, department_id = :department_id, location = :location, vacancies = :vacancies, experience = :experience, age = :age, 
                          salary_from = :salary_from, salary_to = :salary_to, type = :type, status = :status, start_date = :start_date, expire_date = :expire_date, 
                          description = :description 
                      WHERE id = :id";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':department_id', $department_id);
            $stmt->bindParam(':location', $location);
            $stmt->bindParam(':vacancies', $vacancies);
            $stmt->bindParam(':experience', $experience);
            $stmt->bindParam(':age', $age);
            $stmt->bindParam(':salary_from', $salary_from);
            $stmt->bindParam(':salary_to', $salary_to);
            $stmt->bindParam(':type', $type);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':start_date', $start_date);
            $stmt->bindParam(':expire_date', $expire_date);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Xóa công việc
    public function deleteJob($id) {
        try {
            $query = "DELETE FROM jobs WHERE id = :id";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Xem thông tin công việc
    public function getJobById($id) {
        try {
            $query = "SELECT * FROM jobs WHERE id = :id";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


    public function getCandidates($job_id) {
        try {
            $query = "SELECT COUNT(ja.id) AS num_applicants
            FROM job_applicants AS ja
            LEFT JOIN jobs AS j ON ja.job_id = j.id
            WHERE ja.job_id = :job_id
            GROUP BY ja.job_id";  
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':job_id', $job_id, PDO::PARAM_INT);
            $stmt->execute();
            // Sử dụng fetch() thay vì fetchAll()
            $result = $stmt->fetch(PDO::FETCH_ASSOC); 
            return $result['num_applicants']; 
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    
    

    // Xem tất cả các công việc kèm theo tên của các phòng ban
    public function viewAllJobs() {
        try {
            $query = "SELECT j.*, d.name AS department_name 
                    FROM jobs AS j 
                    LEFT JOIN departments AS d ON j.department_id = d.id";
            $stmt = $this->dbh->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


}
