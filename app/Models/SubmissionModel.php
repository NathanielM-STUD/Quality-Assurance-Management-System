<?php

namespace App\Models;

use CodeIgniter\Model;

class SubmissionModel extends Model
{
    protected $table = 'submissions';
    protected $primaryKey = 'id';
    protected $allowedFields = ['document_category_id', 'department_id', 'user_id', 'title', 'description', 'file_path', 'status', 'remarks'];
    protected $useTimestamps = true;
    protected $createdField = 'submitted_at';
    protected $updatedField = 'updated_at';

    public function getSubmissionWithDetails($id)
    {
        return $this->select('submissions.*, 
                departments.name as department_name, 
                document_categories.name as category_name,
                users.full_name as submitted_by,
                document_categories.requirements')
            ->join('departments', 'departments.id = submissions.department_id')
            ->join('document_categories', 'document_categories.id = submissions.document_category_id')
            ->join('users', 'users.id = submissions.user_id')
            ->where('submissions.id', $id)
            ->first();
    }

    public function getUserSubmissionsWithDetails($userId, $perPage = 10)
        {
            return $this->select('submissions.*, 
                    departments.name as department_name, 
                    document_categories.name as category_name,
                    users.full_name as submitted_by')
                ->join('departments', 'departments.id = submissions.department_id')
                ->join('document_categories', 'document_categories.id = submissions.document_category_id')
                ->join('users', 'users.id = submissions.user_id')
                ->where('submissions.user_id', $userId)
                ->orderBy('submissions.submitted_at', 'DESC')
                ->paginate($perPage);
        }
    public function getStatusSummary($userId = null)
{
    $query = $this->select('status, COUNT(*) as count')
                 ->groupBy('status');

    if ($userId !== null) {
        $query->where('user_id', $userId);
    }

    $results = $query->get()->getResultArray();

    // Define all possible statuses with default 0 counts
    $defaultStatuses = [
        'pending' => 0,
        'approved' => 0,
        'rejected' => 0,
        'reviewed' => 0,  // Add this line
        // Add other statuses if needed
    ];

    // Merge with actual results
    $summary = $defaultStatuses;
    foreach ($results as $row) {
        $summary[$row['status']] = $row['count'];
    }

    return $summary;
}
}