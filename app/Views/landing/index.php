<!-- FILE: app/Views/landing/index_spa.php -->
<!-- Ganti file index.php dengan ini untuk SPA experience -->
<?= $this->extend('landing/layout') ?>
<?= $this->section('content') ?>

<div id="app">
    <!-- Section: Beranda -->
    <div id="section-beranda" class="section-content">
        <div class="flex items-center justify-center min-h-[70vh]">
            <div class="text-center max-w-4xl mx-auto">
                <?php if (!empty($profil['logo'])): ?>
                    <div class="mb-8">
                        <img src="<?= base_url('uploads/profil/' . $profil['logo']) ?>" 
                             alt="Logo" 
                             class="w-32 h-32 mx-auto object-contain animate-fade-in">
                    </div>
                <?php endif; ?>
                
                <h1 class="text-5xl font-bold text-gray-800 mb-3 animate-fade-in">
                    <?= esc($profil['nama_instansi']) ?>
                </h1>
                
                <p class="text-xl text-gray-600 mb-2 animate-fade-in">
                    Sistem Buku Tamu Digital
                </p>
                
                <?php if (!empty($profil['alamat'])): ?>
                    <p class="text-gray-500 mb-8 animate-fade-in">
                        <i class="fas fa-map-marker-alt mr-2"></i><?= esc($profil['alamat']) ?>
                    </p>
                <?php endif; ?>
                
                <div class="w-24 h-1 bg-blue-600 mx-auto mb-8"></div>
                
                <div class="bg-white rounded-lg shadow-lg p-8 mb-8 animate-slide-up">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Selamat Datang</h2>
                    <p class="text-gray-600 leading-relaxed">
                        Terima kasih telah berkunjung. Silakan gunakan menu navigasi di atas 
                        untuk melakukan registrasi atau mengisi survei kepuasan kami.
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-gray-600">
                    <?php if (!empty($profil['telepon'])): ?>
                    <div class="bg-white rounded-lg shadow p-4 animate-fade-in">
                        <i class="fas fa-phone text-blue-600 text-2xl mb-2"></i>
                        <p class="text-sm">Telepon</p>
                        <p class="font-semibold"><?= esc($profil['telepon']) ?></p>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($profil['email'])): ?>
                    <div class="bg-white rounded-lg shadow p-4 animate-fade-in">
                        <i class="fas fa-envelope text-blue-600 text-2xl mb-2"></i>
                        <p class="text-sm">Email</p>
                        <p class="font-semibold"><?= esc($profil['email']) ?></p>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($profil['website'])): ?>
                    <div class="bg-white rounded-lg shadow p-4 animate-fade-in">
                        <i class="fas fa-globe text-blue-600 text-2xl mb-2"></i>
                        <p class="text-sm">Website</p>
                        <p class="font-semibold"><?= esc($profil['website']) ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Section: Registrasi -->
    <div id="section-registrasi" class="section-content hidden">
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex items-center space-x-4">
                <div class="bg-blue-100 p-3 rounded-lg">
                    <i class="fas fa-user-plus text-blue-600 text-3xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Registrasi Tamu</h1>
                    <p class="text-gray-600">Silakan lengkapi formulir di bawah ini untuk melakukan registrasi</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-8">
            <form id="formRegistrasi">
                <div class="flex flex-col md:flex-row gap-8">
                    <!-- KIRI -->
                    <div class="flex-1 space-y-6">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_lengkap" id="nama_lengkap" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 transition"
                                placeholder="Masukkan nama lengkap Anda">
                            <span class="text-red-500 text-sm error-message"></span>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Email</label>
                            <input type="email" name="email" id="email"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 transition"
                                placeholder="email@example.com">
                            <span class="text-red-500 text-sm error-message"></span>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">
                                No. Handphone <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" name="no_hp" id="no_hp" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 transition"
                                placeholder="08xxxxxxxxxx">
                            <span class="text-red-500 text-sm error-message"></span>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Asal Instansi</label>
                            <input type="text" name="asal_instansi" id="asal_instansi"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 transition"
                                placeholder="Nama instansi/perusahaan">
                            <span class="text-red-500 text-sm error-message"></span>
                        </div>
                    </div>

                    <!-- KANAN -->
                    <div class="flex-1 space-y-6">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Alamat</label>
                            <input type="text" name="alamat" id="alamat"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 transition"
                                placeholder="Alamat lengkap">
                            <span class="text-red-500 text-sm error-message"></span>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">
                                Keperluan <span class="text-red-500">*</span>
                            </label>
                            <select name="keperluan_id" id="keperluan_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 transition">
                                <option value="">-- Pilih Keperluan --</option>
                                <?php foreach ($keperluan_list as $k): ?>
                                    <option value="<?= $k['id'] ?>"><?= esc($k['nama']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <span class="text-red-500 text-sm error-message"></span>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Bertemu Dengan</label>
                            <input type="text" name="bertemu_dengan" id="bertemu_dengan"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 transition"
                                placeholder="Nama orang/bagian yang dituju">
                            <span class="text-red-500 text-sm error-message"></span>
                        </div>
                    </div>

                    <!-- TANDA TANGAN -->
                    <div class="flex-1">
                        <label class="block text-gray-700 font-semibold mb-2">
                            Tanda Tangan Digital <span class="text-red-500">*</span>
                        </label>
                        <div class="bg-gray-50 border-2 border-gray-300 rounded-lg p-2">
                            <canvas id="signaturePad" class="signature-pad w-full h-80 border-2 border-gray-200 rounded"></canvas>
                            <div class="mt-3 flex items-center justify-between">
                                <button type="button" id="clearSignature"
                                    class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition">
                                    <i class="fas fa-eraser mr-2"></i>Hapus
                                </button>
                                <span class="text-gray-600 text-sm">
                                    <i class="fas fa-info-circle mr-1"></i>Tanda tangani di area di atas
                                </span>
                            </div>
                        </div>
                        <input type="hidden" name="tanda_tangan" id="tanda_tangan">
                        <span class="text-red-500 text-sm error-message"></span>
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg transition transform hover:scale-105 shadow-md">
                        <i class="fas fa-save mr-2"></i>Simpan Registrasi
                    </button>
                </div>
            </form>
        </div>

        <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 rounded-lg p-4">
            <div class="flex items-start">
                <i class="fas fa-info-circle text-blue-500 text-xl mr-3 mt-1"></i>
                <div class="text-sm text-gray-700">
                    <p class="font-semibold mb-1">Informasi:</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Field yang bertanda (<span class="text-red-500">*</span>) wajib diisi</li>
                        <li>Foto tamu akan diambil oleh petugas admin</li>
                        <li>Pastikan tanda tangan Anda jelas dan terbaca</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Section: Survei -->
    <div id="section-survei" class="section-content hidden">
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex items-center space-x-4">
                <div class="bg-green-100 p-3 rounded-lg">
                    <i class="fas fa-clipboard-check text-green-600 text-3xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Survei Kepuasan</h1>
                    <p class="text-gray-600">Bantu kami meningkatkan kualitas pelayanan dengan mengisi survei ini</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-8">
            <form id="formSurvei">
                <div class="mb-8">
                    <label class="block text-gray-700 font-semibold mb-2">
                        Pilih Data Kunjungan Anda <span class="text-red-500">*</span>
                    </label>
                    <select name="tamu_id" id="tamu_id" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 transition">
                        <option value="">-- Pilih Nama Anda --</option>
                    </select>
                    <span class="text-red-500 text-sm error-message"></span>
                    <p class="text-sm text-gray-500 mt-2">
                        <i class="fas fa-info-circle"></i> Pilih nama Anda yang telah terdaftar di sistem
                    </p>
                </div>

                <div id="penilaianSection" class="hidden">
                    <div class="border-t border-gray-200 pt-6 mb-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-1">Penilaian</h3>
                        <p class="text-gray-600 text-sm mb-6">Berikan penilaian Anda untuk setiap kategori berikut</p>
                        <div id="penilaianContainer" class="space-y-6"></div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Saran</label>
                        <textarea name="saran" id="saran" rows="4"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 transition resize-none"
                            placeholder="Berikan saran untuk meningkatkan pelayanan kami (opsional)"></textarea>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Kritik</label>
                        <textarea name="kritik" id="kritik" rows="4"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 transition resize-none"
                            placeholder="Berikan kritik yang membangun untuk kami (opsional)"></textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg transition transform hover:scale-105 shadow-md">
                            <i class="fas fa-paper-plane mr-2"></i>Kirim Survei
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="mt-6 bg-green-50 border-l-4 border-green-500 rounded-lg p-4">
            <div class="flex items-start">
                <i class="fas fa-info-circle text-green-500 text-xl mr-3 mt-1"></i>
                <div class="text-sm text-gray-700">
                    <p class="font-semibold mb-1">Catatan:</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Survei hanya dapat diisi oleh tamu yang sudah melakukan registrasi</li>
                        <li>Setelah mengisi survei, status kunjungan Anda akan otomatis menjadi "Keluar"</li>
                        <li>Penilaian menggunakan skala bintang 1-5 (1 = Sangat Kurang, 5 = Sangat Baik)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes slideUp {
        from { 
            opacity: 0;
            transform: translateY(20px);
        }
        to { 
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fade-in {
        animation: fadeIn 0.5s ease-in;
    }
    
    .animate-slide-up {
        animation: slideUp 0.6s ease-out;
    }
    
    .section-content {
        animation: fadeIn 0.3s ease-in;
    }
</style>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    let signaturePad;
    let penilaianKategori = [];
    
    // SPA Navigation
    function navigateTo(section) {
        // Hide all sections
        document.querySelectorAll('.section-content').forEach(el => {
            el.classList.add('hidden');
        });
        
        // Show selected section
        document.getElementById('section-' + section).classList.remove('hidden');
        
        // Update URL without reload
        window.history.pushState({section: section}, '', '/' + (section === 'beranda' ? '' : section));
        
        // Update active nav link
        document.querySelectorAll('.nav-link').forEach(link => {
            link.classList.remove('active');
        });
        
        const activeLink = document.querySelector(`.nav-link[href*="${section === 'beranda' ? '' : section}"]`);
        if (activeLink) {
            activeLink.classList.add('active');
        }
        
        // Initialize features for specific sections
        if (section === 'registrasi') {
            initSignaturePad();
        } else if (section === 'survei') {
            loadTamuData();
            loadPenilaianKategori();
        }
    }
    
    // Handle browser back/forward
    window.addEventListener('popstate', (e) => {
        if (e.state && e.state.section) {
            navigateTo(e.state.section);
        }
    });
    
    // Intercept navigation clicks
    document.addEventListener('DOMContentLoaded', function() {
        // Override nav links
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const href = this.getAttribute('href');
                let section = 'beranda';
                
                if (href.includes('registrasi')) section = 'registrasi';
                else if (href.includes('survei')) section = 'survei';
                
                navigateTo(section);
            });
        });
        
        // Initial load
        const currentPath = window.location.pathname;
        if (currentPath.includes('registrasi')) {
            navigateTo('registrasi');
        } else if (currentPath.includes('survei')) {
            navigateTo('survei');
        } else {
            navigateTo('beranda');
        }
    });
    
    // Initialize Signature Pad
    function initSignaturePad() {
        if (signaturePad) return; // Already initialized
        
        const canvas = document.getElementById('signaturePad');
        if (!canvas) return;
        
        signaturePad = new SignaturePad(canvas, {
            backgroundColor: 'rgb(255, 255, 255)',
            penColor: 'rgb(0, 0, 0)',
            minWidth: 1,
            maxWidth: 2.5
        });
        
        function resizeCanvas() {
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);
            signaturePad.clear();
        }
        
        window.addEventListener("resize", resizeCanvas);
        resizeCanvas();
        
        $('#clearSignature').click(function() {
            signaturePad.clear();
        });
    }
    
    // Load Tamu Data
    function loadTamuData() {
        $.ajax({
            url: '<?= base_url('api/get-tamu') ?>',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const select = $('#tamu_id');
                    select.find('option:not(:first)').remove();
                    
                    if (response.data.length === 0) {
                        select.append('<option value="" disabled>Tidak ada data tamu yang masuk</option>');
                    } else {
                        $.each(response.data, function(i, tamu) {
                            select.append(`<option value="${tamu.id}">${tamu.nama_lengkap}</option>`);
                        });
                    }
                }
            }
        });
    }
    
    // Load Penilaian Kategori
    function loadPenilaianKategori() {
        $.ajax({
            url: '<?= base_url('api/penilaian-kategori') ?>',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    penilaianKategori = response.data;
                    renderPenilaian();
                }
            }
        });
    }
    
    // Render Penilaian
    function renderPenilaian() {
        const container = $('#penilaianContainer');
        container.empty();
        
        if (penilaianKategori.length === 0) {
            container.html('<p class="text-gray-500 text-center py-4">Tidak ada kategori penilaian</p>');
            return;
        }
        
        $.each(penilaianKategori, function(index, kategori) {
            const html = `
                <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                    <label class="block text-gray-800 font-semibold mb-3">
                        ${kategori.nama} <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center gap-2 mb-2" data-kategori="${kategori.id}">
                        ${generateStars(kategori.id)}
                    </div>
                    <div class="text-sm text-gray-500 mt-2">
                        <span id="rating-text-${kategori.id}">Belum ada penilaian</span>
                    </div>
                    <input type="hidden" name="penilaian[${kategori.id}]" id="rating_${kategori.id}" required>
                </div>
            `;
            container.append(html);
        });
    }
    
    // Generate Stars
    function generateStars(kategoriId) {
        let html = '';
        for (let i = 1; i <= 5; i++) {
            html += `<i class="fas fa-star rating-star text-4xl text-gray-300" 
                        data-rating="${i}" 
                        data-kategori="${kategoriId}"></i>`;
        }
        return html;
    }
    
    // Handle star rating click
    $(document).on('click', '.rating-star', function() {
        const rating = $(this).data('rating');
        const kategoriId = $(this).data('kategori');
        const container = $(this).parent();
        const stars = container.find('.rating-star');
        
        stars.each(function(index) {
            if (index < rating) {
                $(this).removeClass('text-gray-300').addClass('text-yellow-400 active');
            } else {
                $(this).removeClass('text-yellow-400 active').addClass('text-gray-300');
            }
        });
        
        $(`#rating_${kategoriId}`).val(rating);
        
        const descriptions = ['Sangat Kurang', 'Kurang', 'Cukup', 'Baik', 'Sangat Baik'];
        $(`#rating-text-${kategoriId}`).text(`${descriptions[rating - 1]} (${rating}/5)`);
    });
    
    // Handle tamu selection
    $('#tamu_id').change(function() {
        if ($(this).val()) {
            $('#penilaianSection').slideDown(400);
        } else {
            $('#penilaianSection').slideUp(400);
        }
    });
    
    // Form Registrasi Submit
    $('#formRegistrasi').submit(function(e) {
        e.preventDefault();
        
        $('.error-message').text('');
        
        if (signaturePad.isEmpty()) {
            Swal.fire({
                icon: 'warning',
                title: 'Tanda Tangan Diperlukan',
                text: 'Silakan buat tanda tangan terlebih dahulu',
                confirmButtonColor: '#2563eb'
            });
            return;
        }
        
        const signatureData = signaturePad.toDataURL();
        $('#tanda_tangan').val(signatureData);
        
        showLoading();
        
        $.ajax({
            url: '<?= base_url('registrasi/save') ?>',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                hideLoading();
                
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Registrasi Berhasil!',
                        html: '<p class="mb-2">' + response.message + '</p>' +
                              '<p class="text-sm text-gray-600">Terimakasih telah melakukan registrasi.</p>',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#2563eb',
                        timer: 4000
                    }).then(() => {
                        // Reset form
                        $('#formRegistrasi')[0].reset();
                        signaturePad.clear();
                        
                        // Navigate to beranda dan load data fresh
                        navigateTo('beranda');
                        loadTamuData();
                        loadPenilaianKategori();
                    });
                } else {
                    if (response.errors) {
                        $.each(response.errors, function(key, value) {
                            $('#' + key).next('.error-message').text(value);
                        });
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Registrasi Gagal',
                        text: response.message,
                        confirmButtonColor: '#2563eb'
                    });
                }
            },
            error: function() {
                hideLoading();
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: 'Tidak dapat terhubung ke server.',
                    confirmButtonColor: '#2563eb'
                });
            }
        });
    });
    
    // Form Survei Submit
    $('#formSurvei').submit(function(e) {
        e.preventDefault();
        
        let allRated = true;
        let errorMsg = [];
        
        penilaianKategori.forEach(function(kategori) {
            const rating = $(`#rating_${kategori.id}`).val();
            if (!rating) {
                allRated = false;
                errorMsg.push(kategori.nama);
            }
        });
        
        if (!allRated) {
            Swal.fire({
                icon: 'warning',
                title: 'Penilaian Belum Lengkap',
                html: '<p>Silakan berikan penilaian untuk kategori berikut:</p>' +
                      '<ul class="text-left mt-2 ml-4">' +
                      errorMsg.map(msg => `<li>• ${msg}</li>`).join('') +
                      '</ul>',
                confirmButtonColor: '#16a34a'
            });
            return;
        }
        
        showLoading();
        
        $.ajax({
            url: '<?= base_url('survei/save') ?>',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                hideLoading();
                
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Terima Kasih!',
                        html: '<p class="mb-2">' + response.message + '</p>' +
                              '<p class="text-sm text-gray-600">Masukan Anda sangat berarti bagi kami.</p>',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#16a34a',
                        timer: 3000
                    }).then(() => {
                        // Reset form & navigate to beranda
                        $('#formSurvei')[0].reset();
                        $('#penilaianSection').hide();
                        navigateTo('beranda');
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Survei Gagal',
                        text: response.message,
                        confirmButtonColor: '#16a34a'
                    });
                }
            },
            error: function() {
                hideLoading();
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: 'Tidak dapat terhubung ke server.',
                    confirmButtonColor: '#16a34a'
                });
            }
        });
    });
</script>
<?= $this->endSection() ?>