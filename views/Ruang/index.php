<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Manajemen Ruang';
?>
<div class="ruang-index">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= Html::encode($this->title) ?></h1>
        <?= Html::a('Tambah Ruang', ['create'], ['class' => 'btn btn-success']) ?>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Kode</th>
                    <th>Nama Ruang</th>
                    <th>Kapasitas</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ruang as $item): ?>
                <tr>
                    <td><?= Html::encode($item->kode_ruang) ?></td>
                    <td><?= Html::encode($item->nama_ruang) ?></td>
                    <td><?= Html::encode($item->kapasitas) ?> orang</td>
                    <td>
                        <span class="badge bg-<?= $item->status === 'tersedia' ? 'success' : 'danger' ?>">
                            <?= $item->getStatusLabel() ?>
                        </span>
                    </td>
                    <td>
                        <?= Html::a('Edit', ['update', 'id' => $item->id], ['class' => 'btn btn-sm btn-warning']) ?>
                        <?= Html::a('Hapus', ['delete', 'id' => $item->id], [
                            'class' => 'btn btn-sm btn-danger',
                            'data' => [
                                'confirm' => 'Yakin hapus ruang ini?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>