<?php
use yii\helpers\Html;

$this->title = 'Preview Laporan';
?>
<div class="laporan-preview">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><?= $model->judul ?></h4>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Jenis Laporan:</strong> <?= $model->getJenisLabel() ?>
                </div>
                <div class="col-md-6">
                    <strong>Periode:</strong> <?= $model->periode ?>
                </div>
            </div>

            <h5>Data Peminjaman</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Kode</th>
                            <th>Ruang</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Peminjam</th>
                            <th>Status</th>
                            <th>Keperluan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($dataPeminjaman)): ?>
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data peminjaman</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($dataPeminjaman as $peminjaman): ?>
                            <tr>
                                <td><?= Html::encode($peminjaman->kode_peminjaman) ?></td>
                                <td><?= Html::encode($peminjaman->ruang->nama_ruang) ?></td>
                                <td><?= date('d/m/Y', strtotime($peminjaman->tanggal_pinjam)) ?></td>
                                <td><?= $peminjaman->jam_mulai ?> - <?= $peminjaman->jam_selesai ?></td>
                                <td><?= Html::encode($peminjaman->user->username) ?></td>
                                <td>
                                    <span class="badge bg-<?= $peminjaman->getStatusClass() ?>">
                                        <?= $peminjaman->getStatusLabel() ?>
                                    </span>
                                </td>
                                <td><?= Html::encode($peminjaman->deskripsi) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <?= Html::a('Simpan Laporan', ['create'], [
                    'class' => 'btn btn-success',
                    'data' => [
                        'method' => 'post',
                        'params' => [
                            'Laporan[judul]' => $model->judul,
                            'Laporan[jenis]' => $model->jenis,
                            'Laporan[periode]' => $model->periode,
                        ],
                    ],
                ]) ?>
                <?= Html::a('Export PDF', ['export-pdf', 'jenis' => $model->jenis, 'periode' => $model->periode], [
                    'class' => 'btn btn-primary',
                    'target' => '_blank'
                ]) ?>
                <?= Html::a('Kembali', ['generate'], ['class' => 'btn btn-secondary']) ?>
            </div>
        </div>
    </div>
</div>