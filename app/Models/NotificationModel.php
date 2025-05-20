<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $table = 'notifications';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'title', 'message', 'is_read', 'related_module', 'related_id'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';

    public function getUserNotifications($userId, $limit = 5)
{
    return $this->where('user_id', $userId)
               ->orderBy('created_at', 'DESC')
               ->limit($limit)
               ->findAll();
}
}