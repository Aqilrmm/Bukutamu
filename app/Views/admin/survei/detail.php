<!-- ==========================================
     FILE 2: app/Views/admin/survei/detail.php
     ========================================== -->
<!-- Response AJAX - bukan full page -->
<div class="space-y-6">
    <!-- Info Tamu -->
    <div class="bg-gray-50 p-4 rounded-lg">
        <h3 class="font-semibold text-gray-800 mb-3">Informasi Tamu</h3>
        <div class="grid grid-cols-2 gap-3 text-sm">
            <div>
                <span class="text-gray-600">Nama:</span>
                <span class="font-medium ml-2"><?= esc($survei['nama_lengkap']) ?></span>
            </div>
            <div>
                <span class="text-gray-600">Email:</span>
                <span class="font-medium ml-2"><?= esc($survei['email'] ?: '-') ?></span>
            </div>
            <div>
                <span class="text-gray-600">No. HP:</span>
                <span class="font-medium ml-2"><?= esc($survei['no_hp']) ?></span>
            </div>
            <div>
                <span class="text-gray-600">Instansi:</span>
                <span class="font-medium ml-2"><?= esc($survei['asal_instansi'] ?: '-') ?></span>
            </div>
        </div>
    </div>
    
    <!-- Penilaian -->
    <div>
        <h3 class="font-semibold text-gray-800 mb-3">Penilaian</h3>
        <div class="space-y-3">
            <?php foreach ($penilaian as $p): ?>
            <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg">
                <span class="text-gray-700 font-medium"><?= esc($p['kategori_nama']) ?></span>
                <div class="flex items-center gap-2">
                    <div class="text-yellow-400">
                        <?php for($i = 1; $i <= 5; $i++): ?>
                            <i class="fas fa-star <?= $i <= $p['rating'] ? '' : 'text-gray-300' ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <span class="text-gray-600 font-semibold"><?= $p['rating'] ?>/5</span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <!-- Saran & Kritik -->
    <?php if ($survei['saran'] || $survei['kritik']): ?>
    <div>
        <h3 class="font-semibold text-gray-800 mb-3">Saran & Kritik</h3>
        
        <?php if ($survei['saran']): ?>
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-3 rounded">
            <p class="text-sm font-semibold text-green-800 mb-1">Saran:</p>
            <p class="text-gray-700"><?= nl2br(esc($survei['saran'])) ?></p>
        </div>
        <?php endif; ?>
        
        <?php if ($survei['kritik']): ?>
        <div class="bg-orange-50 border-l-4 border-orange-500 p-4 rounded">
            <p class="text-sm font-semibold text-orange-800 mb-1">Kritik:</p>
            <p class="text-gray-700"><?= nl2br(esc($survei['kritik'])) ?></p>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>