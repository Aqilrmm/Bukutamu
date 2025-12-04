<!-- ==========================================
     FILE 3: app/Views/admin/profil_instansi/index.php
     ========================================== -->
<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Profil Instansi</h1>
    <p class="text-gray-600">Kelola informasi profil instansi Anda</p>
</div>

<div class="bg-white rounded-lg shadow-md p-8">
    <form action="<?= base_url('admin/profil-instansi/update') ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Nama Instansi -->
            <div class="md:col-span-2">
                <label class="block text-gray-700 font-semibold mb-2">
                    Nama Instansi <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nama_instansi" value="<?= esc($profil['nama_instansi']) ?>" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            
            <!-- Telepon -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Telepon</label>
                <input type="text" name="telepon" value="<?= esc($profil['telepon']) ?>"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            
            <!-- Email -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Email</label>
                <input type="email" name="email" value="<?= esc($profil['email']) ?>"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            
            <!-- Website -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Website</label>
                <input type="text" name="website" value="<?= esc($profil['website']) ?>"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            
            <!-- Alamat -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Alamat</label>
                <textarea name="alamat" rows="3"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"><?= esc($profil['alamat']) ?></textarea>
            </div>
            
            <!-- Logo -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Logo</label>
                <?php if ($profil['logo']): ?>
                    <img src="<?= base_url('uploads/profil/' . $profil['logo']) ?>" class="w-32 h-32 object-contain mb-2 border p-2 rounded">
                <?php endif; ?>
                <input type="file" name="logo" accept="image/*"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG. Maksimal 2MB</p>
            </div>
            
            <!-- Banner -->
            <div class="md:col-span-2">
                <label class="block text-gray-700 font-semibold mb-2">Banner</label>
                <?php if ($profil['banner']): ?>
                    <img src="<?= base_url('uploads/profil/' . $profil['banner']) ?>" class="w-full h-32 object-cover mb-2 border rounded">
                <?php endif; ?>
                <input type="file" name="banner" accept="image/*"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG. Maksimal 2MB. Rekomendasi ukuran: 1920x400px</p>
            </div>
        </div>
        
        <div class="mt-8 flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg">
                <i class="fas fa-save mr-2"></i>Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>