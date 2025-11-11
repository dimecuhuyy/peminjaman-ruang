<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Buat Laporan';
?>
<div class="laporan-create">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0"><?= Html::encode($this->title) ?></h4>
        </div>
        <div class="card-body">
            <?php $form = ActiveForm::begin([
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'labelOptions' => ['class' => 'form-label fw-bold'],
                    'inputOptions' => ['class' => 'form-control'],
                    'errorOptions' => ['class' => 'invalid-feedback']
                ]
            ]); ?>

            <div class="row">
                <div class="col-12 col-md-6 mb-3">
                    <?= $form->field($model, 'judul')->textInput([
                        'placeholder' => 'Masukkan judul laporan',
                        'class' => 'form-control'
                    ]) ?>
                </div>
                <div class="col-12 col-md-6 mb-3">
                    <?= $form->field($model, 'jenis')->dropDownList([
                        'harian' => 'Laporan Harian',
                        'mingguan' => 'Laporan Mingguan', 
                        'bulanan' => 'Laporan Bulanan',
                        'tahunan' => 'Laporan Tahunan',
                    ], [
                        'prompt' => 'Pilih Jenis Laporan',
                        'class' => 'form-select'
                    ]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <?= $form->field($model, 'periode')->textInput([
                        'placeholder' => 'Contoh: 2024-01-15 (harian), 2024-03 (bulanan), 2024 (tahunan)',
                        'class' => 'form-control'
                    ]) ?>
                </div>
            </div>

            <div class="form-group mt-4">
                <div class="d-flex flex-column flex-md-row gap-2">
                    <?= Html::submitButton('<i class="fas fa-save me-2"></i>Simpan Laporan', [
                        'class' => 'btn btn-success flex-fill'
                    ]) ?>
                    <?= Html::a('<i class="fas fa-times me-2"></i>Batal', ['index'], [
                        'class' => 'btn btn-secondary flex-fill'
                    ]) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <!-- Panduan -->
    <div class="card mt-3">
        <div class="card-header bg-info text-white">
            <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Panduan Format Periode</h6>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="border rounded p-3 h-100">
                        <p class="fw-bold mb-2">📅 Harian</p>
                        <small class="text-muted">Format: <code>YYYY-MM-DD</code></small><br>
                        <small>Contoh: <code>2024-01-15</code></small>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="border rounded p-3 h-100">
                        <p class="fw-bold mb-2">📊 Bulanan</p>
                        <small class="text-muted">Format: <code>YYYY-MM</code></small><br>
                        <small>Contoh: <code>2024-01</code></small>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="border rounded p-3 h-100">
                        <p class="fw-bold mb-2">🗓️ Tahunan</p>
                        <small class="text-muted">Format: <code>YYYY</code></small><br>
                        <small>Contoh: <code>2024</code></small>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="border rounded p-3 h-100">
                        <p class="fw-bold mb-2">📈 Mingguan</p>
                        <small class="text-muted">Format: <code>YYYY-WW</code></small><br>
                        <small>Contoh: <code>2024-01</code></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Responsive Design untuk Form Laporan */
.laporan-create .card-body {
    padding: 1.5rem;
}

/* Mobile */
@media (max-width: 767px) {
    .laporan-create .card-body {
        padding: 1rem;
    }
    
    .laporan-create .form-control,
    .laporan-create .form-select {
        font-size: 16px; /* Prevent zoom on iOS */
    }
    
    .laporan-create .btn {
        width: 100%;
    }
    
    .laporan-create .d-flex.flex-md-row {
        flex-direction: column !important;
    }
    
    .laporan-create .flex-fill {
        margin-bottom: 0.5rem;
    }
}

/* Small Mobile */
@media (max-width: 575px) {
    .laporan-create .card-body {
        padding: 0.75rem;
    }
    
    .laporan-create .form-label {
        font-size: 0.9rem;
    }
    
    .laporan-create .p-3 {
        padding: 1rem !important;
    }
    
    .laporan-create small {
        font-size: 0.8rem;
    }
}

/* Extra Small Mobile */
@media (max-width: 400px) {
    .laporan-create h4 {
        font-size: 1.1rem;
    }
    
    .laporan-create h6 {
        font-size: 0.9rem;
    }
    
    .laporan-create .fw-bold {
        font-size: 0.85rem;
    }
}
</style>