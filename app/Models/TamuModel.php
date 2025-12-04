<?php
// File: app/Models/TamuModel.php
namespace App\Models;

class TamuModel extends BaseModel
{
    protected $table = 'tamu';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama_lengkap', 'email', 'no_hp', 'asal_instansi', 'alamat', 
        'keperluan_id', 'bertemu_dengan', 'foto', 'tanda_tangan', 
        'waktu_masuk', 'waktu_keluar', 'status'
    ];
    
    public function getTamuWithKeperluan($filters = [])
    {
        $builder = $this->select('tamu.*, keperluan.nama as keperluan_nama')
                        ->join('keperluan', 'keperluan.id = tamu.keperluan_id', 'left');
        
        if (isset($filters['tanggal_dari'])) {
            $builder->where('DATE(tamu.waktu_masuk) >=', $filters['tanggal_dari']);
        }
        
        if (isset($filters['tanggal_sampai'])) {
            $builder->where('DATE(tamu.waktu_masuk) <=', $filters['tanggal_sampai']);
        }
        
        if (isset($filters['status']) && $filters['status'] !== '') {
            $builder->where('tamu.status', $filters['status']);
        }
        
        return $builder->orderBy('tamu.waktu_masuk', 'DESC')->findAll();
    }
    
    public function getTamuDetail($id)
    {
        return $this->select('tamu.*, keperluan.nama as keperluan_nama')
                    ->join('keperluan', 'keperluan.id = tamu.keperluan_id', 'left')
                    ->find($id);
    }
    
    public function getTamuToday()
    {
        return $this->where('DATE(waktu_masuk)', date('Y-m-d'))
                    ->orderBy('waktu_masuk', 'DESC')
                    ->findAll();
    }
    
    public function getTamuMasuk()
    {
        return $this->select('id, nama_lengkap')
                    ->where('status', 'masuk')
                    ->orderBy('waktu_masuk', 'DESC')
                    ->findAll();
    }
    
    public function updateWaktuKeluar($id)
    {
        return $this->update($id, [
            'waktu_keluar' => date('Y-m-d H:i:s'),
            'status' => 'keluar'
        ]);
    }
    
    public function getStatistik()
    {
        $today = date('Y-m-d');
        
        return [
            'total_hari_ini' => $this->where('DATE(waktu_masuk)', $today)->countAllResults(),
            'masuk_hari_ini' => $this->where('DATE(waktu_masuk)', $today)->where('status', 'masuk')->countAllResults(),
            'keluar_hari_ini' => $this->where('DATE(waktu_masuk)', $today)->where('status', 'keluar')->countAllResults(),
            'total_bulan_ini' => $this->where('MONTH(waktu_masuk)', date('m'))->where('YEAR(waktu_masuk)', date('Y'))->countAllResults(),
        ];
    }
}