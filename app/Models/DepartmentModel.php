<?php

namespace App\Models;

use CodeIgniter\Model;

class DepartmentModel extends Model
{
    protected $table = 'departments';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'description'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getDepartmentsWithRepresentatives()
    {
        return $this->select('departments.*, GROUP_CONCAT(users.full_name SEPARATOR ", ") as representatives')
            ->join('users', 'users.department_id = departments.id AND users.role = "representative"', 'left')
            ->groupBy('departments.id')
            ->orderBy('departments.name')
            ->findAll();
    }

    public function getDepartmentsWithCompliance()
    {
        // This would be a more complex query in a real application
        // For now, we'll just return basic department info
        return $this->select('departments.*, 
                (SELECT COUNT(*) FROM submissions WHERE submissions.department_id = departments.id AND status = "approved") as approved_count,
                (SELECT COUNT(*) FROM submissions WHERE submissions.department_id = departments.id AND status = "rejected") as rejected_count,
                (SELECT COUNT(*) FROM submissions WHERE submissions.department_id = departments.id AND status = "pending") as pending_count')
            ->orderBy('departments.name')
            ->findAll();
    }
}