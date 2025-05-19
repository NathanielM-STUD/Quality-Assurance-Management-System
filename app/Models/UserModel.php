<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'email', 'password', 'full_name', 'role', 'department_id', 'reset_token', 'reset_expiry'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getUsersWithDepartments()
    {
        return $this->select('users.*, departments.name as department_name')
            ->join('departments', 'departments.id = users.department_id', 'left')
            ->orderBy('users.role', 'DESC')
            ->orderBy('users.full_name')
            ->findAll();
    }
}