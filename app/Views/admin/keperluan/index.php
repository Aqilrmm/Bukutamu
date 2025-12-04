<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Kelola Keperluan</h1>
    <p class="text-gray-600">Manajemen data keperluan kunjungan</p>
</div>

<div class="bg-white rounded-lg shadow-md p-6">
    <button onclick="showAddModal()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg mb-4">
        <i class="fas fa-plus mr-2"></i>Tambah Keperluan
    </button>
    
    <table id="keperluanTable" class="display w-full">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Keperluan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($keperluan as $k): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= esc($k['nama']) ?></td>
                <td>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold <?= $k['is_active'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                        <?= $k['is_active'] ? 'Aktif' : 'Nonaktif' ?>
                    </span>
                </td>
                <td>
                    <button onclick="editData(<?= $k['id'] ?>, '<?= esc($k['nama']) ?>')" 
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button onclick="deleteData(<?= $k['id'] ?>)" 
                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal Form -->
<div id="modalForm" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg p-6 max-w-md w-full">
            <h3 id="modalTitle" class="text-xl font-bold mb-4">Tambah Keperluan</h3>
            <form id="formKeperluan">
                <input type="hidden" id="keperluan_id">
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Nama Keperluan</label>
                    <input type="text" id="nama" required
                           class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div class="flex gap-2">
                    <button type="button" onclick="closeModal()" 
                            class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 rounded-lg">
                        Batal
                    </button>
                    <button type="submit" 
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded-lg">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $('#keperluanTable').DataTable();
    
    function showAddModal() {
        $('#modalTitle').text('Tambah Keperluan');
        $('#keperluan_id').val('');
        $('#nama').val('');
        $('#modalForm').removeClass('hidden');
    }
    
    function editData(id, nama) {
        $('#modalTitle').text('Edit Keperluan');
        $('#keperluan_id').val(id);
        $('#nama').val(nama);
        $('#modalForm').removeClass('hidden');
    }
    
    function closeModal() {
        $('#modalForm').addClass('hidden');
    }
    
    $('#formKeperluan').submit(function(e) {
        e.preventDefault();
        const id = $('#keperluan_id').val();
        const url = id ? '<?= base_url('admin/keperluan/update/') ?>' + id : '<?= base_url('admin/keperluan/save') ?>';
        
        $.ajax({
            url: url,
            type: 'POST',
            data: { nama: $('#nama').val() },
            success: function(response) {
                if (response.success) {
                    showToast('success', 'Berhasil', response.message);
                    location.reload();
                } else {
                    showToast('error', 'Gagal', response.message);
                }
            }
        });
    });
    
    function deleteData(id) {
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Yakin ingin menghapus data ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('admin/keperluan/delete/') ?>' + id,
                    type: 'DELETE',
                    success: function(response) {
                        if (response.success) {
                            showToast('success', 'Berhasil', response.message);
                            location.reload();
                        }
                    }
                });
            }
        });
    }
</script>
<?= $this->endSection() ?>