<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Tambah Ruang';
?>
<div class="ruang-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="ruang-form">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'kode_ruang')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'nama_ruang')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'kapasitas')->textInput(['type' => 'number']) ?>

        <?= $form->field($model, 'status')->dropDownList([
            'tersedia' => 'Tersedia',
            'tidak_tersedia' => 'Tidak Tersedia'
        ]) ?>

        <div class="form-group">
            <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
            <?= Html::a('Batal', ['index'], ['class' => 'btn btn-secondary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>