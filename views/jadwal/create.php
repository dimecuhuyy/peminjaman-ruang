<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = 'Tambah Jadwal Reguler';
?>
<div class="jadwal-create">
    <div class="card">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0"><i class="fas fa-plus-circle me-2"></i><?= Html::encode($this->title) ?></h4>
        </div>
        <div class="card-body">
            <?php $form = ActiveForm::begin(); ?>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'nama_hari')->dropDownList(
                        $model->getHariList(),
                        ['prompt' => '-- Pilih Hari --', 'class' => 'form-control']
                    ) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'id_room')->dropDownList(
                        ArrayHelper::map($ruang, 'id', 'nama_ruang'),
                        ['prompt' => '-- Pilih Ruang --', 'class' => 'form-control']
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

            <?= $form->field($model, 'keterangan')->textarea([
                'rows' => 3,
                'placeholder' => 'Contoh: Pelajaran Matematika Kelas X, Praktikum Komputer, dll.'
            ]) ?>

            <div class="form-group">
                <?= Html::submitButton('<i class="fas fa-save me-2"></i>Simpan Jadwal', [
                    'class' => 'btn btn-success'
                ]) ?>
                <?= Html::a('<i class="fas fa-times me-2"></i>Batal', ['index'], [
                    'class' => 'btn btn-secondary'
                ]) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Jadwal Reguler</h5>
        </div>
        <div class="card-body">
            <p>Jadwal reguler adalah jadwal tetap yang berulang setiap minggu. Contoh:</p>
            <ul>
                <li>Pelajaran Matematika setiap Senin jam 07:00-09:00</li>
                <li>Praktikum Komputer setiap Rabu jam 13:00-15:00</li>
                <li>Rapat Guru setiap Jumat jam 14:00-16:00</li>
            </ul>
            <p class="text-warning mb-0"><i class="fas fa-exclamation-triangle me-1"></i>
                <strong>Perhatian:</strong> Peminjaman ruang tidak bisa dilakukan pada jam yang sudah terjadwal reguler.
            </p>
        </div>
    </div>
</div>