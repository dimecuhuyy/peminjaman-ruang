<?php
use yii\helpers\Html;

$this->title = 'Laporan: ' . $laporan->judul;
?>
<div class="header">
    <h1>LAPORAN PEMINJAMAN RUANG</h1>
    <h2>SMKN 1 BANTUL</h2>
    <h3><?= Html::encode($laporan->judul) ?></h3>
</div>

<div class="info">
    <p><strong>Jenis Laporan:</strong> <?= $laporan->getJenisLabel() ?></p>
    <p><strong>Periode:</strong> <?= Html::encode($laporan->periode) ?></p>
    <p><strong>Dibuat oleh:</strong> <?= Html::encode($laporan->petugas->username) ?></p>
    <p><strong>Tanggal Dibuat:</strong> <?= Yii::$app->formatter->asDatetime($laporan->created_at) ?></p>
</div>

<?php if (empty($dataPeminjaman)): ?>
    <p class="text-center">Tidak ada data peminjaman untuk periode ini.</p>
<?php else: ?>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Peminjam</th>
                <th>Ruang</th>
                <th>Tanggal Pinjam</th>
                <th>Jam Mulai</th>
                <th>Jam Selesai</th>
                <th>Keperluan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dataPeminjaman as $index => $peminjaman): ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= Html::encode($peminjaman->user->username ?? 'N/A') ?></td>
                <td><?= Html::encode($peminjaman->ruang->nama_ruang ?? 'N/A') ?></td>
                <td><?= Yii::$app->formatter->asDate($peminjaman->tanggal_pinjam) ?></td>
                <td><?= Html::encode($peminjaman->jam_mulai) ?></td>
                <td><?= Html::encode($peminjaman->jam_selesai) ?></td>
                <td><?= Html::encode($peminjaman->keperluan) ?></td>
                <td>
                    <?php
                    $statuses = [
                        0 => 'Pending',
                        1 => 'Disetujui', 
                        2 => 'Ditolak'
                    ];
                    echo $statuses[$peminjaman->status] ?? 'Unknown';
                    ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <p><strong>Total Data: <?= count($dataPeminjaman) ?> peminjaman</strong></p>
<?php endif; ?>