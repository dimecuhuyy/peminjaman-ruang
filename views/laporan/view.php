<?php
use yii\helpers\Html;

$this->title = 'Detail Laporan: ' . $laporan->judul;
?>
<div class="laporan-view">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h4 class="card-title mb-0"><?= Html::encode($this->title) ?></h4>
                <div class="d-flex gap-2">
                    <?= Html::a('<i class="fas fa-print me-1"></i>Print', ['print', 'id' => $laporan->id], [
                        'class' => 'btn btn-primary btn-sm',
                        'target' => '_blank'
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="card-body">
            <!-- Informasi Laporan -->
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <div class="info-box p-3 border rounded h-100">
                        <strong>Judul:</strong> <?= Html::encode($laporan->judul) ?><br>
                        <strong>Jenis:</strong> <span class="badge bg-primary"><?= $laporan->getJenisLabel() ?></span>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="info-box p-3 border rounded h-100">
                        <strong>Periode:</strong> <?= Html::encode($laporan->periode) ?><br>
                        <strong>Dibuat oleh:</strong> <?= Html::encode($laporan->petugas->username) ?><br>
                        <strong>Tanggal Dibuat:</strong> <?= Yii::$app->formatter->asDatetime($laporan->created_at) ?>
                    </div>
                </div>
            </div>

            <!-- Data Peminjaman -->
            <div class="table-container">
                <h5 class="mb-3"><i class="fas fa-list me-2"></i>Data Peminjaman</h5>
                <?php if (empty($dataPeminjaman)): ?>
                    <div class="alert alert-warning mb-0">
                        <i class="fas fa-exclamation-triangle me-2"></i>Tidak ada data peminjaman untuk periode ini.
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-sm">
                            <thead class="table-dark">
                                <tr>
                                    <th width="50" class="text-center">#</th>
                                    <th>Peminjam</th>
                                    <th>Ruang</th>
                                    <th width="100" class="text-center">Tanggal</th>
                                    <th width="100" class="text-center">Jam Mulai</th>
                                    <th width="100" class="text-center">Jam Selesai</th>
                                    <th>Keperluan</th>
                                    <th width="90" class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dataPeminjaman as $index => $peminjaman): ?>
                                <tr>
                                    <td class="text-center"><?= $index + 1 ?></td>
                                    <td><?= Html::encode($peminjaman->user->username ?? 'N/A') ?></td>
                                    <td><?= Html::encode($peminjaman->ruang->nama_ruang ?? 'N/A') ?></td>
                                    <td class="text-center"><?= Yii::$app->formatter->asDate($peminjaman->tanggal_pinjam) ?></td>
                                    <td class="text-center"><?= Html::encode($peminjaman->jam_mulai) ?></td>
                                    <td class="text-center"><?= Html::encode($peminjaman->jam_selesai) ?></td>
                                    <td class="text-truncate" style="max-width: 200px;" title="<?= Html::encode($peminjaman->deskripsi ?? $peminjaman->keperluan ?? 'Tidak ada keterangan') ?>">
                                        <?= Html::encode($peminjaman->deskripsi ?? $peminjaman->keperluan ?? 'Tidak ada keterangan') ?>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        $statuses = [
                                            0 => '<span class="badge bg-warning">Pending</span>',
                                            1 => '<span class="badge bg-success">Disetujui</span>',
                                            2 => '<span class="badge bg-danger">Ditolak</span>',
                                        ];
                                        echo $statuses[$peminjaman->status] ?? '<span class="badge bg-secondary">Unknown</span>';
                                        ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3 p-2 bg-light rounded">
                        <strong><i class="fas fa-chart-bar me-2"></i>Total Data: <?= count($dataPeminjaman) ?> peminjaman</strong>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Action Buttons -->
            <div class="mt-4 d-flex flex-wrap gap-2">
                <?= Html::a('<i class="fas fa-arrow-left me-2"></i>Kembali', ['index'], ['class' => 'btn btn-secondary']) ?>
                <?= Html::a('<i class="fas fa-trash me-2"></i>Hapus Laporan', ['delete', 'id' => $laporan->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Yakin hapus laporan ini?',
                        'method' => 'post',
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>

<style>
/* Responsive Design untuk View Laporan */
.laporan-view .info-box {
    background: #f8f9fa;
}

.laporan-view .table-container {
    margin-top: 1.5rem;
}

/* Tablet */
@media (max-width: 991px) {
    .laporan-view .card-header .d-flex {
        flex-direction: column;
        align-items: flex-start !important;
    }
    
    .laporan-view .card-header .gap-2 {
        margin-top: 10px;
    }
    
    .laporan-view .table-responsive {
        font-size: 0.9rem;
    }
}

/* Mobile */
@media (max-width: 767px) {
    .laporan-view .card-body {
        padding: 1rem;
    }
    
    .laporan-view .table-responsive {
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
    }
    
    .laporan-view .table th,
    .laporan-view .table td {
        padding: 0.5rem;
        font-size: 0.85rem;
    }
    
    .laporan-view .btn {
        width: 100%;
        margin-bottom: 0.5rem;
    }
    
    .laporan-view .d-flex.gap-2 {
        flex-direction: column;
    }
    
    /* Hide some columns on mobile */
    .laporan-view .table td:nth-child(4), /* Tanggal column */
    .laporan-view .table th:nth-child(4),
    .laporan-view .table td:nth-child(5), /* Jam Mulai column */
    .laporan-view .table th:nth-child(5),
    .laporan-view .table td:nth-child(6), /* Jam Selesai column */
    .laporan-view .table th:nth-child(6) {
        display: none;
    }
}

/* Small Mobile */
@media (max-width: 575px) {
    .laporan-view .card-body {
        padding: 0.75rem;
    }
    
    .laporan-view .table th,
    .laporan-view .table td {
        padding: 0.375rem;
        font-size: 0.8rem;
    }
    
    .laporan-view .info-box {
        padding: 1rem !important;
        font-size: 0.9rem;
    }
    
    /* Hide more columns on very small screens */
    .laporan-view .table td:nth-child(7), /* Keperluan column */
    .laporan-view .table th:nth-child(7) {
        display: none;
    }
}

/* Extra Small Mobile */
@media (max-width: 400px) {
    .laporan-view .table-responsive {
        font-size: 0.75rem;
    }
    
    .laporan-view .btn {
        font-size: 0.9rem;
        padding: 0.5rem 0.75rem;
    }
    
    .laporan-view h4 {
        font-size: 1.1rem;
    }
    
    .laporan-view h5 {
        font-size: 1rem;
    }
}
</style>