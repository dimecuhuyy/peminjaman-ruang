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
                            'class' => 'form-control',
                            'id' => 'ruang-select'
                        ]
                    )->label('Pilih Ruang') ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'tanggal_pinjam')->input('date', [
                        'class' => 'form-control',
                        'min' => date('Y-m-d'),
                        'id' => 'tanggal-pinjam'
                    ]) ?>
                </div>
            </div>

            <!-- Ganti input time dengan select sesi -->
            <div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'jam_mulai')->dropDownList(
            $this->context->generateSesiOptions('mulai'), // Untuk mulai
            [
                'prompt' => '-- Pilih Sesi Mulai --',
                'class' => 'form-control',
                'id' => 'jam-mulai'
            ]
        )->label('Sesi Mulai') ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'jam_selesai')->dropDownList(
            $this->context->generateSesiOptions('selesai'), // Untuk selesai
            [
                'prompt' => '-- Pilih Sesi Selesai --',
                'class' => 'form-control',
                'id' => 'jam-selesai'
            ]
        )->label('Sesi Selesai') ?>
    </div>
</div>

            <!-- Info jumlah sesi -->
            <div class="alert alert-info" id="sesi-info" style="display: none;">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Info:</strong> Anda memilih <span id="jumlah-sesi">0</span> sesi 
                (<span id="total-menit">0</span> menit)
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
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Sesi</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li><i class="fas fa-clock me-2 text-primary"></i><strong>Durasi Sesi:</strong> 45 menit</li>
                        <li><i class="fas fa-play me-2 text-primary"></i><strong>Jam Mulai:</strong> 07:00 - 16:15</li>
                        <li><i class="fas fa-stop me-2 text-primary"></i><strong>Jam Selesai:</strong> 07:45 - 17:00</li>
                        <li><i class="fas fa-calendar-day me-2 text-primary"></i><strong>Total Sesi/Hari:</strong> 14 sesi</li>
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
                    <p><strong>Sistem Sesi 45 Menit:</strong></p>
                    <ol>
                        <li>1 sesi = 45 menit</li>
                        <li>Pilih sesi mulai dan sesi selesai</li>
                        <li>Sistem hitung otomatis jumlah sesi</li>
                        <li>Minimal 1 sesi, maksimal 14 sesi/hari</li>
                        <li>Ajukan minimal 1 hari sebelumnya</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
$this->registerJs(<<<JS
    function calculateSesi() {
        var jamMulai = $('#jam-mulai').val();  // Format: HH:MM (mulai)
        var jamSelesai = $('#jam-selesai').val(); // Format: HH:MM (selesai)
        
        if (jamMulai && jamSelesai) {
            // Konversi ke timestamp untuk perbandingan
            var mulaiTime = new Date('1970-01-01T' + jamMulai + ':00');
            var selesaiTime = new Date('1970-01-01T' + jamSelesai + ':00');
            
            if (selesaiTime > mulaiTime) {
                // Hitung selisih dalam menit
                var diffMenit = (selesaiTime - mulaiTime) / (1000 * 60);
                var jumlahSesi = Math.ceil(diffMenit / 45);
                var totalMenit = jumlahSesi * 45;
                
                $('#jumlah-sesi').text(jumlahSesi);
                $('#total-menit').text(totalMenit);
                $('#sesi-info').show();
                
                // Validasi: hapus error jika valid
                $('#jam-selesai').removeClass('is-invalid');
                $('#jam-selesai').next('.invalid-feedback').remove();
            } else {
                $('#sesi-info').hide();
                // Tampilkan error jika jam selesai <= jam mulai
                if (!$('#jam-selesai').hasClass('is-invalid')) {
                    $('#jam-selesai').addClass('is-invalid');
                    $('#jam-selesai').after('<div class="invalid-feedback">Jam selesai harus setelah jam mulai</div>');
                }
            }
        } else {
            $('#sesi-info').hide();
        }
    }
    
    $('#jam-mulai, #jam-selesai').change(function() {
        calculateSesi();
    });
    
    // Validasi saat submit form
    $('#peminjaman-form').on('beforeSubmit', function() {
        var jamMulai = $('#jam-mulai').val();
        var jamSelesai = $('#jam-selesai').val();
        
        if (jamMulai && jamSelesai) {
            var mulaiTime = new Date('1970-01-01T' + jamMulai + ':00');
            var selesaiTime = new Date('1970-01-01T' + jamSelesai + ':00');
            
            if (selesaiTime <= mulaiTime) {
                alert('Error: Jam selesai harus setelah jam mulai!');
                return false;
            }
        }
        return true;
    });
JS
);
?>