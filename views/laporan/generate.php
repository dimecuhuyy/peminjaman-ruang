<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Generate Laporan';
?>
<div class="laporan-generate">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="card">
        <div class="card-body">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'judul')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'jenis')->dropDownList([
                'harian' => 'Laporan Harian',
                'mingguan' => 'Laporan Mingguan', 
                'bulanan' => 'Laporan Bulanan',
                'tahunan' => 'Laporan Tahunan',
            ], ['prompt' => 'Pilih Jenis Laporan']) ?>

            <?= $form->field($model, 'periode')->textInput([
                'placeholder' => 'Contoh: 2024-01-15 (harian), 2024-03 (bulanan), 2024 (tahunan)'
            ]) ?>

            <div class="form-group">
                <?= Html::submitButton('Generate Laporan', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Batal', ['index'], ['class' => 'btn btn-secondary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <div class="mt-4">
        <div class="alert alert-info">
            <strong>Format Periode:</strong><br>
            - Harian: YYYY-MM-DD (contoh: 2024-01-15)<br>
            - Bulanan: YYYY-MM (contoh: 2024-01)<br>
            - Tahunan: YYYY (contoh: 2024)
        </div>
    </div>
</div>