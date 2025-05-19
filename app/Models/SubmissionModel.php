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
}