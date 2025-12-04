<?php
// File: app/Models/PenilaianKategoriModel.php
namespace App\Models;

class PenilaianKategoriModel extends BaseModel
{
    protected $table = 'penilaian_kategori';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama', 'urutan', 'is_active'];
    
    public function getActiveOrdered()
    {
        return $this->where('is_active', 1)->orderBy('urutan', 'ASC')->findAll();
    }
    
    public function reorderItems($orders)
    {
        $db = $this->db;
        $db->transStart();
        
        foreach ($orders as $order) {
            $this->update($order['id'], ['urutan' => $order['urutan']]);
        }
        
        $db->transComplete();
        return $db->transStatus();
    }
}