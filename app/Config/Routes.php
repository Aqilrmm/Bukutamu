<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Landing Page
$routes->get('/', 'Home::index');
$routes->get('registrasi', 'Home::registrasi');
$routes->post('registrasi/save', 'Home::saveRegistrasi');
$routes->get('survei', 'Home::survei');
$routes->get('api/get-tamu', 'Home::getTamu');
$routes->post('survei/save', 'Home::saveSurvei');
$routes->get('api/keperluan', 'Home::getKeperluan');
$routes->get('api/penilaian-kategori', 'Home::getPenilaianKategori');

// Admin Authentication
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('login', 'Auth::index', ['as' => 'admin.login']);
    $routes->post('login', 'Auth::login');
    $routes->get('logout', 'Auth::logout');
});

// Admin Dashboard (Protected)
$routes->group('admin', ['namespace' => 'App\Controllers\Admin', 'filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'Dashboard::index');
    
    // Data Tamu
    $routes->get('tamu', 'Tamu::index');
    $routes->get('tamu/detail/(:num)', 'Tamu::detail/$1');
    $routes->post('tamu/upload-foto/(:num)', 'Tamu::uploadFoto/$1');
    $routes->post('tamu/update-waktu-keluar/(:num)', 'Tamu::updateWaktuKeluar/$1');
    $routes->get('tamu/export-csv', 'Tamu::exportCSV');
    $routes->get('tamu/export-pdf', 'Tamu::exportPDF');
    $routes->get('tamu/export-detail-pdf/(:num)', 'Tamu::exportDetailPDF/$1');
    $routes->get('api/tamu', 'Tamu::apiGetTamu');
    
    // Keperluan
    $routes->get('keperluan', 'Keperluan::index');
    $routes->post('keperluan/save', 'Keperluan::save');
    $routes->post('keperluan/update/(:num)', 'Keperluan::update/$1');
    $routes->delete('keperluan/delete/(:num)', 'Keperluan::delete/$1');
    
    // Survei Kepuasan & Penilaian
    $routes->get('survei', 'Survei::index');
    $routes->get('survei/detail/(:num)', 'Survei::detail/$1');
    $routes->get('api/survei', 'Survei::apiGetSurvei');
    
    // Penilaian Kategori
    $routes->get('penilaian', 'Penilaian::index');
    $routes->post('penilaian/save', 'Penilaian::save');
    $routes->post('penilaian/update/(:num)', 'Penilaian::update/$1');
    $routes->delete('penilaian/delete/(:num)', 'Penilaian::delete/$1');
    $routes->post('penilaian/reorder', 'Penilaian::reorder');
    
    // Profil Instansi
    $routes->get('profil-instansi', 'ProfilInstansi::index');
    $routes->post('profil-instansi/update', 'ProfilInstansi::update');
    
    // Profil Admin
    $routes->get('profil', 'Profil::index');
    $routes->post('profil/update', 'Profil::update');
    $routes->post('profil/change-password', 'Profil::changePassword');
});

// API Real-time
$routes->get('api/profil-instansi', 'Home::getProfilInstansi');