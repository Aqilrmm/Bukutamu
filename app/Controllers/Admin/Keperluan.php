<?php
// File: app/Controllers/Admin/Keperluan.php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KeperluanModel;

class Keperluan extends BaseController
{
    protected $keperluanModel;
    
    public function __construct()
    {
        $this->keperluanModel = new KeperluanModel();
    }
    
    public function index()
    {
        $data = [
            'title' => 'Kelola Keperluan',
            'keperluan' => $this->keperluanModel->orderBy('nama', 'ASC')->findAll()
        ];
        
        return view('admin/keperluan/index', $data);
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
        
        $data = ['nama' => $this->request->getPost('nama')];
        
        if ($this->keperluanModel->insert($data)) {
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
        
        if ($this->keperluanModel->update($id, $data)) {
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
        if ($this->keperluanModel->delete($id)) {
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
}
