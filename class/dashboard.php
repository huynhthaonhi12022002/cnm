<?php
class Dashboard {
    private $dbh; 
    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    public function getCountEmployees() {
        $stmt = $this->dbh->query("SELECT COUNT(*) FROM employees");
        return $stmt->fetchColumn();
    }

    public function getCountTasks() {
        $stmt = $this->dbh->query("SELECT COUNT(*) FROM tasks");
        return $stmt->fetchColumn();
    }

    public function getCountClients() {
        $stmt = $this->dbh->query("SELECT COUNT(*) FROM clients");
        return $stmt->fetchColumn();
    }

    public function getCountProjects() {
        $stmt = $this->dbh->query("SELECT COUNT(*) FROM projects");
        return $stmt->fetchColumn();
    }

    public function getRecentProjects() {
        $stmt = $this->dbh->prepare("
            SELECT p.id, p.name, 
                (SELECT COUNT(*) FROM tasks t WHERE t.project_id = p.id AND t.status = '0') AS incomplete_tasks,
                (SELECT COUNT(*) FROM tasks t WHERE t.project_id = p.id AND t.status = '1') AS completed_tasks,
                (SELECT COUNT(*) FROM tasks t WHERE t.project_id = p.id) AS total_tasks,
                (CASE 
                    WHEN (SELECT COUNT(*) FROM tasks t WHERE t.project_id = p.id) = 0 THEN 0
                    ELSE (SELECT COUNT(*) FROM tasks t WHERE t.project_id = p.id AND t.status = '1') * 100.0 / (SELECT COUNT(*) FROM tasks t WHERE t.project_id = p.id)
                END) AS progress
            FROM projects p
            ORDER BY p.id DESC
            LIMIT 5
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRecentClients() {
        $sql = "SELECT * FROM getRecentClients  ORDER BY create_at DESC LIMIT 5";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTodayLeaves() {
        $today = date('Y-m-d');
        
        $sql = "SELECT COUNT(*) as count FROM leaves WHERE DATE(created_at) = :today";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(['today' => $today]);
        $todayLeaves = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

        $sql = "SELECT COUNT(*) as total FROM leaves";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        $totalLeaves = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        $percentage = ($totalLeaves > 0) ? ($todayLeaves / $totalLeaves) * 100 : 0;

        return [
            'today' => $todayLeaves,
            'total' => $totalLeaves,
            'percentage' => $percentage
        ];
    }

    public function getTodayApplicants() {
        $today = date('Y-m-d');

        $sql = "SELECT COUNT(*) as count FROM job_applicants WHERE DATE(created_at) = :today";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(['today' => $today]);
        $todayApplicants = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

        $sql = "SELECT COUNT(*) as total FROM job_applicants";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        $totalApplicants = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        $percentage = ($totalApplicants > 0) ? ($todayApplicants / $totalApplicants) * 100 : 0;

        return [
            'today' => $todayApplicants,
            'total' => $totalApplicants,
            'percentage' => $percentage
        ];
    }

    public function getTodayJobs() {
        $today = date('Y-m-d');

        $sql = "SELECT COUNT(*) as count FROM jobs WHERE DATE(created_at) = :today";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(['today' => $today]);
        $todayJobs = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

        $sql = "SELECT COUNT(*) as total FROM jobs";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        $totalJobs = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        $percentage = ($totalJobs > 0) ? ($todayJobs / $totalJobs) * 100 : 0;

        return [
            'today' => $todayJobs,
            'total' => $totalJobs,
            'percentage' => $percentage
        ];
    }

    public function getCompletedProjects() {
        $sql = "SELECT COUNT(*) as count FROM projects WHERE status = 1";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        $completedCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

        $sql = "SELECT COUNT(*) as total FROM projects";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        $totalCount = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

     
        $percentage = ($totalCount > 0) ? ($completedCount / $totalCount) * 100 : 0;

        return [
            'today' => $completedCount,
            'total' => $totalCount,
            'percentage' => $percentage
        ];
    }

    public function getEmployeesOnLeave() {
        $today = date('Y-m-d');
        $sql = " SELECT e.id, e.firstname, e.lastname, l.status, l.created_at,e.avatar
                FROM employees e
                JOIN leaves l ON e.id = l.employee_id
                WHERE DATE(l.created_at) = :today
        ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(['today' => $today]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEmployeeDashboardSummary($employeeId) {
        $stmt = $this->dbh->prepare("
            SELECT 
                COUNT(p.id) AS total_projects,
                COUNT(t.id) AS total_tasks,
                SUM(CASE WHEN t.status = '0' THEN 1 ELSE 0 END) AS pending_tasks
            FROM projects p
            LEFT JOIN tasks t ON t.project_id = p.id
            WHERE t.employee_id = :employeeId 
        ");
        $stmt->bindParam(':employeeId', $employeeId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getEmployeeProjectCount($employeeId) {
        try {
            $query = "SELECT 
            COUNT(DISTINCT p.id) AS total_projects
            FROM projects p
            WHERE JSON_CONTAINS(p.team, '\"$employeeId\"')";
            $stmt = $this->dbh->prepare($query);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC)['total_projects'];
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
?>
