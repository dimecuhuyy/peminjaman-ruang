<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Registrasi Akun';
?>
<div class="user-register">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-user-plus me-2"></i><?= Html::encode($this->title) ?></h4>
                </div>
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

                    <!-- HIDDEN FIELD untuk role, otomatis menjadi peminjam -->
                    <?= $form->field($model, 'role')->hiddenInput(['value' => \app\models\User::ROLE_PEMINJAM])->label(false) ?>

                    <div class="form-group">
                        <?= Html::submitButton('<i class="fas fa-user-plus me-2"></i>Daftar sebagai Peminjam', [
                            'class' => 'btn btn-success btn-block'
                        ]) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                    <hr>
                    <div class="text-center">
                        <p class="mb-1">Sudah punya akun?</p>
                        <?= Html::a('<i class="fas fa-sign-in-alt me-1"></i>Login di sini', ['site/login'], [
                            'class' => 'btn btn-outline-primary btn-sm'
                        ]) ?>
                    </div>
                </div>
            </div>

            <!-- Informasi Hak Akses -->
            <div class="card mt-3">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Hak Akses Peminjam</h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-info mb-3">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Registrasi otomatis sebagai Peminjam</strong><br>
                        Untuk akses sebagai Administrator atau Petugas, hubungi administrator sistem.
                    </div>
                    
                    <p><strong>✅ Yang bisa dilakukan:</strong></p>
                    <ul class="small">
                        <li>Ajukan peminjaman ruang</li>
                        <li>Lihat status peminjaman</li>
                        <li>Lihat jadwal ruang tersedia</li>
                        <li>Lihat riwayat peminjaman sendiri</li>
                    </ul>

                    <p><strong>❌ Yang tidak bisa dilakukan:</strong></p>
                    <ul class="small">
                        <li>Mengelola user lain</li>
                        <li>Mengelola data ruang</li>
                        <li>Melihat laporan sistem</li>
                        <li>Menyetujui/tolak peminjaman</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>