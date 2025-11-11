<?php
use yii\helpers\Html;

$this->title = 'Jadwal Reguler Ruang';
?>
<div class="jadwal-index">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-calendar-alt me-2"></i><?= Html::encode($this->title) ?></h1>
        <?php if (Yii::$app->user->identity->isAdministrator() || Yii::$app->user->identity->isPetugas()): ?>
            <?= Html::a('<i class="fas fa-plus me-2"></i>Tambah Jadwal', ['create'], ['class' => 'btn btn-success']) ?>
        <?php endif; ?>
    </div>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-table me-2"></i>Jadwal Mingguan</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Hari</th>
                            <th>Ruang</th>
                            <th>Jam</th>
                            <th>Keterangan</th>
                            <th>User</th>
                            <?php if (Yii::$app->user->identity->isAdministrator() || Yii::$app->user->identity->isPetugas()): ?>
                                <th>Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($jadwalByHari as $hari => $jadwalHari): ?>
                            <?php if (empty($jadwalHari)): ?>
                                <tr>
                                    <td><strong><?= $hari ?></strong></td>
                                    <td colspan="<?= (Yii::$app->user->identity->isAdministrator() || Yii::$app->user->identity->isPetugas()) ? 5 : 4 ?>" class="text-center text-muted">
                                        <i class="fas fa-info-circle me-1"></i>Tidak ada jadwal
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($jadwalHari as $index => $jadwal): ?>
                                <tr>
                                    <?php if ($index === 0): ?>
                                        <td rowspan="<?= count($jadwalHari) ?>"><strong><?= $hari ?></strong></td>
                                    <?php endif; ?>
                                    <td><?= Html::encode($jadwal->ruang->nama_ruang) ?></td>
                                    <td>
                                        <span class="badge bg-primary">
                                            <?= $jadwal->getDisplayJam() ?>
                                        </span>
                                    </td>
                                    <td><?= Html::encode($jadwal->keterangan) ?></td>
                                    <td><?= Html::encode($jadwal->user->username) ?></td>
                                    <?php if (Yii::$app->user->identity->isAdministrator() || Yii::$app->user->identity->isPetugas()): ?>
                                        <td>
                                            <?= Html::a('<i class="fas fa-edit"></i>', ['update', 'id' => $jadwal->id_reguler], [
                                                'class' => 'btn btn-sm btn-warning',
                                                'title' => 'Edit'
                                            ]) ?>
                                            <?= Html::a('<i class="fas fa-trash"></i>', ['delete', 'id' => $jadwal->id_reguler], [
                                                'class' => 'btn btn-sm btn-danger',
                                                'title' => 'Hapus',
                                                'data' => [
                                                    'confirm' => 'Yakin hapus jadwal ini?',
                                                    'method' => 'post',
                                                ],
                                            ]) ?>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi</h5>
                </div>
                <div class="card-body">
                    <p>Jadwal reguler menunjukkan penggunaan ruang yang sudah terjadwal secara tetap setiap minggu.</p>
                    <div class="row">
                        <div class="col-md-4">
                            <strong><i class="fas fa-building me-1"></i>Total Ruang:</strong> <?= count($ruangList) ?>
                        </div>
                        <div class="col-md-4">
                            <strong><i class="fas fa-calendar me-1"></i>Hari Aktif:</strong> 7 Hari
                        </div>
                        <div class="col-md-4">
                            <strong><i class="fas fa-clock me-1"></i>Jam Operasional:</strong> 07:00 - 16:00
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>