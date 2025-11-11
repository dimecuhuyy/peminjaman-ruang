<?php
use yii\helpers\Html;

$this->title = 'Manajemen User';
?>
<div class="user-index">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= Html::encode($this->title) ?></h1>
        <?= Html::a('Tambah User', ['create'], ['class' => 'btn btn-success']) ?>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Tanggal Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= Html::encode($user->username) ?></td>
                    <td><?= Html::encode($user->email) ?></td>
                    <td>
                      <span class="badge bg-<?= $user->role === 'administrator' ? 'danger' : ($user->role === 'peminjam' ? 'success' : 'info') ?>">
    <?= $user->role === 'administrator' ? 'Administrator' : ($user->role === 'peminjam' ? 'Peminjam' : 'Petugas') ?>
</span>
                    </td>
                    <td><?= Yii::$app->formatter->asDatetime($user->created_at) ?></td>
                    <td>
                        <?= Html::a('Edit', ['update', 'id' => $user->id], ['class' => 'btn btn-sm btn-warning']) ?>
                        <?php if ($user->id != Yii::$app->user->id): ?>
                            <?= Html::a('Hapus', ['delete', 'id' => $user->id], [
                                'class' => 'btn btn-sm btn-danger',
                                'data' => [
                                    'confirm' => 'Yakin hapus user ini?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>