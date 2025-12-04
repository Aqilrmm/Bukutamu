<?php
// File: app/Controllers/Admin/Auth.php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    
    public function index()
    {
        // Redirect if already logged in
        if (session()->get('admin_logged_in')) {
            return redirect()->to('/admin/dashboard');
        }
        
        $data = ['title' => 'Login Admin'];
        return view('admin/auth/login', $data);
    }
    
    public function login()
    {
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        
        $user = $this->userModel->getByUsername($username);
        
        if ($user && password_verify($password, $user['password'])) {
            session()->set([
                'admin_id' => $user['id'],
                'admin_username' => $user['username'],
                'admin_full_name' => $user['full_name'],
                'admin_email' => $user['email'],
                'admin_photo' => $user['photo'],
                'admin_logged_in' => true
            ]);
            
            return redirect()->to('/admin/dashboard')->with('success', 'Login berhasil!');
        }
        
        return redirect()->back()->withInput()->with('error', 'Username atau password salah');
    }
    
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/admin/login')->with('success', 'Logout berhasil');
    }
}
