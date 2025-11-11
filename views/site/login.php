<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Login - Sistem Peminjaman Ruang';
?>
<div class="site-login">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="text-center mb-0">Login Peminjaman Ruang</h4>
                </div>
                <div class="card-body">
                    <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                    ]); ?>

                    <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'class' => 'form-control']) ?>

                    <?= $form->field($model, 'password')->passwordInput(['class' => 'form-control']) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Login', ['class' => 'btn btn-primary w-100', 'name' => 'login-button']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                    <hr>
                    <div class="text-center">
                        <small class="text-muted">
                            <strong>Demo Accounts:</strong><br>
                            Admin: <code>admin</code> / <code>admin123</code><br>
                            Peminjam: <code>peminjam</code> / <code>peminjam123</code>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>