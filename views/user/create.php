<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Tambah User';
?>
<div class="user-create">
    <h1><i class="fas fa-user-plus me-2"></i><?= Html::encode($this->title) ?></h1>

    <div class="card">
        <div class="card-body">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'username')->textInput([
                'autofocus' => true,
                'placeholder' => 'Masukkan username'
            ]) ?>

            <?= $form->field($model, 'email')->input('email', [
                'placeholder' => 'contoh@email.com'
            ]) ?>

            <?= $form->field($model, 'password')->passwordInput([
                'placeholder' => 'Minimal 6 karakter'
            ]) ?>

            <?= $form->field($model, 'password_repeat')->passwordInput([
                'placeholder' => 'Ketik ulang password'
            ]) ?>

            <?= $form->field($model, 'role')->dropDownList(
                $model->getAdminRoleOptions(), // Gunakan method dari model
                ['prompt' => '-- Pilih Role --']
            ) ?>

            <div class="form-group">
                <?= Html::submitButton('<i class="fas fa-save me-2"></i>Simpan User', [
                    'class' => 'btn btn-success'
                ]) ?>
                <?= Html::a('<i class="fas fa-times me-2"></i>Batal', ['index'], [
                    'class' => 'btn btn-secondary'
                ]) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <!-- Informasi Role untuk Admin -->
    <div class="card mt-3">
        <div class="card-header bg-info text-white">
            <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Role</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <p><strong>👑 Administrator:</strong></p>
                    <ul class="small">
                        <li>Manajemen user dan ruang</li>
                        <li>Kelola semua peminjaman</li>
                        <li>Buat laporan lengkap</li>
                        <li>Akses penuh sistem</li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <p><strong>👨‍💼 Petugas:</strong></p>
                    <ul class="small">
                        <li>Kelola peminjaman</li>
                        <li>Lihat laporan</li>
                        <li>Manajemen ruang</li>
                        <li>Tidak bisa manage user</li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <p><strong>👤 Peminjam:</strong></p>
                    <ul class="small">
                        <li>Ajukan peminjaman ruang</li>
                        <li>Lihat status peminjaman</li>
                        <li>Lihat jadwal ruang</li>
                    </ul>
                </div>
            </div>
            
            <div class="alert alert-warning mt-3 mb-0">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Perhatian:</strong> Hati-hati dalam memilih role. Administrator memiliki akses penuh ke sistem.
            </div>
        </div>
    </div>
</div>