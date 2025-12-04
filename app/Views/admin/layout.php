<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin' ?> - Buku Tamu</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        
        * { font-family: 'Inter', sans-serif; }
        
        .sidebar { 
            transition: all 0.3s;
            background: linear-gradient(180deg, #1e40af 0%, #1e3a8a 100%);
        }
        .sidebar.collapsed { width: 80px; }
        .sidebar-link { 
            transition: all 0.2s;
            position: relative;
        }
        .sidebar-link:hover { 
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }
        .sidebar-link.active { 
            background: rgba(255, 255, 255, 0.15);
            border-left: 4px solid #60a5fa;
        }
        
        .spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #2563eb;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* DataTables Custom */
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #2563eb !important;
            color: white !important;
            border-color: #2563eb !important;
            border-radius: 0.375rem;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #dbeafe !important;
            color: #1e40af !important;
            border-color: #93c5fd !important;
        }
        
        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            padding: 0.5rem;
        }
    </style>
</head>
<body class="bg-gray-50">
    
    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar fixed left-0 top-0 h-full w-64 text-white z-50 shadow-xl">
        <div class="p-6 border-b border-blue-700">
            <div class="flex items-center space-x-3">
                <div class="bg-white p-2 rounded-lg">
                    <i class="fas fa-book text-blue-700 text-xl"></i>
                </div>
                <div class="sidebar-text">
                    <h1 class="text-xl font-bold">Buku Tamu</h1>
                    <p class="text-xs text-blue-200">Admin Panel</p>
                </div>
            </div>
        </div>
        
        <nav class="mt-6 px-3">
            <a href="<?= base_url('admin/dashboard') ?>" 
               class="sidebar-link flex items-center px-4 py-3 mb-1 rounded-lg <?= (uri_string() == 'admin/dashboard') ? 'active' : '' ?>">
                <i class="fas fa-home w-6 text-lg"></i>
                <span class="ml-3 sidebar-text">Dashboard</span>
            </a>
            
            <a href="<?= base_url('admin/tamu') ?>" 
               class="sidebar-link flex items-center px-4 py-3 mb-1 rounded-lg <?= (strpos(uri_string(), 'admin/tamu') !== false) ? 'active' : '' ?>">
                <i class="fas fa-users w-6 text-lg"></i>
                <span class="ml-3 sidebar-text">Data Tamu</span>
            </a>
            
            <a href="<?= base_url('admin/keperluan') ?>" 
               class="sidebar-link flex items-center px-4 py-3 mb-1 rounded-lg <?= (uri_string() == 'admin/keperluan') ? 'active' : '' ?>">
                <i class="fas fa-list w-6 text-lg"></i>
                <span class="ml-3 sidebar-text">Kelola Keperluan</span>
            </a>
            
            <a href="<?= base_url('admin/survei') ?>" 
               class="sidebar-link flex items-center px-4 py-3 mb-1 rounded-lg <?= (strpos(uri_string(), 'admin/survei') !== false) ? 'active' : '' ?>">
                <i class="fas fa-clipboard-check w-6 text-lg"></i>
                <span class="ml-3 sidebar-text">Survei Kepuasan</span>
            </a>
            
            <a href="<?= base_url('admin/penilaian') ?>" 
               class="sidebar-link flex items-center px-4 py-3 mb-1 rounded-lg <?= (uri_string() == 'admin/penilaian') ? 'active' : '' ?>">
                <i class="fas fa-star w-6 text-lg"></i>
                <span class="ml-3 sidebar-text">Kelola Penilaian</span>
            </a>
            
            <div class="border-t border-blue-700 my-4"></div>
            
            <a href="<?= base_url('admin/profil-instansi') ?>" 
               class="sidebar-link flex items-center px-4 py-3 mb-1 rounded-lg <?= (uri_string() == 'admin/profil-instansi') ? 'active' : '' ?>">
                <i class="fas fa-building w-6 text-lg"></i>
                <span class="ml-3 sidebar-text">Profil Instansi</span>
            </a>
            
            <a href="<?= base_url('admin/profil') ?>" 
               class="sidebar-link flex items-center px-4 py-3 mb-1 rounded-lg <?= (uri_string() == 'admin/profil') ? 'active' : '' ?>">
                <i class="fas fa-user-circle w-6 text-lg"></i>
                <span class="ml-3 sidebar-text">Profil Saya</span>
            </a>
            
            <a href="<?= base_url('/') ?>" target="_blank" 
               class="sidebar-link flex items-center px-4 py-3 mb-1 rounded-lg">
                <i class="fas fa-external-link-alt w-6 text-lg"></i>
                <span class="ml-3 sidebar-text">Lihat Beranda</span>
            </a>
            
            <a href="<?= base_url('admin/logout') ?>" 
               class="sidebar-link flex items-center px-4 py-3 mb-1 rounded-lg hover:bg-red-600">
                <i class="fas fa-sign-out-alt w-6 text-lg"></i>
                <span class="ml-3 sidebar-text">Logout</span>
            </a>
        </nav>
    </aside>
    
    <!-- Main Content -->
    <main id="mainContent" class="ml-64 transition-all min-h-screen">
        <!-- Top Navbar -->
        <header class="bg-white shadow-sm sticky top-0 z-40">
            <div class="flex items-center justify-between px-6 py-4">
                <button id="toggleSidebar" class="text-gray-600 hover:text-gray-800 transition">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                
                <div class="flex items-center gap-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-semibold text-gray-800"><?= session()->get('admin_full_name') ?></p>
                        <p class="text-xs text-gray-500"><?= session()->get('admin_email') ?></p>
                    </div>
                    
                    <?php if (session()->get('admin_photo')): ?>
                        <img src="<?= base_url('uploads/users/' . session()->get('admin_photo')) ?>" 
                             alt="Avatar" 
                             class="w-10 h-10 rounded-full object-cover border-2 border-blue-500">
                    <?php else: ?>
                        <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold border-2 border-blue-600">
                            <?= strtoupper(substr(session()->get('admin_full_name'), 0, 1)) ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </header>
        
        <!-- Content Area -->
        <div class="p-6">
            <?= $this->renderSection('content') ?>
        </div>
        
        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 px-6 py-4 mt-8">
            <div class="flex flex-col sm:flex-row items-center justify-between text-sm text-gray-600">
                <p>&copy; <?= date('Y') ?> Aplikasi Buku Tamu Digital. All rights reserved.</p>
                <p class="mt-2 sm:mt-0">Version 1.0.0</p>
            </div>
        </footer>
    </main>
    
    <!-- Loading Spinner -->
    <div id="loadingSpinner" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 flex flex-col items-center shadow-2xl">
            <div class="spinner mb-4"></div>
            <p class="text-gray-700 font-medium">Memproses data...</p>
        </div>
    </div>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // Sidebar Toggle
        $('#toggleSidebar').click(function() {
            $('#sidebar').toggleClass('collapsed');
            $('#mainContent').toggleClass('ml-64 ml-20');
            $('.sidebar-text').fadeToggle(200);
        });
        
        // Loading Spinner Functions
        window.showLoading = function() {
            $('#loadingSpinner').removeClass('hidden').addClass('flex');
        }
        
        window.hideLoading = function() {
            $('#loadingSpinner').removeClass('flex').addClass('hidden');
        }
        
        // Toast Notification
        window.showToast = function(icon, title, text) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
            
            Toast.fire({ icon, title, text });
        }
        
        // Show flash messages
        <?php if (session()->getFlashdata('success')): ?>
            showToast('success', 'Berhasil!', '<?= session()->getFlashdata('success') ?>');
        <?php endif; ?>
        
        <?php if (session()->getFlashdata('error')): ?>
            showToast('error', 'Gagal!', '<?= session()->getFlashdata('error') ?>');
        <?php endif; ?>
    </script>
    
    <?= $this->renderSection('scripts') ?>
</body>
</html>