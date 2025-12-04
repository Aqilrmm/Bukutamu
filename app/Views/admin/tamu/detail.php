<!-- Response dari AJAX - bukan full page -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <!-- Foto Tamu -->
    <div class="text-center">
        <?php if ($tamu['foto']): ?>
            <img src="<?= base_url('uploads/tamu/' . $tamu['foto']) ?>" 
                 alt="Foto Tamu" 
                 class="w-full max-w-xs mx-auto rounded-lg shadow-md">
        <?php else: ?>
            <div class="w-64 h-64 mx-auto bg-gray-200 rounded-lg flex items-center justify-center">
                <i class="fas fa-user text-gray-400 text-6xl"></i>
            </div>
            <p class="text-gray-500 mt-2">Belum ada foto</p>
        <?php endif; ?>
        
        <!-- Tanda Tangan -->
        <div class="mt-4">
            <p class="font-semibold text-gray-700 mb-2">Tanda Tangan:</p>
            <?php if ($tamu['tanda_tangan']): ?>
                <img src="<?= $tamu['tanda_tangan'] ?>" 
                     alt="Tanda Tangan" 
                     class="border-2 border-gray-300 rounded p-2 mx-auto bg-white">
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Data Tamu -->
    <div class="space-y-3">
        <div>
            <label class="font-semibold text-gray-700">Nama Lengkap</label>
            <p class="text-gray-900"><?= esc($tamu['nama_lengkap']) ?></p>
        </div>
        
        <div>
            <label class="font-semibold text-gray-700">Email</label>
            <p class="text-gray-900"><?= esc($tamu['email'] ?: '-') ?></p>
        </div>
        
        <div>
            <label class="font-semibold text-gray-700">No. HP</label>
            <p class="text-gray-900"><?= esc($tamu['no_hp']) ?></p>
        </div>
        
        <div>
            <label class="font-semibold text-gray-700">Asal Instansi</label>
            <p class="text-gray-900"><?= esc($tamu['asal_instansi'] ?: '-') ?></p>
        </div>
        
        <div>
            <label class="font-semibold text-gray-700">Alamat</label>
            <p class="text-gray-900"><?= esc($tamu['alamat'] ?: '-') ?></p>
        </div>
        
        <div>
            <label class="font-semibold text-gray-700">Keperluan</label>
            <p class="text-gray-900"><?= esc($tamu['keperluan_nama']) ?></p>
        </div>
        
        <div>
            <label class="font-semibold text-gray-700">Bertemu Dengan</label>
            <p class="text-gray-900"><?= esc($tamu['bertemu_dengan'] ?: '-') ?></p>
        </div>
        
        <div>
            <label class="font-semibold text-gray-700">Waktu Masuk</label>
            <p class="text-gray-900"><?= date('d/m/Y H:i:s', strtotime($tamu['waktu_masuk'])) ?></p>
        </div>
        
        <div>
            <label class="font-semibold text-gray-700">Waktu Keluar</label>
            <p class="text-gray-900">
                <?= $tamu['waktu_keluar'] ? date('d/m/Y H:i:s', strtotime($tamu['waktu_keluar'])) : '-' ?>
            </p>
        </div>
        
        <div>
            <label class="font-semibold text-gray-700">Status</label>
            <p>
                <span class="px-3 py-1 rounded-full text-sm font-semibold <?= $tamu['status'] == 'masuk' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' ?>">
                    <?= ucfirst($tamu['status']) ?>
                </span>
            </p>
        </div>
    </div>
</div>

<div class="mt-6 flex gap-2">
    <a href="<?= base_url('admin/tamu/export-detail-pdf/' . $tamu['id']) ?>" 
       target="_blank"
       class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg text-center">
        <i class="fas fa-file-pdf mr-2"></i>Download PDF
    </a>
</div>