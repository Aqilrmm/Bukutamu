<?php
// File: app/Models/SurveiPenilaianModel.php
namespace App\Models;

class SurveiPenilaianModel extends BaseModel
{
    protected $table = 'survei_penilaian';
    protected $primaryKey = 'id';
    protected $allowedFields = ['survei_id', 'penilaian_kategori_id', 'rating'];
    protected $useTimestamps = false;

    public function getPenilaianBySurvei($surveiId)
    {
        return $this->select('survei_penilaian.*, penilaian_kategori.nama as kategori_nama')
            ->join('penilaian_kategori', 'penilaian_kategori.id = survei_penilaian.penilaian_kategori_id')
            ->where('survei_id', $surveiId)
            ->orderBy('penilaian_kategori.urutan', 'ASC')
            ->findAll();
    }

    public function insertBatsch($data)
    {
        return $this->db->table($this->table)->insertBatch($data);
    }

    public function getAverageRatings()
    {
        return $this->select('penilaian_kategori.nama as kategori, AVG(survei_penilaian.rating) as avg_rating')
            ->join('penilaian_kategori', 'penilaian_kategori.id = survei_penilaian.penilaian_kategori_id')
            ->groupBy('survei_penilaian.penilaian_kategori_id')
            ->orderBy('penilaian_kategori.urutan', 'ASC')
            ->findAll();
    }
}
