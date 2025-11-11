<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Update User: ' . $user->username;
?>
<div class="user-update">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
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
                'placeholder' => 'Kosongkan jika tidak ingin mengubah password'
            ])->hint('Kosongkan field ini jika tidak ingin mengubah password') ?>

            <?= $form->field($model, 'password_repeat')->passwordInput([
                'placeholder' => 'Ketik ulang password'
            ]) ?>

            <?= $form->field($model, 'role')->dropDownList(
                $model->getAdminRoleOptions(), // Gunakan options untuk admin
                ['prompt' => '-- Pilih Role --']
            )->label('Pilih Role Akun') ?>

            <div class="form-group">
                <?= Html::submitButton('<i class="fas fa-save me-2"></i>Update User', [
                    'class' => 'btn btn-success'
                ]) ?>
                <?= Html::a('<i class="fas fa-arrow-left me-2"></i>Kembali', ['index'], [
                    'class' => 'btn btn-secondary'
                ]) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>