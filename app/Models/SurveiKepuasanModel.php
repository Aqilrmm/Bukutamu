<?php
// File: app/Models/SurveiKepuasanModel.php
namespace App\Models;

class SurveiKepuasanModel extends BaseModel
{
    protected $table = 'survei_kepuasan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tamu_id', 'saran', 'kritik'];
    protected $useTimestamps = false;
    
    public function getSurveiWithTamu($filters = [])
    {
        $builder = $this->select('survei_kepuasan.*, tamu.nama_lengkap, tamu.asal_instansi, tamu.no_hp')
                        ->join('tamu', 'tamu.id = survei_kepuasan.tamu_id');
        
        if (isset($filters['tanggal_dari'])) {
            $builder->where('DATE(survei_kepuasan.created_at) >=', $filters['tanggal_dari']);
        }
        
        if (isset($filters['tanggal_sampai'])) {
            $builder->where('DATE(survei_kepuasan.created_at) <=', $filters['tanggal_sampai']);
        }
        
        return $builder->orderBy('survei_kepuasan.created_at', 'DESC')->findAll();
    }
    
    public function getSurveiDetail($id)
    {
        return $this->select('survei_kepuasan.*, tamu.nama_lengkap, tamu.email, tamu.no_hp, tamu.asal_instansi')
                    ->join('tamu', 'tamu.id = survei_kepuasan.tamu_id')
                    ->find($id);
    }
}