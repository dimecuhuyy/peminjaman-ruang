<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = 'Update Jadwal Reguler: ' . $model->keterangan;
?>
<div class="jadwal-update">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="fas fa-edit me-2"></i><?= Html::encode($this->title) ?></h4>
        </div>
        <div class="card-body">
            <?php $form = ActiveForm::begin(); ?>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'nama_hari')->dropDownList(
                        $model->getHariList(),
                        ['class' => 'form-control']
                    ) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'id_room')->dropDownList(
                        ArrayHelper::map($ruang, 'id', 'nama_ruang'),
                        ['class' => 'form-control']
                    ) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'jam_mulai')->input('time', [
                        'class' => 'form-control'
                    ]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'jam_selesai')->input('time', [
                        'class' => 'form-control'
                    ]) ?>
                </div>
            </div>

            <?= $form->field($model, 'keterangan')->textarea(['rows' => 3]) ?>

            <div class="form-group">
                <?= Html::submitButton('<i class="fas fa-save me-2"></i>Update Jadwal', [
                    'class' => 'btn btn-primary'
                ]) ?>
                <?= Html::a('<i class="fas fa-times me-2"></i>Batal', ['index'], [
                    'class' => 'btn btn-secondary'
                ]) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>