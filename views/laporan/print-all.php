<?php
use yii\helpers\Html;

$models = $dataProvider->getModels();
$this->title = 'Daftar Semua Laporan';
?>
<div class="header">
    <h1>DAFTAR SEMUA LAPORAN</h1>
    <h2>SMKN 1 BANTUL</h2>
    <p>Periode: <?= date('d F Y') ?></p>
</div>

<?php if (empty($models)): ?>
    <p class="text-center">Tidak ada data laporan.</p>
<?php else: ?>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Jenis</th>
                <th>Periode</th>
                <th>Petugas</th>
                <th>Tanggal Dibuat</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($models as $index => $model): ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= Html::encode($model->judul) ?></td>
                <td><?= $model->getJenisLabel() ?></td>
                <td><?= Html::encode($model->periode) ?></td>
                <td><?= Html::encode($model->petugas->username) ?></td>
                <td><?= Yii::$app->formatter->asDate($model->created_at) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <p><strong>Total Laporan: <?= count($models) ?></strong></p>
<?php endif; ?>

<div class="footer">
    <p>Dicetak dari Sistem Peminjaman Ruang SMKN 1 Bantul</p>
    <p>Tanggal cetak: <?= date('d/m/Y H:i:s') ?></p>
</div>

<script>
    window.onload = function() {
        window.print();
    }
</script>