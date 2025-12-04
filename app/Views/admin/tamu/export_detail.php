<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 30px; }
        .detail-table { width: 100%; }
        .detail-table td { padding: 10px; }
        .label { font-weight: bold; width: 200px; }
        img { max-width: 300px; border: 1px solid #ddd; padding: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>DETAIL TAMU</h2>
    </div>
    
    <?php if ($tamu['foto']): ?>
        <div style="text-align: center; margin-bottom: 20px;">
            <img src="<?= FCPATH . 'uploads/tamu/' . $tamu['foto'] ?>" alt="Foto">
        </div>
    <?php endif; ?>
    
    <table class="detail-table">
        <tr>
            <td class="label">Nama Lengkap</td>
            <td>: <?= esc($tamu['nama_lengkap']) ?></td>
        </tr>
        <tr>
            <td class="label">Email</td>
            <td>: <?= esc($tamu['email'] ?: '-') ?></td>
        </tr>
        <tr>
            <td class="label">No. HP</td>
            <td>: <?= esc($tamu['no_hp']) ?></td>
        </tr>
        <tr>
            <td class="label">Asal Instansi</td>
            <td>: <?= esc($tamu['asal_instansi'] ?: '-') ?></td>
        </tr>
        <tr>
            <td class="label">Alamat</td>
            <td>: <?= esc($tamu['alamat'] ?: '-') ?></td>
        </tr>
        <tr>
            <td class="label">Keperluan</td>
            <td>: <?= esc($tamu['keperluan_nama']) ?></td>
        </tr>
        <tr>
            <td class="label">Bertemu Dengan</td>
            <td>: <?= esc($tamu['bertemu_dengan'] ?: '-') ?></td>
        </tr>
        <tr>
            <td class="label">Waktu Masuk</td>
            <td>: <?= date('d/m/Y H:i:s', strtotime($tamu['waktu_masuk'])) ?></td>
        </tr>
        <tr>
            <td class="label">Waktu Keluar</td>
            <td>: <?= $tamu['waktu_keluar'] ? date('d/m/Y H:i:s', strtotime($tamu['waktu_keluar'])) : '-' ?></td>
        </tr>
        <tr>
            <td class="label">Status</td>
            <td>: <?= ucfirst($tamu['status']) ?></td>
        </tr>
    </table>
    
    <?php if ($tamu['tanda_tangan']): ?>
        <div style="margin-top: 30px;">
            <p><strong>Tanda Tangan:</strong></p>
            <img src="<?= $tamu['tanda_tangan'] ?>" alt="Tanda Tangan" style="max-width: 200px;">
        </div>
    <?php endif; ?>
</body>
</html>