<?php
// File: app/Controllers/Admin/Profil.php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Profil extends BaseController
{
    protected $userModel;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    
    public function index()
    {
        $userId = session()->get('admin_id');
        $user = $this->userModel->find($userId);
        
        $data = [
            'title' => 'Profil Saya',
            'user' => $user
        ];
        
        return view('admin/profil/index', $data);
    }
    
    public function update()
    {
        $userId = session()->get('admin_id');
        
        $rules = [
            'full_name' => 'required|min_length[3]',
            'email' => 'required|valid_email'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $data = [
            'full_name' => $this->request->getPost('full_name'),
            'email' => $this->request->getPost('email')
        ];
        
        // Handle photo upload
        $photo = $this->request->getFile('photo');
        if ($photo && $photo->isValid() && !$photo->hasMoved()) {
            $user = $this->userModel->find($userId);
            
            // Delete old photo
            if ($user['photo'] && file_exists(FCPATH . 'uploads/users/' . $user['photo'])) {
                unlink(FCPATH . 'uploads/users/' . $user['photo']);
            }
            
            $uploadPath = FCPATH . 'uploads/users/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            $newName = 'user_' . $userId . '_' . time() . '.' . $photo->getExtension();
            $photo->move($uploadPath, $newName);
            $data['photo'] = $newName;
            
            // Update session
            session()->set('admin_photo', $newName);
        }
        
        if ($this->userModel->update($userId, $data)) {
            // Update session
            session()->set([
                'admin_full_name' => $data['full_name'],
                'admin_email' => $data['email']
            ]);
            
            return redirect()->back()->with('success', 'Profil berhasil diupdate');
        }
        
        return redirect()->back()->with('error', 'Gagal mengupdate profil');
    }
    
    public function changePassword()
    {
        $userId = session()->get('admin_id');
        
        $rules = [
            'current_password' => 'required',
            'new_password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[new_password]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }
        
        $user = $this->userModel->find($userId);
        $currentPassword = $this->request->getPost('current_password');
        
        if (!password_verify($currentPassword, $user['password'])) {
            return redirect()->back()->with('error', 'Password lama tidak sesuai');
        }
        
        $newPassword = $this->request->getPost('new_password');
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        
        if ($this->userModel->update($userId, ['password' => $hashedPassword])) {
            return redirect()->back()->with('success', 'Password berhasil diubah');
        }
        
        return redirect()->back()->with('error', 'Gagal mengubah password');
    }
}