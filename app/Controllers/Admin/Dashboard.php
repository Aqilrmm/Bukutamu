<?php

// File: app/Controllers/Admin/Dashboard.php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TamuModel;
use App\Models\SurveiKepuasanModel;
use App\Models\SurveiPenilaianModel;

class Dashboard extends BaseController
{
    protected $tamuModel;
    protected $surveiKepuasanModel;
    protected $surveiPenilaianModel;
    
    public function __construct()
    {
        $this->tamuModel = new TamuModel();
        $this->surveiKepuasanModel = new SurveiKepuasanModel();
        $this->surveiPenilaianModel = new SurveiPenilaianModel();
    }
    
    public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'statistik' => $this->tamuModel->getStatistik(),
            'avg_ratings' => $this->surveiPenilaianModel->getAverageRatings(),
            'recent_tamu' => $this->tamuModel->orderBy('waktu_masuk', 'DESC')->findAll(5)
        ];
        
        return view('admin/dashboard/index', $data);
    }
}