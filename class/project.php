<?php
class Project {
    private $dbh;

    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    // Add a new project
    public function addProject($name, $client_id, $start_date, $end_date, $rate, $priority, $leader, $team, $description, $files, $progress, $status) {
        try {
            $query = "INSERT INTO projects (name, client_id, start_date, end_date, rate, priority, leader, team, description, files, progress, status) 
                      VALUES (:name, :client_id, :start_date, :end_date, :rate, :priority, :leader, :team, :description, :files, :progress, :status)";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':client_id', $client_id);
            $stmt->bindParam(':start_date', $start_date);
            $stmt->bindParam(':end_date', $end_date);
            $stmt->bindParam(':rate', $rate);
            $stmt->bindParam(':priority', $priority);
            $stmt->bindParam(':leader', $leader);
            $stmt->bindParam(':team', $team);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':files', $files);
            $stmt->bindParam(':progress', $progress);
            $stmt->bindParam(':status', $status);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Update project information
    public function updateProject($id, $name, $client_id, $start_date, $end_date, $rate, $priority, $leader, $team, $description, $files, $progress, $status) {
        try {
            $query = "UPDATE projects SET name = :name, client_id = :client_id, start_date = :start_date, end_date = :end_date, 
                      rate = :rate, priority = :priority, leader = :leader, team = :team, description = :description, files = :files, 
                      progress = :progress, status = :status WHERE id = :id";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':client_id', $client_id);
            $stmt->bindParam(':start_date', $start_date);
            $stmt->bindParam(':end_date', $end_date);
            $stmt->bindParam(':rate', $rate);
            $stmt->bindParam(':priority', $priority);
            $stmt->bindParam(':leader', $leader);
            $stmt->bindParam(':team', $team);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':files', $files);
            $stmt->bindParam(':progress', $progress);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Delete a project
    public function deleteProject($id) {
        try {
            $query = "DELETE FROM projects WHERE id = :id";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // View all projects
    public function viewAllProjects() {
        try {
            $query = "SELECT projects.name, projects.rate, projects.client_id, projects.start_date, projects.end_date, projects.priority, projects.leader, projects.team , projects.description, projects.files, projects.progress, projects.status, projects.created_at, projects.id as project_id, clients.firstname as firstname_c, clients.lastname as lastname_c, employees.*
            FROM projects 
            INNER JOIN clients ON projects.client_id = clients.id
            INNER JOIN employees ON projects.leader = employees.id";
            $stmt = $this->dbh->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function getProjectsByEmp($employeeId) {
        try {
            $query = "SELECT projects.name, projects.rate, projects.client_id, projects.start_date, projects.end_date, projects.priority, projects.leader, projects.team , projects.description, projects.files, projects.progress, projects.status, projects.created_at, projects.id as project_id, clients.firstname AS firstname_c, clients.lastname AS lastname_c, employees.*
                      FROM projects 
                      INNER JOIN clients ON projects.client_id = clients.id
                      INNER JOIN employees ON projects.leader = employees.id 
                      WHERE JSON_CONTAINS(projects.team, '\"$employeeId\"')";
            $stmt = $this->dbh->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


    // View project by ID
    public function viewProjectById($id) {
        try {
            $query = "SELECT projects.*, employees.firstname, employees.lastname
            FROM projects 
            INNER JOIN employees ON projects.leader = employees.id
            WHERE projects.id = :id";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function getEmployeeById($id) {
        try {
            $query = "SELECT * FROM employees WHERE id = :id";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function viewProjectWithTasksById($id) {
        try {
            $query = "SELECT 
                        projects.*, 
                        tasks.id AS task_id,
                        tasks.title AS task_title,
                        tasks.status AS task_status
                    FROM 
                        projects 
                    LEFT JOIN 
                        tasks ON tasks.project_id = projects.id
                    WHERE 
                        projects.id = :id";
                        
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $projectDetails = null;
            $allTasks = [];
            $pendingTasks = [];
            $completedTasks = [];
    
            foreach ($result as $row) {
                if ($projectDetails === null) {
                    $projectDetails = [
                        'id' => $row['id'],
                        'title' => $row['title'],
                        'status' => $row['status'],
                    ];
                }
                
                if ($row['task_id']) {
                    $task = [
                        'id' => $row['task_id'],
                        'title' => $row['task_title'],
                        'status' => $row['task_status']
                    ];
    
                    $allTasks[] = $task;
    
                    if ($row['task_status'] == 0) {
                        $pendingTasks[] = $task;
                    } elseif ($row['task_status'] == 1) {
                        $completedTasks[] = $task;
                    }
                }
            }
    
            return [
                'project' => $projectDetails,
                'allTasks' => $allTasks,
                'pendingTasks' => $pendingTasks,
                'completedTasks' => $completedTasks
            ];
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
?>
