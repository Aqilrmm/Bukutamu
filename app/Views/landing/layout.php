<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Buku Tamu' ?> - <?= esc($profil['nama_instansi']) ?></title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
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
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .signature-pad {
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            cursor: crosshair;
            touch-action: none;
            background: white;
        }

        .clock {
            font-family: 'Courier New', monospace;
            letter-spacing: 2px;
        }

        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background-color: #2563eb;
            transition: width 0.3s ease;
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }

        .nav-link.active {
            color: #2563eb;
        }

        /* Star Rating Animation */
        .rating-star {
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .rating-star:hover {
            transform: scale(1.2);
        }

        .rating-star.active {
            color: #fbbf24;
            transform: scale(1.1);
        }
    </style>
</head>

<body class="min-h-screen">

    <!-- Top Navigation Bar -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-20">
                <!-- Logo & Brand -->
                <div class="flex items-center space-x-4">
                    <?php if (!empty($profil['logo'])): ?>
                        <img src="<?= base_url('uploads/profil/' . $profil['logo']) ?>"
                            alt="Logo"
                            class="h-12 w-12 object-contain">
                    <?php endif; ?>
                    <div>
                        <h1 class="text-lg font-bold text-gray-800 leading-tight">
                            <?= esc($profil['nama_instansi']) ?>
                        </h1>
                        <p class="text-xs text-gray-500">Buku Tamu Digital</p>
                    </div>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="<?= base_url('/') ?>"
                        class="nav-link text-gray-700 hover:text-blue-600 font-medium py-2 <?= uri_string() == '' ? 'active' : '' ?>">
                        <i class="fas fa-home mr-2"></i>Beranda
                    </a>
                    <a href="<?= base_url('registrasi') ?>"
                        class="nav-link text-gray-700 hover:text-blue-600 font-medium py-2 <?= uri_string() == 'registrasi' ? 'active' : '' ?>">
                        <i class="fas fa-user-plus mr-2"></i>Registrasi Tamu
                    </a>
                    <a href="<?= base_url('survei') ?>"
                        class="nav-link text-gray-700 hover:text-blue-600 font-medium py-2 <?= uri_string() == 'survei' ? 'active' : '' ?>">
                        <i class="fas fa-clipboard-check mr-2"></i>Survei Kepuasan
                    </a>
                </div>

                <!-- Clock & Fullscreen -->
                <div class="flex items-center space-x-4">
                    <div class="hidden lg:block text-right">
                        <div id="clock" class="clock text-lg font-bold text-gray-800"></div>
                        <div id="date" class="text-xs text-gray-600"></div>
                    </div>
                    <button id="fullscreenBtn"
                        class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-2 rounded-lg transition-all">
                        <i class="fas fa-expand"></i>
                    </button>
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobileMenuBtn" class="md:hidden text-gray-700">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobileMenu" class="hidden md:hidden pb-4">
                <a href="<?= base_url('/') ?>"
                    class="block py-3 px-4 text-gray-700 hover:bg-gray-100 rounded">
                    <i class="fas fa-home mr-2"></i>Beranda
                </a>
                <a href="<?= base_url('registrasi') ?>"
                    class="block py-3 px-4 text-gray-700 hover:bg-gray-100 rounded">
                    <i class="fas fa-user-plus mr-2"></i>Registrasi Tamu
                </a>
                <a href="<?= base_url('survei') ?>"
                    class="block py-3 px-4 text-gray-700 hover:bg-gray-100 rounded">
                    <i class="fas fa-clipboard-check mr-2"></i>Survei Kepuasan
                </a>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container mx-auto px-4 py-8">
        <?= $this->renderSection('content') ?>
    </div>

    <!-- Footer -->
    <footer class="bg-white shadow-lg fixed bottom-0 left-0 w-full z-50">
        <div class="container mx-auto px-4 py-6">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <p class="text-gray-600 text-sm mb-2 md:mb-0">
                    &copy; <?= date('Y') ?> <?= esc($profil['nama_instansi']) ?>. Semua hak dilindungi undang-undang.
                </p>
                <p class="text-gray-500 text-xs">
                    Powered by <a href="https://github.com/Aqilrmm/" target="_blank" class="text-blue-600 hover:underline">Aqil Ramadhan</a>
                </p>
            </div>
        </div>
    </footer>

    <!-- Loading Spinner -->
    <div id="loadingSpinner" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 flex flex-col items-center">
            <div class="spinner mb-4"></div>
            <p class="text-gray-700 font-medium">Memproses...</p>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Signature Pad -->
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>

    <script>
        // Clock & Date
        function updateClock() {
            const now = new Date();

            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');

            $('#clock').text(`${hours}:${minutes}:${seconds}`);

            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];

            const dayName = days[now.getDay()];
            const day = now.getDate();
            const month = months[now.getMonth()];
            const year = now.getFullYear();

            $('#date').text(`${dayName}, ${day} ${month} ${year}`);
        }

        setInterval(updateClock, 1000);
        updateClock();

        // Fullscreen Toggle
        $('#fullscreenBtn').click(function() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
                $(this).html('<i class="fas fa-compress"></i>');
            } else {
                document.exitFullscreen();
                $(this).html('<i class="fas fa-expand"></i>');
            }
        });

        // Mobile Menu Toggle
        $('#mobileMenuBtn').click(function() {
            $('#mobileMenu').slideToggle(300);
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
            });

            Toast.fire({
                icon,
                title,
                text
            });
        }
    </script>

    <?= $this->renderSection('scripts') ?>
</body>

</html>