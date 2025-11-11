<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = 'Ajukan Peminjaman Ruang';
?>
<div class="peminjaman-create">
    <div class="card">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0"><i class="fas fa-plus-circle me-2"></i><?= Html::encode($this->title) ?></h4>
        </div>
        <div class="card-body">
            <?php $form = ActiveForm::begin([
                'id' => 'peminjaman-form',
                'enableClientValidation' => true,
            ]); ?>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'ruang_id')->dropDownList(
                        ArrayHelper::map($ruang, 'id', function($model) {
                            return $model->nama_ruang . ' (Kapasitas: ' . $model->kapasitas . ' orang)';
                        }),
                        [
                            'prompt' => '-- Pilih Ruang --',
                            'class' => 'form-control'
                        ]
                    )->label('Pilih Ruang') ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'tanggal_pinjam')->input('date', [
                        'class' => 'form-control',
                        'min' => date('Y-m-d')
                    ]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'jam_mulai')->input('time', [
                        'class' => 'form-control',
                        'min' => '07:00',
                        'max' => '17:00'
                    ]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'jam_selesai')->input('time', [
                        'class' => 'form-control',
                        'min' => '07:00',
                        'max' => '17:00'
                    ]) ?>
                </div>
            </div>

            <?= $form->field($model, 'deskripsi')->textarea([
                'rows' => 4,
                'placeholder' => 'Jelaskan keperluan peminjaman ruang secara detail...'
            ]) ?>

            <div class="form-group">
                <?= Html::submitButton('<i class="fas fa-paper-plane me-2"></i>Ajukan Peminjaman', [
                    'class' => 'btn btn-success btn-lg',
                    'name' => 'submit-button'
                ]) ?>
                <?= Html::a('<i class="fas fa-times me-2"></i>Batal', ['index'], [
                    'class' => 'btn btn-secondary btn-lg'
                ]) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <!-- Informasi Penting -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Peminjaman</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li><i class="fas fa-clock me-2 text-primary"></i><strong>Jam Operasional:</strong> 07:00 - 17:00</li>
                        <li><i class="fas fa-calendar me-2 text-primary"></i><strong>Minimal Peminjaman:</strong> 1 hari sebelumnya</li>
                        <li><i class="fas fa-exclamation-triangle me-2 text-warning"></i><strong>Perhatian:</strong> Sistem akan otomatis menolak jika ada jadwal bentrok</li>
                        <li><i class="fas fa-history me-2 text-primary"></i><strong>Status:</strong> Akan diproses oleh administrator</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="fas fa-exclamation-circle me-2"></i>Penting!</h5>
                </div>
                <div class="card-body">
                    <p><strong>Pastikan ruang tersedia sebelum mengajukan:</strong></p>
                    <ol>
                        <li>Cek <strong>Jadwal Reguler</strong> untuk melihat jadwal tetap</li>
                        <li>Periksa <strong>Status Peminjaman</strong> untuk melihat peminjaman lain</li>
                        <li>Hindari jam yang sama dengan peminjaman lain</li>
                        <li>Ajukan minimal 1 hari sebelum tanggal peminjaman</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>