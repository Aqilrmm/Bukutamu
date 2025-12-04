<?= $this->extend('landing/layout') ?>
<?= $this->section('content') ?>

<div class="max-w-4xl mx-auto">
    <!-- Header -->
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
    
    <!-- Form -->
    <div class="bg-white rounded-lg shadow-md p-8">
        <form id="formSurvei">
            <!-- Pilih Data Kunjungan -->
            <div class="mb-8">
                <label class="block text-gray-700 font-semibold mb-2">
                    Pilih Data Kunjungan Anda <span class="text-red-500">*</span>
                </label>
                <select name="tamu_id" id="tamu_id" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                    <option value="">-- Pilih Nama Anda --</option>
                </select>
                <span class="text-red-500 text-sm error-message"></span>
                <p class="text-sm text-gray-500 mt-2">
                    <i class="fas fa-info-circle"></i> Pilih nama Anda yang telah terdaftar di sistem
                </p>
            </div>
            
            <!-- Penilaian Section -->
            <div id="penilaianSection" class="hidden">
                <div class="border-t border-gray-200 pt-6 mb-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-1">Penilaian</h3>
                    <p class="text-gray-600 text-sm mb-6">Berikan penilaian Anda untuk setiap kategori berikut</p>
                    
                    <div id="penilaianContainer" class="space-y-6"></div>
                </div>
                
                <!-- Saran -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">
                        Saran
                    </label>
                    <textarea name="saran" id="saran" rows="4"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition resize-none"
                              placeholder="Berikan saran untuk meningkatkan pelayanan kami (opsional)"></textarea>
                </div>
                
                <!-- Kritik -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">
                        Kritik
                    </label>
                    <textarea name="kritik" id="kritik" rows="4"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition resize-none"
                              placeholder="Berikan kritik yang membangun untuk kami (opsional)"></textarea>
                </div>
                
                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" id="btnSubmit" 
                            class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg transition transform hover:scale-105 shadow-md">
                        <i class="fas fa-paper-plane mr-2"></i>Kirim Survei
                    </button>
                </div>
            </div>
        </form>
    </div>
    
    <!-- Info -->
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

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    let penilaianKategori = [];
    
    // Load data tamu yang masuk
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
            },
            error: function() {
                showToast('error', 'Error', 'Gagal memuat data tamu');
            }
        });
    }
    
    // Load penilaian kategori
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
            },
            error: function() {
                showToast('error', 'Error', 'Gagal memuat kategori penilaian');
            }
        });
    }
    
    // Render penilaian form dengan perulangan
    function renderPenilaian() {
        const container = $('#penilaianContainer');
        container.empty();
        
        if (penilaianKategori.length === 0) {
            container.html('<p class="text-gray-500 text-center py-4">Tidak ada kategori penilaian</p>');
            return;
        }
        
        // Loop through setiap kategori penilaian
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
                    <span class="text-red-500 text-sm error-message"></span>
                </div>
            `;
            container.append(html);
        });
    }
    
    // Generate star HTML
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
        
        // Update visual
        stars.each(function(index) {
            if (index < rating) {
                $(this).removeClass('text-gray-300').addClass('text-yellow-400 active');
            } else {
                $(this).removeClass('text-yellow-400 active').addClass('text-gray-300');
            }
        });
        
        // Update hidden input
        $(`#rating_${kategoriId}`).val(rating);
        
        // Update text description
        const descriptions = ['Sangat Kurang', 'Kurang', 'Cukup', 'Baik', 'Sangat Baik'];
        $(`#rating-text-${kategoriId}`).text(`${descriptions[rating - 1]} (${rating}/5)`);
    });
    
    // Handle tamu selection
    $('#tamu_id').change(function() {
        if ($(this).val()) {
            $('#penilaianSection').slideDown(400);
            $('html, body').animate({
                scrollTop: $('#penilaianSection').offset().top - 100
            }, 500);
        } else {
            $('#penilaianSection').slideUp(400);
        }
    });
    
    // Form Submit
    $('#formSurvei').submit(function(e) {
        e.preventDefault();
        
        // Validate ratings
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
        
        // Show loading
        showLoading();
        
        // Submit via AJAX
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
                        confirmButtonColor: '#16a34a'
                    }).then(() => {
                        window.location.href = '<?= base_url('/') ?>';
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
                    text: 'Tidak dapat terhubung ke server. Silakan coba lagi.',
                    confirmButtonColor: '#16a34a'
                });
            }
        });
    });
    
    // Initialize
    $(document).ready(function() {
        loadTamuData();
        loadPenilaianKategori();
    });
</script>
<?= $this->endSection() ?>