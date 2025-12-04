<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TamuModel;
use App\Models\KeperluanModel;
use Mpdf\Mpdf;

class Tamu extends BaseController
{
    protected $tamuModel;
    protected $keperluanModel;
    
    public function __construct()
    {
        $this->tamuModel = new TamuModel();
        $this->keperluanModel = new KeperluanModel();
    }
    
    public function index()
    {
        $data = [
            'title' => 'Data Tamu',
            'keperluan_list' => $this->keperluanModel->getActiveOrdered()
        ];
        
        return view('admin/tamu/index', $data);
    }
    
    public function apiGetTamu()
    {
        $filters = [
            'tanggal_dari' => $this->request->getGet('tanggal_dari'),
            'tanggal_sampai' => $this->request->getGet('tanggal_sampai'),
            'status' => $this->request->getGet('status')
        ];
        
        $tamu = $this->tamuModel->getTamuWithKeperluan($filters);
        
        return $this->response->setJSON([
            'data' => $tamu
        ]);
    }
    
    public function detail($id)
    {
        $tamu = $this->tamuModel->getTamuDetail($id);
        
        if (!$tamu) {
            return redirect()->back()->with('error', 'Data tamu tidak ditemukan');
        }
        
        $data = [
            'title' => 'Detail Tamu',
            'tamu' => $tamu
        ];
        
        return view('admin/tamu/detail', $data);
    }
    
    public function uploadFoto($id)
    {
        $tamu = $this->tamuModel->find($id);
        
        if (!$tamu) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data tamu tidak ditemukan'
            ]);
        }
        
        $foto = $this->request->getFile('foto');
        
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $validationRule = [
                'foto' => [
                    'rules' => 'uploaded[foto]|max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
                ]
            ];
            
            if (!$this->validate($validationRule)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'File tidak valid',
                    'errors' => $this->validator->getErrors()
                ]);
            }
            
            // Delete old photo if exists
            if ($tamu['foto'] && file_exists(FCPATH . 'uploads/tamu/' . $tamu['foto'])) {
                unlink(FCPATH . 'uploads/tamu/' . $tamu['foto']);
            }
            
            // Create uploads directory if not exists
            $uploadPath = FCPATH . 'uploads/tamu/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            $newName = $foto->getRandomName();
            $foto->move($uploadPath, $newName);
            
            $this->tamuModel->update($id, ['foto' => $newName]);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Foto berhasil diupload',
                'foto' => $newName
            ]);
        }
        
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Tidak ada file yang diupload'
        ]);
    }
    
    public function updateWaktuKeluar($id)
    {
        $tamu = $this->tamuModel->find($id);
        
        if (!$tamu) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data tamu tidak ditemukan'
            ]);
        }
        
        if ($this->tamuModel->updateWaktuKeluar($id)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Waktu keluar berhasil diupdate'
            ]);
        }
        
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Gagal mengupdate waktu keluar'
        ]);
    }
    
    public function exportCSV()
    {
        $filters = [
            'tanggal_dari' => $this->request->getGet('tanggal_dari'),
            'tanggal_sampai' => $this->request->getGet('tanggal_sampai'),
            'status' => $this->request->getGet('status')
        ];
        
        $tamu = $this->tamuModel->getTamuWithKeperluan($filters);
        
        $filename = 'data_tamu_' . date('Ymd_His') . '.csv';
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        
        // Add BOM for UTF-8
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        // Header
        fputcsv($output, ['No', 'Waktu Masuk', 'Nama Lengkap', 'Email', 'No. HP', 'Asal Instansi', 'Alamat', 'Keperluan', 'Bertemu Dengan', 'Waktu Keluar', 'Status']);
        
        // Data
        $no = 1;
        foreach ($tamu as $t) {
            fputcsv($output, [
                $no++,
                $t['waktu_masuk'],
                $t['nama_lengkap'],
                $t['email'],
                $t['no_hp'],
                $t['asal_instansi'],
                $t['alamat'],
                $t['keperluan_nama'],
                $t['bertemu_dengan'],
                $t['waktu_keluar'],
                ucfirst($t['status'])
            ]);
        }
        
        fclose($output);
        exit;
    }
    
    public function exportPDF()
    {
        $filters = [
            'tanggal_dari' => $this->request->getGet('tanggal_dari'),
            'tanggal_sampai' => $this->request->getGet('tanggal_sampai'),
            'status' => $this->request->getGet('status')
        ];
        
        $tamu = $this->tamuModel->getTamuWithKeperluan($filters);
        
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-L',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 10,
            'margin_bottom' => 10,
        ]);
        
        $html = view('admin/tamu/export_pdf', [
            'tamu' => $tamu,
            'filters' => $filters
        ]);
        
        $mpdf->WriteHTML($html);
        $mpdf->Output('data_tamu_' . date('Ymd_His') . '.pdf', 'D');
    }
    
    public function exportDetailPDF($id)
    {
        $tamu = $this->tamuModel->getTamuDetail($id);
        
        if (!$tamu) {
            return redirect()->back()->with('error', 'Data tamu tidak ditemukan');
        }
        
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 15,
            'margin_bottom' => 15,
        ]);
        
        $html = view('admin/tamu/export_detail_pdf', ['tamu' => $tamu]);
        
        $mpdf->WriteHTML($html);
        $mpdf->Output('detail_tamu_' . $tamu['nama_lengkap'] . '_' . date('Ymd_His') . '.pdf', 'D');
    }
}