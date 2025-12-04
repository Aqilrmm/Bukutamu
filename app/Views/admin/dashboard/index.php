!-- ========================================== -->

<!-- FILE: app/Views/admin/dashboard/index.php -->
<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
    <p class="text-gray-600">Selamat datang, <?= session()->get('admin_full_name') ?>!</p>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Hari Ini -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Total Tamu Hari Ini</p>
                <h3 class="text-3xl font-bold text-blue-600 mt-2"><?= $statistik['total_hari_ini'] ?></h3>
            </div>
            <div class="bg-blue-100 p-4 rounded-lg">
                <i class="fas fa-users text-blue-600 text-2xl"></i>
            </div>
        </div>
    </div>
    
    <!-- Masuk Hari Ini -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Tamu Masuk</p>
                <h3 class="text-3xl font-bold text-green-600 mt-2"><?= $statistik['masuk_hari_ini'] ?></h3>
            </div>
            <div class="bg-green-100 p-4 rounded-lg">
                <i class="fas fa-sign-in-alt text-green-600 text-2xl"></i>
            </div>
        </div>
    </div>
    
    <!-- Keluar Hari Ini -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Tamu Keluar</p>
                <h3 class="text-3xl font-bold text-red-600 mt-2"><?= $statistik['keluar_hari_ini'] ?></h3>
            </div>
            <div class="bg-red-100 p-4 rounded-lg">
                <i class="fas fa-sign-out-alt text-red-600 text-2xl"></i>
            </div>
        </div>
    </div>
    
    <!-- Total Bulan Ini -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Total Bulan Ini</p>
                <h3 class="text-3xl font-bold text-purple-600 mt-2"><?= $statistik['total_bulan_ini'] ?></h3>
            </div>
            <div class="bg-purple-100 p-4 rounded-lg">
                <i class="fas fa-calendar-alt text-purple-600 text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Charts & Recent Data -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Average Ratings -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Rata-rata Penilaian</h2>
        
        <?php if (!empty($avg_ratings)): ?>
            <div class="space-y-4">
                <?php foreach ($avg_ratings as $rating): ?>
                    <div>
                        <div class="flex justify-between mb-1">
                            <span class="text-gray-700"><?= esc($rating['kategori']) ?></span>
                            <span class="text-gray-700 font-semibold"><?= number_format($rating['avg_rating'], 1) ?> / 5</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-yellow-400 h-3 rounded-full" style="width: <?= ($rating['avg_rating'] / 5) * 100 ?>%"></div>
                        </div>
                        <div class="text-yellow-400 text-sm mt-1">
                            <?php 
                            $stars = round($rating['avg_rating']);
                            for($i = 1; $i <= 5; $i++): 
                                echo ($i <= $stars) ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
                            endfor; 
                            ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-gray-500 text-center py-8">Belum ada data penilaian</p>
        <?php endif; ?>
    </div>
    
    <!-- Recent Guests -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Tamu Terbaru</h2>
        
        <?php if (!empty($recent_tamu)): ?>
            <div class="space-y-3">
                <?php foreach ($recent_tamu as $tamu): ?>
                    <div class="flex items-center justify-between border-b pb-3">
                        <div>
                            <p class="font-semibold text-gray-800"><?= esc($tamu['nama_lengkap']) ?></p>
                            <p class="text-sm text-gray-600"><?= esc($tamu['asal_instansi'] ?? '-') ?></p>
                            <p class="text-xs text-gray-500">
                                <i class="far fa-clock mr-1"></i><?= date('d/m/Y H:i', strtotime($tamu['waktu_masuk'])) ?>
                            </p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold <?= $tamu['status'] == 'masuk' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' ?>">
                            <?= ucfirst($tamu['status']) ?>
                        </span>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <a href="<?= base_url('admin/tamu') ?>" class="block text-center text-blue-600 hover:underline mt-4">
                Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
            </a>
        <?php else: ?>
            <p class="text-gray-500 text-center py-8">Belum ada data tamu</p>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Auto refresh statistik every 30 seconds
    setInterval(function() {
        location.reload();
    }, 30000);
</script>
<?= $this->endSection() ?>