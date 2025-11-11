<?php
use yii\helpers\Html;

$this->title = 'Dashboard';
$user = Yii::$app->user->identity;

// Statistics
$totalRuang = \app\models\Ruang::find()->count();
$ruangTersedia = \app\models\Ruang::find()->where(['status' => 'tersedia'])->count();
$totalPeminjaman = \app\models\Peminjaman::find()->count();
$peminjamanPending = \app\models\Peminjaman::find()->where(['status' => 'pending'])->count();
?>
<div class="site-index">
    <!-- Hero Section -->
    <div class="jumbotron mb-5">
        <h1 class="display-4 fw-bold">Selamat Datang! 👋</h1>
        <p class="lead">Sistem Peminjaman Ruang SMKN 1 Bantul</p>
        <hr class="my-4" style="border-color: rgba(255,255,255,0.3);">
        
        <?php if (Yii::$app->user->isGuest): ?>
            <p>Kelola peminjaman ruang dengan mudah dan efisien</p>
            <div class="mt-4">
                <?= Html::a('<i class="fas fa-sign-in-alt me-2"></i>Login', ['site/login'], ['class' => 'btn btn-light btn-lg me-3']) ?>
                <?= Html::a('<i class="fas fa-user-plus me-2"></i>Registrasi', ['user/register'], ['class' => 'btn btn-outline-light btn-lg']) ?>
            </div>
        <?php elseif ($user->isAdministrator()): ?>
            <p>Anda login sebagai <span class="badge bg-danger">👑 Administrator</span></p>
            <div class="mt-4">
                <?= Html::a('<i class="fas fa-building me-2"></i>Manajemen Ruang', ['ruang/index'], ['class' => 'btn btn-light btn-lg me-2']) ?>
                <?= Html::a('<i class="fas fa-users me-2"></i>Manajemen User', ['user/index'], ['class' => 'btn btn-light btn-lg me-2']) ?>
                <?= Html::a('<i class="fas fa-chart-bar me-2"></i>Laporan', ['laporan/index'], ['class' => 'btn btn-light btn-lg me-2']) ?>
                <?= Html::a('<i class="fas fa-clipboard-list me-2"></i>Kelola Peminjaman', ['peminjaman/index'], ['class' => 'btn btn-light btn-lg me-2']) ?>
            </div>
        <?php elseif ($user->isPetugas()): ?>
            <p>Anda login sebagai <span class="badge bg-warning text-dark">👨‍💼 Petugas</span></p>
            <div class="mt-4">
                <?= Html::a('<i class="fas fa-clipboard-list me-2"></i>Kelola Peminjaman', ['peminjaman/index'], ['class' => 'btn btn-light btn-lg me-2']) ?>
                <?= Html::a('<i class="fas fa-building me-2"></i>Manajemen Ruang', ['ruang/index'], ['class' => 'btn btn-light btn-lg me-2']) ?>
                <?= Html::a('<i class="fas fa-chart-bar me-2"></i>Laporan', ['laporan/index'], ['class' => 'btn btn-light btn-lg me-2']) ?>
                <?= Html::a('<i class="fas fa-calendar-alt me-2"></i>Jadwal', ['jadwal/index'], ['class' => 'btn btn-light btn-lg me-2']) ?>
            </div>
        <?php else: ?>
            <p>Anda login sebagai <span class="badge bg-info">👤 Peminjam</span></p>
            <div class="mt-4">
                <?= Html::a('<i class="fas fa-plus-circle me-2"></i>Ajukan Peminjaman', ['peminjaman/create'], ['class' => 'btn btn-light btn-lg me-3']) ?>
                <?= Html::a('<i class="fas fa-history me-2"></i>Lihat Status', ['peminjaman/index'], ['class' => 'btn btn-outline-light btn-lg']) ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Quick Stats -->
    <div class="row mb-5">
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="feature-icon">
                    <i class="fas fa-building"></i>
                </div>
                <h3 class="stat-number"><?= $totalRuang ?></h3>
                <p class="text-muted">Total Ruang</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="feature-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h3 class="stat-number"><?= $ruangTersedia ?></h3>
                <p class="text-muted">Ruang Tersedia</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="feature-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <h3 class="stat-number"><?= $totalPeminjaman ?></h3>
                <p class="text-muted">Total Peminjaman</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="feature-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h3 class="stat-number"><?= $peminjamanPending ?></h3>
                <p class="text-muted">Menunggu Persetujuan</p>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <?php if (Yii::$app->user->isGuest): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-star me-2"></i>Fitur Unggulan</h4>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <i class="fas fa-bolt feature-icon"></i>
                            <h5>Proses Cepat</h5>
                            <p class="text-muted">Pengajuan peminjaman yang mudah dan cepat</p>
                        </div>
                        <div class="col-md-4">
                            <i class="fas fa-chart-line feature-icon"></i>
                            <h5>Real-time Tracking</h5>
                            <p class="text-muted">Pantau status peminjaman secara real-time</p>
                        </div>
                        <div class="col-md-4">
                            <i class="fas fa-mobile-alt feature-icon"></i>
                            <h5>Responsive Design</h5>
                            <p class="text-muted">Akses dari berbagai perangkat</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>