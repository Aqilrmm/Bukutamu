<?php
// File: app/Models/UserModel.php
namespace App\Models;

class UserModel extends BaseModel
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'email', 'password', 'full_name', 'photo'];
    
    public function getByUsername($username)
    {
        return $this->where('username', $username)->first();
    }
    
    public function getByEmail($email)
    {
        return $this->where('email', $email)->first();
    }
}
