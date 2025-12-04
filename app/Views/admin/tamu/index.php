<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Data Tamu</h1>
    <p class="text-gray-600">Kelola data kunjungan tamu</p>
</div>

<!-- Filter Section -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">
        <i class="fas fa-filter mr-2"></i>Filter Data
    </h3>
    
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-gray-700 font-medium mb-2">Tanggal Dari</label>
            <input type="date" id="tanggal_dari" value="<?= date('Y-m-d') ?>"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>
        
        <div>
            <label class="block text-gray-700 font-medium mb-2">Tanggal Sampai</label>
            <input type="date" id="tanggal_sampai" value="<?= date('Y-m-d') ?>"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>
        
        <div>
            <label class="block text-gray-700 font-medium mb-2">Status</label>
            <select id="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Status</option>
                <option value="masuk">Masuk</option>
                <option value="keluar">Keluar</option>
            </select>
        </div>
        
        <div class="flex items-end">
            <button onclick="filterData()" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                <i class="fas fa-search mr-2"></i>Filter
            </button>
        </div>
    </div>
    
    <!-- Export Buttons -->
    <div class="flex gap-2 mt-4">
        <button onclick="exportCSV()" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg">
            <i class="fas fa-file-csv mr-2"></i>Export CSV
        </button>
        <button onclick="exportPDF()" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg">
            <i class="fas fa-file-pdf mr-2"></i>Export PDF
        </button>
    </div>
</div>

<!-- Data Table -->
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="overflow-x-auto">
        <table id="tamuTable" class="display responsive nowrap w-full">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Waktu Masuk</th>
                    <th>Nama</th>
                    <th>Asal Instansi</th>
                    <th>No. HP</th>
                    <th>Keperluan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<!-- Modal Detail Tamu -->
<div id="modalDetail" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full p-6 relative">
            <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-600 hover:text-gray-800">
                <i class="fas fa-times text-2xl"></i>
            </button>
            
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Detail Tamu</h2>
            
            <div id="detailContent"></div>
        </div>
    </div>
</div>

<!-- Modal Upload Foto -->
<div id="modalUploadFoto" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Upload Foto Tamu</h3>
            
            <form id="formUploadFoto" enctype="multipart/form-data">
                <input type="hidden" id="upload_tamu_id" name="tamu_id">
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Pilih Foto</label>
                    <input type="file" name="foto" id="foto" accept="image/*" capture="environment"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <p class="text-sm text-gray-500 mt-1">Maksimal 2MB (JPG, PNG)</p>
                </div>
                
                <div class="flex gap-2">
                    <button type="button" onclick="closeModalUpload()" 
                            class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg">
                        Batal
                    </button>
                    <button type="submit" 
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                        <i class="fas fa-upload mr-2"></i>Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    let table;
    
    $(document).ready(function() {
        // Initialize DataTable
        table = $('#tamuTable').DataTable({
            processing: true,
            ajax: {
                url: '<?= base_url('admin/api/tamu') ?>',
                type: 'GET',
                data: function(d) {
                    d.tanggal_dari = $('#tanggal_dari').val();
                    d.tanggal_sampai = $('#tanggal_sampai').val();
                    d.status = $('#status').val();
                }
            },
            columns: [
                { 
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                { 
                    data: 'waktu_masuk',
                    render: function(data) {
                        return moment(data).format('DD/MM/YYYY HH:mm:ss');
                    }
                },
                { data: 'nama_lengkap' },
                { data: 'asal_instansi' },
                { data: 'no_hp' },
                { data: 'keperluan_nama' },
                { 
                    data: 'status',
                    render: function(data) {
                        if (data === 'masuk') {
                            return '<span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">Masuk</span>';
                        }
                        return '<span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-semibold">Keluar</span>';
                    }
                },
                { 
                    data: null,
                    render: function(data) {
                        let buttons = `
                            <div class="flex gap-1">
                                <button onclick="viewDetail(${data.id})" 
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded text-sm"
                                        title="Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button onclick="uploadFoto(${data.id})" 
                                        class="bg-purple-500 hover:bg-purple-600 text-white px-2 py-1 rounded text-sm"
                                        title="Upload Foto">
                                    <i class="fas fa-camera"></i>
                                </button>
                        `;
                        
                        if (data.status === 'masuk') {
                            buttons += `
                                <button onclick="updateWaktuKeluar(${data.id})" 
                                        class="bg-orange-500 hover:bg-orange-600 text-white px-2 py-1 rounded text-sm"
                                        title="Update Waktu Keluar">
                                    <i class="fas fa-sign-out-alt"></i>
                                </button>
                            `;
                        }
                        
                        buttons += '</div>';
                        return buttons;
                    }
                }
            ],
            order: [[1, 'desc']],
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            }
        });
        
        // Auto refresh every 10 seconds
        setInterval(function() {
            table.ajax.reload(null, false);
        }, 100000);
    });
    
    // Moment.js for date formatting
    function moment(date) {
        const d = new Date(date);
        return {
            format: function(format) {
                const day = String(d.getDate()).padStart(2, '0');
                const month = String(d.getMonth() + 1).padStart(2, '0');
                const year = d.getFullYear();
                const hours = String(d.getHours()).padStart(2, '0');
                const minutes = String(d.getMinutes()).padStart(2, '0');
                const seconds = String(d.getSeconds()).padStart(2, '0');
                
                return format
                    .replace('DD', day)
                    .replace('MM', month)
                    .replace('YYYY', year)
                    .replace('HH', hours)
                    .replace('mm', minutes)
                    .replace('ss', seconds);
            }
        };
    }
    
    function filterData() {
        table.ajax.reload();
    }
    
    function viewDetail(id) {
        showLoading();
        
        $.ajax({
            url: '<?= base_url('admin/tamu/detail/') ?>' + id,
            type: 'GET',
            success: function(response) {
                hideLoading();
                $('#detailContent').html(response);
                $('#modalDetail').removeClass('hidden');
            },
            error: function() {
                hideLoading();
                showToast('error', 'Gagal', 'Gagal memuat detail tamu');
            }
        });
    }
    
    function closeModal() {
        $('#modalDetail').addClass('hidden');
    }
    
    function uploadFoto(id) {
        $('#upload_tamu_id').val(id);
        $('#modalUploadFoto').removeClass('hidden');
    }
    
    function closeModalUpload() {
        $('#modalUploadFoto').addClass('hidden');
        $('#formUploadFoto')[0].reset();
    }
    
    $('#formUploadFoto').submit(function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const tamuId = $('#upload_tamu_id').val();
        
        showLoading();
        
        $.ajax({
            url: '<?= base_url('admin/tamu/upload-foto/') ?>' + tamuId,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                hideLoading();
                
                if (response.success) {
                    showToast('success', 'Berhasil', response.message);
                    closeModalUpload();
                    table.ajax.reload(null, false);
                } else {
                    showToast('error', 'Gagal', response.message);
                }
            },
            error: function() {
                hideLoading();
                showToast('error', 'Error', 'Terjadi kesalahan pada server');
            }
        });
    });
    
    function updateWaktuKeluar(id) {
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah Anda yakin ingin mengupdate waktu keluar untuk tamu ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Update',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                showLoading();
                
                $.ajax({
                    url: '<?= base_url('admin/tamu/update-waktu-keluar/') ?>' + id,
                    type: 'POST',
                    success: function(response) {
                        hideLoading();
                        
                        if (response.success) {
                            showToast('success', 'Berhasil', response.message);
                            table.ajax.reload(null, false);
                        } else {
                            showToast('error', 'Gagal', response.message);
                        }
                    },
                    error: function() {
                        hideLoading();
                        showToast('error', 'Error', 'Terjadi kesalahan pada server');
                    }
                });
            }
        });
    }
    
    function exportCSV() {
        const tanggalDari = $('#tanggal_dari').val();
        const tanggalSampai = $('#tanggal_sampai').val();
        const status = $('#status').val();
        
        window.location.href = '<?= base_url('admin/tamu/export-csv') ?>?' + 
            'tanggal_dari=' + tanggalDari + 
            '&tanggal_sampai=' + tanggalSampai + 
            '&status=' + status;
    }
    
    function exportPDF() {
        const tanggalDari = $('#tanggal_dari').val();
        const tanggalSampai = $('#tanggal_sampai').val();
        const status = $('#status').val();
        
        window.open('<?= base_url('admin/tamu/export-pdf') ?>?' + 
            'tanggal_dari=' + tanggalDari + 
            '&tanggal_sampai=' + tanggalSampai + 
            '&status=' + status, '_blank');
    }
</script>
<?= $this->endSection() ?>