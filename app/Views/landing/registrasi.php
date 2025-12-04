<?= $this->extend('landing/layout') ?>
<?= $this->section('content') ?>

<div class="">
    <!-- Header -->
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

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-md p-8">
        <form id="formRegistrasi">
            <div class="flex flex-col md:flex-row gap-8">

                <!-- KIRI (4 INPUT) -->
                <div class="flex-1 space-y-6">
                    <!-- Nama Lengkap -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 transition"
                            placeholder="Masukkan nama lengkap Anda">
                        <span class="text-red-500 text-sm error-message"></span>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Email</label>
                        <input type="email" name="email" id="email"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 transition"
                            placeholder="email@example.com">
                        <span class="text-red-500 text-sm error-message"></span>
                    </div>

                    <!-- No. HP -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            No. Handphone <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" name="no_hp" id="no_hp" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 transition"
                            placeholder="08xxxxxxxxxx">
                        <span class="text-red-500 text-sm error-message"></span>
                    </div>

                    <!-- Asal Instansi -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Asal Instansi</label>
                        <input type="text" name="asal_instansi" id="asal_instansi"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 transition"
                            placeholder="Nama instansi/perusahaan">
                        <span class="text-red-500 text-sm error-message"></span>
                    </div>
                </div>

                <!-- KANAN (3 INPUT) -->
                <div class="flex-1 space-y-6">
                    <!-- Alamat -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Alamat</label>
                        <input type="text" name="alamat" id="alamat"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 transition"
                            placeholder="Alamat lengkap">
                        <span class="text-red-500 text-sm error-message"></span>
                    </div>

                    <!-- Keperluan -->
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

                    <!-- Bertemu Dengan -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Bertemu Dengan</label>
                        <input type="text" name="bertemu_dengan" id="bertemu_dengan"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 transition"
                            placeholder="Nama orang/bagian yang dituju">
                        <span class="text-red-500 text-sm error-message"></span>
                    </div>
                </div>

                <!-- TANDA TANGAN (SEBELAH KANAN) -->
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
                                <i class="fas fa-info-circle mr-1"></i>
                                Tanda tangani di area di atas
                            </span>
                        </div>
                    </div>

                    <input type="hidden" name="tanda_tangan" id="tanda_tangan">
                    <span class="text-red-500 text-sm error-message"></span>
                </div>

            </div>

            <!-- Submit -->
            <div class="mt-8 flex justify-end">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg transition transform hover:scale-105 shadow-md">
                    <i class="fas fa-save mr-2"></i>Simpan Registrasi
                </button>
            </div>
        </form>

    </div>

    <!-- Info -->
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

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Initialize Signature Pad
    const canvas = document.getElementById('signaturePad');
    const signaturePad = new SignaturePad(canvas, {
        backgroundColor: 'rgb(255, 255, 255)',
        penColor: 'rgb(0, 0, 0)',
        minWidth: 1,
        maxWidth: 2.5
    });

    // Resize canvas
    function resizeCanvas() {
        const ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);
        signaturePad.clear();
    }

    window.addEventListener("resize", resizeCanvas);
    resizeCanvas();

    // Clear signature
    $('#clearSignature').click(function() {
        signaturePad.clear();
    });

    // Form Submit
    $('#formRegistrasi').submit(function(e) {
        e.preventDefault();

        // Clear previous errors
        $('.error-message').text('');

        // Check signature
        if (signaturePad.isEmpty()) {
            Swal.fire({
                icon: 'warning',
                title: 'Tanda Tangan Diperlukan',
                text: 'Silakan buat tanda tangan terlebih dahulu',
                confirmButtonColor: '#2563eb'
            });
            return;
        }

        // Get signature data
        const signatureData = signaturePad.toDataURL();
        $('#tanda_tangan').val(signatureData);

        // Show loading
        showLoading();

        // Submit via AJAX
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
                            '<p class="text-sm text-gray-600">Terima kasih telah melakukan registrasi.</p>',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#2563eb'
                    }).then(() => {
                        window.location.href = '<?= base_url('/') ?>';
                    });
                } else {
                    // Show validation errors
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
                    text: 'Tidak dapat terhubung ke server. Silakan coba lagi.',
                    confirmButtonColor: '#2563eb'
                });
            }
        });
    });
</script>
<?= $this->endSection() ?>