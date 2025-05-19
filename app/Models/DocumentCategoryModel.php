<?php

namespace App\Models;

use CodeIgniter\Model;

class DocumentCategoryModel extends Model
{
    protected $table = 'document_categories';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'description', 'requirements', 'deadline_day'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getUpcomingRequirements()
    {
        $currentDay = date('j');
        $builder = $this->db->table($this->table);
        $builder->where('deadline_day >=', $currentDay);
        $builder->orderBy('deadline_day', 'ASC');
        $builder->limit(5);
        return $builder->get()->getResultArray();
    }
}