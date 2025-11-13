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
            <?php $form = ActiveForm::begin(['id' => 'jadwal-form']); ?>

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

            <!-- ✅ UBAH INPUT TIME MENJADI DROPDOWN SESI -->
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'jam_mulai')->dropDownList(
                        $this->context->generateSesiOptions('mulai'),
                        [
                            'prompt' => '-- Pilih Sesi Mulai --',
                            'class' => 'form-control',
                            'id' => 'jam-mulai'
                        ]
                    )->label('Sesi Mulai') ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'jam_selesai')->dropDownList(
                        $this->context->generateSesiOptions('selesai'),
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
                <strong>Info:</strong> Jadwal ini menggunakan <span id="jumlah-sesi">0</span> sesi 
                (<span id="total-menit">0</span> menit)
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

    <!-- Informasi Sesi -->
    <div class="card mt-4">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Sistem Sesi</h5>
        </div>
        <div class="card-body">
            <ul class="list-unstyled">
                <li><i class="fas fa-clock me-2 text-primary"></i><strong>Durasi Sesi:</strong> 45 menit</li>
                <li><i class="fas fa-play me-2 text-primary"></i><strong>Jam Mulai:</strong> 07:00 - 16:15</li>
                <li><i class="fas fa-stop me-2 text-primary"></i><strong>Jam Selesai:</strong> 07:45 - 17:00</li>
                <li><i class="fas fa-calendar-day me-2 text-primary"></i><strong>Total Sesi/Hari:</strong> 14 sesi</li>
            </ul>
            <p class="text-warning mb-0"><i class="fas fa-exclamation-triangle me-1"></i>
                <strong>Perhatian:</strong> Peminjaman ruang tidak bisa dilakukan pada jam yang sudah terjadwal reguler.
            </p>
        </div>
    </div>
</div>

<?php
// ✅ TAMBAHKAN JAVASCRIPT UNTUK HITUNG SESI
$this->registerJs(<<<JS
    function calculateSesi() {
        var jamMulai = $('#jam-mulai').val();
        var jamSelesai = $('#jam-selesai').val();
        
        if (jamMulai && jamSelesai) {
            var mulaiTime = new Date('1970-01-01T' + jamMulai + ':00');
            var selesaiTime = new Date('1970-01-01T' + jamSelesai + ':00');
            
            if (selesaiTime > mulaiTime) {
                var diffMenit = (selesaiTime - mulaiTime) / (1000 * 60);
                var jumlahSesi = Math.ceil(diffMenit / 45);
                var totalMenit = jumlahSesi * 45;
                
                $('#jumlah-sesi').text(jumlahSesi);
                $('#total-menit').text(totalMenit);
                $('#sesi-info').show();
            } else {
                $('#sesi-info').hide();
            }
        } else {
            $('#sesi-info').hide();
        }
    }
    
    $('#jam-mulai, #jam-selesai').change(function() {
        calculateSesi();
    });
    
    // Hitung sesi saat pertama kali load
    calculateSesi();
JS
);
?>