<?php

// File: app/Models/ProfilInstansiModel.php
namespace App\Models;

class ProfilInstansiModel extends BaseModel
{
    protected $table = 'profil_instansi';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama_instansi', 'telepon', 'email', 'website', 
        'alamat', 'logo', 'banner'
    ];
    protected $useTimestamps = false;
    
    public function getProfil()
    {
        $profil = $this->find(1);
        if (!$profil) {
            // Create default profile if not exists
            $this->insert([
                'id' => 1,
                'nama_instansi' => 'Instansi Anda',
                'alamat' => '-'
            ]);
            $profil = $this->find(1);
        }
        return $profil;
    }
    
    public function updateProfil($data)
    {
        return $this->update(1, $data);
    }
}