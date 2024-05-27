<?php
class Payroll {
    private $dbh;

    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    // Add a new payroll entry
    public function addPayroll($employee_id, $work_day, $allowance, $month_salary, $status, $deduction, $total_salary, $paid_type, $paid_date) {
        try {
            $query = "INSERT INTO payrolls (employee_id, work_day, allowance, month_salary, status, deduction, total_salary, paid_type, paid_date) 
                      VALUES (:employee_id, :work_day, :allowance, :month_salary, :status, :deduction, :total_salary, :paid_type, :paid_date)";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':employee_id', $employee_id);
            $stmt->bindParam(':work_day', $work_day);
            $stmt->bindParam(':allowance', $allowance);
            $stmt->bindParam(':month_salary', $month_salary);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':deduction', $deduction);
            $stmt->bindParam(':total_salary', $total_salary);
            $stmt->bindParam(':paid_type', $paid_type);
            $stmt->bindParam(':paid_date', $paid_date);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Update payroll information
    public function updatePayroll($id, $employee_id, $work_day, $allowance, $month_salary, $status, $deduction, $total_salary, $paid_type, $paid_date) {
        try {
            $query = "UPDATE payrolls SET employee_id = :employee_id, work_day = :work_day, allowance = :allowance, 
                      month_salary = :month_salary, status = :status, deduction = :deduction, total_salary = :total_salary, 
                      paid_type = :paid_type, paid_date = :paid_date WHERE id = :id";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':employee_id', $employee_id);
            $stmt->bindParam(':work_day', $work_day);
            $stmt->bindParam(':allowance', $allowance);
            $stmt->bindParam(':month_salary', $month_salary);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':deduction', $deduction);
            $stmt->bindParam(':total_salary', $total_salary);
            $stmt->bindParam(':paid_type', $paid_type);
            $stmt->bindParam(':paid_date', $paid_date);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Delete a payroll entry
    public function deletePayroll($id) {
        try {
            $query = "DELETE FROM payrolls WHERE id = :id";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // View all payroll information
    public function viewAllPayroll() {
        try {
            $query = "SELECT payrolls.*, employees.firstname, employees.lastname,employees.basic_salary
            FROM payrolls
            INNER JOIN employees ON payrolls.employee_id = employees.id;";
            $stmt = $this->dbh->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    public function getEmployeeById($id) {
        try {
            $query = "SELECT e.*, d.name AS department_name, des.name AS designation_name 
            FROM employees AS e 
            LEFT JOIN departments AS d ON e.department_id = d.id 
            LEFT JOIN designations AS des ON e.designation_id = des.id WHERE e.id = :id";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    // View payroll information by ID
    public function viewPayrollById($id) {
        try {
            $query = "SELECT * FROM payrolls WHERE id = :id";
            $stmt = $this->dbh->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function getPayrollByEmp($id) {
        try {
            $query = "SELECT * FROM payrolls WHERE employee_id = :id";
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
