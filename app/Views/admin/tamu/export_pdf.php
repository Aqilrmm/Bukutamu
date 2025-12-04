<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #4CAF50; color: white; }
        .header { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>DATA TAMU</h2>
        <?php if ($filters['tanggal_dari'] && $filters['tanggal_sampai']): ?>
            <p>Periode: <?= date('d/m/Y', strtotime($filters['tanggal_dari'])) ?> - <?= date('d/m/Y', strtotime($filters['tanggal_sampai'])) ?></p>
        <?php endif; ?>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Waktu Masuk</th>
                <th>Nama</th>
                <th>Instansi</th>
                <th>No. HP</th>
                <th>Keperluan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($tamu as $t): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= date('d/m/Y H:i', strtotime($t['waktu_masuk'])) ?></td>
                <td><?= esc($t['nama_lengkap']) ?></td>
                <td><?= esc($t['asal_instansi'] ?: '-') ?></td>
                <td><?= esc($t['no_hp']) ?></td>
                <td><?= esc($t['keperluan_nama']) ?></td>
                <td><?= ucfirst($t['status']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>