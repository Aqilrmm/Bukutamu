<?php
// File: app/Controllers/Admin/ProfilInstansi.php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProfilInstansiModel;

class ProfilInstansi extends BaseController
{
    protected $profilInstansiModel;
    
    public function __construct()
    {
        $this->profilInstansiModel = new ProfilInstansiModel();
    }
    
    public function index()
    {
        $data = [
            'title' => 'Profil Instansi',
            'profil' => $this->profilInstansiModel->getProfil()
        ];
        
        return view('admin/profil_instansi/index', $data);
    }
    
    public function update()
    {
        $rules = [
            'nama_instansi' => 'required|min_length[3]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $data = [
            'nama_instansi' => $this->request->getPost('nama_instansi'),
            'telepon' => $this->request->getPost('telepon'),
            'email' => $this->request->getPost('email'),
            'website' => $this->request->getPost('website'),
            'alamat' => $this->request->getPost('alamat')
        ];
        
        // Handle logo upload
        $logo = $this->request->getFile('logo');
        if ($logo && $logo->isValid() && !$logo->hasMoved()) {
            $profil = $this->profilInstansiModel->getProfil();
            
            // Delete old logo
            if ($profil['logo'] && file_exists(FCPATH . 'uploads/profil/' . $profil['logo'])) {
                unlink(FCPATH . 'uploads/profil/' . $profil['logo']);
            }
            
            $uploadPath = FCPATH . 'uploads/profil/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            $newName = 'logo_' . time() . '.' . $logo->getExtension();
            $logo->move($uploadPath, $newName);
            $data['logo'] = $newName;
        }
        
        // Handle banner upload
        $banner = $this->request->getFile('banner');
        if ($banner && $banner->isValid() && !$banner->hasMoved()) {
            $profil = $this->profilInstansiModel->getProfil();
            
            // Delete old banner
            if ($profil['banner'] && file_exists(FCPATH . 'uploads/profil/' . $profil['banner'])) {
                unlink(FCPATH . 'uploads/profil/' . $profil['banner']);
            }
            
            $uploadPath = FCPATH . 'uploads/profil/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            $newName = 'banner_' . time() . '.' . $banner->getExtension();
            $banner->move($uploadPath, $newName);
            $data['banner'] = $newName;
        }
        
        if ($this->profilInstansiModel->updateProfil($data)) {
            return redirect()->back()->with('success', 'Profil instansi berhasil diupdate');
        }
        
        return redirect()->back()->with('error', 'Gagal mengupdate profil instansi');
    }
}