<?= $this->extend('landing/layout') ?>
<?= $this->section('content') ?>

<!-- Hero Section -->
<div class="flex items-center justify-center min-h-[85vh]">
    <div class="text-center max-w-4xl mx-auto">
        <!-- Logo -->
        <?php if (!empty($profil['logo'])): ?>
            <div class="mb-8">
                <img src="<?= base_url('uploads/profil/' . $profil['logo']) ?>" 
                     alt="Logo" 
                     class="w-32 h-32 mx-auto object-contain">
            </div>
        <?php endif; ?>
        
        <!-- Nama Instansi -->
        <h1 class="text-5xl font-bold text-gray-800 mb-3">
            <?= esc($profil['nama_instansi']) ?>
        </h1>
        
        <!-- Tagline -->
        <p class="text-xl text-gray-600 mb-2">
            Sistem Buku Tamu Digital
        </p>
        
        <!-- Alamat -->
        <?php if (!empty($profil['alamat'])): ?>
            <p class="text-gray-500 mb-8">
                <i class="fas fa-map-marker-alt mr-2"></i><?= esc($profil['alamat']) ?>
            </p>
        <?php endif; ?>
        
        <!-- Divider -->
        <div class="w-24 h-1 bg-blue-600 mx-auto mb-8"></div>
        
        <!-- Welcome Text -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">
                Selamat Datang
            </h2>
            <p class="text-gray-600 leading-relaxed">
                Terima kasih telah berkunjung. Silakan gunakan menu navigasi di atas 
                untuk melakukan registrasi atau mengisi survei kepuasan kami.
            </p>
        </div>
        
        <!-- Contact Info -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-gray-600">
            <?php if (!empty($profil['telepon'])): ?>
            <div class="bg-white rounded-lg shadow p-4">
                <i class="fas fa-phone text-blue-600 text-2xl mb-2"></i>
                <p class="text-sm">Telepon</p>
                <p class="font-semibold"><?= esc($profil['telepon']) ?></p>
            </div>
            <?php endif; ?>
            
            <?php if (!empty($profil['email'])): ?>
            <div class="bg-white rounded-lg shadow p-4">
                <i class="fas fa-envelope text-blue-600 text-2xl mb-2"></i>
                <p class="text-sm">Email</p>
                <p class="font-semibold"><?= esc($profil['email']) ?></p>
            </div>
            <?php endif; ?>
            
            <?php if (!empty($profil['website'])): ?>
            <div class="bg-white rounded-lg shadow p-4">
                <i class="fas fa-globe text-blue-600 text-2xl mb-2"></i>
                <p class="text-sm">Website</p>
                <p class="font-semibold"><?= esc($profil['website']) ?></p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>