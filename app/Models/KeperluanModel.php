<?php

// File: app/Models/KeperluanModel.php
namespace App\Models;

class KeperluanModel extends BaseModel
{
    protected $table = 'keperluan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama', 'is_active', 'urutan'];
    
    public function getActiveOrdered()
    {
        return $this->where('is_active', 1)->orderBy('nama', 'ASC')->findAll();
    }
}