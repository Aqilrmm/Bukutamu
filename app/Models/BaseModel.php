<?php

namespace App\Models;

use CodeIgniter\Model;

class BaseModel extends Model
{
    protected $useTimestamps = true;
    protected $useSoftDeletes = false;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    /**
     * Get all active records
     */
    public function getActive()
    {
        return $this->where('is_active', 1)->findAll();
    }
    
    /**
     * Toggle active status
     */
    public function toggleActive($id)
    {
        $record = $this->find($id);
        if ($record) {
            return $this->update($id, ['is_active' => !$record['is_active']]);
        }
        return false;
    }
    
    /**
     * Soft delete by updating is_active
     */
    public function softDelete($id)
    {
        return $this->update($id, ['is_active' => 0]);
    }
}