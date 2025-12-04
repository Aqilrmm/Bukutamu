<!-- ==========================================
     FILE 4: app/Views/admin/profil/index.php
     ========================================== -->
<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Profil Saya</h1>
    <p class="text-gray-600">Kelola informasi profil dan keamanan akun Anda</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Profile Info -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <?php if ($user['photo']): ?>
                <img src="<?= base_url('uploads/users/' . $user['photo']) ?>" 
                     class="w-32 h-32 rounded-full mx-auto mb-4 object-cover border-4 border-gray-200">
            <?php else: ?>
                <div class="w-32 h-32 rounded-full mx-auto mb-4 bg-blue-500 flex items-center justify-center text-white text-4xl font-bold">
                    <?= strtoupper(substr($user['full_name'], 0, 1)) ?>
                </div>
            <?php endif; ?>
            
            <h3 class="text-xl font-bold text-gray-800"><?= esc($user['full_name']) ?></h3>
            <p class="text-gray-600"><?= esc($user['email']) ?></p>
            <p class="text-sm text-gray-500 mt-2">@<?= esc($user['username']) ?></p>
        </div>
    </div>
    
    <!-- Update Profile -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Update Profil</h3>
            
            <form action="<?= base_url('admin/profil/update') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Nama Lengkap</label>
                        <input type="text" name="full_name" value="<?= esc($user['full_name']) ?>" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Email</label>
                        <input type="email" name="email" value="<?= esc($user['email']) ?>" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Foto Profil</label>
                        <input type="file" name="photo" accept="image/*"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG. Maksimal 2MB</p>
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg">
                            <i class="fas fa-save mr-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
        
        <!-- Change Password -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Ubah Password</h3>
            
            <form action="<?= base_url('admin/profil/change-password') ?>" method="POST">
                <?= csrf_field() ?>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Password Lama</label>
                        <input type="password" name="current_password" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Password Baru</label>
                        <input type="password" name="new_password" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Konfirmasi Password Baru</label>
                        <input type="password" name="confirm_password" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg">
                            <i class="fas fa-key mr-2"></i>Ubah Password
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>