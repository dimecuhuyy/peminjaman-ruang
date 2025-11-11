<?php
use yii\helpers\Html;

$this->title = 'Laporan: ' . $laporan->judul;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= Html::encode($this->title) ?></title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px;
            font-size: 12px;
        }
        .header { 
            text-align: center; 
            margin-bottom: 20px; 
            border-bottom: 2px solid #333; 
            padding-bottom: 10px; 
        }
        .table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 20px; 
        }
        .table th, .table td { 
            border: 1px solid #ddd; 
            padding: 6px; 
            text-align: left; 
        }
        .table th { 
            background-color: #4361ee; 
            color: white; 
        }
        .info { 
            margin-bottom: 20px; 
            padding: 10px; 
            background-color: #f8f9fa; 
            border-radius: 5px; 
        }
        .footer { 
            margin-top: 30px; 
            text-align: center; 
            font-size: 10px; 
            color: #666; 
        }
    </style>
</head>
<body>
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
                    <td><?= Html::encode($peminjaman->deskripsi ?? $peminjaman->keperluan ?? 'Tidak ada keterangan') ?></td>
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

    <div class="footer">
        <p>Dicetak dari Sistem Peminjaman Ruang SMKN 1 Bantul</p>
        <p>Tanggal cetak: <?= date('d/m/Y H:i:s') ?></p>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>