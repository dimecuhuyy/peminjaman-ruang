<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Data Peminjaman';
$isAdmin = Yii::$app->user->identity->isAdministrator();
$isPetugas = Yii::$app->user->identity->isPetugas();
$isPeminjam = Yii::$app->user->identity->isPeminjam();
?>
<div class="peminjaman-index">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= Html::encode($this->title) ?></h1>
        <?php if ($isPeminjam): ?>
            <?= Html::a('Ajukan Peminjaman', ['create'], ['class' => 'btn btn-success']) ?>
        <?php endif; ?>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Kode</th>
                    <th>Ruang</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <?php if ($isAdmin || $isPetugas): ?>
                        <th>Peminjam</th>
                        <th>Aksi</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($peminjaman as $item): ?>
                <tr>
                    <td><?= Html::encode($item->kode_peminjaman) ?></td>
                    <td><?= Html::encode($item->ruang->nama_ruang) ?></td>
                    <td><?= date('d/m/Y', strtotime($item->tanggal_pinjam)) ?></td>
                    <td><?= $item->jam_mulai ?> - <?= $item->jam_selesai ?></td>
                    <td><?= Html::encode($item->deskripsi) ?></td>
                    <td>
                        <span class="badge bg-<?= $item->getStatusClass() ?>">
                            <?= $item->getStatusLabel() ?>
                        </span>
                    </td>
                    <?php if ($isAdmin || $isPetugas): ?>
                        <td><?= Html::encode($item->user->username) ?></td>
                        <td>
                            <?php if ($item->status === 'pending'): ?>
                                <?= Html::a('Setujui', ['approve', 'id' => $item->id], [
                                    'class' => 'btn btn-sm btn-success',
                                    'data' => [
                                        'confirm' => 'Setujui peminjaman ini?',
                                        'method' => 'post'
                                    ]
                                ]) ?>
                                <?= Html::a('Tolak', ['reject', 'id' => $item->id], [
                                    'class' => 'btn btn-sm btn-danger',
                                    'data' => [
                                        'confirm' => 'Tolak peminjaman ini?',
                                        'method' => 'post'
                                    ]
                                ]) ?>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>