<!-- ==========================================
     FILE 1: app/Views/admin/survei/index.php
     ========================================== -->
<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Data Survei Kepuasan</h1>
    <p class="text-gray-600">Hasil survei kepuasan dari tamu</p>
</div>

<!-- Filter Section -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">
        <i class="fas fa-filter mr-2"></i>Filter Data
    </h3>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-gray-700 font-medium mb-2">Tanggal Dari</label>
            <input type="date" id="tanggal_dari" value="<?= date('Y-m-01') ?>"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>
        
        <div>
            <label class="block text-gray-700 font-medium mb-2">Tanggal Sampai</label>
            <input type="date" id="tanggal_sampai" value="<?= date('Y-m-d') ?>"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>
        
        <div class="flex items-end">
            <button onclick="filterData()" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                <i class="fas fa-search mr-2"></i>Filter
            </button>
        </div>
    </div>
</div>

<!-- Data Table -->
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="overflow-x-auto">
        <table id="surveiTable" class="display responsive nowrap w-full">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama Tamu</th>
                    <th>Asal Instansi</th>
                    <th>No. HP</th>
                    <th>Rata-rata Rating</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<!-- Modal Detail -->
<div id="modalDetail" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-3xl w-full p-6 relative">
            <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-600 hover:text-gray-800">
                <i class="fas fa-times text-2xl"></i>
            </button>
            
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Detail Survei</h2>
            
            <div id="detailContent"></div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    let table;
    
    $(document).ready(function() {
        table = $('#surveiTable').DataTable({
            processing: true,
            ajax: {
                url: '<?= base_url('admin/api/survei') ?>',
                type: 'GET',
                data: function(d) {
                    d.tanggal_dari = $('#tanggal_dari').val();
                    d.tanggal_sampai = $('#tanggal_sampai').val();
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
                    data: 'created_at',
                    render: function(data) {
                        const d = new Date(data);
                        return d.toLocaleDateString('id-ID') + ' ' + d.toLocaleTimeString('id-ID');
                    }
                },
                { data: 'nama_lengkap' },
                { data: 'asal_instansi' },
                { data: 'no_hp' },
                { 
                    data: null,
                    render: function(data) {
                        return '<span class="text-yellow-500">★★★★★</span>';
                    }
                },
                { 
                    data: null,
                    render: function(data) {
                        return `
                            <button onclick="viewDetail(${data.id})" 
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm"
                                    title="Detail">
                                <i class="fas fa-eye"></i> Detail
                            </button>
                        `;
                    }
                }
            ],
            order: [[1, 'desc']],
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            }
        });
    });
    
    function filterData() {
        table.ajax.reload();
    }
    
    function viewDetail(id) {
        showLoading();
        
        $.ajax({
            url: '<?= base_url('admin/survei/detail/') ?>' + id,
            type: 'GET',
            success: function(response) {
                hideLoading();
                $('#detailContent').html(response);
                $('#modalDetail').removeClass('hidden');
            },
            error: function() {
                hideLoading();
                showToast('error', 'Gagal', 'Gagal memuat detail survei');
            }
        });
    }
    
    function closeModal() {
        $('#modalDetail').addClass('hidden');
    }
</script>
<?= $this->endSection() ?>