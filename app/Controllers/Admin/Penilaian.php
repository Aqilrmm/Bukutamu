<?php
// File: app/Controllers/Admin/Penilaian.php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PenilaianKategoriModel;

class Penilaian extends BaseController
{
    protected $penilaianKategoriModel;
    
    public function __construct()
    {
        $this->penilaianKategoriModel = new PenilaianKategoriModel();
    }
    
    public function index()
    {
        $data = [
            'title' => 'Kelola Penilaian',
            'penilaian' => $this->penilaianKategoriModel->orderBy('urutan', 'ASC')->findAll()
        ];
        
        return view('admin/penilaian/index', $data);
    }
    
    public function save()
    {
        $rules = ['nama' => 'required|min_length[3]'];
        
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $this->validator->getErrors()
            ]);
        }
        
        // Get max urutan
        $maxUrutan = $this->penilaianKategoriModel->selectMax('urutan')->first();
        $newUrutan = ($maxUrutan['urutan'] ?? 0) + 1;
        
        $data = [
            'nama' => $this->request->getPost('nama'),
            'urutan' => $newUrutan
        ];
        
        if ($this->penilaianKategoriModel->insert($data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data berhasil ditambahkan'
            ]);
        }
        
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Gagal menambahkan data'
        ]);
    }
    
    public function update($id)
    {
        $rules = ['nama' => 'required|min_length[3]'];
        
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $this->validator->getErrors()
            ]);
        }
        
        $data = ['nama' => $this->request->getPost('nama')];
        
        if ($this->penilaianKategoriModel->update($id, $data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data berhasil diupdate'
            ]);
        }
        
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Gagal mengupdate data'
        ]);
    }
    
    public function delete($id)
    {
        if ($this->penilaianKategoriModel->delete($id)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data berhasil dihapus'
            ]);
        }
        
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Gagal menghapus data'
        ]);
    }
    
    public function reorder()
    {
        $orders = $this->request->getPost('orders');
        
        if ($this->penilaianKategoriModel->reorderItems($orders)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Urutan berhasil diupdate'
            ]);
        }
        
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Gagal mengupdate urutan'
        ]);
    }
}