<?php

namespace App\Models;

use CodeIgniter\Model;

class SubmissionHistoryModel extends Model
{
    protected $table = 'submission_history';
    protected $primaryKey = 'id';
    protected $allowedFields = ['submission_id', 'user_id', 'action', 'old_status', 'new_status', 'remarks', 'updated_at'];
    protected $useTimestamps = false;

    protected $updatedField = 'null';
    protected $createdField = 'created_at';

    public function getHistoryForSubmission($submissionId)
    {
        return $this->select('submission_history.*, users.full_name as user_name')
            ->join('users', 'users.id = submission_history.user_id')
            ->where('submission_id', $submissionId)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }
}