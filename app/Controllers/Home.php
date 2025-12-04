<?php

namespace App\Controllers;

use App\Models\TamuModel;
use App\Models\KeperluanModel;
use App\Models\PenilaianKategoriModel;
use App\Models\SurveiKepuasanModel;
use App\Models\SurveiPenilaianModel;
use App\Models\ProfilInstansiModel;

class Home extends BaseController
{
    protected $tamuModel;
    protected $keperluanModel;
    protected $penilaianKategoriModel;
    protected $surveiKepuasanModel;
    protected $surveiPenilaianModel;
    protected $profilInstansiModel;
    
    public function __construct()
    {
        $this->tamuModel = new TamuModel();
        $this->keperluanModel = new KeperluanModel();
        $this->penilaianKategoriModel = new PenilaianKategoriModel();
        $this->surveiKepuasanModel = new SurveiKepuasanModel();
        $this->surveiPenilaianModel = new SurveiPenilaianModel();
        $this->profilInstansiModel = new ProfilInstansiModel();
    }
    
    public function index()
    {
        $data = [
            'title' => 'Selamat Datang',
            'profil' => $this->profilInstansiModel->getProfil()
        ];
        
        return view('landing/index', $data);
    }
    
    public function registrasi()
    {
        $data = [
            'title' => 'Registrasi Tamu',
            'profil' => $this->profilInstansiModel->getProfil(),
            'keperluan_list' => $this->keperluanModel->getActiveOrdered()
        ];
        
        return view('landing/registrasi', $data);
    }
    
    public function saveRegistrasi()
    {
        $rules = [
            'nama_lengkap' => 'required|min_length[3]',
            'no_hp' => 'required|numeric',
            'keperluan_id' => 'required|numeric',
            'tanda_tangan' => 'required'
        ];
        
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $this->validator->getErrors()
            ]);
        }
        
        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'email' => $this->request->getPost('email'),
            'no_hp' => $this->request->getPost('no_hp'),
            'asal_instansi' => $this->request->getPost('asal_instansi'),
            'alamat' => $this->request->getPost('alamat'),
            'keperluan_id' => $this->request->getPost('keperluan_id'),
            'bertemu_dengan' => $this->request->getPost('bertemu_dengan'),
            'tanda_tangan' => $this->request->getPost('tanda_tangan'),
            'waktu_masuk' => date('Y-m-d H:i:s'),
            'status' => 'masuk'
        ];
        
        $tamuId = $this->tamuModel->insert($data);
        
        if ($tamuId) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Registrasi berhasil! Terima kasih telah berkunjung.',
                'tamu_id' => $tamuId
            ]);
        }
        
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Terjadi kesalahan saat menyimpan data'
        ]);
    }
    
    public function survei()
    {
        $data = [
            'title' => 'Survei Kepuasan',
            'profil' => $this->profilInstansiModel->getProfil(),
            'penilaian_kategori' => $this->penilaianKategoriModel->getActiveOrdered()
        ];
        
        return view('landing/survei', $data);
    }
    
    public function getTamu()
    {
        $tamuList = $this->tamuModel->getTamuMasuk();
        return $this->response->setJSON([
            'success' => true,
            'data' => $tamuList
        ]);
    }
    
    public function saveSurvei()
    {
        $rules = [
            'tamu_id' => 'required|numeric'
        ];
        
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $this->validator->getErrors()
            ]);
        }
        
        $tamuId = $this->request->getPost('tamu_id');
        $penilaian = $this->request->getPost('penilaian'); // Array of ratings
        $saran = $this->request->getPost('saran');
        $kritik = $this->request->getPost('kritik');
        
        // Check if tamu exists and status is masuk
        $tamu = $this->tamuModel->find($tamuId);
        if (!$tamu) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data tamu tidak ditemukan'
            ]);
        }
        
        // Check if survey already exists
        $existingSurvei = $this->surveiKepuasanModel->where('tamu_id', $tamuId)->first();
        if ($existingSurvei) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Anda sudah mengisi survei kepuasan'
            ]);
        }
        
        // Start transaction
        $db = \Config\Database::connect();
        $db->transStart();
        
        // Insert survei kepuasan
        $surveiData = [
            'tamu_id' => $tamuId,
            'saran' => $saran,
            'kritik' => $kritik,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $surveiId = $this->surveiKepuasanModel->insert($surveiData);
        
        // Insert penilaian
        if ($surveiId && !empty($penilaian)) {
            $penilaianData = [];
            foreach ($penilaian as $kategoriId => $rating) {
                $penilaianData[] = [
                    'survei_id' => $surveiId,
                    'penilaian_kategori_id' => $kategoriId,
                    'rating' => $rating
                ];
            }
            $this->surveiPenilaianModel->insertBatsch($penilaianData);
        }
        
        // Update tamu status to keluar
        $this->tamuModel->update($tamuId, [
            'waktu_keluar' => date('Y-m-d H:i:s'),
            'status' => 'keluar'
        ]);
        
        $db->transComplete();
        
        if ($db->transStatus() === false) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan survei'
            ]);
        }
        
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Terima kasih atas masukan Anda!'
        ]);
    }
    
    public function getKeperluan()
    {
        $keperluan = $this->keperluanModel->getActiveOrdered();
        return $this->response->setJSON([
            'success' => true,
            'data' => $keperluan
        ]);
    }
    
    public function getPenilaianKategori()
    {
        $kategori = $this->penilaianKategoriModel->getActiveOrdered();
        return $this->response->setJSON([
            'success' => true,
            'data' => $kategori
        ]);
    }
    
    public function getProfilInstansi()
    {
        $profil = $this->profilInstansiModel->getProfil();
        return $this->response->setJSON([
            'success' => true,
            'data' => $profil
        ]);
    }
}