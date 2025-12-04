<?php

// File: app/Controllers/Admin/Survei.php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SurveiKepuasanModel;
use App\Models\SurveiPenilaianModel;

class Survei extends BaseController
{
    protected $surveiKepuasanModel;
    protected $surveiPenilaianModel;
    
    public function __construct()
    {
        $this->surveiKepuasanModel = new SurveiKepuasanModel();
        $this->surveiPenilaianModel = new SurveiPenilaianModel();
    }
    
    public function index()
    {
        $data = ['title' => 'Data Survei Kepuasan'];
        return view('admin/survei/index', $data);
    }
    
    public function apiGetSurvei()
    {
        $filters = [
            'tanggal_dari' => $this->request->getGet('tanggal_dari'),
            'tanggal_sampai' => $this->request->getGet('tanggal_sampai')
        ];
        
        $survei = $this->surveiKepuasanModel->getSurveiWithTamu($filters);
        
        return $this->response->setJSON(['data' => $survei]);
    }
    
    public function detail($id)
    {
        $survei = $this->surveiKepuasanModel->getSurveiDetail($id);
        
        if (!$survei) {
            return redirect()->back()->with('error', 'Data survei tidak ditemukan');
        }
        
        $penilaian = $this->surveiPenilaianModel->getPenilaianBySurvei($id);
        
        $data = [
            'title' => 'Detail Survei',
            'survei' => $survei,
            'penilaian' => $penilaian
        ];
        
        return view('admin/survei/detail', $data);
    }
}